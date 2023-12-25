<?php

require_once '../includes/db_connection.php';

class authentication extends db_connection {

    public function is_user_registered($username, $email, $tel) {
        try {
            parent::connect();  // Connect to the database

            // Check if a user with the provided username, email, or tel already exists
            $sql = "SELECT id FROM users WHERE username = ? OR email = ? OR tel = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $tel);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Bind the result variable
                mysqli_stmt_bind_result($stmt, $id);

                // Fetch the result
                mysqli_stmt_fetch($stmt);

                // Close the statement
                mysqli_stmt_close($stmt);

                // If a user with the same username, email, or tel exists, return true
                // Otherwise, return false
                return ($id !== null);

            } else {
                throw new Exception("Failed to check user registration.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error checking user registration: " . $e->getMessage();
            return false;
    
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }

}

?>
