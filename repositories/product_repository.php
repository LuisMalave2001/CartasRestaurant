<?php namespace product_repository;

$path = $_SERVER["DOCUMENT_ROOT"];
require_once($path . "/includes/connection.php");
require_once($path . "/models/restaurant_models.php");

use Exception;
use PDO;
use restaurant_models\Product;

class ProductRepository{

    public function deleteProduct(int $productId){
        if($productId){
            $connection = getConnection();
            $createProductQuery = "DELETE FROM Products WHERE product_id = :product_id";
            $statement = $connection->prepare($createProductQuery);

            $statement -> bindParam(":product_id", $productId, PDO::PARAM_INT);

            $result = $statement -> execute();
            $connection = null;
            return $result;
        }
        return null;
    }

    public function updateProduct(Product $product){
        if($product -> id){
            $connection = getConnection();
            $createProductQuery = "UPDATE Products SET 
                name = :name
                , price = :price 
                , sequence = :sequence 
                WHERE product_id = :product_id";
            $statement = $connection->prepare($createProductQuery);

            $statement -> bindParam(":name", $product -> name, PDO::PARAM_STR);
            $statement -> bindParam(":price", $product -> price);
            $statement -> bindParam(":sequence", $product -> sequence, PDO::PARAM_INT);

            $statement -> bindParam(":product_id", $product -> id, PDO::PARAM_INT);

            $result = $statement -> execute();
            $connection = null;
            return $result;
        }
        return null;
    }
    
    public function createProduct($product){

        $connection = getConnection();
        $createProductQuery = "INSERT INTO Products (Name, price, sequence) SELECT :name, :price, (SELECT MAX(sequence)+1 FROM Products)";
        $statement = $connection->prepare($createProductQuery);

        $statement -> bindParam(":name", $product -> name, PDO::PARAM_STR);
        $statement -> bindParam(":price", $product -> price);

        if ($statement -> execute()){
            $productId = $connection->lastInsertId();
        } else {
            throw new Exception($statement->errorInfo()[2]);
            //$productId = null;
        }
        $product->id = $productId;
        
        $connection = null;

    }

    public function findAll(){
        $connection = getConnection();

        $getProductQuery 
        = "SELECT product_id, name, COALESCE(price, 0.0) as price
            FROM products";

        $statement = $connection->query($getProductQuery);
        $statement->execute();
        $productList = [];
        while ($productParams = $statement->fetch(PDO::FETCH_ASSOC)){

            $id    = $productParams["product_id"];
            $name  = $productParams["name"];
            $price = $productParams["price"];

            $product = new Product();
            $product -> id = $id;
            $product -> name = $name;
            $product -> price = $price;

            $productList[] = $product;
        }
        return $productList;
    }

    public function findById(array $productIds){
        $connection = getConnection();

        $getProductQuery 
        = "SELECT name, price
            FROM products
            WHERE  productId IN (" + implode(",", $productIds) . ")";

        $statement = $connection->query($getProductQuery);
        $statement->execute();
        while ($productParams = $statement->fetch(PDO::FETCH_ASSOC)){
            $a = 0;
        }
        //$statement -> bindParam(":name", $product -> name, PDO::PARAM_STR);
/*
        if ($statement -> execute()){
            $productId = $connection->lastInsertId();
        } else {
            $productId = null;
        }
        $product->id = $productId;
        
        $connection = null;*/
    }
}

?>