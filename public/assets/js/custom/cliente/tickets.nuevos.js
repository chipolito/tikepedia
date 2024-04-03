'use strict';

var KTTicket = (function () {
    var customTable     = document.querySelector('#kt_custom_ticket_table'),
        customDatatable = null,
        customDate      = document.querySelector('#kt_custom_ticket_flatpickr'),
        customDateRange = null,
        customDateClear = document.querySelector('#kt_custom_ticket_flatpickr_clear'),
        customSearch    = document.querySelector('[data-kt-custom-ticket-filter="search"]');

    var configurarFiltros = () => {
        $.fn.dataTable.ext.search.push((function( settings, data, dataIndex ) {
            let fecha_inicio    = customDateRange.selectedDates[0] ? new Date(customDateRange.selectedDates[0]) : null,
                fecha_final     = customDateRange.selectedDates[1] ? new Date(customDateRange.selectedDates[1]) : null;

            let current_date = new Date(moment(data[3], 'DD/MM/YYYY'));
                
            return  (fecha_inicio === null && fecha_final === null) ||
                    (fecha_inicio === null && current_date <= fecha_final) ||
                    (fecha_inicio <= current_date && fecha_final === null) ||
                    (fecha_inicio <= current_date && current_date <= fecha_final)
        }));

        customDateRange = $(customDate).flatpickr({
            altInput: true,
            altFormat: 'd/m/Y',
            dateFormat: 'Y-m-d',
            mode: 'range',
            locale: localeFlatPickr,
            onChange: function(e, t, n) {
                customDatatable.draw();
            }
        });

        KTUtil.addEvent(customDateClear, 'click', function(e){
            customDateRange.clear();
        });

        KTUtil.addEvent(customSearch, 'keyup', function (e) {
            customDatatable.search(e.target.value).draw();
        });
    }

    var loadDatetable = () => {
        customDatatable = $(customTable).DataTable({
            ajax: {
                url: `${baseUrl}api/ticket/1`,
                dataSrc: (result) => {
                    return result.messages.data
                }
            },
            info: false,
            pageLength: 10,
            language: KTCliente.languageDataTable,
            select: true,
            columns: [
                {data: 'ticket_folio'},
                {data: 'ticket_departamento_nombre'},
                {data: 'ticket_sunto'},
                {data: 'ticket_created_at'},
                {data: 'ticket_prioridad'}
            ],
            columnDefs: [
                {
                    target: 0,
                    render: (data, type, row) => {
                        let prioridadDetalle = JSON.parse( row.ticket_prioridad_detalle );

                        return `
                            <div class="d-flex align-items-center">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-40px me-2" style="background-color: ${prioridadDetalle.prioridad_color}"></span>
                                <!--end::Bullet-->

                                <!--begin::Description-->
                                <span class="">${data}</span>
                                <!--end::Description-->
                            </div>
                        `;
                    }
                    
                },
                {
                    target: 1,
                    render: (data, type, row) => {
                        let temaDetalle = JSON.parse( row.ticket_tema_detalle );

                        return `
                            <div class="d-flex flex-column">
                                <span>${data}</span>
                                <span class="fs-7">${temaDetalle.tema_nombre}</span>
                            </div>
                        `;
                    }
                    
                },
                {
                    targets: 3,
                    render: (data) => {
                        return moment(data).format('DD/MM/YYYY HH:mm');
                    }
                },
                {
                    targets: 4,
                    render: (data, type, row) => {
                        let prioridadDetalle    = JSON.parse( row.ticket_prioridad_detalle ),
                            slaTiempo           = JSON.parse( row.ticket_sla_respuesta_detalle );

                        return `
                            <div class="d-flex flex-column">
                                <span>${prioridadDetalle.prioridad_nombre}</span>
                                <span class="fs-7">Tiempo espera: ${slaTiempo.sla_periodo_hora < 10 ? '0' + slaTiempo.sla_periodo_hora : slaTiempo.sla_periodo_hora}:${slaTiempo.sla_periodo_minuto < 10 ? '0' + slaTiempo.sla_periodo_minuto : slaTiempo.sla_periodo_minuto}</span>
                            </div>
                        `;
                    }
                }
            ],
            initComplete: function () {
                configurarFiltros();
            }
        });
    };

    var configuracionGeneral = () => {
        $('.link-nuevo').addClass('active');
    };

    return {
        init: function () {
            loadDatetable();
            configuracionGeneral();
        }
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTTicket.init();
});