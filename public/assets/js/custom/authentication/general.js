"use strict";

var KTLogin = (function () {
    var btnLogin    = document.querySelector("#kt_sign_in_submit"),
        formLogin   = document.querySelector("#kt_sign_in_form");

    var reglaFormLogin = FormValidation.formValidation(
        formLogin, {
            fields: {
                usuario_nombre: {
                    validators: {
                        notEmpty: {
                            message: 'El nombre de usuario es requerido.'
                        }
                    }
                },
                usuario_contrasenia: {
                    validators: {
                        notEmpty: {
                            message: 'La contraseña es requerida.'
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

    var validacionFormLogin = () => {
        KTUtil.addEvent(btnLogin, 'click', function(e) {
            e.preventDefault();

            reglaFormLogin.validate().then((status) => {
                if (status == 'Valid') {
                    btnLogin.setAttribute("data-kt-indicator", "on")
                    btnLogin.disabled = true;
                    
                    let formElement = new FormData( formLogin ),
                        formData 	= Object.fromEntries(formElement.entries());

                    axios.post(`${baseUrl}api/usuario/dologin`, formData)
                    .then(function (response) {
                        if(response.status == 201) {
                            formLogin.reset();

                            let data = response.data.messages;

                            swal.fire({
                                title: data.success,
                                text: 'Cargando configuracion de la cuenta',
                                icon: "success",
                                timer: 4000,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: function() {
                                    Swal.showLoading()
                                }
                            }).then(function() {
                                window.location.replace(baseUrl);
                            });
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
                    })
                    .finally(() => {
                        btnLogin.removeAttribute("data-kt-indicator");
                        btnLogin.disabled = false;
                    });
                }
            });
        });
    };

    var configuracionNotificacion = () => {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    };

    var configuracionLetrero = () => {
        var typed = new Typed("#letreroHelpDesk", {
            strings: ["Un sistema de tickets de asistencia técnica de nivel empresarial."],
            typeSpeed: 30
        });
    };

    return {
        init: function () {
            configuracionNotificacion();
            configuracionLetrero();
            validacionFormLogin();
        }
    };

})();

KTUtil.onDOMContentLoaded(function () {
    KTLogin.init();
});
