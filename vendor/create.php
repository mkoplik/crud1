<?php

require_once '../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['description'], $_POST['price'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $query = "INSERT INTO `products` (`id`, `title`, `price`, `description`) VALUES (NULL, '$title', '$price', '$description')";
    if (mysqli_query($connect, $query)) {
        $response = array(
            'success' => true,
            'message' => 'Product added successfully.'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error adding product: ' . mysqli_error($connect)
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array(
        'success' => false,
        'message' => 'Invalid request.'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}
