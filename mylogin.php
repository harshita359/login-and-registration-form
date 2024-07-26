<?php
require_once "config.php";

if (isset($_POST['submit'])) {
    $post_username = trim($_POST['username']);
    $post_password = trim($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) { // Check if the statement was prepared successfully
        // If not, output the error message to understand the cause
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("ss", $username, $password);
    echo "hello".$username;
    echo "hello".$password;
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    if ($count == 1) {
        // Redirect to welcome page on successful login
        header("Location: welcome.php");
        exit(); // Important to stop further code execution
    } else {
        // Corrected JavaScript with proper syntax and closed tag
        echo '<script>
            alert("Login failed: Invalid username and password!");
            
        </script>';
    }

    // Always close the statement and connection
    $stmt->close();
    $conn->close();
}// window.location.href = "login.php";