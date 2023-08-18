<?php

require_once '../config/connect.php';

$response = array();

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    if(mysqli_query($connect, "DELETE FROM products WHERE `products`.`id` = '$id'")) {
        $response['status'] = "success";
        $response['message'] = "Product successfully deleted";
    } else {
        $response['status'] = "error";
        $response['message'] = "Error deleting product: " . mysqli_error($connect);
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid ID";
}

echo json_encode($response);
?>