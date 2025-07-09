$(document).ready(function() {

    var numFilas = [ 10, 15, 20, 25, 50, -1 ];
    var filas    = [ '10 filas','15 filas','20 filas','25 filas','50 filas','Todas' ];
    var botones  = ['pageLength','copy', 'excel', 'pdf', 'print'];
    var idioma   = "/js/Spanish.json";

//Plantilla general para cualquier tabla
    $('#MyTable').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones
    } );

    $('#MyTableServicios').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones,
        //order: [1, 'asc']
    } );

    $('#MyTableTalleres').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones,
    } );

    $('#MyTableEmpleados').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones,
    } );

    $('#MyTableCuadrillas').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones
    } );

    $('#MyTableAdministraciones').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones
    } );

    $('#MyTableEdificios').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones
    } );

    $('#MyTablePuestos').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones
    } );

    $('#MyTableAdscripciones').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones
    } );

    $('#MyTablePersonal').DataTable( {
        language: {
             //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             "url": idioma
             },
        responsive: "true",
        //dom: 'Bfrtip',
        lengthMenu: [
        numFilas,
        filas
       ],
        buttons: botones
    } );
} );
