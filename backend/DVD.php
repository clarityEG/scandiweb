<?php
class DVD extends Product
{
    protected $attribute;
    private $size;

    function __construct($name, $price, $sku, $size)
    {
        parent::__construct($name, $price, $sku, 'DVD');
        $this->size = $size;
    }

  
    public function save() {
        $this->insert('products', 
                    array('name', 'price', 'sku', 'attribute', 'type') ,
                    array($this->name, $this->price,
                        strtolower($this->sku), $this->size . ' MB', 'DVD'))
                ->execute();
    }
};