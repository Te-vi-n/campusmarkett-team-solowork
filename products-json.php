<?php
header('Content-Type: application/json; charset=UTF-8');
$products = require __DIR__ . '/data/products.php';
echo json_encode($products, JSON_UNESCAPED_UNICODE);