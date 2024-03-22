'use strict';

var KTCliente = (function () {
    var btnLogout = document.querySelector("#btnCerrarSession");

    var configuracionBotones = () => {
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
    };

    return {
        init: function () {
            configuracionBotones();
        }
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTCliente.init();
});