<?php 

	// carga el modelo de usuarios
	include_once 'models/Users.php';

	$tpl = new MotorMaster("landing");

	// variables a reemplazar en la vista
	$vars = ["CANT_USERS" => getCantUsers(), "CANT_PRODUCTS" => 100];
	
	$tpl->setVars($vars);

	$tpl->print();


 ?>