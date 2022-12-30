<?php
header('Access-Control-Allow-Origin: *');
require_once('./ProductsController.php');

$request = $_SERVER['REQUEST_URI'];


if ($_SERVER['REQUEST_METHOD'] == 'GET' && $request == '/products') {
    $_ = new ProductsController();
    echo json_encode($_->getAll());
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $request == '/delete-products') {
    $_ = new ProductsController();
    $_->removeProduct($_POST['prods']);    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $request == '/products') {
    $_ = new ProductsController();    
    $response = $_->createProduct($_POST['name'], $_POST['price'], $_POST['type'], $_POST['sku'], $_POST['attribute']);
    http_response_code($response);
}

