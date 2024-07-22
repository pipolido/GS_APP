

<?php
include 'data.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ID_User']) && isset($_POST['name']) && isset($_POST['password'])) {
        $ID_User = $_POST['ID_User'];
        $name = $_POST['name'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT ID_User, name, password FROM users WHERE ID_User = ? AND name = ?");

        if ($stmt === false) {
            error_log("Prepare failed: " . $conn->error);
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("is", $ID_User, $name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($ID_User, $name, $storedPassword);
            $stmt->fetch();

            if ($password === $storedPassword) {
                $_SESSION['user_id'] = $ID_User;
                $_SESSION['name'] = $name;
                header("Location: https://youtube.com");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Invalid ID or username.";
        }

        $stmt->close();
    } else {
        $error = "Please enter all required fields.";
    }
}

$conn->close();
?>

