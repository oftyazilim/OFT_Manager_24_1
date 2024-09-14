'use strict';
import Swal from 'sweetalert2';
import axios from 'axios';

$(function () {
  document.getElementById('baslik').innerHTML = '2. Kalite Sayımı (Akyazı)';

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#barkodInput').on('keypress', function (e) {
    if (e.which === 13) {
      // Enter key pressed
      e.preventDefault();
      var str = $(this).val();
      var barkod = str.slice(0, 2) + ' ' + str.slice(2, 4) + ' ' + str.slice(4, 6) + ' ' + str.slice(6, 10);
      $(this).val(''); // Clear the input field
      axios
        .post('/stok-sayim', { okuma: 1, barkod: barkod })
        .then(function (response) {
          if (response.data.sonuc) {
            $('#mesaj').text(response.data.mesaj);
            veriAl();
          } else {
            Swal.fire({
              title: 'Sayılmadı',
              text: response.data.mesaj,
              icon: 'error',
              confirmButtonText: 'Kapat',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          }
        })
        .catch(function (error) {
          console.error('Error:', error);
          $('#barkodInput').focus();
        });
    }
  });

  veriAl();

  function veriAl($button) {
    axios
      .post('/stok-sayim', { okuma: 0, barkod: null })
      .then(function (response) {
        $('#toplamSayilanAdet').text(response.data.toplamSayilanAdet);
        $('#sayilmayanStokAdeti').text(response.data.sayilmayanStokAdeti);
        var toplam = parseInt(response.data.toplamSayilanAdet) + parseInt(response.data.sayilmayanStokAdeti);
        $('#toplam').text(toplam);
        $('#barkodInput').focus();
      })
      .catch(function (error) {
        console.error('Error:', error);
        $('#barkodInput').focus();
      });
  }
});
