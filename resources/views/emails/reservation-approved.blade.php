@component('mail::message')
# Selamat! Reservasi Anda Telah Disetujui 🎉

Halo {{ $pelanggan->user->name }},

Kami dengan senang hati memberitahukan bahwa **pembayaran Anda telah diverifikasi dan reservasi Anda telah disetujui**!

<div style="margin: 20px 0; padding: 20px; background-color: #f0f5f9; border-left: 4px solid #1e90ff; border-radius: 4px;">

### Detail Reservasi

**ID Reservasi:** {{ $reservasi->id }}

**Paket Wisata:** {{ $paketWisata->nama }}

**Akomodasi:** {{ $penginapan->nama }}

**Tanggal Kunjungan:** {{ $reservasi->tanggal_kunjungan->translatedFormat('l, j F Y') }}

**Jumlah Peserta:** {{ $reservasi->jumlah_peserta }} orang

**Total Harga:** Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}

**Status Pembayaran:** Sudah Diverifikasi ✅

</div>

### Apa yang Selanjutnya?

Reservasi Anda sudah dikonfirmasi oleh tim admin kami. Berikut adalah langkah-langkah selanjutnya:

1. **Siapkan Dokumen Penting**
   - Bawa kartu identitas asli Anda pada hari kunjungan
   - Cetak atau simpan email konfirmasi ini sebagai bukti pemesanan

2. **Hubungi Kami Jika Ada Pertanyaan**
   - Silakan hubungi tim customer service kami untuk pertanyaan lebih lanjut
   - Kami siap membantu Anda 24/7

3. **Nikmati Pengalaman Terbaik**
   - Tim kami akan memastikan pengalaman wisata Anda tak terlupakan
   - Terima kasih telah memilih Desa Wisata Jomok!

<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">

@if ($reservasi->catatan)
**Catatan Tambahan:** {{ $reservasi->catatan }}
@endif

Terima kasih telah mempercayai kami untuk menjadi bagian dari liburan impian Anda!

Salam hangat,<br>
**Tim Desa Wisata Jomok**

</div>

@endcomponent
