/**
 * Dashboard Analytics
 */

'use strict';

import ApexCharts from "apexcharts";

(function () {

  document.getElementById('baslik').innerHTML = ' Dashboard';

  window.config = {
    colors: {
      primary: '#7367f0',
      secondary: '#808390',
      success: '#28c76f',
      info: '#00bad1',
      warning: '#ff9f43',
      danger: '#FF4C51',
      dark: '#4b4b4b',
      black: '#000',
      white: '#fff',
      cardColor: '#fff',
      bodyBg: '#f8f7fa',
      bodyColor: '#6d6b77',
      headingColor: '#444050',
      textMuted: '#acaab1',
      borderColor: '#e6e6e8'
    },
    colors_label: {
      primary: '#7367f029',
      secondary: '#a8aaae29',
      success: '#28c76f29',
      info: '#00cfe829',
      warning: '#ff9f4329',
      danger: '#ea545529',
      dark: '#4b4b4b29'
    },
    colors_dark: {
      cardColor: '#2f3349',
      bodyBg: '#25293c',
      bodyColor: '#b2b1cb',
      headingColor: '#cfcce4',
      textMuted: '#8285a0',
      borderColor: '#565b79'
    },
    enableMenuLocalStorage: true // Enable menu state with local storage support
  };

  const isDarkStyle = config.isDarkStyle;

  let cardColor, headingColor, labelColor, shadeColor, grayColor;
  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    headingColor = config.colors_dark.headingColor;
    shadeColor = 'dark';
    grayColor = '#5E6692'; // gray color is for stacked bar chart
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;
    shadeColor = '';
    grayColor = '#817D8D';
  }


  // Earning Reports Bar Chart
  // --------------------------------------------------------------------
  const weeklyEarningReportsEl = document.querySelector('#weeklyEarningReports'),
    weeklyEarningReportsConfig = {
      chart: {
        height: 161,
        parentHeightOffset: 0,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          barHeight: '60%',
          columnWidth: '38%',
          startingShape: 'rounded',
          endingShape: 'rounded',
          borderRadius: 4,
          distributed: true
        }
      },
      grid: {
        show: false,
        padding: {
          top: -30,
          bottom: 0,
          left: -10,
          right: -10
        }
      },
      colors: [
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors.primary,
        config.colors_label.primary,
        config.colors_label.primary
      ],
      dataLabels: {
        enabled: false
      },
      series: [
        {
          data: [40, 65, 50, 45, 90, 55, 70]
        }
      ],
      legend: {
        show: false
      },
      xaxis: {
        categories: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px',
            fontFamily: 'Public Sans'
          }
        }
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      tooltip: {
        enabled: false
      },
      responsive: [
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 199
            }
          }
        }
      ]
    };
  if (typeof weeklyEarningReportsEl !== undefined && weeklyEarningReportsEl !== null) {
    const weeklyEarningReports = new ApexCharts(weeklyEarningReportsEl, weeklyEarningReportsConfig);
    weeklyEarningReports.render();
  }


  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  // setTimeout(() => {
  //   $('.dataTables_filter .form-control').removeClass('form-control-sm');
  //   $('.dataTables_length .form-select').removeClass('form-select-sm');
  // }, 300);
})();
