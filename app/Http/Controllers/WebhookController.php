<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Date;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Simple signature check (configure PAYMENT_WEBHOOK_KEY in .env)
        $signature = $request->header('X-PAYMENT-SIGNATURE');
        if (! $signature || $signature !== env('PAYMENT_WEBHOOK_KEY')) {
            Log::warning('Invalid webhook signature', ['signature' => $signature]);
            return response()->json(['ok' => false], 401);
        }

        $payload = $request->all();

        // Expected payload: transaction_id, status, amount
        $tx = $payload['transaction_id'] ?? null;
        $status = $payload['status'] ?? null;

        if (! $tx || ! $status) {
            return response()->json(['ok' => false], 400);
        }

        // Idempotency: find payment by transaction_id
        $payment = Payment::where('transaction_id', $tx)->first();
        if (! $payment) {
            // Optionally create payment record if missing
            Log::warning('Payment not found for webhook', ['transaction_id' => $tx]);
            return response()->json(['ok' => false], 404);
        }

        // Update status inside transaction
        try {
                    DB::transaction(function () use ($payment, $status) {
                        $payment->status = $status;
                        if ($status === 'paid') {
                            $payment->paid_at = Date::now();
                            if ($payment->reservasi && $payment->reservasi->exists) {
                                $payment->reservasi->status = 'confirmed';
                                $payment->reservasi->save();
                            }
                        }
                        $payment->save();
                    });
                } catch (\Exception $e) {
                    Log::error('Webhook transaction failed', [
                        'error' => $e->getMessage(),
                        'transaction_id' => $payment->transaction_id,
                        'status' => $status
                    ]);
                    return response()->json(['ok' => false, 'error' => 'Transaction failed'], 500);
                }

        return response()->json(['ok' => true]);
    }
}
