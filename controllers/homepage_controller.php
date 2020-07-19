<?php namespace homepage;

class HomepageController{

	const URI_BASE = '/';
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