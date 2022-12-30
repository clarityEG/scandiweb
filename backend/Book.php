<?php

class Book extends Product
{
    protected $attribute;
    private $weight;

    function __construct($name, $price, $sku, $weight)
    {
        parent::__construct($name, $price, $sku, 'Book');
        $this->weight = $weight;
    }

    public function save() {
        $this->insert('products', 
                    array('name', 'price', 'sku', 'attribute', 'type') ,
                    array($this->name, $this->price,
                        strtolower($this->sku), $this->weight . ' KG', 'Book'))
                ->execute();
    }
};