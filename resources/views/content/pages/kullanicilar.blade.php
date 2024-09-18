@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Kullanıcılar')

<!-- Vendor Styles -->
@section('vendor-style')

    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/laravel-user-management.js'])
@endsection
@vite(['resources/assets/vendor/libs/jquery/jquery.js'])

@section('content')
    <div class="card mt-2">
        @include('_message')
        <div class="card">
            {{-- <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Kullanıcılar</h5>
        </div> --}}
            <div class="card-datatable table-responsive-sm">


                <table class="datatables-users table table-sm">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Kullanıcı Adı</th>
                            <th>Email</th>
                            <th>Rolü</th>
                            <th>Onaylandı</th>
                            <th>Eylemler</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>


        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
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
                        <label class="form-label" for="user-role">Kullanıcı Rolü</label>
                        <select id="user-role" class="form-control" name="role_id" required>
                            <option value="">Seçiniz...</option>
                            @foreach ($rolAl as $value)
                                <option {{ old('role_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}">
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary me-3 data-submit">Kaydet</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Vazgeç</button>
                </form>
            </div>
        </div>


    </div>

@endsection
