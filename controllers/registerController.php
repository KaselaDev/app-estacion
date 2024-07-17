<?php 
	
	// vector con las variables para la vista
	$vars = ["MSG_ERROR" => "" ];

	// si se presiono el botón de registrar
	if(isset($_POST['btn_register'])){

		// crea un usuario con el email y la contraseña del formulario
		$usuario = new User($_POST["txt_email"], $_POST["txt_password"]);

		// se procede a intentar registrar el nuevo usuario
		$result = $usuario->register();

		// se almacena el resultado del intento de registro
		$vars["MSG_ERROR"] = $result["error"];

		// si el registro fue valido
		if($result["errno"]==200){

			// el objeto usuario se pasa a una variable de sesión
			$_SESSION['mbcorp']['user'] = $usuario;

			// lo llevamos a su perfil para que lo complete
			header("Location: ?slug=perfil");
		}
	}

	// carga la vista
	$tpl = new MotorMaster("register");

	// reemplaza las variables de la vista con los valores del vector
	$tpl->setVars($vars);

	// imprime la vista en la página
	$tpl->print();

 ?>