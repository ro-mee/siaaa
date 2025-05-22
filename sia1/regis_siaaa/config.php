<?php
// Start output buffering to hide messages
ob_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'student_grades_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    // Message hidden
} else {
    // Message hidden
}

// Select the database
$conn->select_db($database);

// Create students table
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    section VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    // Message hidden
} else {
    // Message hidden
}

// Create grades table
$sql = "CREATE TABLE IF NOT EXISTS grades (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT(6) UNSIGNED,
    subject VARCHAR(100) NOT NULL,
    prelim FLOAT,
    midterm FLOAT,
    finals FLOAT,
    remarks VARCHAR(20),
    FOREIGN KEY (student_id) REFERENCES students(id)
)";

if ($conn->query($sql) === TRUE) {
    // Message hidden
} else {
    // Message hidden
}

// Clear the output buffer and discard the contents
ob_end_clean();
?> 