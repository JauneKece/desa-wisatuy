<?php

namespace App\Http\Controllers;

use App\Models\ObjekWisata;
use App\Models\PaketWisata;
use App\Models\Penginapan;
use App\Models\Berita;
use App\Models\Reservasi;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $objekWisata = ObjekWisata::take(6)->get();
        $paketWisata = PaketWisata::take(6)->get();
        $penginapan = Penginapan::take(6)->get();
        $berita = Berita::where('status', true)->take(3)->latest()->get();
        $totalReservasi = Reservasi::count();

        return view('home', compact('objekWisata', 'paketWisata', 'penginapan', 'berita', 'totalReservasi'));
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->role === 'pelanggan') {
            return $this->customerDashboard($user);
        } elseif ($user->role === 'admin') {
            return $this->adminDashboard($user);
        } elseif ($user->role === 'owner') {
            return $this->ownerDashboard($user);
        } elseif ($user->role === 'bendahara') {
            return $this->bendaharaDashboard($user);
        }

        return redirect()->route('home');
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard($user)
    {
        $totalUsers = User::count();
        $totalCustomers = User::where('role', 'pelanggan')->count();
        $totalStaff = User::where('role', 'bendahara')->count();
        $totalManagers = User::where('role', 'owner')->count();
        
        $totalReservasi = Reservasi::count();
        $pendingReservasi = Reservasi::where('status', 'pending')->count();
        $confirmedReservasi = Reservasi::where('status', 'confirmed')->count();
        
        $totalObjekWisata = ObjekWisata::count();
        $totalPaketWisata = PaketWisata::count();
        $totalPenginapan = Penginapan::count();
        $totalBerita = Berita::count();
        
        // Revenue calculation
        $totalRevenue = Reservasi::where('status', '!=', 'cancelled')
            ->sum('total_harga');
        $revenueThisMonth = Reservasi::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_harga');
        
        // Recent activities
        $recentReservasi = Reservasi::with('pelanggan', 'paketWisata')
            ->latest()->take(5)->get();
        $recentBerita = Berita::with('user')
            ->latest()->take(5)->get();
        
        return view('dashboard.admin', compact(
            'totalUsers', 'totalCustomers', 'totalStaff', 'totalManagers',
            'totalReservasi', 'pendingReservasi', 'confirmedReservasi',
            'totalObjekWisata', 'totalPaketWisata', 'totalPenginapan', 'totalBerita',
            'totalRevenue', 'revenueThisMonth',
            'recentReservasi', 'recentBerita'
        ));
    }

    /**
     * Owner Dashboard (Pemilik/Manager Operasional)
     */
    private function ownerDashboard($user)
    {
        $totalReservasi = Reservasi::count();
        $pendingReservasi = Reservasi::where('status', 'pending')->count();
        $confirmedReservasi = Reservasi::where('status', 'confirmed')->count();
        
        $totalPaketWisata = PaketWisata::count();
        $totalPenginapan = Penginapan::count();
        $totalObjekWisata = ObjekWisata::count();
        
        // Revenue
        $totalRevenue = Reservasi::where('status', '!=', 'cancelled')
            ->sum('total_harga');
        $revenueThisMonth = Reservasi::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_harga');
        
        // Recent activities
        $recentReservasi = Reservasi::with('pelanggan', 'paketWisata')
            ->latest()->take(8)->get();
        
        // Pending reservasi details
        $pendingReservasiDetail = Reservasi::where('status', 'pending')
            ->with('pelanggan', 'paketWisata', 'penginapan')
            ->latest()->take(5)->get();
        
        return view('dashboard.owner', compact(
            'totalReservasi', 'pendingReservasi', 'confirmedReservasi',
            'totalPaketWisata', 'totalPenginapan', 'totalObjekWisata',
            'totalRevenue', 'revenueThisMonth',
            'recentReservasi', 'pendingReservasiDetail'
        ));
    }

    /**
     * Bendahara Dashboard (Staff Keuangan)
     * Kelola pembayaran, reservasi, dan analisa revenue
     */
    private function bendaharaDashboard($user)
    {
        // Payment statistics
        $totalPayments = Payment::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $approvedPayments = Payment::where('status', 'paid')->count();
        $rejectedPayments = Payment::where('status', 'failed')->count();
        
        // Reservation statistics
        $totalReservasi = Reservasi::count();
        $pendingReservasi = Reservasi::where('status', 'pending')->count();
        $confirmedReservasi = Reservasi::where('status', 'confirmed')->count();
        $cancelledReservasi = Reservasi::where('status', 'cancelled')->count();
        
        // Revenue analysis
        $totalRevenue = Reservasi::where('status', '!=', 'cancelled')
            ->sum('total_harga');
        $revenueThisMonth = Reservasi::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_harga');
        $pendingRevenue = Reservasi::where('status', 'pending')
            ->sum('total_harga');
        
        // Recent reservasi with payment status
        $recentReservasi = Reservasi::with('pelanggan', 'paketWisata', 'payment')
            ->latest()->take(8)->get();
        
        // Confirmed reservasi
        $confirmedReservasiDetail = Reservasi::where('status', 'confirmed')
            ->with('pelanggan', 'paketWisata', 'penginapan', 'payment')
            ->latest()->take(5)->get();
        
        // Destination info for reference
        $totalObjekWisata = ObjekWisata::count();
        $totalPaketWisata = PaketWisata::count();
        $totalPenginapan = Penginapan::count();
        
        return view('dashboard.bendahara', compact(
            'totalPayments', 'pendingPayments', 'approvedPayments', 'rejectedPayments',
            'totalReservasi', 'pendingReservasi', 'confirmedReservasi', 'cancelledReservasi',
            'totalRevenue', 'revenueThisMonth', 'pendingRevenue',
            'recentReservasi', 'confirmedReservasiDetail',
            'totalObjekWisata', 'totalPaketWisata', 'totalPenginapan'
        ));
    }

    /**
     * Customer Dashboard
     */
    private function customerDashboard($user)
    {
        // Get pelanggan profile
        $pelanggan = Pelanggan::where('user_id', $user->id)->first();
        
        if (!$pelanggan) {
            // Create pelanggan profile if not exists
            $pelanggan = Pelanggan::create([
                'user_id' => $user->id,
                'nomor_identitas' => null,
                'jenis_identitas' => 'KTP',
                'alamat' => '',
                'kota' => '',
                'provinsi' => '',
                'kode_pos' => '',
                'telepon' => '',
            ]);
        }
        
        // Reservasi statistics
        $totalReservasi = Reservasi::whereHas('pelanggan', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        $pendingReservasi = Reservasi::whereHas('pelanggan', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'pending')->count();
        
        $confirmedReservasi = Reservasi::whereHas('pelanggan', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'confirmed')->count();
        
        $completedReservasi = Reservasi::whereHas('pelanggan', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'confirmed')->count();
        
        // Total spent
        $totalSpent = Reservasi::whereHas('pelanggan', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', '!=', 'cancelled')
            ->sum('total_harga');
        
        // Recent reservasi
        $recentReservasi = Reservasi::whereHas('pelanggan', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('paketWisata', 'penginapan')
            ->latest()->take(5)->get();
        
        // Featured packages and accommodations
        $featuredPaket = PaketWisata::take(3)->get();
        $featuredPenginapan = Penginapan::take(3)->get();
        
        return view('dashboard.customer', compact(
            'pelanggan',
            'totalReservasi', 'pendingReservasi', 'confirmedReservasi',
            'totalSpent',
            'recentReservasi',
            'featuredPaket', 'featuredPenginapan'
        ));
    }
}
