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
            info: false,
            order: [],
            pageLength: 10,
            columnDefs: [],
            language: KTCliente.languageDataTable
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