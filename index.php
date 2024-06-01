<?php

	// incluimos el motor de plantillas
	include_once 'lib/motorMaster/MotorMaster.php';

	// Router con auto carga de controladores 

	// por defecto seccion es landing
	$seccion = "landing";

	// si existe slug por GET
	if(isset($_GET['slug'])){
		// se reemplaza seccion por el valor de slug	
		$seccion = $_GET['slug'];
	}

	// si no existe el archivo del controlador
	if(!file_exists('controllers/'.$seccion.'Controller.php')){
		// seccion se carga con el controlador de error 404
		$seccion = "error404";
	}

	// carga del controlador
	include 'controllers/'.$seccion.'Controller.php';

 ?>