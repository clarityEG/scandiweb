<?php

class Furniture extends Product
{
    protected $attribute;
    private $height;
    private $length;
    private $width;

    function __construct($name, $price, $sku, $attributes)
    {
        parent::__construct($name, $price, $sku, 'Furniture');
        $this->height = $attributes['height'];
        $this->length = $attributes['length'];
        $this->width = $attributes['width'];
    }

    public function save() {
        $this->insert('products', 
                    array('name', 'price', 'sku', 'attribute', 'type') ,
                    array($this->name, $this->price,
                        strtolower($this->sku), implode('x', array($this->height, $this->width, $this->length)),
                        'Furniture'))
                ->execute();
    }
};