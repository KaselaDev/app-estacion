<?php 

	// se pasa el objeto usuario de la sesión a una variable
	$usuario = $_SESSION["mbcorp"]["user"];

	// se procede a abandonar al app (soft delete)
	$usuario->leaveOut();

	// se redirecciona a landing
	header("Location: ?slug=logout");

 ?>