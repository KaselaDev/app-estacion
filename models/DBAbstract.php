<?php 

	// Anula los errores de mysql
	mysqli_report(MYSQLI_REPORT_OFF);

	define("HOST", "localhost");
	define("USER", "mbcorp");
	define("PASS", "mbcorp1234");
	define("DB", "mbcorp");

	/**
	 * 
	 * Clase para heredar la conexión a la base de datos
	 * 
	 * */
	class DBAbstract{

		private static $instance = null;
		public $db;

		/**
		 * 
		 * Constructor de la clase ejecuta el metodo de conexión a la DB
		 * 
		 * */
		function __construct(){

			$this->connect();

		}

		/**
		 * 
		 * Conecta con la base de datos
		 * 
		 * */
		function connect(){
			// el arroba silencia los errores del objeto
			$this->db = @new mysqli(HOST, USER, PASS, DB);	

			// control de errores de conexion a la db
			if($this->db->connect_errno){
				echo "Se produjo un error en la conexion: <br>".$this->db->connect_errno;

				exit();
			}
		}

		/**
		 * 
		 * DML -> SELECT
		 * Realiza la consulta a la base de datos
		 * 
		 * */
		function query($sql){

			// se fuerza a que genere otra conexion si no esta activa
			$this->connect();			

			$response = $this->db->query($sql);
			
			// control de errores en la query
			if($this->db->errno){
				echo "Ocurrio un error: ".$this->db->error;
				exit();
			}

			/*< retorna un objeto mysqli_response  */
			return $response; 
		}
	}


 ?>