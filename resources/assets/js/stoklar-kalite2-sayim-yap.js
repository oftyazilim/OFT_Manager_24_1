'use strict';
import Swal from 'sweetalert2';
import ExcelJS from 'exceljs';
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
      var barkod = str.slice(0, 2) + " " + str.slice(2, 4) + " " + str.slice(4, 6) + " " + str.slice(6, 10);
      $(this).val(''); // Clear the input field
console.log(barkod);
      // Send the barcode to the server
      axios
        .post('/stok-sayim', { barkod: barkod })
        .then(function (response) {
          console.log(response.data);
          // Update summary information
          $('#mesaj').text(response.data.mesaj);
          $('#toplamSayilanAdet').text(response.data.toplamSayilanAdet);
          $('#sayilmayanStokAdeti').text(response.data.sayilmayanStokAdeti);

          // Set focus back to input
          $('#barkodInput').focus();
        })
        .catch(function (error) {
          console.error('Error:', error);
          // Handle error (optional)
          $('#barkodInput').focus();
        });
    }
  });
});
