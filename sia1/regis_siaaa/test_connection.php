<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'student_grades_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!";
}

// Close connection
$conn->close();
?> 