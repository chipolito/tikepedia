'use strict';

var KTCliente = (function () {
    var btnLogout               = document.querySelector("#btnCerrarSession");

    var quillTicketNuevo;

    var quillToolbarOptions     = [
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'font': [] }],
        ['bold', 'italic', 'underline', 'strike', 'blockquote'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }]
    ];

    var languageDataTable       = {
        emptyTable: 'No hay registros para mostrar',
        infoEmpty: 'No se encontraron registros'
    };

    var languageSelect2         = {
        noResults: function() { return 'Sin registros'; }
    }

    var dropZoneNewTicket;

    var idTicketNuevo           = 0;

    var btnRegistraTicket       = document.querySelector("#kt_registra_ticket"),
        formNuevoTicket         = document.querySelector("#kt_ticket_nuevo_form");

    var reglaFormNuevoTicket    = FormValidation.formValidation(
        formNuevoTicket, {
            fields: {
                ticket_departamento: {
                    validators: {
                        notEmpty: {
                            message: 'El departamento es requerido.'
                        }
                    }
                },
                ticket_tema: {
                    validators: {
                        notEmpty: {
                            message: 'El tema de ayuda es requerido.'
                        }
                    }
                },
                ticket_sunto: {
                    validators: {
                        notEmpty: {
                            message: 'El asunto del tema es requerido.'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                bootstrap: new FormValidation.plugins.Bootstrap5({ 
                    rowSelector: '.fv-row', 
                    eleInvalidClass: '', 
                    eleValidClass: ''
                })
            }
        }
    );

    var configureDropzone = () => {
        const id = '#kt_dropzonejs_ticket_nuevo';
        const dropzone = document.querySelector(id);

        var previewNode = dropzone.querySelector('.dropzone-item');
        previewNode.id = '';
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        dropZoneNewTicket = new Dropzone(id, {
            url: `${baseUrl}api/ticket/putevidencia`,
            paramName: 'evidencia',
            maxFiles: 5,
            maxFilesize: 2,
            previewTemplate: previewTemplate,
            autoQueue: false,
            previewsContainer: `${id} .dropzone-items`,
            clickable: `${id} .dropzone-select`,
            dictFileTooBig: 'El archivo es demasiado grande ({{filesize}}MB). Maximo permitido: {{maxFilesize}}MB.',
            dictMaxFilesExceeded: 'Solo puedes agregar un máximo de {{maxFiles}} archivos.',
            parallelUploads:5,
            uploadMultiple:true
        });

        dropZoneNewTicket.on('addedfile', function (file) {
            // file.previewElement.querySelector(`${id} .dropzone-start`).onclick = function () { dropZoneNewTicket.enqueueFile(file); };
            const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
            dropzoneItems.forEach(dropzoneItem => {
                dropzoneItem.style.display = '';
            });
            // dropzone.querySelector('.dropzone-upload').style.display = "inline-block";
            dropzone.querySelector('.dropzone-remove-all').style.display = "inline-block";
        });

        // dropZoneNewTicket.on('totaluploadprogress', function (progress) {
        //     const progressBars = dropzone.querySelectorAll('.progress-bar');
        //     progressBars.forEach(progressBar => {
        //         progressBar.style.width = `${progress}%`;
        //     });
        // });

        dropZoneNewTicket.on('sending', function (file, xhr, formData) {
            formData.append('ticket_id', idTicketNuevo);
        });

        // dropZoneNewTicket.on('complete', function (progress) {
        //     const progressBars = dropzone.querySelectorAll('.dz-complete');
        
        //     setTimeout(function () {
        //         progressBars.forEach(progressBar => {
        //             progressBar.querySelector('.progress-bar').style.opacity = '0';
        //             progressBar.querySelector('.progress').style.opacity = '0';
        //             progressBar.querySelector('.dropzone-start').style.opacity = '0';
        //         });
        //     }, 500);
        // });

        dropzone.querySelector('.dropzone-upload').addEventListener('click', function () {
            const deleteIcons = dropzone.querySelectorAll('.dropzone-delete');
            deleteIcons.forEach(deleteIcon => {
                deleteIcon.style.display = 'none';
            });

            dropZoneNewTicket.enqueueFiles(dropZoneNewTicket.getFilesWithStatus(Dropzone.ADDED));
        });

        dropzone.querySelector('.dropzone-remove-all').addEventListener('click', function () {
            dropzone.querySelector('.dropzone-upload').style.display = 'none';
            dropzone.querySelector('.dropzone-remove-all').style.display = 'none';
            dropZoneNewTicket.removeAllFiles(true);
        });

        dropZoneNewTicket.on('queuecomplete', function (progress) {
            const uploadIcons = dropzone.querySelectorAll('.dropzone-upload');
            uploadIcons.forEach(uploadIcon => {
                uploadIcon.style.display = 'none';
            });

            toastr.success('Ticket registrado y archivos almacenados correctamente');

            KTDrawer.hideAll();
        });

        dropZoneNewTicket.on('removedfile', function (file) {
            if (dropZoneNewTicket.files.length < 1) {
                dropzone.querySelector('.dropzone-upload').style.display = 'none';
                dropzone.querySelector('.dropzone-remove-all').style.display = 'none';
            }
        });

        dropZoneNewTicket.on('error', (fileObject, response) => {
            toastr.error(response);

            $(fileObject.previewElement).remove();
        });
    };

    var validacionFormNuevoTicket = () => {
        KTUtil.addEvent(btnRegistraTicket, 'click', function(e) {
            e.preventDefault();

            reglaFormNuevoTicket.validate().then((status) => {

                if (status == 'Valid') {
                    let arrayDetalle    = quillTicketNuevo.getContents().ops;

                    if( arrayDetalle[0].insert.length == 1){
                        toastr.error('Proporcione los detalles del ticket');
                        return false;
                    }

                    btnRegistraTicket.setAttribute("data-kt-indicator", "on")
                    btnRegistraTicket.disabled = true;

                    let archivos        = dropZoneNewTicket.files.length,
                        temaConfig      = $('#ticket_tema').select2('data')[0],
                        foioTicket      = 'T-APT-';

                    let formElement = new FormData( formNuevoTicket );

                    formElement.append('ticket_detalle', JSON.stringify(arrayDetalle));
                    formElement.append('ticket_prioridad', temaConfig.prioridad);
                    formElement.append('ticket_sla', temaConfig.tema_sla);
                    formElement.append('ticket_sla_respuesta', temaConfig.tema_sla_respuesta);
                    formElement.append('ticket_folio', foioTicket);
                    formElement.append('ticket_estatus', 1);
                    formElement.append('ticket_calificacion', 0);
                    formElement.append('ticket_cerrado', 0);
                    formElement.append('ticket_reabierto', 0);

                    let formData = Object.fromEntries(formElement.entries());
                    
                    axios.post(`${baseUrl}api/ticket/create`, formData)
                    .then(async function (response) {
                        if(response.status == 201) {
                            let data = response.data.messages;
                            
                            idTicketNuevo = data.ticket_id;

                            await axios.put(`${baseUrl}api/ticket/update/${data.ticket_id}`, {ticket_folio: `${foioTicket}${ String(data.ticket_id).padStart(4, '0') }`});

                            if( archivos == 0) {
                                toastr.success( data.success );
                                KTDrawer.hideAll();
                            } else {
                                $('.dropzone-upload')[0].click();
                            }
                        }
                    })
                    .catch(function (error) {
                        if (error.response) {
                            toastr.error(error.response.data.messages.error, 'Verifique sus datos');
                        } else if (error.request) {
                            toastr.error('No se recibió respuesta del servidor, consulte con el administrador de red.');
                        } else {
                            toastr.error('Error al procesar la petición, recargue la página (F5)');
                        }

                        btnRegistraTicket.removeAttribute("data-kt-indicator");
                        btnRegistraTicket.disabled = false;
                    });
                }

            });
        });
    };

    var configuraciones = () => {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1500",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        KTUtil.addEvent(btnLogout, 'click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estas seguro?',
                text: 'Confirma que deseas salir y cerrar la sesión',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Cerrar mi sesión',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: "btn btn-dark",
                    cancelButton: "btn btn-secondary"
                },
                allowOutsideClick: false,
                allowEscapeKey: false
              }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace(`${baseUrl}logout`);
                }
            });
        });

        $('#ticket_sunto').maxlength({
            warningClass: "badge badge-dark",
            limitReachedClass: "badge badge-danger"
        });

        quillTicketNuevo = new Quill('#ticket_detalle', {
            modules: {
                toolbar: quillToolbarOptions
            },
            placeholder: 'Explique a detalle la problemática que tiene...',
            theme: 'snow'
        });

        configureDropzone();

        validacionFormNuevoTicket();

        cargarDepartamentos();

        let drawerEl    = document.querySelector("#kt_drawer_ticket_nuevo");
        let drawer      = KTDrawer.getInstance(drawerEl);
        drawer.on("kt.drawer.after.hidden", function() {
            formTicketReset();
        });

    };

    var cargarDepartamentos = () => {
        axios.get(`${baseUrl}api/departamento`)
        .then(function (response) {
            if(response.status == 200) {
                let departamentos = response.data.messages.data,
                    data = [];
                
                departamentos.forEach((departamento) => {
                    data.push({ 
                        id: departamento.departamento_id,
                        text: departamento.departamento_nombre
                    });
                });

                $('#ticket_departamento').select2({
                    data: data,
                    language: languageSelect2
                });
            }
        })
        .catch(function (error) {
            if (error.response) {
                toastr.error('Error de respuesta, recargue la página (F5)');
            } else if (error.request) {
                toastr.error('Error de petición, recargue la página (F5)');
            } else {
                toastr.error('Error al procesar la petición, recargue la página (F5)');
            }
        })
        .finally(() => {
            $('#ticket_departamento').on('select2:select', function (e) {
                var data = e.params.data;

                cargarTemasAyuda(data.id);
            });
        });
    };

    var cargarTemasAyuda = (departamentoId) => {
        $('#ticket_tema').select2('destroy');

        axios.get(`${baseUrl}api/tema/${departamentoId}`)
        .then(function (response) {
            if(response.status == 200) {
                let temas = response.data.messages.data,
                    data = [];
                
                temas.forEach((tema) => {
                    data.push({ 
                        id: tema.tema_id,
                        text: tema.tema_nombre,
                        prioridad: tema.tema_prioridad,
                        tema_sla: tema.tema_sla,
                        tema_sla_respuesta: tema.tema_sla_respuesta
                    });
                });

                $('#ticket_tema').select2({
                    data: data,
                    language: languageSelect2
                });
            }
        })
        .catch(function (error) {
            $('#ticket_tema')
            .html('<option></option>')
            .select2({ language: languageSelect2 });

            $('#ticket_tema').val(null).trigger('change');
        });
    };

    var formTicketReset = () => {
        $('#ticket_departamento').val(null).trigger('change');
        
        $('#ticket_tema').select2('destroy');
        $('#ticket_tema')
            .html('<option></option>')
            .select2({ language: languageSelect2 });

        $('#ticket_tema').val(null).trigger('change');

        $('#ticket_sunto').val('');

        quillTicketNuevo.setContents([{insert:'\n'}]);

        $('.dropzone-remove-all')[0].click();

        reglaFormNuevoTicket.resetForm();

        btnRegistraTicket.removeAttribute("data-kt-indicator");
        btnRegistraTicket.disabled = false;        
    };

    return {
        init: function () {
            configuraciones();
        },
        languageDataTable,
        quillToolbarOptions,
        languageSelect2
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTCliente.init();
});