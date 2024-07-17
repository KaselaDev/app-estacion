<?php 

	// crea un usuario
	$usuarios = new Users();

	// carga la vista
	$tpl = new MotorMaster("landing");

	// variables a reemplazar en la vista
	$vars = ["CANT_USERS" => $usuarios->getCant(), "CANT_PRODUCTS" => 100];
	
	// reemplaza las variables de la vista con los valores del vector 
	$tpl->setVars($vars);

	// imprime la vista en la página
	$tpl->print();


 ?>