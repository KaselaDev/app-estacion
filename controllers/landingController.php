<?php 

	// carga el modelo de usuarios
	include_once 'models/Users.php';

	// carga la vista
	$tpl = loadTPL('landing');

	// variables a reemplazar en la vista
	$vars = ["CANT_USERS" => getCantUsers(), "CANT_PRODUCTS" => 100];
	
	// reemplazo de variables en la vista
	$tpl = setVarsTPL($vars,$tpl);
	
	// imprime la vista en pantalla
	printTPL($tpl);

 ?>