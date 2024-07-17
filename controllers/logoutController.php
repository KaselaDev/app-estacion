<?php 

	// se pasa el objeto usuario de la sesión a una variable
	$usuario = $_SESSION["mbcorp"]["user"];

	// se procede a desloguear
	$usuario->logout();

	// se redirecciona a landing
	header("Location: ?slug=landing");

 ?>