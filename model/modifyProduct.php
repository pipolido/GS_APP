<?php
include 'data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (
        !empty($_POST['ProductName']) &&
        !empty($_POST['Price']) &&
        !empty($_POST['Quantity']) &&
        !empty($_POST['id'])
    ) {
        $id = $_POST['id'];
        $name = $_POST['ProductName'];
        $price = $_POST['Price'];
        $quantity = $_POST['Quantity'];

        $sql = "UPDATE product SET name = ?, Price = ?, Quantity = ? WHERE ID_Product = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sdii', $name, $price, $quantity, $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $_SESSION['message'] = ['text' => 'Product updated successfully', 'type' => 'success'];
                } else {
                    $_SESSION['message'] = ['text' => 'Unexpected error: No rows affected.', 'type' => 'error'];
                }
            } else {
                $_SESSION['message'] = ['text' => 'Database error: ' . $stmt->error, 'type' => 'error'];
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = ['text' => 'Database error: ' . $conn->error, 'type' => 'error'];
        }
    } else {
        $_SESSION['message'] = ['text' => 'Information missing', 'type' => 'error'];
    }

    header('Location: ../view/AddProduct.php');
    exit;
}
?>
