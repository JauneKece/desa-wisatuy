# Rencana Migrasi & Analisa Perbedaan Database

Tanggal: 2026-04-05

Ringkasan singkat
- Tujuan: Ubah struktur database dan alur sehingga cocok dengan skema pada screenshot kedua (DB2), tanpa mengorbankan fitur yang sudah ada pada skema pertama (DB1).
- Pendekatan: Migrasi inkremental — tambahkan kolom/tabel baru sesuai DB2, migrasikan data, update kode untuk mendukung kedua skema secara bersamaan, lalu deprecate bidang lama setelah verifikasi.

1) Perbedaan Utama (ringkasan per-tabel)

- `users`
  - DB1: kolom `role`/`level` enum yang terlihat `('admin','manager','staff','customer')` dan atribut `is_active`, `email_verified_at`.
  - DB2: enum berbeda (`admin','bendahara','pelanggan','pemilik'`) dan `level` penamaan. DB2 menaruh `id_user` di beberapa tabel (link ke users).
  - Dampak: Perlu peta konversi role/level dan penambahan nilai enum yang kompatibel atau field mapping di model.

- `pelanggan` (customers)
  - DB1: rich customer profile (user_id, nomor_identitas, alamat, kota, provinsi, kode_pos, telepon, dsb.).
  - DB2: lebih ringkas (`nama_lengkap`, `no_hp`, `alamat`, `foto`, `id_user`).
  - Dampak: Semua kolom DB1 harus tetap tersedia/integritas data dijaga; jika DB2 mengurangi fields, migrasi harus menyalin atau menyimpan data DB1 ke kolom DB2 yang relevan, atau menambah kolom DB2 agar tidak kehilangan data.

- `reservasi`
  - DB1: struktur dengan `pelanggan_id`, `paket_wisata_id`, `penginapan_id`, `tanggal_reservasi`, `tanggal_kunjungan`, `jumlah_peserta`, `total_harga`, `status (varchar)`, `catatan`.
  - DB2: memakai `tgl_reservasi_wisata datetime`, `harga`, `diskon`, `nilai_diskon`, `total_bayar`, `file_bukti_tr`, `status_reservasi_wisata` enum (`pesan`,`dibayar`,`selesai`). Pembayaran kadang disatukan ke dalam reservasi.
  - Dampak: Jika aplikasi DB1 memakai tabel `payments` terpisah (DB1 punya `payments`), pilih strategi: (A) pertahankan `payments` dan tambah kolom DB2 ke `reservasi` sebagai denormalisasi; atau (B) migrasikan `payments` ke kolom di `reservasi` dan hapus `payments` nantinya. Pilih A untuk minimal risk.

- `payments`
  - DB1: tabel terpisah (`reservasi_id`, `amount`, `method`, `transaction_id`, `status`, `paid_at`, `metadata`).
  - DB2: beberapa field pembayaran disimpan di `reservasi` (`file_bukti_tr`, `status_reservasi_wisata`, total fields).
  - Dampak: Pertahankan `payments` sambil menambahkan kolom agregasi di `reservasi` agar DB2-compatible.

- `paket_wisata`, `objek_wisata`, `penginapan`, `kategori_*`, `berita`
  - Perbedaan nama kolom (foto1..foto5 vs foto tunggal, `fasilitas`), tipe harga (int vs decimal), dan penamaan kolom. DB2 tampak memiliki lebih banyak foto (foto1..foto5) dan beberapa kolom ringkas.
  - Dampak: Tambah kolom baru (foto2..foto5, fasilitas) sambil tetap menjaga kolom lama (`foto`) agar tidak kehilangan data.

2) Prinsip migrasi tanpa kehilangan fitur

- Jangan hapus kolom DB1 sebelum semua kode dan data diuji.
- Lakukan migrasi bertahap: tambahkan kolom/tables DB2 → copy/transform data → update kode memakai fields DB2 (sambil mendukung fallback ke DB1 fields) → verifikasi → hapus/deprecate lama.
- Gunakan mekanisme dual-write sementara (saat melakukan perubahan pada aplikasi, tulis ke field lama dan baru) atau job background untuk sinkronisasi.

3) Pemetaan dan perubahan yang harus dibuat (contoh per-tabel)

- `users`
  - Tambah nilai enum yang diperlukan jika belum ada (`bendahara`,`pemilik`) atau ubah enum menjadi tabel `roles` untuk fleksibilitas jangka panjang.
  - Tambah kolom `level` jika DB2 memakai `level` dan DB1 memakai `role` (ataupun buat accessor supaya keduanya sinkron).

- `pelanggan`
  - Tambah kolom `nama_lengkap`, `no_hp`, `foto` pada DB1 jika belum ada.
  - Jika DB1 memiliki kolom detail lain (provinsi, kode_pos) — tetap simpan; buat migration script untuk mengisi `pelanggan.nama_lengkap` dari `users.name` atau gabungan kolom.

- `reservasi` dan `payments`
  - Tambah kolom di `reservasi`: `harga`, `diskon`, `nilai_diskon`, `total_bayar`, `file_bukti_tr`, `status_reservasi_wisata` (enum yang mencakup `pesan,dibayar,selesai`).
  - Biarkan tabel `payments` tetap ada; tambahkan trigger/job untuk meng-update `reservasi.total_bayar` dan `reservasi.status_reservasi_wisata` dari record `payments` (saat payment berubah menjadi `paid`).
  - Pilih konsistensi: source-of-truth pembayaran tetap `payments` (DB1) agar laporan/history lebih lengkap.

- `paket_wisata`, `objek_wisata`, `penginapan`
  - Tambah kolom `foto2..foto5` dan `fasilitas` serta `harga_per_pack` (atau alias) sesuai DB2.
  - Periksa tipe numerik: jika DB2 pakai `int` sedangkan DB1 pakai `decimal`, pilih `decimal(12,2)` agar tidak kehilangan desimal.

4) Contoh langkah migrasi teknis (urutan)

1. Backup DB penuh dan buat environment staging yang identik.
2. Buat migrations baru yang menambahkan kolom/tabel DB2 ke DB1 (tanpa drop apapun).
3. Jalankan migrations di staging.
4. Tulis dan jalankan script migrasi data (SQL/Artisan command) untuk menyalin/transform data:
   - copy `users.role` → map ke `users.level` (sediakan peta konversi)
   - copy `payments` summary → `reservasi.total_bayar` dan `reservasi.status_reservasi_wisata`
   - copy `paket_wisata.foto` → `paket_wisata.foto1` dan set `foto2..foto5` = NULL
5. Update Eloquent models: tambahkan atribut baru di `$fillable`, buat accessors/mutators untuk backward compatibility.
6. Update service layer / controller untuk menulis ke kedua fields (lama & baru) atau pakai adapter untuk support kedua skema.
7. Deploy ke staging, jalankan tests integrasi (reservasi + pembayaran + pelanggan + upload foto).
8. Setelah verifikasi, lakukan deploy ke produksi dengan window maintenance. Monitor logs, rollback jika perlu.

5) Contoh SQL/Artisan migration snippets (template)

-- Contoh: tambahkan kolom reservasi
-- Laravel migration (PHP) – ringkasan:

```php
Schema::table('reservasi', function (Blueprint $table) {
  $table->decimal('harga', 12, 2)->nullable();
  $table->decimal('diskon', 10, 2)->nullable();
  $table->decimal('nilai_diskon', 12, 2)->nullable();
  $table->bigInteger('total_bayar')->nullable();
  $table->string('file_bukti_tr')->nullable();
  $table->enum('status_reservasi_wisata', ['pesan','dibayar','selesai'])->nullable();
});
```

-- Contoh SQL migrasi data: summarize payments → reservasi

```sql
UPDATE reservasi r
JOIN (
  SELECT reservasi_id, SUM(amount) AS paid_sum, MAX(CASE WHEN status='paid' THEN 1 ELSE 0 END) AS any_paid
  FROM payments
  GROUP BY reservasi_id
) p ON p.reservasi_id = r.id
SET r.total_bayar = p.paid_sum,
    r.status_reservasi_wisata = CASE WHEN p.any_paid=1 THEN 'dibayar' ELSE r.status_reservasi_wisata END;
```

6) Kompatibilitas & testing

- Unit tests: update model tests untuk memastikan accessor/alias bekerja.
- Integration tests: alur reservasi lengkap (buat reservasi → upload bukti → payment → status berubah) di staging.
- Manual QA: verifikasi tampilan profil pelanggan, history payment, report keuangan apakah angka konsisten.

7) Rollback & safety

- Backup DB (dump) sebelum produksi.
- Migrate only-additive schema first (menambahkan kolom). Jangan menghapus kolom sampai >2 release dan semua data/logic sudah memakai field baru.
- Sediakan migration rollback script untuk menghapus kolom baru jika terjadi masalah.

8) Estimasi pekerjaan & prioritas

- Fase 1 (1-2 hari): buat migrations additive + dokumen mapping + data migration script di staging.
- Fase 2 (2-4 hari): update models + services dan jalankan tests integrasi.
- Fase 3 (1 hari): deploy ke production dengan monitoring.

9) Rekomendasi tambahan teknis

- Pertimbangkan membuat tabel `roles` untuk fleksibilitas role/level.
- Gunakan background queue job (Laravel Queue) untuk sinkronisasi massal data, supaya tidak memblokir produksi.
- Document API contract dan backward compatibility bagi client yang mungkin mengandalkan field lama.

Jika Anda ingin, saya bisa:
- menghasilkan migration files (Laravel) untuk semua perubahan additive yang diperlukan.
- membuat skrip migrasi data SQL/Artisan lengkap untuk tabel utama (`users`,`pelanggan`,`reservasi`,`paket_wisata`,`objek_wisata`,`penginapan`).

---
Dokumen ini dibuat berdasarkan perbandingan visual dari dua screenshot skema DB yang Anda lampirkan. Bila Anda mau, saya bisa menambahkan peta kolom lengkap (kolom-lama → kolom-baru) per tabel dengan SQL migrasi yang lebih spesifik.
