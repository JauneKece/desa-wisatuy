# 🎪 DESMOK - Reservasi Wisata Desa Jomok

Selamat datang di **Desmok**, platform reservasi wisata online untuk Desa Jomok yang dirancang dengan gaya comic yang ceria dengan warna utama **kuning dan biru**.

## 📋 Fitur Utama

### 1. **Landing Page Menarik**
- Tampilan beranda yang indah dengan animasi floating dan slide-in
- Showcase produk wisata dengan live statistics
- Call-to-action untuk daftar dan login

### 2. **Sistem Role-Based Access Control**
Aplikasi memiliki 4 role dengan akses berbeda:

#### 👤 **Customer (Pelanggan)**
- Membuat dan mengelola reservasi
- Melihat status reservasi
- Menjelajahi objek wisata, paket, dan penginapan
- Edit profil pribadi

#### 👨‍💼 **Admin**
- Mengelola semua aspek sistem
- CRUD Objek Wisata
- CRUD Paket Wisata
- CRUD Penginapan
- Mengelola Reservasi (lihat dan update status)
- CRUD Berita

#### 👨‍⚙️ **Manager**
- Mengelola reservasi pelanggan
- CRUD Objek Wisata
- CRUD Paket Wisata
- CRUD Penginapan
- CRUD Berita
- Dashboard dengan statistik pending reservasi

#### 👨‍💼 **Staff**
- Membuat dan mengelola berita
- Melihat informasi objek wisata, paket, dan penginapan
- Edit profil

### 3. **Fitur CRUD Lengkap**
- ✅ Objek Wisata
- ✅ Paket Wisata
- ✅ Penginapan
- ✅ Reservasi
- ✅ Berita & Informasi

### 4. **Design & UX**
- 🎨 Comic Style dengan warna kuning (#FFD700) dan biru (#1E90FF)
- ✨ Animasi floating, slide-in, dan pulse
- 🏞️ Landscape imagery untuk setiap halaman
- 📱 Responsive design untuk semua perangkat
- 💫 Hover effects dan interactive elements

## 🚀 Akun Test

Gunakan akun-akun berikut untuk testing:

### Admin
```
Email: admin@desmok.com
Password: password123
```

### Manager
```
Email: manager@desmok.com
Password: password123
```

### Staff
```
Email: staff@desmok.com
Password: password123
```

### Customer
```
Email: customer@desmok.com
Password: password123
```

## 📁 Struktur Project

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── ObjekWisataController.php
│   │   │   ├── PaketWisataController.php
│   │   │   ├── PenginapanController.php
│   │   │   ├── ReservasiController.php
│   │   │   └── BeritaController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Pelanggan.php
│   │   ├── ObjekWisata.php
│   │   ├── PaketWisata.php
│   │   ├── Penginapan.php
│   │   ├── Reservasi.php
│   │   ├── Berita.php
│   │   └── KategoriWisata.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── navbar.blade.php
│   │   │   └── footer.blade.php
│   │   ├── objek-wisata/
│   │   ├── paket-wisata/
│   │   ├── penginapan/
│   │   ├── reservasi/
│   │   ├── berita/
│   │   ├── dashboard/
│   │   └── home.blade.php
├── routes/
│   └── web.php
└── bootstrap/
    └── app.php
```

## 🎯 Endpoint Routes

### Public Routes
```
GET  /                           - Landing Page
GET  /objek-wisata               - Daftar Objek Wisata
GET  /objek-wisata/{id}          - Detail Objek Wisata
GET  /paket-wisata               - Daftar Paket Wisata
GET  /paket-wisata/{id}          - Detail Paket Wisata
GET  /penginapan                 - Daftar Penginapan
GET  /penginapan/{id}            - Detail Penginapan
GET  /berita                     - Daftar Berita
GET  /berita/{id}                - Detail Berita
```

### Authenticated Routes
```
GET  /dashboard                  - Dashboard (Role-Based)
GET  /profile                    - Edit Profil
POST /profile                    - Update Profil
DELETE /profile                  - Hapus Akun
```

### Customer Routes
```
GET  /reservasi                  - Daftar Reservasi Saya
GET  /reservasi/create           - Buat Reservasi Baru
POST /reservasi                  - Store Reservasi
GET  /reservasi/{id}             - Detail Reservasi
GET  /reservasi/{id}/edit        - Edit Reservasi
PATCH /reservasi/{id}            - Update Reservasi
DELETE /reservasi/{id}           - Hapus Reservasi
```

### Admin/Manager Routes
```
POST /objek-wisata               - Buat Objek Wisata
GET  /objek-wisata/{id}/edit     - Edit Form Objek Wisata
PATCH /objek-wisata/{id}         - Update Objek Wisata
DELETE /objek-wisata/{id}        - Hapus Objek Wisata

POST /paket-wisata               - Buat Paket Wisata
GET  /paket-wisata/{id}/edit     - Edit Form Paket Wisata
PATCH /paket-wisata/{id}         - Update Paket Wisata
DELETE /paket-wisata/{id}        - Hapus Paket Wisata

POST /penginapan                 - Buat Penginapan
GET  /penginapan/{id}/edit       - Edit Form Penginapan
PATCH /penginapan/{id}           - Update Penginapan
DELETE /penginapan/{id}          - Hapus Penginapan
```

### Staff/Admin/Manager Routes
```
POST /berita                     - Buat Berita
GET  /berita/create              - Form Berita Baru
GET  /berita/{id}/edit           - Edit Form Berita
PATCH /berita/{id}               - Update Berita
DELETE /berita/{id}              - Hapus Berita
```

## 🎨 Warna & Styling

### Warna Utama
- **Kuning (Desmok Yellow)**: #FFD700
- **Biru (Desmok Blue)**: #1E90FF
- **Light Yellow**: #FFF8DC
- **Light Blue**: #E0F4FF

### Font
- **Comic Neue** - Font utama dengan style comic yang ceria
- **Poppins** - Font fallback untuk body text

### Animasi
- **Float**: Elemen naik-turun perlahan
- **Slide-In**: Elemen masuk dari atas
- **Pulse**: Elemen berdetak dengan perubahan warna
- **Hover Effects**: Card dan button bergeser sedikit ke atas dengan shadow lebih besar

## 📝 Database Schema

### Users Table
- id
- name
- email
- password
- role (admin, manager, staff, customer)
- is_active
- email_verified_at
- remember_token
- timestamps

### Pelanggan Table
- id
- user_id (FK)
- nomor_identitas
- jenis_identitas
- alamat
- kota
- provinsi
- kode_pos
- telepon
- timestamps

### ObjekWisata Table
- id
- kategori_wisata_id (FK)
- nama_objek
- deskripsi
- lokasi
- harga_tiket
- jam_buka
- jam_tutup
- foto
- rating
- timestamps

### PaketWisata Table
- id
- nama_paket
- deskripsi
- harga_paket
- durasi_hari
- durasi_jam
- kuota_peserta
- itinerary
- foto
- timestamps

### Penginapan Table
- id
- nama_penginapan
- deskripsi
- alamat
- telepon
- harga_penginapan
- jumlah_kamar
- tipe_kamar
- foto
- rating
- timestamps

### Reservasi Table
- id
- pelanggan_id (FK)
- paket_wisata_id (FK, nullable)
- penginapan_id (FK, nullable)
- tanggal_reservasi
- tanggal_kunjungan
- jumlah_peserta
- total_harga
- status (pending, confirmed, cancelled)
- catatan
- timestamps

### Berita Table
- id
- kategori_berita_id (FK)
- user_id (FK)
- judul
- konten
- foto
- status
- timestamps

## 🔧 Setup & Installation

### 1. Copy .env
```bash
cp .env.example .env
```

### 2. Generate App Key
```bash
php artisan key:generate
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Seed Database
```bash
php artisan db:seed
```

### 5. Start Development Server
```bash
php artisan serve
```

### 6. Compile Assets (optional)
```bash
npm install
npm run dev
```

## 📱 Responsive Design

Aplikasi ini fully responsive dan dapat diakses dari:
- ✅ Desktop (1920px dan lebih)
- ✅ Tablet (768px - 1024px)
- ✅ Mobile (320px - 767px)

## 🔒 Security

- CSRF Protection pada semua form
- Password hashing dengan bcrypt
- Role-based access control
- Input validation pada semua form
- SQL injection protection

## 🎯 Next Steps untuk Development

1. **Upload Gambar**: Implementasi upload gambar ke storage/public
2. **Email Notification**: Kirim email konfirmasi reservasi
3. **Payment Gateway**: Integrasi payment gateway (Midtrans, Stripe)
4. **Rating & Review**: Sistem rating dan review
5. **Discount Code**: Sistem kode diskon
6. **Advanced Search**: Fitur pencarian dan filtering lebih kompleks
7. **API**: Buat REST API untuk mobile app
8. **Analytics**: Dashboard analytics untuk penjualan

## 📞 Support

Untuk pertanyaan atau bantuan lebih lanjut, hubungi:
- Email: info@desmok.com
- Telepon: (0123) 456-7890

---

**Happy Booking! 🎉 Selamat menikmati wisata di Desa Jomok!**
