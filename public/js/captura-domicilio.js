'use strict'

window.addEventListener('load', function(){

    let cpInput = document.querySelector("#codigo_postal");

    if (!cpInput) {
        console.warn("⚠️ No se encontró el input con id 'codigo_postal'.");
        return;
    }

	function buscaAlcaldiaColonia(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/buscaAlcaldiaColonia',
            data: {
                cp: $('#codigo_postal').val(),
            },
            success: function (respuesta) {  
            	console.log(respuesta);
                if(respuesta.exito == 1){
                    $('#colonia').attr("disabled", false);
                    $('#alcaldia').attr("disabled", false);
                    $('#btnGuarda').attr("disabled", false); 
                    document.querySelector('#validaDomicilio').innerHTML = "";
                    var selectAlcaldia = '<option value="'+respuesta.alcaldia[0].iid_alcaldia +'">'+respuesta.alcaldia[0].cnombre_alcaldia+'</option>';
                    var selectColonia;
                    for(let i in respuesta.listaColonia){
                        selectColonia+= '<option value="'+respuesta.listaColonia[i].iid_colonia +'">'+respuesta.listaColonia[i].cnombre_colonia+'</option>';
                    }
                    document.querySelector("#alcaldia").innerHTML = selectAlcaldia;
                    document.querySelector("#colonia").innerHTML = selectColonia;
                	document.querySelector('#validaDomicilio').innerHTML = "";
                }else{
                    $('#colonia').attr("disabled", true);
                    $('#alcaldia').attr("disabled", true);
                    $('#btnGuarda').attr("disabled", true);
                    var selectAlcaldia = "<option value='0'>Escriba un Código Postal...</option>";
                    var selectColonia = "<option value='0'>Escriba un Código Postal...</option>";
                    document.querySelector("#alcaldia").innerHTML = selectAlcaldia;
                    document.querySelector("#colonia").innerHTML = selectColonia;                   
                    var error=""; 
                    error+="<label><font style='color: red;'>*No se econtraron resultados con este codigo postal.<font style='color: red;'></label><br/>"
                    document.querySelector('#validaDomicilio').innerHTML = error;
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
               alert('Ocurrio un errror, intente de nuevo.' + jqXHR.responseText );
            }
        });
    }

    var cp = document.querySelector("#codigo_postal");

    cp.addEventListener('change', function(){        
        buscaAlcaldiaColonia();
    });
});