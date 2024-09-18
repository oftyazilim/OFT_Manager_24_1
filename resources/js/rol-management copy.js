/**
 * Page Role List
 */

'use strict';
import Swal from 'sweetalert2';

// Datatable (jquery)
$(function () {
  document.getElementById('baslik').innerHTML = 'Roller Listesi';
  // Değişkenler
  var dt_role_table = $('.datatables-roles'),
    offCanvasForm = $('#offcanvasAddRole'),
    myModal = $('#myModal'),
    izinDuzenle = 1,
    izinEkle = 1,
    izinSil = 1;

  // Ajax yapılandırması
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Roller datatable
  if (dt_role_table.length) {
    var dt_role = dt_role_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'rollers'
      },
      columns: [{ data: '' }, { data: 'fake_id' }, { data: 'id' }, { data: 'name' }, { data: 'created_at' }, { data: 'action' }],
      columnDefs: [
        {
          // Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          targets: 2,
          responsivePriority: 4,
        },
        {
          targets: 3,
          responsivePriority: 4,
        },
        {
          targets: 4,
          // render: function (data, type, full, meta) {
          //   // Tarih verisini al
          //   var $tarih = full['created_at'];

          //   // Tarih nesnesine dönüştür
          //   var date = new Date($tarih);

          //   // Tarih formatlama fonksiyonu
          //   function formatDate(date) {
          //     var options = { day: '2-digit', month: 'long', year: 'numeric' };
          //     return date.toLocaleDateString('tr-TR', options);
          //   }

          //   // Formatlanmış tarihi döndür
          //   return '<span class="tarih">' + formatDate(date) + '</span>';
          // }
        },
        {
          // Actions
          targets: -1,
          title: 'Eylemler',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let editButton = '';
            let deleteButton = '';

            if (izinDuzenle) {
              editButton = `<button data-bs-toggle="modal"  data-bs-target="#myModal" class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><i class="ti ti-edit"></i></button>`;
            }

            if (izinSil) {
              // Eğer silme izni varsa, silme butonunu da göster
              // Benzer şekilde izinleri kontrol edebilirsiniz

              deleteButton = `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}"><i class="ti ti-trash"></i></button>`;
            }
            return '<div class="d-flex align-items-center gap-50">' + editButton + deleteButton + '</div>';
          }
        }
      ],
      order: [[3, 'desc']],
      dom:
        '<"row"' +
        '<"col-md-2"<"ms-n2"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0"fB>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [7, 10, 20, 50, 70, 100],
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Rol Ara',
        info: 'Kayıt: _END_ / _TOTAL_ ',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-4 waves-effect waves-light',
          text: '<i class="ti ti-upload me-2 ti-xs"></i>Dışa Aktar',
          buttons: [
            // Export options (print, csv, excel, pdf, copy)
            // ...
          ]
        },
        izinEkle
          ? [
              {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Rol Ekle</span>',
                className: 'add-new btn btn-primary waves-effect waves-light',
                attr: {
                  'data-bs-toggle': 'offcanvas',
                  'data-bs-target': '#offcanvasAddRole'
                }
              }
            ]
          : []
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detaylar: ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== ''
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
  }

  // Silme İşlemi
  $(document).on('click', '.delete-record', function () {
    alert($(this).data('id'));
    var user_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: 'Emin misiniz?',
      text: 'Bu işlemi geri alamayacaksınız!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Evet, Silebilirsin!',
      cancelButtonText: 'Vazgeç',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}roller/${user_id}`,
          success: function () {
            dt_role.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: 'Silindi!',
          text: 'Rol silindi',
          confirmButtonText: 'Kapat',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Vazgeçildi',
          text: 'Rol silinmedi!',
          icon: 'error',
          confirmButtonText: 'Kapat',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // // Düzenleme İşlemi
  // $(document).on('click', '.edit-record', function () {
  //   var role_id = $(this).data('id');

  //   $('#myModalLabel').text('Rol Düzenle');

  //   $.get(`${baseUrl}rollers/${role_id}/edit`, function (rol) {
  //     console.log(rol);

  //     // Form elemanlarını güncelle
  //     $('#role_id').val(rol.id);
  //     $('#roleName').val(rol.name);

  //     // İzinler için checkbox'ları güncelle
  //     $('input[name="permission_id[]"]').each(function () {
  //       var permission_id = $(this).val();
  //       var isChecked = rol.permissions.includes(parseInt(permission_id));
  //       $(this).prop('checked', isChecked);
  //     });

  //     // Modal'ı göster
  //     $('#myModal').modal('show');
  //   });
  // });

  $(document).on('click', '.edit-record', function () {
    const roleId = $(this).data('id');

    $.ajax({
        url: `/roller/edit/${roleId}`, // GET isteği için URL
        type: 'GET',
        success: function (response) {
            console.log('AJAX yanıtı:', response);

            const { kayitAl, rolIzinAl, izinAl, result } = response;

            $('#roleName').val(kayitAl.name);

            let permissionsHtml = '';
            if (izinAl && Array.isArray(izinAl) && izinAl.length > 0) {
                izinAl.forEach(value => {
                    let groupHtml = '';
                    if (value.group && Array.isArray(value.group) && value.group.length > 0) {
                        value.group.forEach(group => {
                            const isChecked = rolIzinAl.some(role => role.permission_id === group.permission_id) ? 'checked' : '';
                            groupHtml += `
                                <div class="col-md-3">
                                    <label>
                                        <input type="checkbox" ${isChecked} value="${group.permission_id}" name="permission_id[]">
                                        ${group.name}
                                    </label>
                                </div>
                            `;
                        });
                    }

                    permissionsHtml += `
                        <div class="row mb-3">
                            <div class="col-md-3">
                                ${value.name}
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    ${groupHtml}
                                </div>
                            </div>
                            <hr>
                        </div>
                    `;
                });

                $('#permissionsContainer').html(permissionsHtml);
            } else {
                $('#permissionsContainer').html('<p>İzinler yüklenemedi veya mevcut değil.</p>');
            }

            $('#myModal').modal('show');
        },
        error: function (xhr) {
            console.log('Bir hata oluştu: ', xhr.responseText);
        }
    });
});


  // $('#roleForm').on('submit', function (e) {
  //   e.preventDefault(); // Formun varsayılan gönderimini engelle

  //   // Seçili izinleri topla
  //   const selectedPermissions = [];
  //   $('#permissionsContainer input[type="checkbox"]:checked').each(function () {
  //     selectedPermissions.push($(this).val());
  //   });

  //   // Örnek formData oluşturma
  //   const formData = {
  //     role_id: $('#role_id').val(),
  //     permissions: $('#roleForm').serializeArray() // Form verilerini al
  //   };
  //   console.log('FormData:', formData);

  //   // AJAX isteği
  //   $.ajax({
  //     url: `/roller/edit/${formData.role_id}`, // POST isteği için URL
  //     type: 'POST',
  //     data: formData,
  //     success: function (response) {
  //       console.log('Güncelleme başarılı:', response);
  //       $('#myModal').modal('hide');
  //     },
  //     error: function (xhr) {
  //       console.log('Bir hata oluştu:', xhr.responseText);
  //     }
  //   });
  // });

 $(document).on('submit', '#roleForm', function (e) {
    e.preventDefault(); // Formun varsayılan gönderimini engelle

    const formData = {
        role_id: $('#role_id').val(),
        permissions: $('#roleForm').serializeArray() // Form verilerini al
    };

    console.log('FormData:', formData);

    $.ajax({
        url: `/roller/edit/${formData.role_id}`, // POST isteği için URL
        type: 'POST',
        data: formData,
        success: function (response) {
            console.log('Güncelleme başarılı:', response);
            $('#myModal').modal('hide');
        },
        error: function (xhr) {
            console.log('Bir hata oluştu:', xhr.responseText);
        }
    });
});


});
