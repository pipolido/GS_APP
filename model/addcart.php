<?php
session_start(); 

include 'data.php'; 
include 'Functions.php';

$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$productId = $_POST['Proname'];
$clientId = $_POST['ClientName']; 

$products = ShowProduct($productId);

if (!empty($products) && is_array($products)) {
    $productQuantity = (int) $products['Quantity'];
    $productPrice = (float) $products['Price'];
    $requestedQuantity = (int) $_POST['Quantity'];

    if ($requestedQuantity > $productQuantity) {
        $_SESSION['message']['text'] = "La quantité à vendre n'est pas disponible.";
        $_SESSION['message']['type'] = "danger";
    } else {
        $sql = "SELECT ID_Product FROM product WHERE ID_Product = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['message']['text'] = "Produit non trouvé.";
            $_SESSION['message']['type'] = "danger";
            header('Location: ../view/AddCart.php');
            exit();
        }

        $totalPrice = $requestedQuantity * $productPrice;

        $sql = "INSERT INTO commande (ID_Client, ID_Product, Quantity, TotalPrice) VALUES (?, ?, ?, ?)";
        $req = $conn->prepare($sql);
        $req->bind_param("iiii", $clientId, $productId, $requestedQuantity, $totalPrice);
        $req->execute();

        if ($req->affected_rows > 0) {
            $sql = "UPDATE product SET Quantity = Quantity - ? WHERE ID_Product = ?";
            $req = $conn->prepare($sql);
            $req->bind_param("ii", $requestedQuantity, $productId);
            $req->execute();

            if ($req->affected_rows > 0) {
                $_SESSION['message']['text'] = "L'achat a réussi. Le prix total est " . $totalPrice . " DH";
                $_SESSION['message']['type'] = "success";
            } else {
                $_SESSION['message']['text'] = "Impossible de continuer.";
                $_SESSION['message']['type'] = "danger";
            }
        } else {
            $_SESSION['message']['text'] = "Il y a eu un problème lors de l'ajout du produit.";
            $_SESSION['message']['type'] = "danger";
        }
    }
} else {
    $_SESSION['message']['text'] = "Certaines informations sont manquantes.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../view/AddCart.php');
exit();
?>
