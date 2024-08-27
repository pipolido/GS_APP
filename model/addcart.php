<?php
// session_start();
 include 'data.php';
include 'Functions.php';

$products = ShowProduct($_POST['ID_Product']);

if (!empty($products) && is_array($products)) {
    if ($_POST['Quantity'] > $products['Quantity']) {
        $_SESSION['message']['text'] = "La quantité à vendre n'est pas disponible";
        $_SESSION['message']['type'] = "danger";
    } else {
        $sql = "INSERT INTO commande(Quantity, TotalPrice) VALUES (?, ?)";
        $req = $connexion->prepare($sql);
        $req->bind_param("ii",$_POST['Quantity'], $_POST['Price']);
        $req->execute();
      
        if ($req->affected_rows != 0) {
            $sql = "UPDATE product SET Quantity=Quantity-? WHERE ID_Product=?";
            $sql = $connexion->prepare($sql);
            $sql->bind_param("is", $_POST['Quantity'], $_POST['Proname']);
            $sql->execute();

            if ($sql->affected_rows != 0) {
                $_SESSION['message']['text'] = "Purchasing Succeeded.";
                $_SESSION['message']['type'] = "success";
            } else {
                $_SESSION['message']['text'] = "Impossible to continue.";
                $_SESSION['message']['type'] = "danger";
            }
        } else {
            $_SESSION['message']['text'] = "There is a problem when adding a product.";
            $_SESSION['message']['type'] = "danger";
        }
    }
} else {
    $_SESSION['message']['text'] = "Some informations are missing.";
    $_SESSION['message']['type'] = "danger";
}
header('Location: ../view/AddCart.php');

?>