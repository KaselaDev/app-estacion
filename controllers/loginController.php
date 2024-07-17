<?php 

	// Variables para la vista
	$vars = ["MSG_ERROR" => "" ];

	// si se presiono el botón de login
	if(isset($_POST['btn_login'])){

		// se crea un usuario con el email y contraseña especificados
		$usuario = new User($_POST["txt_email"], $_POST["txt_password"]);

		// procede a intentar loguear el usuario
		$result = $usuario->login();

		// carga el resultado del intento de logueo en la variable para la vista
		$vars["MSG_ERROR"] = $result["error"];

		// si el logueo fue valido
		if($result["errno"]==0){

			//echo $usuario->nombre;

			// el objeto usuario se pasa una variable de sesión
			$_SESSION['mbcorp']['user'] = $usuario;

			// se redirecciona al panel de usuario
			header("Location: ?slug=panel");
		}
	}


	// carga la vista
	$tpl = new MotorMaster("login");

	// carga las variables de la vista con los valores del vector
	$tpl->setVars($vars);

	// imprime la vista en la página
	$tpl->print();

 ?>