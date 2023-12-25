<?php

require_once '../classes/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    $user_type = $_POST['user_type'];

    $user = new users($name, $username, $email, $password, $tel, $user_type);

    if ($user->register()) {
        // Registration successful
        // echo "Registration successful.";
        //header('Location: login.php');
        exit();
    } else {
        // Registration failed
        // echo "Registration failed. Please try again.";
    }
}
?>