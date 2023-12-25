<?php
include_once 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'];
    $to = $_POST['to'];

    // Add validation for inputs

    $db = new DBConnection();
    $db->connect();

    $query = "SELECT * FROM Flights WHERE itinerary LIKE '%$from%$to%'";
    $result = mysqli_query($db->return_connect(), $query);

    // Process the result as needed

    $db->disconnect();
}
?>