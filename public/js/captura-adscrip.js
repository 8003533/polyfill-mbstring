'use strict'

window.addEventListener('load', function(){

	function buscarAdscripcion() {
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
        	type: 'POST',
        	url: '/buscaAdscripciones',
        	data: {
        		ba: $('#busca_adscripcion').val(),
        	},
        	success: function (respuesta) {
        		console.log(respuesta);
        		if(respuesta.exito == 1){
        			var selectAdsc;
        			for(let i in respuesta.listaAdscs){
                        selectAdsc+= '<option value="'+respuesta.listaAdscs[i].iid_adscripcion +'">'+respuesta.listaAdscs[i].cdescripcion_adscripcion+'</option>';
                    }
                    document.querySelector('#adscripcion').innerHTML = selectAdsc;
                    document.querySelector('#validaPuestoAdsc').innerHTML = "";
        		}else{
        			var selectAdsc = "<option value=''>Capture una Adscripción en Buscar Adscripción, o una Nueva Adscripción...</option>";
        			var error="";
        			document.querySelector('#adscripcion').innerHTML = selectAdsc;
                    error+="<label><font style='color: red;'>*La Adscripción que busca NO Existe en el catálogo, verifique; o capturela en Nueva Adscripción.<font style='color: red;'></label><br/>"
        			document.querySelector('#validaPuestoAdsc').innerHTML = error;
                    return false;
        		}
        	},
        	error: function (jqXHR, textStatus, errorThrown) {
        		alert('Ocurrio un errror, intente de nuevo.' + jqXHR.responseText );
        	}
        });
	}

	function cambiaAdscReq() {
		var nvaAdscrip = document.querySelector('#nueva_adscripcion');
		if (nvaAdscrip!="") {
			$('#adscripcion').removeAttr('required');
			$('#nueva_adscripcion').prop('required',true);
		} else {
			$('#adscripcion').prop('required',true);
			$('#nueva_adscripcion').removeAttr('required');
		}
	}

//VARIABLES
	var buscaAdscrip = document.querySelector('#busca_adscripcion');
	var nvaAdscrip 	 = document.querySelector('#nueva_adscripcion');

	buscaAdscrip.addEventListener('change', function(){
		buscarAdscripcion();
	});
	nvaAdscrip.addEventListener('change', function(){
		cambiaAdscReq();
	});
});