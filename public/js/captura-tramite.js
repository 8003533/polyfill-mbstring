'use strict'

window.addEventListener('load', function(){
//Funciones
//Muestra Lista de Beneficios o Lista de Otros Trámites
	function muestraBeneficiouOtro() {
		var tipoTramiteId = document.querySelector('#tramite').value;
		if (tipoTramiteId=="1"){
			$('#divbenpen').show();
			$('#divotrotramite').hide();
			$('#beneficio').attr('required','required');
			$('#nobeneficio').removeAttr('required');
		} else if (tipoTramiteId=="2"){
			$('#divbenpen').hide();
			$('#divotrotramite').show();
			$('#beneficio').removeAttr('required');
			$('#nobeneficio').attr('required','required');
		} else {
			$('#divbenpen').hide();
			$('#divotrotramite').hide();
			$('#beneficio').removeAttr('required');
			$('#nobeneficio').removeAttr('required');
		}
	}

//Muestra Lista de Juzgados para Incompetencia o campo Cumplimiento
	function muestraIncompCumplim(){
		var tipoRemiteId  = document.querySelector('#remite').value;
		if (tipoRemiteId=="1"){
			$('#divincompetencia').show();
			$('#divcumplimiento').hide();
			$('#incompetencia').attr('required','required');
			$('#cumplimiento').removeAttr('required');
		} else if (tipoRemiteId=="2"){
			$('#divincompetencia').hide();
			$('#divcumplimiento').show();
			$('#incompetencia').removeAttr('required');
			$('#cumplimiento').attr('required','required');
		} else {
			$('#divincompetencia').hide();
			$('#divcumplimiento').hide();
			$('#incompetencia').removeAttr('required');
			$('#cumplimiento').removeAttr('required');
		}
	}

//Variables
	var tipoTramite   = document.querySelector('#tramite');
	var tipoTramiteId = document.querySelector('#tramite').value;
	var tipoRemite 	  = document.querySelector('#remite');
	var tipoRemiteId  = document.querySelector('#remite').value;

//Muestra Lista de Beneficios o Lista de Otros Trámites
	if (tipoTramiteId=="1"){
		$('#divbenpen').show();
		$('#divotrotramite').hide();
		$('#beneficio').attr('required','required');
		$('#nobeneficio').removeAttr('required');
	} else if (tipoTramiteId=="2"){
		$('#divbenpen').hide();
		$('#divotrotramite').show();
		$('#beneficio').removeAttr('required');
		$('#nobeneficio').attr('required','required');
	} else {
		$('#divbenpen').hide();
		$('#divotrotramite').hide();
		$('#beneficio').removeAttr('required');
		$('#nobeneficio').removeAttr('required');
	}

//Muestra Lista de Juzgados para Incompetencia o campo Cumplimiento
	if (tipoRemiteId=="1"){
		$('#divincompetencia').show();
		$('#divcumplimiento').hide();
		$('#incompetencia').attr('required','required');
		$('#cumplimiento').removeAttr('required');
	} else if (tipoRemiteId=="2"){
		$('#divincompetencia').hide();
		$('#divcumplimiento').show();
		$('#incompetencia').removeAttr('required');
		$('#cumplimiento').attr('required','required');
	} else {
		$('#divincompetencia').hide();
		$('#divcumplimiento').hide();
		$('#incompetencia').removeAttr('required');
		$('#cumplimiento').removeAttr('required');
	}

//Llamar funciones
	tipoTramite.addEventListener('change', function(){
		muestraBeneficiouOtro();
	});
	tipoRemite.addEventListener('change', function(){
		muestraIncompCumplim();
	})
});