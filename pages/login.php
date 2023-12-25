<?php

require_once '../classes/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginUsername = $_POST['loginUsername'];
    $loginPassword = $_POST['loginPassword'];

    $user = new users('', $loginUsername, '', $loginPassword, '', '');

    $userId = $user->login($loginUsername, $loginPassword);

    if ($userId !== false) {
        // Login successful, set up the user session or redirect to a dashboard
        session_start();
        $_SESSION['user_id'] = $userId;
        header('Location: dashboard.php'); // Replace with the desired redirect URL
        exit();
    } else {
        // Login failed, display an error message or redirect to the login page
        // echo "Login failed. Please try again.";
    }
}
