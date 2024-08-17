<?php 

	// pasa el objeto usuario de la sesión a una variable
	$usuario = $_SESSION["mbcorp"]["user"];

	// apretaron el boton de guardar
	if(isset($_POST["btn_guardar"])){

		// se quita el botón del vector de POST
		unset($_POST['btn_guardar']);

		// actualiza los datos del usuario con los datos de POST
		$usuario->update($_POST);

		// redirecciona al panel de usuario
		header("Location: panel");
	}

	// carga la vista
	$tpl = new MotorMaster("perfil");

	// vector con variables para la vista
	$vars = ["MSG_ERROR" => "","NAME_USER" => $usuario->first_name, "LAST_NAME" => $usuario->last_name, "AVATAR_URL" => $usuario->avatar];

	// reemplaza las variables de la vista con los valores del vector
	$tpl->setVars($vars);
	
	// imprime la vista en la página
	$tpl->print();


 ?>