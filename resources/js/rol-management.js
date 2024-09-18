'use strict';
import Swal from 'sweetalert2';

$(function () {
  document.getElementById('baslik').innerHTML = 'Roller Listesi';

  var dt_role_table = $('.datatables-roles'),
    offCanvasForm = $('#offcanvasAddRole'),
    myModal = $('#myModal'),
    izinEkle = 0,
    izinDuzenle = 0,
    izinSil = 0;

  main();

  async function izinAl() {
    try {
      const response = await $.get(`${baseUrl}izin-al`);
      const data = response;

      data.forEach(function (izin) {
        if (izin.slug === 'Rol Ekle') izinEkle = 1;
        if (izin.slug === 'Rol Düzenle') izinDuzenle = 1;
        if (izin.slug === 'Rol Sil') izinSil = 1;
      });
    } catch (error) {
      console.error('AJAX Hatası: Internal Server Error', error);
    }
  }

  async function main() {
    await izinAl();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    if (dt_role_table.length) {
      var dt_role = dt_role_table.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: baseUrl + 'rol-list'
        },
        columns: [
          { data: '' },
          { data: 'fake_id' },
          { data: 'id' },
          { data: 'name' },
          { data: 'created_at' },
          { data: 'action' }
        ],
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
            responsivePriority: 4
          },
          {
            targets: 3,
            responsivePriority: 4
          },
          {
            targets: 4,
            render: function (data, type, full, meta) {
              // Tarih verisini al
              var $tarih = full['created_at'];

              // Tarih nesnesine dönüştür
              var date = new Date($tarih);

              // Tarih formatlama fonksiyonu
              function formatDate(date) {
                var options = { day: '2-digit', month: 'long', year: 'numeric' };
                return date.toLocaleDateString('tr-TR', options);
              }

              // Formatlanmış tarihi döndür
              return '<span class="tarih">' + formatDate(date) + '</span>';
            }
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
                editButton = `<button data-bs-toggle="modal"  data-bs-target="#myModal" class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}" data-bs-toggle="myModal" data-bs-target="#myModal"><i class="ti ti-edit"></i></button>`;
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
  }

  $(document).on('click', '.edit-record', function () {
    const roleId = $(this).data('id'); // Düzenleme yapacağımız rolün ID'si
    $('#role_id1').val(roleId);

    // AJAX isteği
    $.get(`${baseUrl}rol-list/${roleId}/edit`, function (data) {
      // Role ait adı inputa koy
      $('#roleName').val(data.kayitAl.name);

      // İzinleri checkbox listesi olarak oluştur
      let izinHtml = '';

      data.permissions.forEach(function (permission) {
        izinHtml += `
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-3">
                        ${permission.permissions[0].name}
                    </div>
                    <div class="col-md-9">
                        <div class="row">`;

        permission.permissions.forEach(function (perm) {
          const isChecked = data.rolIzinAl.some(role => role.permission_id === perm.permission_id) ? 'checked' : '';
          // console.log( perm.name);

          izinHtml += `
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" ${isChecked} value="${perm.permission_id}" name="permission_id[]">
                            ${perm.name}
                        </label>
                    </div>`;
        });

        izinHtml += `
                        </div>
                    </div>
                    <hr>
                </div>`;
      });

      // Checkbox listesini modal içinde bir div'e ekleyin
      $('#permissionsContainer').html(izinHtml);

      // Modalı göster
      $('#myModal').modal('show');
    }).fail(function () {
      console.error('AJAX Hatası: Internal Server Error');
    });
  });

  $(document).on('click', '#updateButton', function (e) {
    e.preventDefault(); // Formun varsayılan gönderimini engelle

    const form = $('#roleForm');
    const formData = form.serialize(); // Form verilerini al
    const roleId = $('#role_id').val(); // Role ID'yi gizli alandan al
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Ajax ile formu gönder
    $.ajax({
      url: `${baseUrl}rol-list/${roleId}`, // Güncelleme URL'si
      method: 'POST', // Güncelleme için PUT kullanın
      data: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken // CSRF Token başlığı ekle
      },
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Başarılı!',
          text: response.message,
          confirmButtonText: 'Tamam',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        dt_role.draw();

        $('#myModal').modal('hide'); // Modal'ı kapat
        // Listeyi güncelle
        // $('#rolListesi').DataTable().ajax.reload(); // DataTable kullanıyorsanız
      },
      error: function (xhr) {
        console.error('Güncelleme hatası:', xhr);
        Swal.fire({
          icon: 'error',
          title: 'Hata!',
          text: 'Güncelleme sırasında bir hata oluştu.',
          confirmButtonText: 'Tamam',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  $(document).on('submit', '#addNewRoleForm', function (e) {
    e.preventDefault(); // Formun varsayılan gönderimini engelle

    const form = $(this);
    const formData = form.serialize(); // Form verilerini al
    const csrfToken = $('meta[name="csrf-token"]').attr('content'); // CSRF token'ı al

    $.ajax({
      url: `${baseUrl}rol-list`, // API URL
      method: 'POST', // Veriyi eklemek için POST kullanılır
      data: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken // CSRF Token başlığı ekle
      },
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Başarılı!',
          text: response.message,
          confirmButtonText: 'Tamam',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(result => {
          if (result.isConfirmed) {
            // Sayfayı yeniden yükleme
            window.location.reload();
            $('#offcanvasAddRole').offcanvas('hide'); // Offcanvas'ı kapat
          }
        });
        $('#offcanvasAddRole').offcanvas('hide'); // Offcanvas'ı kapat
      },
      error: function (xhr) {
        console.log(xhr.responseText); // Hata mesajını konsola yazdır
        Swal.fire({
          icon: 'error',
          title: 'Hata!',
          text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
          confirmButtonText: 'Tamam',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });
});
