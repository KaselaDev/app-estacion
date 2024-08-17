<?php

	/**
	* @file Users.php
	* @brief Implementación de las funciones para el manejo la tabla Users.
	* @author Matias Leonardo Baez
	* @date 2024
	* @contact elmattprofe@gmail.com
	*/

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

				/**< Pasa el nombre del campo a una variable */
				$variable = $value["Field"];
				
				/**< Pasa los nombres de los campos a un vector*/
				$this->attributes[] = $variable;

				/**< pasa como un nuevo atributo el nombre de un campo */
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

			$result = $this->query("CALL `getByEmail`('".$this->email."')")->fetch_all(MYSQLI_ASSOC);

			if(count($result)==0){
				return false;
			}

			return $result;
		}

		/**
		 * 
		 * @brief Realiza soft delete
		 * 
		 * El usuario abandona o suspende su cuenta
		 * 
		 * @return bool nada
		 * 
		 * */
		function leaveOut(){
			// todas las tablas siempre id, create_at, update_at, delete_at
			$ssql = "CALL leaveOut({$this->id})";
	
			$this->query($ssql);

		}

		/**
		 * 
		 * Agrega el usuario
		 * @return array arreglo de errores
		 * 
		 * */
		function register(){
			
			$vector_error = ["error" => "", "errno" => 0];

			$result = $this->getByEmail();
			// email no repetido msg guarda
			if($result === false){

				// guardo el usuario en la tabla
				$email = $this->email;
				$password = md5($this->password);

				$ssql = "CALL register('$email', '$password')";

				//var_dump($ssql);

				$result = $this->query($ssql);

				$vector_error["error"] = "Guardo el usuario correctamente";
				$vector_error["errno"] = 200;

				return $vector_error;
			}

			// Existe porque sufrio soft delete y volvio
			// arrastrandose
			if($result[0]['delete_at']!='0000-00-00 00:00:00'){
				
				$id = $result[0]["id"];
				$password = md5($this->password);

				$ssql = "CALL comeBack($id, '$password')";

				$this->query($ssql);

				$vector_error["error"] = "Usuario que vuelve arrastrandose";
				$vector_error["errno"] = 201;

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

			$ssql = "CALL updateUser('$email', '$nombre', '$apellido')";

			var_dump($ssql);

			$this->query($ssql);

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

			$result = $this->query($ssql)->fetch_all(MYSQLI_ASSOC);

			// no se encontro el email
			if(count($result)==0){
				$vector_error["error"] = "No existe el correo electronico";
				$vector_error["errno"] = 404;

				return $vector_error;
			}

			$result = $result[0];

			// la contraseña no es correcta
			if($result["password"]!=md5($this->password)){
				$vector_error["error"] = "La contraseña no es valida";
				$vector_error["errno"] = 405;

				return $vector_error;
			}

			// se agrega al arreglo los mensajes de error
			$result = array_merge($vector_error, $result);

			// autocarga de valores (queda tambien la contraseña)
			foreach ($this->attributes as $key => $attribute) {
				$this->$attribute = $result[$attribute];
			}


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

			return count($this->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC));
		}

	}


 ?>