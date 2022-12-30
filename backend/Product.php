<?php

abstract class Product extends DBController{

    protected $name;
    protected $price;
    protected $sku;
    protected $type;    
    private $allowedTypes = array('DVD', 'Book', 'Furniture');

    public function __construct($name, $price, $sku, $type) {
        
        $this->checkPrice($price);
        $this->checkName($name);
        $this->checkSKU($sku);
        $this->checkType($type);


        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
        $this->type = $type;

        parent::__construct($_SERVER['DB_HOST'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_USERNAME'], $_SERVER['DB_NAME']);
    }
    

    private function checkPrice($price) {
        if(!is_numeric($price))
            throw new Exception('Invalid price');
    }

    private function checkName($name) {
        if(strlen($name) == 0)
            throw new Exception('Invalid name');
    }

    private function checkSKU($sku) {
        if(strlen($sku) == 0)
            throw new Exception('Invalid sku');
    }

    private function checkType($type) {
        if(in_array($type, $this->allowedTypes) == 0)
            throw new Exception('Invalid type');
    }

    private function checkAttribute($attributes) {
        foreach ($attributes as $attribute){
            if(!is_numeric($attribute) || $attribute <= 0)
                throw new Exception('Invalid attributes');
        }
    }

    abstract protected function save();
}

?>
