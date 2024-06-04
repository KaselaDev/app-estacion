<?php


	/**
	 * 
	 * Motor de plantillas para php
	 * 
	 * */
	class MotorMaster{

		private $buffer; // contenido de la vista
		public $vista; // nombre de la vista

		/**
		 * 
		 * Se ejecuta al instanciar la clase
		 * @param string $vista nombre de la vista
		 * 
		 * */
		function __construct($vista){
			$this->vista = $vista;

			if(!file_exists("views/".$vista."View.html")){

				echo "No se encontro la vista <b>$vista</b>";
				exit();
			}

			$this->buffer = file_get_contents("views/".$vista."View.html");
		}

		/**
		 * 
		 * Reemplaza las variables del buffer
		 * @param array $vars Es un arreglo asociativo la llave es el nombre de la variable
		 * 
		 * */

		function setVars($vars){

			foreach ($vars as $needle => $content) {

				if($this->testVar($needle)){
					$this->buffer =str_replace("{{".$needle."}}", $content, $this->buffer); 
				}else{

					echo "No existe en la vista la variable <b>$needle</b>";
					exit();
				}
			}
		}

		/**
		 * 
		 * Verifica si existe la variable dentro del buffer
		 * @param string $name nombre de la variable
		 * @return bool variable existe | no existe
		 * 
		 * */
		function testVar($name){
			return strpos($this->buffer, $name);
		}

		/**
		 * 
		 * Imprime en la pagina el contenido de buffer
		 * 
		 * */
		function print(){
			echo $this->buffer;
		}
		
	}


 ?>