'use strict';

var KTTicket = (function () {
    var customTable     = document.querySelector('#kt_custom_ticket_table'),
        customDatatable = null,
        customDate      = document.querySelector('#kt_custom_ticket_flatpickr'),
        customDateRange = null,
        customDateClear = document.querySelector('#kt_custom_ticket_flatpickr_clear'),
        customSearch    = document.querySelector('[data-kt-custom-ticket-filter="search"]'),
        drawerElement   = document.querySelector('#kt_drawer_ticket_detalle'),
        drawerTicketDetalle,
        quillTicketDetalle;

    var configurarFiltros = () => {
        $.fn.dataTable.ext.search.push((function( settings, data, dataIndex ) {
            let fecha_inicio    = customDateRange.selectedDates[0] ? new Date(customDateRange.selectedDates[0]) : null,
                fecha_final     = customDateRange.selectedDates[1] ? new Date(customDateRange.selectedDates[1]) : null;

            let current_date = new Date(moment(data[2], 'DD/MM/YYYY'));
                
            return  (fecha_inicio === null && fecha_final === null) ||
                    (fecha_inicio === null && current_date <= fecha_final) ||
                    (fecha_inicio <= current_date && fecha_final === null) ||
                    (fecha_inicio <= current_date && current_date <= fecha_final)
        }));

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
                {data: 'ticket_sunto'},
                {data: 'ticket_created_at'},
                {data: 'ticket_prioridad'}
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
                    render: (data, type, row) => {
                        let prioridadDetalle    = JSON.parse( row.ticket_prioridad_detalle ),
                            slaTiempo           = JSON.parse( row.ticket_sla_respuesta_detalle );

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
                }
            ],
            order: [
                [2, 'desc']
            ],
            initComplete: function () {
                configurarFiltros();
            }
        });
    };

    var configuracionGeneral = () => {
        $('.link-nuevo').addClass('active');

        drawerTicketDetalle = KTDrawer.getInstance(drawerElement);

        quillTicketDetalle  = new Quill('#ticket_detalle_detalle', {
            readOnly: true,
            modules: {
                toolbar: null
            }
        });

        drawerTicketDetalle.on('kt.drawer.after.hidden', function() {
            customDatatable.rows('.selected').deselect();
        });

        customDatatable.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                let data                = customDatatable.rows(indexes).data()[0],
                    detalleTema         = JSON.parse(data.ticket_tema_detalle),
                    detallePrioridad    = JSON.parse(data.ticket_prioridad_detalle),
                    detalleSlaRespuesta = JSON.parse(data.ticket_sla_respuesta_detalle);

                $('#lbl-ticket-detalle-folio').html( `#${data.ticket_folio}` );
                $('#lbl-ticket-detalle-fecha').html( moment(data.ticket_created_at).format('DD/MM/YYYY HH:mm') );
                $('#lbl-ticket-detalle-departamento').html( data.ticket_departamento_nombre );
                $('#lbl-ticket-detalle-tema-ayuda').html( detalleTema.tema_nombre );
                $('#lbl-ticket-detalle-asunto').html( data.ticket_sunto );
                quillTicketDetalle.setContents(JSON.parse(data.ticket_detalle));
                $('#contenedor-ticket-detalle-evidencia').html('');
                $('#lbl-ticket-detalle-prioridad').find('.sub-bg-color').css('background-color', detallePrioridad.prioridad_color);
                $('#lbl-ticket-detalle-prioridad').find('.sub-text').html(`Prioridad: ${detallePrioridad.prioridad_nombre}`);
                $('#lbl-ticket-detalle-prioridad').attr('title', detallePrioridad.prioridad_descripcion);
                $('#lbl-ticket-detalle-sla-espera').html(`${detalleSlaRespuesta.sla_periodo_hora < 10 ? '0' + detalleSlaRespuesta.sla_periodo_hora : detalleSlaRespuesta.sla_periodo_hora}:${detalleSlaRespuesta.sla_periodo_minuto < 10 ? '0' + detalleSlaRespuesta.sla_periodo_minuto : detalleSlaRespuesta.sla_periodo_minuto} Hrs`);

                if(data.ticket_evidencia) {
                    let evidencias      = JSON.parse( data.ticket_evidencia ),
                        evidenciaItem   = '';

                    evidencias.forEach(evidencia => {
                        let url = `${baseUrl}assets/evidencia/ticket/${data.ticket_id}/${evidencia.newName}`;

                        evidenciaItem += `
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Title-->
                                <a href="${url}" target="_blank" rel="noopener noreferrer" class="text-primary opacity-75-hover fs-6 fw-semibold">${evidencia.file}</a>                  
                                <!--end::Title-->  

                                <!--begin::Action-->
                                <a href="${url}" target="_blank" rel="noopener noreferrer" class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">
                                    <i class="ki-outline ki-exit-right-corner fs-2"></i>
                                </a>
                                <!--end::Action-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-2"></div>
                            <!--end::Separator-->
                        `;
                    });

                    $('#contenedor-ticket-detalle-evidencia').html(evidenciaItem);
                    $('#seccion-ticket-detalle-evidencia').removeClass('d-none');
                } else { $('#seccion-ticket-detalle-evidencia').addClass('d-none'); }

                drawerTicketDetalle.show();
            }
        });

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