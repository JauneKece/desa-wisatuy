<footer class="site-footer">
    <div class="site-footer__inner container-responsive">
        <div class="site-footer__cards">
            <section class="footer-card">
                <h5 class="footer-card__title">✨ DESMOK</h5>
                <p class="footer-card__text">
                    Platform reservasi wisata terpercaya untuk Desa Jomok. Nikmati pengalaman wisata yang tak terlupakan dengan layanan terbaik kami.
                </p>
                <div class="footer-socials">
                    <a href="#" class="footer-social" aria-label="Facebook">f</a>
                    <a href="#" class="footer-social" aria-label="X">𝕏</a>
                    <a href="#" class="footer-social" aria-label="Instagram">📷</a>
                </div>
            </section>

            <section class="footer-card">
                <h5 class="footer-card__heading">📞 Hubungi Kami</h5>
                <ul class="footer-list footer-list--contact">
                    <li><span>📱</span><span>(0123) 456-7890</span></li>
                    <li><span>✉️</span><span>info@desmok.com</span></li>
                    <li><span>📍</span><span>Desa Jomok, Indonesia</span></li>
                </ul>
            </section>

            <section class="footer-card">
                <h5 class="footer-card__heading">🕐 Jam Operasional</h5>
                <ul class="footer-list footer-list--hours">
                    <li><span>Senin - Jumat</span><strong>08:00 - 17:00</strong></li>
                    <li><span>Sabtu</span><strong>08:00 - 16:00</strong></li>
                    <li><span>Minggu</span><strong>09:00 - 15:00</strong></li>
                </ul>
            </section>
        </div>

        <div class="footer-links-grid">
            <div>
                <h6>Jelajahi</h6>
                <ul>
                    <li><a href="{{ route('objek-wisata.index') }}">Objek Wisata</a></li>
                    <li><a href="{{ route('paket-wisata.index') }}">Paket Wisata</a></li>
                    <li><a href="{{ route('penginapan.index') }}">Penginapan</a></li>
                </ul>
            </div>
            <div>
                <h6>Informasi</h6>
                <ul>
                    <li><a href="{{ route('berita.index') }}">Berita & Update</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan</a></li>
                </ul>
            </div>
            <div>
                <h6>Bantuan</h6>
                <ul>
                    <li><a href="#">Dukungan</a></li>
                    <li><a href="#">Panduan</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                </ul>
            </div>
            <div>
                <h6>Legal</h6>
                <ul>
                    <li><a href="#">Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Lisensi</a></li>
                </ul>
            </div>
        </div>

        <div class="site-footer__divider"></div>

        <div class="site-footer__copyright">
            <p>
                &copy; 2026 <span>DESMOK</span> - Desa Jomok Tourism. All rights reserved.
            </p>
            <p>
                Designed with ❤️ by <span>Desmok Team</span>
            </p>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        margin-top: 3.5rem;
        border-top: 2px solid #E2B59A;
        background: linear-gradient(180deg, rgba(255, 225, 175, 0.98) 0%, #FFE1AF 100%);
    }

    .site-footer__inner {
        padding-top: 3rem;
        padding-bottom: 2rem;
    }

    .site-footer__cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .footer-card {
        display: flex;
        flex-direction: column;
        min-height: 230px;
        padding: 1.5rem;
        border: 2px solid #E2B59A;
        border-radius: 1.1rem;
        background-color: #FFF8EA;
        box-shadow: 0 8px 18px rgba(149, 124, 98, 0.08);
    }

    .footer-card__title {
        margin: 0 0 0.75rem;
        font-size: 2rem;
        font-weight: 900;
        color: #957C62;
    }

    .footer-card__heading {
        margin: 0 0 1rem;
        font-size: 1.7rem;
        font-weight: 800;
        color: #957C62;
    }

    .footer-card__text {
        margin: 0;
        color: #B77466;
        line-height: 1.7;
        font-size: 1rem;
    }

    .footer-socials {
        display: flex;
        gap: 0.65rem;
        margin-top: auto;
        padding-top: 1rem;
    }

    .footer-social {
        width: 2.5rem;
        height: 2.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.65rem;
        background-color: #B77466;
        color: #fff;
        text-decoration: none;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .footer-social:hover {
        background-color: #957C62;
        transform: translateY(-2px);
    }

    .footer-list {
        margin: 0;
        padding: 0;
        list-style: none;
        color: #B77466;
    }

    .footer-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.7rem;
    }

    .footer-list--hours li {
        justify-content: space-between;
    }

    .footer-list--hours strong {
        color: #957C62;
    }

    .footer-links-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.25rem;
        border-top: 1px solid #E2B59A;
        padding-top: 1.75rem;
    }

    .footer-links-grid h6 {
        margin: 0 0 0.85rem;
        font-size: 1.1rem;
        color: #957C62;
        font-weight: 700;
    }

    .footer-links-grid ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .footer-links-grid li + li {
        margin-top: 0.55rem;
    }

    .footer-links-grid a {
        color: #B77466;
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: border-color 0.2s ease, color 0.2s ease;
    }

    .footer-links-grid a:hover {
        color: #957C62;
        border-bottom-color: #957C62;
    }

    .site-footer__divider {
        height: 3px;
        margin: 2rem 0 1.25rem;
        border-radius: 999px;
        background-color: #E2B59A;
    }

    .site-footer__copyright {
        text-align: center;
        color: #B77466;
    }

    .site-footer__copyright p {
        margin: 0.15rem 0;
    }

    .site-footer__copyright span {
        color: #957C62;
        font-weight: 700;
    }

    @media (max-width: 1024px) {
        .site-footer__cards {
            grid-template-columns: 1fr;
        }

        .footer-card {
            min-height: 0;
        }

        .footer-links-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .site-footer {
            margin-top: 2.25rem;
        }

        .site-footer__inner {
            padding-top: 2.25rem;
        }

        .footer-card__title {
            font-size: 1.6rem;
        }

        .footer-card__heading {
            font-size: 1.3rem;
        }

        .footer-links-grid {
            grid-template-columns: 1fr;
        }
    }
</style>