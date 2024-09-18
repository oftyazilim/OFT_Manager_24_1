@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roller')

<!-- Vendor Styles -->
@section('vendor-style')

    <style>

        .custom-modal {
    max-width: 200%; /* İstediğiniz genişliği burada belirleyin */
}


    </style>
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS ve bağımlılıkları -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/rol-management.js'])
@endsection
@vite(['resources/assets/vendor/libs/jquery/jquery.js'])

@section('content')



    <div class="card mt-2">
        @include('_message')
        <div class="card">
            <div class="card-datatable table-responsive-sm">


                <table class="datatables-roles table table-sm">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>kjl</th>
                            <th>ID</th>
                            <th>Rol Adı</th>
                            <th>Tarih</th>
                            <th>Eylemler</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                      @foreach ($kayitAl as $value)
                          <tr>
                              <td>{{ $value->id }}</td>
                              <td>{{ $value->name }}</td>
                              <td>{{ $value->created_at }}</td>
                              <td>
                                  @if (!empty($IzinDuzenle))
                                  <a href="{{ url('kisiler/duzenle/' . $value->id) }}"
                                      class="btn btn-primary btn-sm">Düzenle</a>
                                  @endif
                                  @if (!empty($IzinSil))
                                  <a href="{{ url('kisiler/sil/' . $value->id) }}"
                                      class="btn btn-danger btn-sm">Sil</a>
                                  @endif
                              </td>
                          </tr>
                      @endforeach
                  </tbody> --}}
                </table>
            </div>
        </div>


        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddRole" aria-labelledby="offcanvasAddRoleLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddRoleLabel" class="offcanvas-title">Rol Ekle</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                <form method="POST" class="add-new-role pt-0" id="addNewRoleForm">
                    <input type="hidden" name="id" id="role_id">
                    <div class="mb-6">
                        <label class="form-label" for="add-role-name">Rol Adı</label>
                        <input type="text" class="form-control" id="add-role-name" placeholder="Yönetici"
                            name="name" aria-label="Yönetici" />
                    </div>



                    <button type="submit" class="btn btn-primary add-new-role-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRole">Yeni Rol Ekle</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Vazgeç</button>
                </form>
            </div>
        </div>










        <!-- Modal HTML -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Rol Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">



                        <input type="hidden" name="role_id" id="role_id" value="">





                        <form id="roleForm" action="" method="POST">
                            @csrf
                            {{-- @method('PUT') --}}
                            <div class="row mb-4">
                                <label for="role_name" class="col-sm-12 col-form-label">Rol Adı:</label>
                                <div class="col-sm-12">
                                    <input type="text" name="roleName" id="roleName" class="form-control" required>
                                    <input type="hidden" name="role_id1" id="role_id1" value="">
                                  </div>
                            </div>
                            <!-- İzinler için bir container -->
                            <div id="permissionsContainer">

                            </div>

                            <button type="submit" id="updateButton" class="btn btn-primary">Güncelle</button>
                            <button type="reset" class="btn btn-label-danger"
                                onclick="window.location.href='{{ route('roller.liste') }}'">Vazgeç</button>
                        </form>




                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
      const redirectUrl = "{{ route('roller.liste') }}";
  </script>


   <script>
        document.addEventListener('DOMContentLoaded', function() {
            const myModal = new bootstrap.Modal(document.getElementById('myModal'));
            const closeBtn = document.querySelector('.btn-close');

            closeBtn.addEventListener('click', function() {
                myModal.hide();
            });

            window.addEventListener('click', function(event) {
                if (event.target === document.getElementById('myModal')) {
                    myModal.hide();
                }
            });
        });

        // function openEditModal(roleId) {
        //     $.ajax({
        //         url: `/roller/edit/${roleId}`,
        //         type: 'GET',
        //         success: function(response) {
        //             $('#myModal').find('input[name="name"]').val(response.rol.name);
        //             $('input[name="permission_id[]"]').each(function() {
        //                 $(this).prop('checked', response.rolIzinAl.some(permission => permission
        //                     .permission_id === parseInt($(this).val())));
        //             });
        //             $('#myModal').modal('show');
        //         },
        //         error: function(xhr) {
        //             console.log('Bir hata oluştu: ', xhr.responseText);
        //         }
        //     });
        // }

        // $('#editForm').on('submit', function(event) {
        //     event.preventDefault();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: $(this).serialize(),
        //         success: function(response) {
        //             alert('Rol başarıyla güncellendi!');
        //             $('#myModal').modal('hide');
        //             $('#example').DataTable().ajax.reload();
        //         },
        //         error: function(xhr) {
        //             console.log('Bir hata oluştu: ', xhr.responseText);
        //         }
        //     });
        // });
    </script>


@endsection
