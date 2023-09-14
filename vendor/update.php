<?php
require_once '../config/connect.php';

// Проверка наличия метода запроса POST и наличия параметра _method с указанием метода PUT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
    // Получение данных из запроса
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Обновление данных в базе данных
    $query = "UPDATE `products` SET `title` = '$title', `price` = '$price', `description` = '$description' WHERE `id` = '$id'";
    
    if (mysqli_query($connect, $query)) {
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request');
    echo json_encode($response);
}
?>