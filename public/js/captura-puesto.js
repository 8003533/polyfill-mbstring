'use strict'

window.addEventListener('load', function(){

	function buscarPuesto() {
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
        	type: 'POST',
        	url: '/buscaPuestos',
        	data: {
        		bp: $('#busca_puesto').val(),
        	},
        	success: function (respuesta) {
        		console.log(respuesta);
        		if(respuesta.exito == 1){
        			var selectPsto;
        			for(let i in respuesta.listaPstos){
                        selectPsto+= '<option value="'+respuesta.listaPstos[i].iid_puesto +'">'+respuesta.listaPstos[i].cdescripcion_puesto+'</option>';
                    }
                    document.querySelector('#puesto').innerHTML = selectPsto;
                    document.querySelector('#validaPuestoAdsc').innerHTML = "";
        		}else{
        			var selectPsto = "<option value=''>Capture un Puesto en Buscar Puesto, o un Nuevo Puesto...</option>";
        			var error="";
        			document.querySelector('#puesto').innerHTML = selectPsto;
                    error+="<label><font style='color: red;'>*El Puesto que busca NO Existe en el catálogo, verifique; o capturelo en Nuevo Puesto.<font style='color: red;'></label><br/>"
        			document.querySelector('#validaPuestoAdsc').innerHTML = error;
                    return false;
        		}
        	},
        	error: function (jqXHR, textStatus, errorThrown) {
        		alert('Ocurrio un errror, intente de nuevo.' + jqXHR.responseText );
        	}
        });
	}

	function cambiaPstoReq() {
		var nvoPsto = document.querySelector('#nuevo_puesto');
		if (nvoPsto!="") {
			$('#puesto').removeAttr('required');
			$('#nuevo_puesto').prop('required',true);
		} else {
			$('#puesto').prop('required',true);
			$('#nuevo_puesto').removeAttr('required');
		}
	}

//VARIABLES
	var buscaPuesto = document.querySelector('#busca_puesto');
	var nvoPsto 	= document.querySelector('#nuevo_puesto');

	buscaPuesto.addEventListener('change', function(){
		buscarPuesto();
	});
	nvoPsto.addEventListener('change', function(){
		cambiaPstoReq();
	});
});