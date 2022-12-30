<?php 
require_once('./DBController.php');
require_once('./Product.php');
require_once('./Furniture.php');
require_once('./DVD.php');
require_once('./Book.php');

class ProductsController {

    private $db;
    private $prods = [
        'Book' => 'Book',
        'book' => 'Book',   // alias for class Book
        'DVD' => 'DVD',
        'dvd' => 'DVD',     // alias for class DVD
        'Furniture' => 'Furniture',
        'furniture' => 'Furniture', // alias for class Furniture
    ];

    public function __construct(){
        $this->db = new DBController($_SERVER['DB_HOST'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_USERNAME'], $_SERVER['DB_NAME']);
    }

    public function getAll() { 
        $this->db->select('products', array('*'));
        return $this->db->execute()->get();
    }

    public function removeProduct($products){
        foreach($products as $product) {
            $this->db->delete('products', 'sku', $product);
            $this->db->execute();
        }
        
        return '';
    }

    public function createProduct($name, $price, $type, $sku, $attribute){
        $prod = new $this->prods[$type]($name, $price, $sku, $attribute);
        
        try{
            $prod->save();
        }catch(PDOException $e){            
            // if SKU is already present set http code to 409 CONFILICT.
            if ($e->getCode() == 23000) {
                return 409;
            }

            else {
                return 500;
            }
                
        }
        
        return 200;
    }
}

?>