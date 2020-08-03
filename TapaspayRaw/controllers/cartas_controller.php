<?php namespace cartas;

class CartasController{

	const URI_BASE = '/cartas';
	function __construct($uri)
	{
		switch($uri){
			case self::URI_BASE:
				$this->renderHomepage();
			break;
		}
	}

	private function renderHomepage(){
		include("../views/homepage.php");
	}

}

?>