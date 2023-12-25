<?php

require_once '../includes/db_connection.php';
require_once '../includes/authentication.php';

class users extends db_connection {
    
    private $id;
    private $name;
    private $username;
    private $email;
    private $password;
    private $tel;
    private $account_balance;
    private $user_type;
    

    public function __construct($name, $username, $email, $password, $tel, $user_type) {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->tel = $tel;
        $this->user_type = $user_type;      
    }
    
    public function register() {
        
        try {
            // Validate user type
            if (!in_array($this->user_type, ['company', 'passenger'])) {
                throw new Exception("Invalid user type.");
            }
            
            // Check if the user is already registered
           $auth = new authentication();
           if ($auth->is_user_registered($this->username, $this->email, $this->tel)) {
               throw new Exception("User with the same username, email, or tel already exists.");
           }
            
            parent::connect();  // Connect to the database

            // Hash the password
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            // Insert user data into the 'users' table
            $sql = "INSERT INTO users (name, username, email, password, tel, user_type) 
                   VALUES ('" . $this->name . "', '" . $this->username . "', '" . $this->email . "', '" . $hashedPassword . "', '" . $this->tel . "', '" . $this->user_type . "')";    
            $query = mysqli_query(parent::get_connect(), $sql);

            // Check if the query was successful
            if (!$query) {
                throw new Exception("Failed to insert user data.");
            }

            // Get the last inserted ID
            $lastInsertId = mysqli_insert_id(parent::get_connect());

            if ($this->user_type === 'company') {
                // Insert additional data into the 'company' table
                $sql = "INSERT INTO company (id) VALUES ('" . $lastInsertId . "')";  
                $query = mysqli_query(parent::get_connect(), $sql);

                // Check if the query was successful
                if (!$query) {
                    throw new Exception("Failed to insert company data.");
                }
            } elseif ($this->user_type === 'passenger') {
                // Insert additional data into the 'passenger' table
                $sql = "INSERT INTO passenger (id) VALUES ('" . $lastInsertId . "')";
                $query = mysqli_query(parent::get_connect(), $sql);

                // Check if the query was successful
                if (!$query) {
                    throw new Exception("Failed to insert passenger data.");
                }
            } 

            // Registration succeeded
            echo "Registration successful.";
            return true;

        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Registration failed: " . $e->getMessage();
            // Registration failed
            return false;

        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }
}

?>
