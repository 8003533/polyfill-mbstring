'use strict';

(function () {
    window.addEventListener('load', function () {
        const buscaAdscrip = document.querySelector('#busca_adscripcion');
        const nvaAdscrip = document.querySelector('#nueva_adscripcion');

        if (buscaAdscrip) {
            buscaAdscrip.addEventListener('change', function () {
                buscarAdscripcion();
            });
        }

        if (nvaAdscrip) {
            nvaAdscrip.addEventListener('change', function () {
                cambiaAdscReq();
            });
        }

        function buscarAdscripcion() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': token }
            });

            $.ajax({
                type: 'POST',
                url: '/buscaAdscripciones',
                data: {
                    ba: buscaAdscrip.value,
                },
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.exito == 1) {
                        let selectAdsc = '';
                        for (let i in respuesta.listaAdscs) {
                            selectAdsc += `<option value="${respuesta.listaAdscs[i].iid_adscripcion}">${respuesta.listaAdscs[i].cdescripcion_adscripcion}</option>`;
                        }
                        document.querySelector('#adscripcion').innerHTML = selectAdsc;
                        document.querySelector('#validaPuestoAdsc').innerHTML = "";
                    } else {
                        document.querySelector('#adscripcion').innerHTML =
                            `<option value=''>Capture una Adscripción en Buscar Adscripción, o una Nueva Adscripción...</option>`;
                        const error = `<label><font style='color: red;'>*La Adscripción que busca NO Existe en el catálogo, verifique; o capturela en Nueva Adscripción.</font></label><br/>`;
                        document.querySelector('#validaPuestoAdsc').innerHTML = error;
                    }
                },
                error: function (jqXHR) {
                    alert('Ocurrió un error, intente de nuevo.' + jqXHR.responseText);
                }
            });
        }

        function cambiaAdscReq() {
            if (nvaAdscrip && nvaAdscrip.value.trim() !== "") {
                $('#adscripcion').removeAttr('required');
                $('#nueva_adscripcion').prop('required', true);
            } else {
                $('#adscripcion').prop('required', true);
                $('#nueva_adscripcion').removeAttr('required');
            }
        }
    });
})();
