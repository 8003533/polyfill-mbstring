$(document).ready(function () {

    var numFilas = [10, 15, 20, 25, 50, -1];
    var filas    = ['10 filas','15 filas','20 filas','25 filas','50 filas','Todas'];
    var idioma   = "/js/Spanish.json";

    function initTabla(selector, titulo) {

        // Si no existe en esta vista, no hacer nada
        if (!$(selector).length) return;

        // Evitar reinicialización
        if ($.fn.DataTable.isDataTable(selector)) return;

        // Inicializar DataTable
        var dt = $(selector).DataTable({
            language: { url: idioma },
            responsive: true,

            // Mostrar filas"
            lengthMenu: [numFilas, filas],

            // Botones
            dom: 'lBfrtip', 
            buttons: [
                { extend: 'copy',  text: 'Copiar'  },
                { extend: 'excel', text: 'Excel' },
                { extend: 'pdf',   text: 'PDF',   title: titulo },
                { extend: 'print', text: 'Imprimir', title: titulo }
            ]
        });

       
        // MOVER CONTROLES A LA BARRA PERSONALIZADA

        var $wrapper = $(selector).closest('.dataTables_wrapper');

       
        var $toolbar = $(selector).closest('.table-responsive').find('.dt-custom-toolbar').first();
        if (!$toolbar.length) return;

       
        $wrapper.find('.dataTables_length').appendTo($toolbar.find('.dt-slot-length'));

  
        $wrapper.find('.dt-buttons').appendTo($toolbar.find('.dt-slot-buttons'));

        
        $wrapper.find('.dataTables_filter').appendTo($toolbar.find('.dt-slot-search'));
    }

    // ========= INICIALIZAR LAS TABLAS =========
    initTabla('#MyTable', 'Reporte');
    initTabla('#MyTableServicios', 'Listado de Servicios');
    initTabla('#MyTableTalleres', 'Listado de Talleres');
    initTabla('#MyTableEmpleados', 'Listado de Empleados');
    initTabla('#MyTableCuadrillas', 'Listado de Cuadrillas');
    initTabla('#MyTableAdministraciones', 'Listado de Administraciones');
    initTabla('#MyTableEdificios', 'Listado de Edificios');
    initTabla('#MyTablePuestos', 'Listado de Puestos');
    initTabla('#MyTableAdscripciones', 'Listado de Adscripciones');
    initTabla('#MyTablePersonal', 'Listado de Personal');
    initTabla('#MyTableAreas', 'Listado de Áreas');
    initTabla('#MyTableProveedores', 'Listado de Proveedores');
    initTabla('#MyTableBienes', 'Listado de Bienes');
    initTabla('#MyTableEntradas', 'Listado de Entradas');
    initTabla('#MyTableSalidas', 'Listado de Salidas');
    initTabla('#MyTableUnidades', 'Listado de Unidades');
});
