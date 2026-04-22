<?php

session_start();
include 'error_log.php';

$productIds = [
    [
        'id' => 1,
        'name' => 'Product 1',
        'price' => 100,
        'quantity' => 1
    ],
    [
        'id' => 2,
        'name' => 'Product 2',
        'price' => 200,
        'quantity' => 2
    ],
    [
        'id' => 3,
        'name' => 'Product 3',
        'price' => 300,
        'quantity' => 3
    ]
];

foreach ($productIds as $product) {
    echo "<form action='' method='post'>";
    echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
    echo $product['name'] . "<br>";
    echo $product['price'] . "<br>";
    echo $product['quantity'] . "<br>";
    echo "<button name='add_to_cart'>Add to Cart</button>" . "<br>";
    echo "<button name='remove_from_cart'>Remove from Cart</button>" . "<br>";
    echo "</form>";
    echo "----------------" . "<br>";
}

// Display current cart contents
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<h3>Current Cart:</h3>";
    foreach($_SESSION['cart'] as $productId => $quantity) {
        $product = array_filter($productIds, function($p) use ($productId) {
            return $p['id'] == $productId;
        });
        $product = reset($product);
        if($product) {
            echo $product['name'] . " - Quantity: " . $quantity . "<br>";
        }
    }
} else {
    echo "<h3>Cart is empty</h3>";
}


function addToCart($productId) {
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if(isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += 1;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
    
    echo "Product " . $productId . " added to cart";
}

function removeFromCart($productId) {
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if(isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] -= 1;
        if($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    }
    
    echo "Product " . $productId . " removed from cart";
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    addToCart($_POST['product_id']);
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
    removeFromCart($_POST['product_id']);
}
