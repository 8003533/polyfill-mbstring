'use strict';

(function () {
    window.addEventListener('load', function () {
        const buscaPuesto = document.querySelector('#busca_puesto');
        const nvoPsto = document.querySelector('#nuevo_puesto');

        if (buscaPuesto) {
            buscaPuesto.addEventListener('change', function () {
                buscarPuesto();
            });
        }

        if (nvoPsto) {
            nvoPsto.addEventListener('change', function () {
                cambiaPstoReq();
            });
        }

        function buscarPuesto() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': token }
            });

            $.ajax({
                type: 'POST',
                url: '/buscaPuestos',
                data: {
                    bp: buscaPuesto.value,
                },
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.exito == 1) {
                        let selectPsto = '';
                        for (let i in respuesta.listaPstos) {
                            selectPsto += `<option value="${respuesta.listaPstos[i].iid_puesto}">${respuesta.listaPstos[i].cdescripcion_puesto}</option>`;
                        }
                        document.querySelector('#puesto').innerHTML = selectPsto;
                        document.querySelector('#validaPuestoAdsc').innerHTML = "";
                    } else {
                        document.querySelector('#puesto').innerHTML = `<option value="">Capture un Puesto en Buscar Puesto, o un Nuevo Puesto...</option>`;
                        const error = `<label><font style='color: red;'>*El Puesto que busca NO Existe en el catálogo, verifique; o capturelo en Nuevo Puesto.</font></label><br/>`;
                        document.querySelector('#validaPuestoAdsc').innerHTML = error;
                    }
                },
                error: function (jqXHR) {
                    alert('Ocurrió un error, intente de nuevo.' + jqXHR.responseText);
                }
            });
        }

        function cambiaPstoReq() {
            if (nvoPsto && nvoPsto.value.trim() !== "") {
                $('#puesto').removeAttr('required');
                $('#nuevo_puesto').prop('required', true);
            } else {
                $('#puesto').prop('required', true);
                $('#nuevo_puesto').removeAttr('required');
            }
        }
    });
})();
