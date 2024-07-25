<?php
session_start();
include 'data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        if (!empty($_POST['ClientName']) && !empty($_POST['tele']) && !empty($_POST['Adr']) && !empty($_POST['Adremail'])) {
            $sql = "INSERT INTO client (name, Telephone, Adresse, Adressemail) VALUES (?, ?, ?, ?)";

            if ($req = $conn->prepare($sql)) {
                $req->bind_param("ssss", $_POST['ClientName'], $_POST['tele'], $_POST['Adr'], $_POST['Adremail']);

                if ($req->execute()) {
                    $_SESSION['message'] = ['text' => 'Client added successfully', 'type' => 'success'];
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
}
?>
