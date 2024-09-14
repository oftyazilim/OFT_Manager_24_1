@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', '2. Kalite Sayımı')

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
    @vite(['resources/assets/js/stoklar-kalite2-sayim-yap.js'])
@endsection


@vite(['resources/assets/vendor/libs/jquery/jquery.js'])

@section('content')

    <div class="row g-6 mb-6">
        <div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Sayaç (syl/sylm/tpl)</span>
                            <h4 class="mb-0 me-2">
                                <span id="toplamSayilanAdet" class="text-heading">0</span>
                                <span class="text-heading"> + </span>
                                <span id="sayilmayanStokAdeti" class="text-heading">0</span>
                                <span class="text-heading"> / </span>
                                <span id="toplam" class="text-heading">0</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2 p-2 pb-0">
                    <h6 id="mesaj" class="card-title text-center">Okutunuz...</h6>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h4 class="card-title">Barkod Okuma</h4>
                    <input type="number" id="barkodInput" class="form-control" autofocus>
                </div>
            </div>


        </div>
    </div>



@endsection
