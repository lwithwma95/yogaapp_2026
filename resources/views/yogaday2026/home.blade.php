@include('yogaday2026.layouts.header')

{{-- ── HERO SECTION ─────────────────────────────────────────── --}}
<br>
<section class="new-hero-section">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100">

            {{-- LEFT CONTENT --}}
            <div class="col-lg-6">
                <div class="hero-content-box">
                    <div class="hero-tag">INTERNATIONAL YOGA DAY 2026</div>
                    <h1 class="hero-main-title">
                        Yoga for Wellness,<br>Wisdom, and World Peace
                    </h1>
                    <p class="hero-text">
                        Join the grand celebration of International Yoga Day 2026
                        and inspire a healthier, peaceful, and mindful society
                        through yoga, meditation, and wellness practices.
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('findmembers') }}" class="btn hero-register-btn">
                            Register Now
                        </a>
                        <a href="{{ route('searchbyshg') }}" class="btn btn-outline-light ms-2">
                            Search by SHG
                        </a>
                    </div>
                </div>
            </div>

            {{-- RIGHT IMAGE --}}
            <div class="col-lg-6">
                <div class="hero-image-wrapper text-center">
                    <div class="circle-bg"></div>
                    <img src="{{ asset('assets/images/cm_official_no3.png') }}" class="img-fluid hero-cm-image"
                        alt="Chief Minister">
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── STATS RIBBON ──────────────────────────────────────────── --}}

{{-- ── WHY YOGA SECTION ─────────────────────────────────────── --}}
<section class="modern-about-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="modern-section-title">Why Yoga Matters</h2>
            <p class="modern-section-subtitle">
                Yoga is the journey of the self, through the self, to the self.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="modern-card h-100">
                    <div class="modern-icon">🧘</div>
                    <h4>Mental Peace</h4>
                    <p>Reduce stress, anxiety and improve mindfulness through meditation.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="modern-card h-100">
                    <div class="modern-icon">💚</div>
                    <h4>Healthy Lifestyle</h4>
                    <p>Improve immunity, flexibility, posture and body balance naturally.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="modern-card h-100">
                    <div class="modern-icon">🌎</div>
                    <h4>Global Unity</h4>
                    <p>Yoga connects humanity with peace, harmony and positivity.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── GALLERY ──────────────────────────────────────────────── --}}
<section class="gallery-modern-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="modern-section-title text-white">Yoga Moments</h2>
        </div>
        <div id="yogaGalleryCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#yogaGalleryCarousel" data-bs-slide-to="0"
                    class="active"></button>
                <button type="button" data-bs-target="#yogaGalleryCarousel" data-bs-slide-to="1"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row g-4">
                        <div class="col-md-4"><img src="{{ asset('assets/images/pic1.jpg') }}"
                                class="modern-gallery-img w-100" alt="Yoga"></div>
                        <div class="col-md-4"><img src="{{ asset('assets/images/pic2.jpg') }}"
                                class="modern-gallery-img w-100" alt="Yoga"></div>
                        <div class="col-md-4"><img src="{{ asset('assets/images/pic4.jpg') }}"
                                class="modern-gallery-img w-100" alt="Yoga"></div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row g-4">
                        <div class="col-md-4"><img src="{{ asset('assets/images/pic3.jpg') }}"
                                class="modern-gallery-img w-100" alt="Yoga"></div>
                        <div class="col-md-4"><img src="{{ asset('assets/images/pic5.jpg') }}"
                                class="modern-gallery-img w-100" alt="Yoga"></div>
                        <div class="col-md-4"><img src="{{ asset('assets/images/pic6.jpg') }}"
                                class="modern-gallery-img w-100" alt="Yoga"></div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#yogaGalleryCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#yogaGalleryCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

{{-- ── ANALYTICS SECTION ────────────────────────────────────── --}}


{{-- ── CALL TO ACTION ───────────────────────────────────────── --}}
<section
    style="background:linear-gradient(135deg,#1b5e20,#2e7d32,#388e3c);padding:60px 0;text-align:center;color:#fff;">
    <div class="container">
        <h2 style="font-size:2.1rem;font-weight:800;margin-bottom:14px;">
            Ready to Join the Movement?
        </h2>
        <p style="font-size:16px;opacity:.85;max-width:500px;margin:0 auto 28px;">
            Register yourself for International Yoga Day 2026 and be part of Assam's
            largest wellness initiative.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('findmembers') }}"
                style="background:#fff;color:#2e7d32;padding:14px 36px;border-radius:50px;font-weight:800;text-decoration:none;font-size:15px;letter-spacing:.3px;transition:.2s;"
                onmouseover="this.style.background='#e8f5e9'" onmouseout="this.style.background='#fff'">
                Register Now
            </a>
            <a href="{{ route('searchbyshg') }}"
                style="background:transparent;color:#fff;padding:14px 36px;border-radius:50px;font-weight:700;text-decoration:none;font-size:15px;border:2px solid rgba(255,255,255,.55);transition:.2s;"
                onmouseover="this.style.borderColor='#fff'" onmouseout="this.style.borderColor='rgba(255,255,255,.55)'">
                Search by SHG
            </a>
        </div>
    </div>
</section>

@include('yogaday2026.layouts.footer')

{{-- ── CHART.JS INITIALIZATION ─────────────────────────────── --}}
