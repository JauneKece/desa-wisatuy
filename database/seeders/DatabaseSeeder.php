<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\KategoriWisata;
use App\Models\ObjekWisata;
use App\Models\PaketWisata;
use App\Models\Penginapan;
use App\Models\KategoriBerita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================================
        // 1. CREATE ADMIN USER & KARYAWAN
        // ============================================================
        $adminUser = User::create([
            'name' => 'Admin Desmok',
            'email' => 'admin@desmok.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        Karyawan::create([
            'user_id' => $adminUser->id,
            'nomor_identitas' => '1234567890123456',
            'departemen' => 'IT & Sistem',
            'posisi' => 'Administrator Sistem',
            'gaji' => 7500000,
            'foto' => null,
        ]);

        // ============================================================
        // 2. CREATE OWNER (PEMILIK) USER & KARYAWAN
        // ============================================================
        $ownerUser = User::create([
            'name' => 'Pemilik Desmok',
            'email' => 'owner@desmok.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'is_active' => true,
        ]);

        Karyawan::create([
            'user_id' => $ownerUser->id,
            'nomor_identitas' => '2345678901234567',
            'departemen' => 'Manajemen Operasional',
            'posisi' => 'Pemilik/Manager Wisata',
            'gaji' => 9000000,
            'foto' => null,
        ]);

        // ============================================================
        // 3. CREATE BENDAHARA (STAFF KEUANGAN) USER & KARYAWAN
        // ============================================================
        $bendaharaUser = User::create([
            'name' => 'Bendahara Desmok',
            'email' => 'bendahara@desmok.com',
            'password' => Hash::make('password123'),
            'role' => 'bendahara',
            'is_active' => true,
        ]);

        Karyawan::create([
            'user_id' => $bendaharaUser->id,
            'nomor_identitas' => '3456789012345678',
            'departemen' => 'Keuangan & Akuntansi',
            'posisi' => 'Bendahara Utama',
            'gaji' => 6500000,
            'foto' => null,
        ]);

        // ============================================================
        // 4. CREATE SAMPLE PELANGGAN (CUSTOMER)
        // ============================================================
        User::create([
            'name' => 'Pelanggan Desmok',
            'email' => 'pelanggan@desmok.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'is_active' => true,
        ]);

        // Ensure Pelanggan record exists for all customer users
        $customerUsers = User::where('role', 'pelanggan')->get();
        foreach ($customerUsers as $cu) {
            Pelanggan::updateOrCreate(
                ['user_id' => $cu->id],
                [
                    'nomor_identitas' => null,
                    'jenis_identitas' => '',
                    'alamat' => '',
                    'kota' => '',
                    'provinsi' => '',
                    'kode_pos' => '',
                    'telepon' => '081234567890',
                ]
            );
        }

        // Create Kategori Wisata
        $kategoris = [
            ['nama_kategori' => 'Alam', 'deskripsi' => 'Wisata alam yang indah'],
            ['nama_kategori' => 'Budaya', 'deskripsi' => 'Wisata budaya lokal'],
            ['nama_kategori' => 'Petualangan', 'deskripsi' => 'Wisata petualangan seru'],
        ];

        foreach ($kategoris as $kategori) {
            KategoriWisata::create($kategori);
        }

        // Create Objek Wisata
        $objekWisata = [
            [
                'kategori_wisata_id' => 1,
                'nama_objek' => 'Air Terjun Jomok',
                'deskripsi' => 'Air terjun yang indah dengan pemandangan yang memukau',
                'lokasi' => 'Desa Jomok',
                'harga_tiket' => 25000,
                'jam_buka' => '08:00',
                'jam_tutup' => '17:00',
                'foto' => 'uploads/air-terjun.svg',
                'rating' => 5,
            ],
            [
                'kategori_wisata_id' => 1,
                'nama_objek' => 'Bukit Hijau Jomok',
                'deskripsi' => 'Bukit dengan pemandangan panorama yang spektakuler',
                'lokasi' => 'Desa Jomok',
                'harga_tiket' => 15000,
                'jam_buka' => '07:00',
                'jam_tutup' => '18:00',
                'foto' => 'uploads/bukit-hijau.svg',
                'rating' => 4,
            ],
            [
                'kategori_wisata_id' => 2,
                'nama_objek' => 'Museum Budaya Lokal',
                'deskripsi' => 'Museum yang menampilkan budaya dan tradisi lokal',
                'lokasi' => 'Pusat Desa Jomok',
                'harga_tiket' => 20000,
                'jam_buka' => '09:00',
                'jam_tutup' => '16:00',
                'foto' => 'uploads/museum.svg',
                'rating' => 4,
            ],
        ];

        foreach ($objekWisata as $objek) {
            ObjekWisata::create($objek);
        }

        // Create Paket Wisata
        $paketWisata = [
            [
                'nama_paket' => 'Paket Keluarga Jomok',
                'deskripsi' => 'Paket wisata keluarga dengan berbagai atraksi menarik',
                'harga_paket' => 500000,
                'durasi_hari' => 2,
                'durasi_jam' => 4,
                'kuota_peserta' => 10,
                'itinerary' => 'Hari 1: Air Terjun - Bukit. Hari 2: Museum - Kembali',
                'foto' => 'uploads/paket-keluarga.svg',
            ],
            [
                'nama_paket' => 'Paket Petualangan Ekstrem',
                'deskripsi' => 'Paket wisata untuk para petualang sejati',
                'harga_paket' => 750000,
                'durasi_hari' => 3,
                'durasi_jam' => 0,
                'kuota_peserta' => 15,
                'itinerary' => 'Hari 1: Pendakian Bukit. Hari 2: Penjelajahan Hutan. Hari 3: Olahraga Air',
                'foto' => 'uploads/paket-keluarga.svg',
            ],
            [
                'nama_paket' => 'Paket Budget Backpacker',
                'deskripsi' => 'Paket wisata ekonomis untuk backpacker',
                'harga_paket' => 300000,
                'durasi_hari' => 1,
                'durasi_jam' => 8,
                'kuota_peserta' => 20,
                'itinerary' => 'Kunjungan ke 3 objek wisata utama dalam sehari',
                'foto' => 'uploads/paket-keluarga.svg',
            ],
        ];

        foreach ($paketWisata as $paket) {
            PaketWisata::create($paket);
        }

        // Create Penginapan
        $penginapan = [
            [
                'nama_penginapan' => 'Hotel Bintang Lima Jomok',
                'deskripsi' => 'Hotel mewah dengan fasilitas lengkap di Desa Jomok',
                'alamat' => 'Jl. Utama Desa Jomok No. 123',
                'telepon' => '(0123) 456-7890',
                'harga_penginapan' => 500000,
                'jumlah_kamar' => 50,
                'tipe_kamar' => 'Standar, Deluxe, Suite',
                'foto' => 'uploads/hotel-bintang.svg',
                'rating' => 5,
            ],
            [
                'nama_penginapan' => 'Losmen Sederhana Jomok',
                'deskripsi' => 'Penginapan sederhana yang nyaman dan terjangkau',
                'alamat' => 'Jl. Samping Desa Jomok No. 45',
                'telepon' => '(0123) 456-7891',
                'harga_penginapan' => 150000,
                'jumlah_kamar' => 20,
                'tipe_kamar' => 'Standar',
                'foto' => 'uploads/hotel-bintang.svg',
                'rating' => 3,
            ],
            [
                'nama_penginapan' => 'Villa Indah Jomok',
                'deskripsi' => 'Villa modern dengan pemandangan alam yang menakjubkan',
                'alamat' => 'Jl. Bukit Desa Jomok No. 789',
                'telepon' => '(0123) 456-7892',
                'harga_penginapan' => 750000,
                'jumlah_kamar' => 15,
                'tipe_kamar' => 'Villa 2BR, Villa 3BR',
                'foto' => 'uploads/hotel-bintang.svg',
                'rating' => 5,
            ],
        ];

        foreach ($penginapan as $akomodasi) {
            Penginapan::create($akomodasi);
        }

        // Create Kategori Berita
        $kategoriBerita = [
            ['nama_kategori' => 'Berita Umum', 'deskripsi' => 'Berita umum tentang Desmok'],
            ['nama_kategori' => 'Promo & Event', 'deskripsi' => 'Promosi dan event spesial'],
            ['nama_kategori' => 'Tips Wisata', 'deskripsi' => 'Tips dan trik wisata'],
        ];

        foreach ($kategoriBerita as $kategori) {
            KategoriBerita::create($kategori);
        }

        // Create Sample Berita
        $user = User::where('role', 'admin')->first();
        $berita = [
            [
                'kategori_berita_id' => 2,
                'user_id' => $user->id,
                'judul' => 'Promo Spesial Liburan Tahun Ini',
                'konten' => '<p>Dapatkan diskon spesial untuk semua paket wisata kami hingga akhir bulan ini!</p>',
                'foto' => 'uploads/berita-promo.svg',
            ],
            [
                'kategori_berita_id' => 1,
                'user_id' => $user->id,
                'judul' => 'Pembukaan Wahana Baru di Desa Jomok',
                'konten' => '<p>Kami dengan bangga mengumumkan pembukaan wahana petualangan baru yang seru dan menantang.</p>',
                'foto' => 'uploads/berita-promo.svg',
            ],
            [
                'kategori_berita_id' => 3,
                'user_id' => $user->id,
                'judul' => 'Tips Menikmati Liburan di Alam Bebas',
                'konten' => '<p>Beberapa tips penting untuk membuat liburan Anda lebih nyaman dan aman di alam bebas.</p>',
                'foto' => 'uploads/berita-promo.svg',
            ],
        ];

        foreach ($berita as $item) {
            \App\Models\Berita::create($item);
        }
    }
}
