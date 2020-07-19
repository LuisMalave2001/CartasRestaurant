<?php namespace menus;

class MenusController{

	const URI_BASE = '/menus';
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