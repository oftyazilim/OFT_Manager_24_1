'use strict';
import Swal from 'sweetalert2';
import axios from 'axios';

$(function () {
  document.getElementById('baslik').innerHTML = '2. Kalite Listesi (Ş.Pınar)';

  var dt_table = $('.datatables-kalite2'),
    filterValue = 2;

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (dt_table.length) {
    var dt_record = dt_table.DataTable({
      processing: true,
      serverSide: true,
      paging: false,
      info: true,
      scrollCollapse: false,
      scrollY: '55vh',
      infoCallback: function (settings, start, end, max, total, pre) {
        return ' Listelenen kayıt sayısı:   ' + end;
      },
      ajax: {
        url: baseUrl + 'stok/indexsayims',
        data: function (d) {
          // Filtre değerini ajax isteğine ekle
          d.filterValue = filterValue;
        }
      },
      columns: [
        // columns according to JSON
        { data: 'fake_id' },
        { data: 'mamul' },
        { data: 'boy' },
        { data: 'adet2' },
        { data: 'kantarkg' },
        { data: 'adet' },
        { data: 'kg' },
        { data: 'nevi' },
        { data: 'pkno' },
        { data: 'hat' },
        { data: 'tarih' },
        { data: 'saat' },
        { data: 'operator' },
        { data: 'mamulkodu' },
        { data: 'basildi' },
        { data: 'id' },
        { data: 'eylem' }
      ],
      buttons: [
        {
          text: 'Sayım Yap',
          className: 'sayimyap btn p-2 ms-1'
        },
        {
          text: 'Tümü',
          className: 'tumu btn p-2 ms-1',
          action: function () {
            filterValue = 2; // Parametre 0 (Tümü)
            dt_record.ajax.reload();
          }
        },
        {
          text: 'Sayılanlar',
          className: 'sayilanlar btn p-2 ms-1',
          action: function () {
            filterValue = 1; // Parametre 1 (Sayılanlar)
            dt_record.ajax.reload();
          }
        },
        {
          text: 'Sayılmayanlar',
          className: 'sayilmayanlar btn p-2 ms-1',
          action: function () {
            filterValue = 0; // Parametre 2 (Sayılmayanlar)
            dt_record.ajax.reload();
          }
        },
        {
          text: 'Sıfırla',
          className: 'sifirla btn p-2 ms-1',
          action: function () {
            filterValue = 0; // Parametre 2 (Sayılmayanlar)
            dt_record.ajax.reload();
          }
        }
      ],
      order: [[15, 'desc']],
      language: {
        search: '',
        searchPlaceholder: 'Ara'
      },
      dom:
        '<"row"' +
        '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start"B>>' +
        '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-5 gap-md-4 mt-n5 mt-md-0"f>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      columnDefs: [
        {
          //For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 1,
          targets: 0,
          render: function (data, type, row, meta) {
            return ``;
          }
        },
        {
          //targets: 0,
          orderable: false,
          responsivePriority: 3,
          searchable: false,
          className: 'dt-body-center',
          render: function (data, type, row, meta) {
            return `<span style="font-weight: bold; color: limegreen;">${full.fake_id}</span>`;
          }
        },
        {
          targets: 1, //mamul
          responsivePriority: 1,
          className: 'dt-body-left'
        },
        {
          targets: 2, //boy
          responsivePriority: 3,
          className: 'text-end'
        },
        {
          targets: 3, //adet2
          className: 'dt-body-center',
          responsivePriority: 2
        },
        {
          targets: 4, //kantarkg
          responsivePriority: 1,
          className: 'dt-body-right',
          render: function (data, type, full, meta) {
            return `<span style="font-weight: bold; color: limegreen;">${full.kantarkg}</span>`;
          }
        },
        {
          targets: 5, //adet
          responsivePriority: 2,
          className: 'dt-body-right',
          render: function (data, type, row, meta) {
            return data;
          }
        },
        {
          targets: 6, //kg
          responsivePriority: 4,
          className: 'dt-body-right',
          render: function (data, type, row, meta) {
            return data;
          }
        },
        {
          targets: 7, //nevi
          responsivePriority: 5,
          className: 'dt-body-center',
          render: function (data, type, full, meta) {
            var $nevi = full['nevi'];
            return `${
              $nevi == 'BYL'
                ? `<span style="color: brown; font-weight: bold;">${full.nevi}</span>`
                : `<span >${full.nevi}</span>`
            }`;
          }
        },
        {
          targets: 8, //pkno
          responsivePriority: 4,
          className: 'dt-body-center',
          width: '100%',
          render: function (data, type, full, meta) {
            return `<span style="white-space: nowrap">${full.pkno}</span>`;
          }
        },
        {
          targets: 9, //hat
          responsivePriority: 5,
          className: 'dt-body-center',
          render: function (data, type, full, meta) {
            return `<span style="white-space: nowrap">${full.hat}</span>`;
          }
        },
        {
          targets: 10, //tarih
          responsivePriority: 4,
          className: 'dt-body-center',
          render: function (data, type, full, meta) {
            return `<span style="white-space: nowrap">${full.tarih}</span>`;
          }
        },
        {
          targets: 11, //saat
          responsivePriority: 5,
          className: 'dt-body-center',
          render: function (data, type, row, meta) {
            return data;
          }
        },
        {
          targets: 12, //operator
          responsivePriority: 5,
          className: 'dt-body-center',
          render: function (data, type, row) {
            return '<span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' + data + '</span>';
          }
        },
        {
          targets: 13, //mamulkodu
          responsivePriority: 5,
          className: 'dt-body-center',
          render: function (data, type, full, meta) {
            return `<span style="white-space: nowrap">${full.mamulkodu}</span>`;
          }
        },
        {
          targets: 14, //basildi
          className: 'dt-body-center',
          responsivePriority: 3,
          render: function (data, type, full, meta) {
            var $verified = full['basildi'];
            return `${
              $verified == 1
                ? '<i class="ti fs-4 ti-shield-check text-success" style="font-size: 13px; line-height: 0.7; vertical-align: middle;"></i>'
                : '<i class="ti fs-4 ti-shield-x text-danger" style="font-size: 13px; line-height: 0.7; vertical-align: middle;"></i>'
            }`;
          }
        },
        {
          targets: 15, //id
          className: 'dt-body-center',
          responsivePriority: 5,
          visible: false
        },
        {
          // Actions
          visible: false,
          targets: -1,
          searchable: false,
          responsivePriority: 4,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              `<i class="ti ti-edit edit-record" data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRecord" style="font-size: 20px; line-height:0.7; vertical-align: middle;"></i>` +
              `<i class="ti ti-trash delete-record" data-id="${full['id']}" style="font-size: 20px; line-height: 0.7; vertical-align: middle;"></i>` +
              '</div>'
            );
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return data['mamul'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
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
      },
      footerCallback: function (row, data, start, end, display) {
        let api = this.api();

        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
          return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
        };

        // Total over all pages
        let toplam = $('.datatables-kalite2').DataTable().ajax.json().toplamKg;

        // Update footer
        api.column(3).footer().innerHTML = toplam;
      }
    });
  }

  veriAl($('.tumu'));

  function veriAl(buton) {
    $('.tumu').css('background-color', 'gray');
    $('.sayilanlar').css('background-color', 'gray');
    $('.sayilmayanlar').css('background-color', 'gray');
    $('.sifirla').css('background-color', 'gray');

    $.ajax({
      method: 'GET',
      url: baseUrl + 'stok/verialsayims',
      data: {
        filterValue: filterValue // Butondan gelen parametre
      },
      success: function (response) {
        let data = response;
        document.getElementById('toplamPaket').innerHTML = data[0] + '<span style="font-size: 14px;"> Adet</span>';
        document.getElementById('toplamGenel').innerHTML = data[1] + '<span style="font-size: 14px;"> Kg</span>';
        document.getElementById('toplamHr').innerHTML = data[2] + '<span style="font-size: 14px;"> Kg</span>';
        document.getElementById('toplamDiger').innerHTML = data[3] + '<span style="font-size: 14px;"> Kg</span>';
      },
      error: function (error) {
        console.log(error);
      }
    });
    buton.css('background-color', '#0d6efd');
  }

  $('.sayimyap').on('click', function () {
    window.location.href = '/stok-sayimyaps';
  });

  $('.tumu').on('click', function () {
    filterValue = 2;
    veriAl($(this));
    dt_table.draw();
  });

  $('.sayilanlar').on('click', function () {
    filterValue = 1;
    veriAl($(this));
    dt_table.draw();
  });

  $('.sayilmayanlar').on('click', function () {
    filterValue = 0;
    veriAl($(this));
    dt_table.draw;
  });

  $('.sifirla').on('click', function () {
    axios
      .post('/reset-sayildis')
      .then(function (response) {
        Swal.fire({
          title: 'Sayım sıfırlandı',
          text: response.data.mesaj,
          icon: 'success',
          confirmButtonText: 'Kapat',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      })
      .catch(function (error) {
        Swal.fire({
          title: 'Hata oluştu',
          text: response.data.mesaj,
          icon: 'error',
          confirmButtonText: 'Kapat',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      });
    filterValue = 2;
    veriAl($('.tumu'));
    dt_table.draw;
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
