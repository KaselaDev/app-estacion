<?php

	// carga el modelos
	include_once 'models/Users.php';

	// incluimos el motor de plantillas
	include_once 'lib/motorMaster/MotorMaster.php';

	session_start();

	// Router con auto carga de controladores 

	// por defecto seccion es landing
	$seccion = "landing";

	// si existe slug por GET
	if($_GET['slug']!=""){
		// se reemplaza seccion por el valor de slug	
		$seccion = $_GET['slug'];
	}



	// si no existe el archivo del controlador
	if(!file_exists('controllers/'.$seccion.'Controller.php')){
		// seccion se carga con el controlador de error 404
		$seccion = "error404";
	}

	$seccion_login = ["panel", "logout", "perfil"];
	$seccion_anonima = ["landing", "login", "register"];



	// existe una sesion
	if(isset($_SESSION['mbcorp'])){
 		
		foreach ($seccion_anonima as $key => $value) {
			if($value==$seccion){
				$seccion = "panel";
				break;
			}
		}

	}else{ // no existe una sesion

		foreach ($seccion_login as $key => $value) {
			if($value==$seccion){
				$seccion = "landing";
				break;
			}
		}

	}

	// carga del controlador
	include 'controllers/'.$seccion.'Controller.php';

 ?>