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
                    eleInvalidClass: 'is-invalid', 
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
            paramName: 'evidencia[]',
            maxFiles: 5,
            maxFilesize: 2,
            previewTemplate: previewTemplate,
            autoQueue: false,
            previewsContainer: `${id} .dropzone-items`,
            clickable: `${id} .dropzone-select`,
            dictFileTooBig: 'El archivo es demasiado grande ({{filesize}}MB). Maximo permitido: {{maxFilesize}}MB.',
            dictMaxFilesExceeded: 'Solo puedes agregar un máximo de {{maxFiles}} archivos.'
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
            console.log(formData)
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
                    btnRegistraTicket.setAttribute("data-kt-indicator", "on")
                    btnRegistraTicket.disabled = true;
                    
                    let formElement = new FormData( formNuevoTicket ),
                        formData 	= Object.fromEntries(formElement.entries());
                        
                        // console.log( 'quill.getContents().ops', quillTicketNuevo.getContents().ops);

                        console.log( 'quill.getContents().ops', quillTicketNuevo.getSemanticHTML(0, 10) );
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
    };

    return {
        init: function () {
            configuraciones();
        },
        languageDataTable,
        quillToolbarOptions
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTCliente.init();
});