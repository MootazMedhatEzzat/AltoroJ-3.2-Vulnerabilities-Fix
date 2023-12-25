<?php
session_start();
include_once 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $itinerary = $_POST['itinerary'];
    $fees = $_POST['fees'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Add validation for inputs

    $db = new DBConnection();
    $db->connect();

    $company_id = $_SESSION['user_id'];

    $query = "INSERT INTO Flights (name, itinerary, fees, start_time, end_time, company_id) 
              VALUES ('$name', '$itinerary', '$fees', '$start_time', '$end_time', '$company_id')";

    if (mysqli_query($db->return_connect(), $query)) {
        echo "Flight added successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db->return_connect());
    }

    $db->disconnect();
}
?>