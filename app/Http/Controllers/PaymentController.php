<?php

namespace App\Http\Controllers;

use App\Mail\ReservationApprovedMail;
use App\Models\Payment;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'reservasi_id' => 'required|exists:reservasi,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
        ]);

        $payment = Payment::create([
            'reservasi_id' => $validated['reservasi_id'],
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'status' => 'pending',
            'transaction_id' => Str::uuid(),
        ]);

        // For gateway integration this would return a token/redirect URL.
        return redirect()->route('payments.show', $payment->id)->with('success', 'Payment initiated');
    }

    public function manualUpload(Request $request)
    {
        $validated = $request->validate([
            'reservasi_id' => 'required|exists:reservasi,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $file = $request->file('proof');
        $filename = 'payment_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payments/proofs', $filename, 'public');

        $payment = Payment::create([
            'reservasi_id' => $validated['reservasi_id'],
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'status' => 'pending',  // Bukti uploaded, menunggu verifikasi admin
            'proof_path' => $path,
            'transaction_id' => Str::uuid(),
        ]);

        // Reservasi status tetap 'pending' (belum diverifikasi oleh admin)
        // Jangan ubah status ke waiting_confirmation

        // Notify admin or show message
        return redirect()->route('payments.show', $payment->id)->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * Show manual upload form for a reservation.
     */
    public function showManual(\App\Models\Reservasi $reservasi)
    {
        return view('payments.manual', ['reservasi' => $reservasi]);
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    // Admin
    public function adminIndex()
    {
        $payments = Payment::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function adminShow(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        // Only admin/manager can verify
        $user = Auth::user();
        if (!$user || !($user instanceof \App\Models\User) || ! in_array($user->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate(['action' => 'required|in:approve,reject']);

        if ($request->action === 'approve') {
            // Set payment to paid
            $payment->status = 'paid';
            $payment->paid_at = now();
            $payment->save();

            // Set reservasi to confirmed
            if ($payment->reservasi) {
                $payment->reservasi->status = 'confirmed';
                $payment->reservasi->save();

                // Send approval email to customer
                try {
                    Mail::send(new ReservationApprovedMail($payment));
                } catch (\Exception $e) {
                    Log::error('Failed to send reservation approved email: ' . $e->getMessage());
                }
            }

            return redirect()->route('admin.payments.show', $payment)->with('success', 'Pembayaran dikonfirmasi dan reservasi dikonfirmasi. Email notifikasi telah dikirim ke customer.');
        }

        // Reject payment
        $payment->status = 'failed';
        $payment->save();
        
        if ($payment->reservasi) {
            $payment->reservasi->status = 'cancelled';
            $payment->reservasi->save();
        }

        return redirect()->route('admin.payments.show', $payment)->with('success', 'Pembayaran ditolak. Reservasi dibatalkan.');
    }

    // Reupload payment proof for failed payments
    public function reupload(Request $request, Payment $payment)
    {
        // Check if payment status is failed
        if ($payment->status !== 'failed') {
            return redirect()->route('payments.show', $payment)->with('error', 'Pembayaran ini tidak dapat di-reupload.');
        }

        // Check authorization - only customer who owns this payment can reupload
        $user = Auth::user();
        if (!$user || !($user instanceof \App\Models\User)) {
            abort(403, 'Unauthorized');
        }
        
        if ($user->role === 'customer') {
            $pelanggan = $payment->reservasi->pelanggan;
            if ($pelanggan->user_id !== $user->id) {
                abort(403, 'Unauthorized');
            }
        } elseif (!in_array($user->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        // Validate file
        $validated = $request->validate([
            'proof' => 'required|file|mimes:jpeg,png,gif,webp,pdf|max:5120', // 5MB
        ], [
            'proof.required' => 'Mohon pilih file bukti pembayaran',
            'proof.file' => 'File harus berupa file, bukan folder',
            'proof.mimes' => 'File hanya boleh JPG, PNG, GIF, WebP, atau PDF',
            'proof.max' => 'Ukuran file tidak boleh lebih dari 5MB',
        ]);

        // Delete old proof if exists
        if ($payment->proof_path && Storage::exists($payment->proof_path)) {
            Storage::delete($payment->proof_path);
        }

        // Store new proof file
        $file = $request->file('proof');
        $filename = 'payment_' . $payment->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payments/proofs', $filename, 'public');

        // Update payment with new proof
        $payment->proof_path = $path;
        $payment->status = 'pending'; // Reset to pending for re-verification
        $payment->paid_at = null;
        $payment->save();

        // Update reservasi status back to pending if was cancelled
        if ($payment->reservasi && $payment->reservasi->status === 'cancelled') {
            $payment->reservasi->status = 'pending';
            $payment->reservasi->save();
        }

        return redirect()->route('payments.show', $payment)->with('success', 'Bukti pembayaran berhasil diperbarui. Mohon tunggu verifikasi admin 1-2 jam kerja.');
    }
}
