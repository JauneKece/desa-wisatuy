# Reservasi & Pembayaran — Rencana Fitur (Simple)

## Ringkasan
Sistem saat ini membuat record `reservasi` dengan `status = pending` dan menghitung `total_harga`. Database telah diperbarui menambahkan tabel `payments` dan beberapa kolom/enum di `reservasi` (mis. `status`, `expired_at`, `booking_code`). Dokumen ini menjelaskan fitur minimal yang perlu ditambahkan agar desa/manager dapat menegakkan aturan pembayaran sederhana, aman, dan mudah dioperasikan.

## Tujuan
- Melacak pembayaran (manual + gateway).
- Menghubungkan status reservasi dengan status pembayaran.
- Memudahkan verifikasi oleh admin/manager.
- Mencegah konfirmasi reservasi tanpa bukti pembayaran (kecuali kebijakan berbeda).

## Mapping DB singkat
- Tabel `reservasi` (sudah ada): `status`, `expired_at`, `booking_code`, `total_harga`.
- Tabel `payments` (sudah ada): relasi `reservasi_id`, kolom `amount`, `method` (bank_transfer/qris/midtrans/cash), `transaction_id`, `proof_path`, `status` (pending/paid/failed/refunded), `paid_at`, `metadata`.
- Relasi: `Reservasi hasMany Payment` (mendukung deposit/partial), `Payment belongsTo Reservasi`.

## Kebijakan status (rekomendasi sederhana)
- Default saat dibuat: `reservasi.status = pending`.
- Payment `status = paid` → otomatis: jika policy = auto-confirm → set `reservasi.status = confirmed`.
- Jika policy = manual → admin memverifikasi bukti → setelah verifikasi → set `reservasi.status = confirmed`.
- Gunakan `expired_at` untuk auto-cancel reservasi tak terbayar (cron/command).

## Fitur yang harus ditambahkan (prioritas)
- Checkout / Payment initiation (gateway + manual).
- Upload bukti transfer untuk metode `bank_transfer`/`qris`.
- Endpoint webhook untuk gateway (Midtrans/Stripe) — verifikasi signature.
- Admin payment verification view (lihat bukti, amount, transaksi).
- Otomatisasi status synchronisation (payment -> reservation).
- Cron job / scheduled command untuk membatalkan reservasi `expired_at` yang belum dibayar.
- Notifikasi Email (atau WhatsApp/SMS) untuk status penting.
- Audit log / `reservation_logs` (catat event payment, verify, cancel).

## API endpoints (contoh)
- `POST /reservasi` — (existing) ubah: buat reservasi + buat payment pending OR redirect ke payment initiation.
- `POST /payments/initiate` — buat payment record & response token/redirect (gateway).
- `POST /payments/manual` — upload `proof_path` untuk manual transfer (multipart/form-data).
- `POST /payments/webhook` — menerima update dari gateway (signature check).
- `GET /admin/reservasi/{id}/payments` — detail & actions (verify/refund).
- `POST /admin/payments/{id}/verify` — manual verifikasi oleh admin.
- `GET /payments/{id}` — status.

## Flow pengguna (simple)
1. Customer memilih paket / penginapan → klik Checkout.
2. Sistem membuat `reservasi` (status pending, set `expired_at` e.g. now + 24h) dan buat `payments` record (status pending).
3. Jika gateway: redirect ke payment gateway; tunggu webhook.
4. Jika manual: tampilkan form upload bukti; customer upload → `payment.status = pending` (sampai admin verifikasi).
5. Webhook/verify → `payment.status = paid` → update `reservasi.status = confirmed` (atau beri flag untuk admin konfirmasi akhir).

## Webhook handling (best practice singkat)
- Verifikasi signature/signature key.
- Check idempotency: cari `payments.transaction_id` atau event id.
- Lakukan update dalam DB transaction: set `payments.status`, `paid_at`; set `reservasi.status` jika policy auto.
- Kirim notifikasi ke user & admin.

## UI yang perlu ditambahkan
- Customer:
  - Halaman Checkout dengan ringkasan harga, metode bayar, dan estimasi `expired_at`.
  - Upload bukti transfer (jika manual).
  - Halaman status reservasi (lihat payment history).
- Admin:
  - Daftar payments pending dengan tombol `Verify` / `Reject`.
  - Detail payment (bukti preview, amount, metadata).
  - Filter & laporan (per tanggal / paket).

## Keamanan & operasi
- Simpan API keys di `.env` (jangan commit ke repo).
- Batasi jenis file & ukuran upload; simpan file di `storage` dan gunakan signed URLs.
- Tangani webhook signature & replay (idempotency token).
- Log semua perubahan status untuk audit.
- Lindungi route admin dengan middleware role.

## Testing dan monitoring
- Tests:
  - Unit tests untuk service payment/state transitions.
  - Integration tests untuk webhook flow (simulate events).
  - E2E tests untuk manual upload + admin verify.
- Monitoring:
  - Logging webhook errors.
  - Alerts bila banyak pembayaran gagal.

## Migration / Model contoh (ringkas)
- Tabel `payments` minimal kolom:
  - `id`, `reservasi_id` (fk), `amount` DECIMAL, `method` VARCHAR/ENUM, `transaction_id` VARCHAR NULL, `proof_path` TEXT NULL, `status` ENUM(pending,paid,failed,refunded), `paid_at`, `metadata` JSON, timestamps.
- Models:
  - `Payment` with `reservasi()` belongsTo.
  - Update `Reservasi` with `payments()` hasMany dan helper `latestPayment()`.

## Cron / Scheduled job
- `php artisan schedule:run` job (daily/cron) atau queue:
  - Task: cancel expired reservations (`status = pending` & `expired_at < now()`) → set `status = expired` dan notify owner.

## Checklist tugas developer (MVP)
- [x] Buat file `reservasi-pembayaran-plan.md` (dokumen rencana).
- [x] Buat migration `create_payments_table` (jika belum).
- [x] Buat `Payment` model & relasi di `Reservasi`.
- [x] Update `ReservasiController@store` untuk create payment record / redirect payment.
- [x] Implement `PaymentController@manualUpload` (validation + store file).
- [x] Implement `WebhookController@handle` (verify signature + idempotency).
- [x] Buat admin UI: payments list, verify action.
- [ ] Buat notification templates (email).
- [x] Add scheduled command `CancelExpiredReservations`.
- [ ] Add tests (unit + integration).
- [ ] Add documentation & env variables di README.

## Prioritas implementasi (MVP)
1. Migration & models (`payments`), relasi.
2. Manual payment upload + admin verify (cepat & langsung operasi).
3. Webhook skeleton + sample gateway integration.
4. Notifications + cron expiry.
5. Tests & docs.

---

Jika Anda mau, saya bisa lanjut membuat contoh migration + `Payment` model + `WebhookController` skeleton. Beri tahu opsi yang Anda inginkan: (a) migration+model, (b) webhook controller, atau (c) view upload bukti + admin verify.