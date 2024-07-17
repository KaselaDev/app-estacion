<?php 

	// se pasa el objeto usuario de la sesión a una variable
	$usuario = $_SESSION["mbcorp"]["user"];

	// carga la vista
	$tpl = new MotorMaster("panel");

	// vector con variables para la vista
	$vars = ["NAME_USER" => $usuario->first_name];

	// reemplaza las variables de la vista con los valores del vector
	$tpl->setVars($vars);
	
	// imprime la vista en la página
	$tpl->print();

 ?>