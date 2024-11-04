<?php 

	
	include_once 'DBAbstract.php';

	class Producto{

		public $list = [];

		function __construct(){
			$this->list = ["pokemon", "digimon"];
		}


		function add($nombre){
			$this->list[] = $nombre;
		}


		function getAll(){
			return $this->list;
		}
	}

 ?>