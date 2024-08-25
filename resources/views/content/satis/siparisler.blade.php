@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Müşteri Siparişleri')

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
    @vite(['resources/assets/js/satis-siparisler-list.js'])

@endsection


@vite(['resources/assets/vendor/libs/jquery/jquery.js'])

@section('content')

<div class="row g-6 mb-6">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span class="text-heading">Bugün Alınan Sipariş Miktarı</span>
            <h4 class="mb-0 me-2">{{ $toplamSiparisKgGun }}<span style="font-size: 14px;"> Ton</span>  / {{ $toplamSiparisAdGun }} <span style="font-size: 14px;"> Adet</span></h4>
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
            <span class="text-heading">Bu Ay Alınan Sipariş Miktarı</span>
            <h4 class="mb-0 me-2">{{ $toplamSiparisKgAy }}<span style="font-size: 14px;"> Ton</span>  / {{ $toplamSiparisAdAy }} <span style="font-size: 14px;"> Adet</span></h4>
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
            <span class="text-heading">Bu Yıl Alınan Sipariş Miktarı</span>
            <h4 class="mb-0 me-2">{{ $toplamSiparisKgYil }}<span style="font-size: 14px;"> Ton</span>  / {{ $toplamSiparisAdYil }} <span style="font-size: 14px;"> Adet</span></h4>
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
            <span class="text-heading">Bakiye Sipariş Miktarı</span>
            <h4 class="mb-0 me-2">{{ $toplamSiparisKg }}<span style="font-size: 14px;"> Ton</span>  / {{ $toplamSiparisAd }} <span style="font-size: 14px;"> Adet</span></h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <div class="card mt-2">
        <div class="card">
            <div class="card-datatable table-responsive-sm  text-nowrap">
              <table style="font-size: 14px" class="datatables-satis table-sm">
                <thead class="border-top">
                  <tr>
                    <th>GÖSTER</th>
                    <th>FİŞ NO</th>
                    <th>MÜŞTERİ ADI</th>
                    <th>AÇIKLAMA</th>
                    <th>SİPARİŞ KG</th>
                    <th>KALAN KG</th>
                    <th>DURUM</th>
                    <th>ÖDEME PLANI</th>
                    <th>TARİH</th>
                    <th>BİRİM</th>
                  </tr>
                </thead>
              </table>
            </div>
        </div>


        <!-- Offcanvas to add new user -->
        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Kullanıcı Ekle</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                <form class="add-new-user pt-0" id="addNewUserForm">
                    <input type="hidden" name="id" id="user_id">
                    <div class="mb-6">
                        <label class="form-label" for="add-user-fullname">Tam Ad</label>
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe"
                            name="name" aria-label="John Doe" />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-email">Email</label>
                        <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
                            aria-label="john.doe@example.com" name="email" />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-contact">İletişim</label>
                        <input type="text" id="add-user-contact" class="form-control phone-mask"
                            placeholder="+1 (609) 988-44-11" aria-label="john.doe@example.com" name="userContact" />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-company">Firma</label>
                        <input type="text" id="add-user-company" class="form-control" placeholder="Web Developer"
                            aria-label="jdoe1" name="company" />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="country">Ülke</label>
                        <select id="country" class="select2 form-select">
                            <option value="">Seçiniz</option>
                            <option value="Australia">Australia</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Brazil">Brazil</option>
                            <option value="Canada">Canada</option>
                            <option value="China">China</option>
                            <option value="France">France</option>
                            <option value="Germany">Germany</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Japan">Japan</option>
                            <option value="Korea">Korea, Republic of</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Russia">Russian Federation</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Turkey">Türkiye</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="user-role">Kullanıcı Rolü</label>
                        <select id="user-role" class="form-select">
                            <option value="subscriber">Subscriber</option>
                            <option value="editor">Editor</option>
                            <option value="maintainer">Maintainer</option>
                            <option value="author">Author</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="user-plan">Plan Seçiniz</label>
                        <select id="user-plan" class="form-select">
                            <option value="basic">Basic</option>
                            <option value="enterprise">Enterprise</option>
                            <option value="company">Company</option>
                            <option value="team">Team</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-3 data-submit">Gönder</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Vazgeç</button>
                </form>
            </div>
        </div> --}}


    </div>

@endsection
