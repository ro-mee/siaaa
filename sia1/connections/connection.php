<?php


$host = 'localhost';
$username = 'root';
$password = '';
$database = 'student_system';

$conn = mysqli_connect($host, $username, $password, $database);

if ($conn === false) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // NOTE: You should use prepared statements for security.
    $sql = "SELECT * FROM student_users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    if ($row && isset($row["access"])) {
        // Save student ID to session
        $_SESSION['student_id'] = $row['id']; // You must have 'id' in student_users table

        if ($row["access"] == "student") {
            header("Location: homepage.php");
            exit;
        } elseif ($row["access"] == "admin") {
            header("Location: adminhome.php");
            exit;
        } elseif ($row["access"] == "teacher") {
            header("Location: teacherhome.php");
            exit;
        } elseif ($row["access"] == "registrar") {
            header("Location: registrarhome.php");
            exit;
        }
    } else {
        echo "Username or password do not match";
        exit;
    }
}

// When accessing homepage.php
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
} else {
    $student = null;
    // You could redirect or show a user-friendly message
}
?>
