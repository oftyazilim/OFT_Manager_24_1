@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Landing - Front Pages')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/nouislider/nouislider.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

<!-- Page Styles -->
@section('page-style')
@vite(['resources/assets/vendor/scss/pages/front-page-landing.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/nouislider/nouislider.js',
  'resources/assets/vendor/libs/swiper/swiper.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/front-page-landing.js'])
@endsection


@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relative">
                <img src="{{ asset('assets/img/front-pages/backgrounds/hero-bg.png') }}" alt="hero background"
                    class="position-absolute top-0 start-50 translate-middle-x object-fit-contain w-100 h-100"
                    data-speed="1" />
                <div class="container">
                    <div class="hero-text-box text-center">
                        <h3 class="baslik  hero-title ">Kalite ve inovasyonun adı:</h3>
                        <h1 style="font-size: 100px;" class="text-primary hero-title display-6 fw-bold">GASSERO</h1>
                        <h2 class="hero-sub-title h6 mb-4 pb-1">
                            Detaylı Üretim, Üstün Performans<br class="d-none d-lg-block" />

                        </h2>
                        <div class="landing-hero-btn d-inline-block position-relative">
                          <span class="hero-btn-item position-absolute d-none d-md-flex text-heading">

                              Gassero'nun tercihi 'OFT Yazılım'
                              <img src="{{ asset('assets/img/front-pages/icons/Join-community-arrow.png') }}"
                                  alt="Join community arrow" class="scaleX-n1-rtl" />
                              <a  href="https://www.oftsoftware.com/" class="btn btn-primary btn-lg">Sizde deneyin!</a>

                          </span>

                      </div>
                    </div>
                    <div id="heroDashboardAnimation" class="hero-animation-img">
                        <a href="https://www.oftsoftware.com/" target="_blank">
                            <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
                                <img src="{{ asset('assets/img/front-pages/landing-page/hero-dashboard-' . $configData['style'] . '.png') }}"
                                    alt="hero dashboard" class="animation-img"
                                    data-app-light-img="front-pages/landing-page/hero-dashboard-light.png"
                                    data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
                                <img src="{{ asset('assets/img/front-pages/landing-page/hero-elements-' . $configData['style'] . '.png') }}"
                                    alt="hero elements"
                                    class="position-absolute hero-elements-img animation-img top-0 start-0"
                                    data-app-light-img="front-pages/landing-page/hero-elements-light.png"
                                    data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="landing-hero-blank"></div>
        </section>
        <!-- Hero: End -->


    </div>
@endsection
