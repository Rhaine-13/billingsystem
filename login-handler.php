<?php
session_start();
require('./database.php'); // Ensure this file contains your database connection code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($connection, $_POST['username']);
    $passwordInput = mysqli_real_escape_string($connection, $_POST['passwordInput']);

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT Password FROM tenant WHERE Email = ?";
    $stmt = $connection->prepare($sql);
    
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("s", $email);
        
        // Execute the statement
        $stmt->execute();
        
        // Store the result
        $stmt->store_result();
        
        // Check if the email exists
        if ($stmt->num_rows > 0) {
            // Bind the result to a variable
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();
            
            // Verify the password
            if (password_verify($passwordInput, $hashedPassword)) {
                // Password is correct, redirect to dashboard
                $_SESSION['email'] = $email; // Store email in session
                $_SESSION['Password'] = $row['Password'];
                $_SESSION['FullName'] = $row['FullName'];

                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['badmessage'] = "Invalid password.";
            }
        } else {
            $_SESSION['badmessage'] = "No account found with that email.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['badmessage'] = "SQL Error: " . $connection->error;
    }

    // Redirect back to the login page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>