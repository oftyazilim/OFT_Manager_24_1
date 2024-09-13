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

<div class="row g-6">

  <!-- Orders -->
  <div class="col-lg-2 col-6">
      <div class="card h-100">
          <div class="card-body text-center">
              <div class="badge rounded p-2 bg-label-danger mb-2"><i class="ti ti-briefcase ti-lg"></i></div>
              <h5 class="card-title mb-1">97.8k</h5>
              <p class="mb-0">Orders</p>
          </div>
      </div>
  </div>

  <!-- Sales last year -->
  <div class="col-xl-2 col-md-4 col-6">
      <div class="card h-100">
          <div class="card-header pb-0">
              <h5 class="card-title mb-1">Sales</h5>
              <p class="card-subtitle">Last Year</p>
          </div>
          <div id="salesLastYear"></div>
          <div class="card-body pt-0">
              <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                  <h4 class="mb-0">175k</h4>
                  <small class="text-danger">-16.2%</small>
              </div>
          </div>
      </div>
  </div>

  <!-- Profit last month -->
  <div class="col-xl-2 col-md-4 col-6">
      <div class="card h-100">
          <div class="card-header pb-0">
              <h5 class="card-title mb-1">Profit</h5>
              <p class="card-subtitle">Last Month</p>
          </div>
          <div class="card-body">
              <div id="profitLastMonth"></div>
              <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                  <h4 class="mb-0">624k</h4>
                  <small class="text-success">+8.24%</small>
              </div>
          </div>
      </div>
  </div>

  <!-- Sessions Last month -->
  <div class="col-xl-2 col-md-4 col-6">
      <div class="card h-100">
          <div class="card-header pb-0">
              <h5 class="card-title mb-1">Sessions</h5>
              <p class="card-subtitle">Last Month</p>
          </div>
          <div class="card-body">
              <div id="sessionsLastMonth"></div>
              <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                  <h4 class="mb-0">45.1k</h4>
                  <small class="text-success">+12.6%</small>
              </div>
          </div>
      </div>
  </div>

  <!-- Expenses -->
  <div class="col-xl-2 col-md-4 col-6">
      <div class="card h-100">
          <div class="card-header pb-2">
              <h5 class="card-title mb-1">82.5k</h5>
              <p class="card-subtitle">Expenses</p>
          </div>
          <div class="card-body">
              <div id="expensesChart"></div>
              <div class="mt-3 text-center">
                  <small class="text-muted mt-3">$21k Expenses more than last month</small>
              </div>
          </div>
      </div>
  </div>

  <!-- Impression -->
  <div class="col-xl-2 col-md-4 col-6">
      <div class="card h-100">
          <div class="card-header pb-0">
              <h5 class="card-title mb-1">Impression</h5>
              <p class="card-subtitle">This Week</p>
          </div>
          <div class="card-body">
              <div id="impressionThisWeek"></div>
              <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                  <h4 class="mb-0">26.1k</h4>
                  <small class="text-danger">-24.5%</small>
              </div>
          </div>
      </div>
  </div>



</div>





    <!-- Earning Reports
    <div class="col-lg-6">
        <div class="card h-40">
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
                            <h2 id="uretimFark" class="mb-0">0 Ton</h2>
                            <div id="uretimFarkYuzde" class="badge rounded bg-label-success">+0%</div>
                        </div>
                        <small class="text-body">Değerlendirme önceki haftanın zaman dilimine göre yapılmaktadır</small>
                    </div>
                    <div class="col-12 col-md-7 ps-xl-8">
                        <div id="weeklyEarningReports"></div>
                    </div>
                </div>
                <div class="border rounded p-5 mt-5">
                    <div class="row gap-4 gap-sm-0">
                      <h5 class="mb-1 mt-0">Aylık Tonajlar & Hedefe Oranı</h5>
                      <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-primary p-1"><i class="ti ti-currency-dollar ti-sm"></i>
                                </div>
                                <h6 class="mb-0 fw-normal">Müşteri Siparişleri</h6>
                            </div>
                            <h4 id="satisTon" class="my-2">0 Ton</h4>
                            {{-- <div class="progress w-75" style="height:4px">
                                <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                                <h6 class="mb-0 fw-normal">Üretim</h6>
                            </div>
                            <h4 id="uretimTon" class="my-2">0 Ton</h4>
                            {{-- <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1"><i class="ti ti-brand-paypal ti-sm"></i>
                                </div>
                                <h6 class="mb-0 fw-normal">Hammadde</h6>
                            </div>
                            <h4 id="hammaddeTon" class="my-2">0 Ton</h4>
                            {{-- <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 Earning Reports -->
@endsection
