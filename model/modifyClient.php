<?php
session_start();
include 'data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (
        !empty($_POST['ClientName']) &&
        !empty($_POST['tele']) &&
        !empty($_POST['Adr']) &&
        !empty($_POST['Adremail']) &&
        !empty($_POST['id'])
    ) {
        $id = $_POST['id'];
        $name = $_POST['ClientName'];
        $Telephone = $_POST['tele'];
        $Adresse = $_POST['Adr'];
        $Adressemail = $_POST['Adremail'];

        $sql = "UPDATE client SET name = ?, Telephone = ?, Adresse = ?, Adressemail = ? WHERE ID_Client = ?";
        if ($req = $conn->prepare($sql)) {
            $req->bind_param('ssssi', $name, $Telephone, $Adresse, $Adressemail, $id);

            if ($req->execute()) {
                if ($req->affected_rows > 0) {
                    $_SESSION['message'] = ['text' => 'Client updated successfully', 'type' => 'success'];
                } else {
                    $_SESSION['message'] = ['text' => 'Unexpected error: No rows affected.', 'type' => 'error'];
                }
            } else {
                $_SESSION['message'] = ['text' => 'Database error: ' . $req->error, 'type' => 'error'];
            }

            $req->close();
        } else {
            $_SESSION['message'] = ['text' => 'Database error: ' . $conn->error, 'type' => 'error'];
        }
    } else {
        $_SESSION['message'] = ['text' => 'Information missing', 'type' => 'error'];
    }

    header('Location: ../view/AddClient.php');
    exit;
}
?>
