'use strict';

var KTBoard = (function () {
    var widGetAvance    = document.querySelector('#kt_chart_widget_avance');

    var createChart = () => {
        parseInt(KTUtil.css(widGetAvance, 'height'));

        let configuracion = {
                series: [1,1,1],
                chart: {
                    fontFamily: 'inherit',
                    type: 'donut',
                    width: 250
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%',
                            labels: {
                                value: {
                                    fontSize: '10px'
                                }
                            }
                        }
                    }
                },
                colors: [KTUtil.getCssVariableValue('--bs-danger'), KTUtil.getCssVariableValue('--bs-warning'), KTUtil.getCssVariableValue('--bs-success')],
                stroke: {
                    width: 0
                },
                labels: ['Atrasados', 'Sin atender', 'Otros'],
                legend: {
                    show: false
                },
                fill: {
                    type: 'false'
                },
                noData: {
                    text: 'Aun no hay datos para graficar',
                    align: 'center',
                    verticalAlign: 'middle',
                    style: {
                      color: KTUtil.getCssVariableValue('--bs-dark'),
                      fontSize: '14px',
                      fontFamily: 'inherit'
                    }
                  }
            },
            chartAvance = new ApexCharts(widGetAvance, configuracion);

        chartAvance.render();
    };

    return {
        init: function () {
            createChart();
        }
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTBoard.init();
});