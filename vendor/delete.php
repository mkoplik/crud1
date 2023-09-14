<?php
require_once '../config/connect.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    if(isset($data['id'])) {
        $id = $data['id'];

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
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid method";
}

echo json_encode($response);
?>
