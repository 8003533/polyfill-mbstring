/*document.addEventListener('DOMContentLoaded', function () {
    $('.modal').on('show.bs.modal', function () {
        $(this).removeAttr('aria-hidden');
    });

    $('.modal').on('hidden.bs.modal', function () {
        $(this).attr('aria-hidden', 'true');
    });
});*/



document.addEventListener('DOMContentLoaded', function () {
    // Coloca fecha y hora actual al abrir el modal
    $('#newOrdenModal').on('show.bs.modal', function () {
        const now = new Date();
        const formatted = now.toLocaleString('es-MX', {
            year: 'numeric', month: '2-digit', day: '2-digit',
            hour: '2-digit', minute: '2-digit'
        });

        document.getElementById('fecha_solicitud').value = formatted;
        document.getElementById('folio').value = ''; // Puedes dejarlo vacío, o colocar "Auto"
        document.getElementById('conclusion').value = '';
        document.getElementById('observaciones').value = '';

        // Inicializar Select2 en el select con id "area" cuando se abre el modal
        $('#area').select2({
            placeholder: "Seleccione área", // Puedes poner un placeholder
            allowClear: true                // Permite limpiar la selección
        });
        
    });

    // Enviar el formulario
    $('#formOrdenServicio').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/registro/guardar',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                // Validar que el folio esté presente en la respuesta
            if (response.folio) {
                    $('#newOrdenModal').modal('hide');
                    mostrarModalExito(response.folio);
                } else {
                    alert('No se generó el folio correctamente.');
                }
            },
            error: function (xhr) {
                alert('Error al guardar: ' + xhr.responseText);
            }
        });
    });

    function mostrarModalExito(folio) {
            // Verificar si el modal ya existe en el DOM
            if ($('#modalExito').length === 0) {
                let modalHtml = `
                <div class="modal fade" id="modalExito" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-body text-center">
                        <h5 class="text-success">Orden guardada correctamente</h5>
                        <p>Folio generado: <strong>${folio}</strong></p>
                        <button class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                    </div>
                </div>
                </div>
                `;
                $('body').append(modalHtml);
            }

            $('#modalExito').modal('show');

            // Limpiar después de cerrar
            $('#modalExito').on('hidden.bs.modal', function () {
                $(this).remove();
            });
    }

});

