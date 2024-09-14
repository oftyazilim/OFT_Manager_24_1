@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', '2. Kalite Sayım Listesi')

<!-- Vendor Styles -->
@section('vendor-style')

    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/stoklar-kalite2s-sayim.js'])
@endsection


@vite(['resources/assets/vendor/libs/jquery/jquery.js'])

@section('content')

    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Paket Adedi</span>
                            <h4 id="toplamPaket" class="mb-0 me-2">0<span style="font-size: 14px;"> Kg</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Ağırlık (Genel)</span>
                            <h4 id="toplamGenel" class="mb-0 me-2">0<span style="font-size: 14px;"> Kg</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Ağırlık (HR)</span>
                            <h4 id="toplamHr" class="mb-0 me-2">0<span style="font-size: 14px;"> Kg</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Ağırlık (Diğer)</span>
                            <h4 id="toplamDiger" class="mb-0 me-2">0<span style="font-size: 14px;"> Kg</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>












    <div class="card mt-2">
        <div class="card">
            <div class="card-datatable table-responsive-sm  text-nowrap">
                <table style="font-size: 14px" class="datatables-kalite2 table-sm">
                    <thead class="border-top">
                        <tr>
                            <th>GÖSTER</th>
                            <th>MAMÜL</th>
                            <th>BOY</th>
                            <th>GERÇEK ADET</th>
                            <th>GERÇEK KG</th>
                            <th>SİSTEM ADET</th>
                            <th>SİSTEM KG</th>
                            <th>NEVİ</th>
                            <th style="text-align: center;">PAKET NO</th>
                            <th>HAT</th>
                            <th>TARİH</th>
                            <th>SAAT</th>
                            <th>PERSONEL</th>
                            <th>MAMUL KODU</th>
                            <th>BASILDI</th>
                            <th>ID</th>
                            <th style="text-align: center;">EYLEM</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th colspan="2">Genel Toplam :</th>
                            <th style="font-weight: bold; font-size: 14px; text-align: right;"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>



    </div>
    @endsection
