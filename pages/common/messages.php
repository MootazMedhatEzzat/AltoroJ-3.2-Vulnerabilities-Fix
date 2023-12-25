<?php
session_start();
include_once 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Add validation for inputs

    $db = new DBConnection();
    $db->connect();

    $query = "INSERT INTO Messages (sender_id, receiver_id, message) 
              VALUES ('$sender_id', '$receiver_id', '$message')";

    if (mysqli_query($db->return_connect(), $query)) {
        echo "Message sent successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db->return_connect());
    }

    $db->disconnect();
}
?>