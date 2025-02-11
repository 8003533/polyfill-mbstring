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

    $('#MyTableTramites').DataTable( {
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

    $('#MyTableExpedientes').DataTable( {
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

    $('#MyTableSentenciados').DataTable( {
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

    $('#MyTableDelitos').DataTable( {
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

    $('#MyTableJuzgados').DataTable( {
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

    $('#MyTableReclusorios').DataTable( {
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

    $('#MyTableEjecucion').DataTable( {
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

    $('#MyTableBeneficios').DataTable( {
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
