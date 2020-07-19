<?php  namespace product;

$path = $_SERVER["DOCUMENT_ROOT"];

use product_repository\ProductRepository;
use restaurant_models\Product;

use PDO;

require_once($path . "/includes/connection.php");
require_once($path . "/models/restaurant_models.php");
require_once($path . "/repositories/product_repository.php");

class ProductController{

	const URI_BASE = '/product';

	function __construct($uri)
	{
		$method = $_SERVER["REQUEST_METHOD"];
		switch($uri){
			case self::URI_BASE:
				switch($method){
					case "POST":
						$this->createProduct();
					break;
					case "GET":
						$this->getAllProducts();
					break;
				}
			break;
			case preg_match("/^\/product\/[0-9]+$/", $uri) !== false:
				switch($method){
					case "PUT":
						$id = preg_replace("/^(\/product\/)/", '', $uri);
						parse_str(file_get_contents("php://input"),$post_vars);

						$product = new Product();
						$product->id = $id;
						$product->name = $post_vars["name"];
						$product->price = $post_vars["price"];
						$this->updateProduct($product);
					break;
				}
			break;
		}
	}

	private function updateProduct($product){
		$productRepo = new ProductRepository();
		if($productRepo->updateProduct($product)){
			echo json_encode($product);
		}else{
			throw new \Exception("An error has occurred");
		}

	}

	private function createProduct(){

		$name = isset($_POST['name']) ? $_POST['name'] : "";
		
		$productRepo = new ProductRepository();

		$product = new Product();
		$product -> name = $name;
		$product -> price = 0.0;

		$productRepo -> createProduct($product);
		echo json_encode($product);
	}

	private function getAllProducts(){

		$productRepo = new ProductRepository();

		$productArray = $productRepo->findAll();

		echo json_encode($productArray);

	}
}

?>