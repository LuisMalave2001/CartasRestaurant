<?php namespace homepage;

use product_repository\ProductRepository;
use restaurant_models\Product;

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
		$product = new Product();
		$product->name = "hola";
		$productRepo = new ProductRepository();
		$product_ids = $productRepo -> findAll();
		include("../views/homepage.php");
	}

}

?>