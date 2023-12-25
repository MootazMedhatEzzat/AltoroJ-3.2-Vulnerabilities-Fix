<?php
session_start();
include_once 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Add validation for inputs

    $db = new DBConnection();
    $db->connect();

    $query = "SELECT * FROM Users WHERE email='$email'";
    $result = mysqli_query($db->return_connect(), $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Login successful, store user details in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['type'];
        echo "Login successful";
    } else {
        echo "Invalid email or password";
    }

    $db->disconnect();
}
?>