<?php 

	include_once 'DBAbstract.php';

	/**
	 * 
	 * Clase para trabajar con la tabla de usuarios
	 * 
	 * */
	class User extends DBAbstract{

		/**
		 * 
		 * Crea el objeto y crea de forma automática los atributos
		 * basandose en las columnas de la tabla que representa
		 * 
		 * */
		function __construct($email, $password){
			parent::__construct();

			$sql = "DESCRIBE users;";

			$result = $this->query($sql);

			foreach ($result as $key => $value) {

				$variable = $value["Field"];

				$this->$variable="";
			}

			$this->email = $email;
			$this->password = $password;

		}

		/**
		 * 
		 * Busca el usuario por su email
		 * @return array|bool arreglo con los datos del usuario|si no lo encontro false
		 * 
		 * */
		function getByEmail(){

			$result = $this->query("SELECT * FROM users WHERE email = '".$this->email."'");

			if(count($result)==0){
				return false;
			}

			return $result;
		}

		/**
		 * 
		 * Agrega el usuario
		 * @return array arreglo de errores
		 * 
		 * */
		function register(){
			
			$vector_error = ["error" => "", "errno" => 0];

			// email no repetido msg guarda
			if($this->getByEmail()=== false){

				// guardo el usuario en la tabla
				$email = $this->email;
				$password = md5($this->password);

				$result = $this->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");

				$vector_error["error"] = "Guardo el usuario correctamente";
				$vector_error["errno"] = 200;

				return $vector_error;
			}

			$vector_error["error"] = "Email ya existente";
			$vector_error["errno"] = 400;

			return $vector_error;

		}

		/**
		 * 
		 * Actualiza los datos
		 * @param array $form arreglo asociativo con los valores a actualizar
		 * @return array arreglo de errores
		 * 
		 * */
		function update($form){

			$email = $this->email;

			$nombre = $form["first_name"];
			$apellido = $form["last_name"];

			// actualiza el contenido de los atributos de la clase
			$this->first_name = $nombre;
			$this->last_name = $apellido;

			$this->query("UPDATE users SET first_name = '$nombre', last_name = '$apellido' WHERE email = '$email'");

			$vector_error["error"] = "Se actualizo los datos con exito";
			$vector_error["errno"] = 200;

			return $vector_error;
		}

		/**
		 * 
		 * Cierra la sesión del usuario
		 * 
		 * */
		function logout(){
			session_unset();
			session_destroy();
		}

		/**
		 * 
		 * valida el usuario y la contraseña
		 * @return array arreglo con el resultado del intento de login
		 * 
		 * */
		function login(){

			$vector_error = ["error" => "", "errno" => 0];

			// se agrego las comillas alrededor de email para que no tire error de mysql
			$ssql = "CALL `getUserByEmail`('".$this->email."')";

			$result = $this->query($ssql);

			// no se encontro el email
			if(count($result)==0){
				$vector_error["error"] = "No existe el correo electronico";
				$vector_error["errno"] = 404;

				return $vector_error;
			}

			// la contraseña no es correcta
			if($result[0]["password"]!=md5($this->password)){
				$vector_error["error"] = "La contraseña no es valida";
				$vector_error["errno"] = 405;

				return $vector_error;
			}

			// se agrega al arreglo los mensajes de error
			$result = array_merge($vector_error, $result);

			// aqui deberiamos colocar la autocarga de los atributos de ese usuarios
			//===================

			$this->first_name = $result[0]["first_name"];
			$this->last_name = $result[0]["last_name"];

			return $result;
			
		}
	}

	/**
	 * 
	 * Clase para trabajar con muchos usuarios
	 * 
	 * */
	class Users extends DBAbstract{

		/**
		 * 
		 * Constructor de la clase
		 * 
		 * */
		function __construct(){

			parent::__construct();

		}

		/**
		 * 
		 * retorna la cantidad de usuarios en la tabla de usuarios
		 * @return int cantidad de usuarios en la tabla de usuarios
		 * 
		 * */
		function getCant(){

			return count($this->query("SELECT * FROM users"));
		}

	}


 ?>