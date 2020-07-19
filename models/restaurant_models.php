<?php namespace restaurant_models;

abstract class Entity {

    protected $tableName;
    protected $idColumnName = 'id';

    public $id;

}

class Product extends Entity {

    public $name;
    public $price;
}

?>