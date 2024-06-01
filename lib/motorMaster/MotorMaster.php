<?php 

	/**
	 * 
	 * Retorna la vista en formato de string
	 * @param string $view nombre de la vista
	 * @return string vista para ser modificada o impresa
	 * 
	 * */
	function loadTPL($view){

		return file_get_contents("views/".$view."View.html");
	}

	/**
	 * 
	 * reemplaza las variables de la vista
	 * @param array $vars es un vector asociativo con las variables y su contenido
	 * @param string $tpl es la vista
	 * @return string la vista con las variables reemplazadas
	 * 
	 * */
	function setVarsTPL($vars, $tpl){

		foreach ($vars as $needle => $content) {
			$tpl =str_replace("{{".$needle."}}", $content, $tpl); 
		}

		return $tpl;
	}

	/**
	 * 
	 * Imprime la vista en pantalla
	 * @param string $tpl la vista a ser impresa en pantalla
	 * 
	 * */
	function printTPL($tpl){
		echo $tpl;
	}


 ?>