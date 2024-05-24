'use strict';

var KTTicket = (function () {
    var customTable     = document.querySelector('#kt_custom_ticket_table'),
        customDatatable = null,
        customDate      = document.querySelector('#kt_custom_ticket_flatpickr'),
        customDateRange = null,
        customDateClear = document.querySelector('#kt_custom_ticket_flatpickr_clear'),
        customSearch    = document.querySelector('[data-kt-custom-ticket-filter="search"]');

    var configurarFiltros = () => {
        customDateRange = $(customDate).flatpickr({
            altInput: true,
            altFormat: 'd/m/Y',
            dateFormat: 'Y-m-d',
            mode: 'range',
            locale: localeFlatPickr,
            onChange: function(e, t, n) {
                let fecha_inicio    = e[0] ? new Date(e[0]) : null,
                    fecha_final     = e[1] ? new Date(e[1]) : null;
                    
                $.fn.dataTable.ext.search.push((function() {
                    let current_inicio  = new Date(moment($(customDatatable[4]).text(), "DD/MM/YYYY")),
                        current_final   = new Date(moment($(customDatatable[4]).text(), "DD/MM/YYYY"));

                    return null === fecha_inicio && null === fecha_final || null === fecha_inicio && fecha_final >= current_final || fecha_inicio <= current_inicio && null === fecha_final || fecha_inicio <= current_inicio && fecha_final >= current_final;
                }));

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
                url: `${baseUrl}api/ticket/3`,
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
                {data: 'ticket_sunto'},
                {data: 'ticket_created_at'},
                {data: 'ticket_updated_at'},
                {data: 'ticket_prioridad'},
                {data: 'ticket_sla'}
            ],
            columnDefs: [
                {
                    target: 0,
                    render: (data, type, row) => {
                        return `
                            <div class="d-flex align-items-center">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-40px me-2 bg-success"></span>
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
                        return `
                            <div class="d-flex flex-column">
                                <span>${data}</span>
                                <span class="fs-7">Departamento: ${row.ticket_departamento_nombre}</span>
                            </div>
                        `;
                    }
                    
                },
                {
                    targets: 2,
                    render: (data) => {
                        return moment(data).format('DD/MM/YYYY HH:mm');
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
                            slaTiempo           = JSON.parse( row.ticket_sla_detalle );

                        return `
                            <div class="position-relative ps-3">
                                <!--begin::Bullet-->
                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2" style="background-color: ${prioridadDetalle.prioridad_color}"></div>
                                <!--end::Bullet-->

                                <!--begin::Description-->
                                <div class="">${prioridadDetalle.prioridad_nombre}</div>
                                <div class="fs-7">Tiempo espera: ${slaTiempo.sla_periodo_hora < 10 ? '0' + slaTiempo.sla_periodo_hora : slaTiempo.sla_periodo_hora}:${slaTiempo.sla_periodo_minuto < 10 ? '0' + slaTiempo.sla_periodo_minuto : slaTiempo.sla_periodo_minuto} Hrs</div>
                                <!--end::Description-->
                            </div>
                        `;
                    }
                },
                {
                    targets: 5,
                    render: (data, type, row) => {
                        let slaTiempo           = JSON.parse( row.ticket_sla_detalle ),
                            duracion            = moment.duration({ hours: slaTiempo.sla_periodo_hora, minutes: slaTiempo.sla_periodo_minuto }),
                            fechaAsignado       = moment(row.ticket_updated_at).add(duracion),
                            fechaActual         = moment(),
                            horasAtraso         = fechaAsignado.diff(fechaActual, 'hours'),
                            minutosAtraso       = fechaAsignado.diff(fechaActual, 'minutes');

                        return `
                            <div class="position-relative ps-3">
                                <!--begin::Bullet-->
                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-dark"></div>
                                <!--end::Bullet-->

                                <!--begin::Description-->
                                <div class="">${fechaAsignado.format('DD/MM/YYYY HH:mm')}</div>
                                <div class="fs-7">${horasAtraso > 0 ? horasAtraso + ' Horas restantes' : minutosAtraso + ' Minutos restantes'} </div>
                                <!--end::Description-->
                            </div>
                        `;
                    }
                }
            ],
            order: [],
            initComplete: function () {
                configurarFiltros();
            }
        });
    };

    var configuracionGeneral = () => {
        $('.link-en-proceso').addClass('active');
    };

    return {
        init: function () {
            loadDatetable();
            configurarFiltros();
            configuracionGeneral();
        }
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTTicket.init();
});