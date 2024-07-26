<?php
// db_operation.php

include 'config.php';

// Open the database connection
$conn = OpenCon();

// Check if the connection is successful
if ($conn) {
    echo "Connected Successfully";
} else {
    echo "Failed to connect to the database";
}

// Close the database connection
CloseCon($conn);
?>
