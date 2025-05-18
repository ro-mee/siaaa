<?php
session_start(); // ✅ Start the session
require_once 'connection.php'; // ✅ I-load ang DB connection (adjust path if needed)

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Dashboard</title>
  <link rel="Stylesheet" href="css/all.min.css">
  <link rel="Stylesheet" href="css/fontawesome.min.css">
  <style>
    a{
        text-decoration: none;
        color: inherit;
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      height: 100vh;
      background-color: #f3f6fb;
    }

    .sidebar {
      width: 260px;
      background-color: #143f7d;
      color: white;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .logo {
      width: 60px;
      margin-bottom: 20px;
    }

    .profile-circle {
      width: 100px;
      height: 100px;
      background-color: #2c4b83;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      margin-bottom: 10px;
    }

    .profile-info {
      text-align: center;
      margin-bottom: 30px;
    }

    .profile-info p {
      font-size: 12px;
      color: #cbd4f0;
    }

    .sidebar h4 {
      font-size: 12px;
      margin: 20px 0 10px;
      text-transform: uppercase;
      color: #9bb4df;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 10px;
      width: 100%;
      border-radius: 8px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .nav-item:hover,
    .nav-item.active {
      background-color: #1c4c99;
    }

    .nav-item span {
      margin-left: 10px;
    }

    .main-content {
      flex: 1;
      padding: 20px 40px;
      overflow-y: auto;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .top-bar span {
      color: #555;
      font-size: 14px;
    }

    .breadcrumb {
      color: #7b84d4;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .page-title {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 30px;
    }

    .cards {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      flex: 1 1 45%;
    }

    .card h3 {
      font-size: 16px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      margin-bottom: 5px;
    }

    .card strong {
      font-weight: 600;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <img src="bcp logo.png" alt="School Logo" class="logo" />
    <div class="profile-circle"><span id="student-initials"></span></div>
    <div class="profile-info">
      <strong><span id="student-name"></span></strong>
      <p>s<?php echo $student['student_id']; ?>@bcp.edu.ph</p>
    </div>

    <h4>Student Dashboard</h4>
    <div class="nav-item active">
      <a href="#"><span><i class="fa-solid fa-house"></i></span> Dashboard</a>
    </div>
    <div class="nav-item">
      <a href="#"><span><i class="fa-regular fa-user"></i></span> Profile</a>
    </div>
    <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-money-check"></i></span> Payment</a>
    </div>
    <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-book-open"></i></span> Semestral Grade</a>
    </div>
        <div class="nav-item">
      <a href="sia/login.php"><span><i class="fa-solid fa-right-from-bracket"></i></span> Logout</a>
    </div>
  </div>

  <div class="main-content">
    <div class="top-bar">
      <div class="menu">
        <span class="breadcrumb">Dashboard</span>
        <h1 class="page-title">Announcements</h1>
      </div>
      <span id="clock">09:50:35 AM</span>
    </div>

    <div class="cards">
      <div class="card">
<h3><i class="fa-regular fa-user"></i> <?php echo $student['fname']; ?></h3>
<p><strong>Course:</strong> <?php echo $student['course']; ?></p>
<p><strong>Admission Type:</strong> <?php echo $student['admission']; ?></p>
<p><strong>School ID:</strong> <?php echo $student['student_id']; ?></p>
<p><strong>Year Level:</strong> <?php echo $student['year']; ?></p>
      </div>

      <div class="card">
        <h3><i class="fa-regular fa-user"></i> ADVISER</h3>
        <p><strong>Name:</strong><span id="adviser-name"></span></p>
        <p><strong>My Section:</strong><span id="student-section"></span></p>
      </div>
    </div>

    <div class="card" style="margin-top: 20px;">
      <h3><i class="fa-solid fa-bullhorn"></i> Announcements</h3>
      <p>No announcements at this time.</p>
    </div>
  </div>

  <script>
    function updateClock() {
      const now = new Date();
      let hours = now.getHours();
      const minutes = now.getMinutes().toString().padStart(2, '0');
      const seconds = now.getSeconds().toString().padStart(2, '0');
      const ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12 || 12;
      document.getElementById("clock").textContent =
        `${hours}:${minutes}:${seconds} ${ampm}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
  </script>
</body>
</html>
