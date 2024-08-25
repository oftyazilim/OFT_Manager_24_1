@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Ana Sayfa')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/swiper/swiper.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/dashboards-analytics.js'])

@section('content')
    <!-- Earning Reports -->
    <div class="col-lg-6">
        <div class="card h-50">
            <div class="card-header pb-0 d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Haftalık Durum Raporu</h5>
                    <p class="card-subtitle">Son 7 Günün Ton Bazında Dağılımı</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center g-md-8">
                    <div class="col-12 col-md-5 d-flex flex-column">
                        <div class="d-flex gap-2 align-items-center mb-3 flex-wrap">
                            <h2 class="mb-0">35 Ton</h2>
                            <div class="badge rounded bg-label-success">+4.2%</div>
                        </div>
                        <small class="text-body">Değerlendirme önceki haftanın ortalamasına göre yapılmaktadır</small>
                    </div>
                    <div class="col-12 col-md-7 ps-xl-8">
                        <div id="weeklyEarningReports"></div>
                    </div>
                </div>
                <div class="border rounded p-5 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-primary p-1"><i class="ti ti-currency-dollar ti-sm"></i>
                                </div>
                                <h6 class="mb-0 fw-normal">Satış</h6>
                            </div>
                            <h4 class="my-2">190 Ton</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                                <h6 class="mb-0 fw-normal">Üretim</h6>
                            </div>
                            <h4 class="my-2">224 Ton</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1"><i class="ti ti-brand-paypal ti-sm"></i>
                                </div>
                                <h6 class="mb-0 fw-normal">Hammadde</h6>
                            </div>
                            <h4 class="my-2">235 Ton</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Earning Reports -->
@endsection
