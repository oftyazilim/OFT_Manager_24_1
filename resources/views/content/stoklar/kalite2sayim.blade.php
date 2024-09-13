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
    @vite(['resources/assets/js/stoklar-kalite2-sayim.js'])
@endsection


@vite(['resources/assets/vendor/libs/jquery/jquery.js'])

@section('content')

    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Stok Paket Adedi</span>
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
                            <span class="text-heading">Sayılan Paket Adedi</span>
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
                            <span class="text-heading">Sayılmayan Paket Adedi</span>
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
                            <span class="text-heading">Bulunamayan Paket Adedi</span>
                            <h4 id="toplamDiger" class="mb-0 me-2">0<span style="font-size: 14px;"> Kg</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <input type="hidden" name="ID" id="rec_id">
              <input type="hidden" name="URUNID" id="urun_id">
              {{-- <input type="hidden" name="miktarTemp" id="miktarTemp"> --}}
              <div class="modal-header">
                  <h3 class="modal-title" id="modalCenterTitle">Modal title</h3>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col mb-4">
                          <label for="mamul" class="form-label">Mamül</label>
                          <input type="text" id="mamul" class="form-control" readonly>
                      </div>
                  </div>
                  <div class="row g-4 mb-4">
                      <div class="col mb-0">
                          <label for="TARIH" class="form-label">Tarih</label>
                          <input type="date" id="TARIH" class="form-control">
                      </div>
                      <div class="col mb-0">
                          <label for="URETIMMIKTAR" class="form-label">Üretim Miktarı</label>
                          <input type="number" id="URETIMMIKTAR" class="form-control" placeholder="0">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col mb-4">
                          <label for="NOTLAR1" class="form-label">Not</label>
                          <textarea id="NOTLAR1" class="form-control dt-input" name="NOTLAR1" rows="4"></textarea>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Vazgeç</button>
                  <button type="button" id="btnKaydet" class="btn btn-primary">Kaydet</button>
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
