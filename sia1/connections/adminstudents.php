<?php
$section = $_GET['section'] ?? '';

$conn = new mysqli("localhost", "root", "", "student_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM students WHERE section = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $section);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Students in Section $section</h2>";

while ($row = $result->fetch_assoc()) {
    echo "<p>" . htmlspecialchars($row['name']) . "</p>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
      <link rel="stylesheet" href="format.css">
    <link rel="Stylesheet" href="css/all.min.css">
  <link rel="Stylesheet" href="css/fontawesome.min.css">
<style>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.card {
    text-align: center;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    padding: 20px;
    transition: transform 0.2s;
}

.card:hover {
    transform: scale(1.05);
}

.orange {
    background-color: #ff8c00;
}

.purple {
    background-color: #6a5acd;
}

.content .number {
    font-size: 24px;
    font-weight: bold;
}

.content .label {
    font-size: 16px;
    margin-top: 10px;
    display: block;
}
</style>

</head>
<body>

  </script>
    <div class="sidebar">
    <img src="bcp logo.png" alt="School Logo" class="logo" />
    <div class="profile-circle"><span id="student-initials"></span></div>
    <div class="profile-info">
      <strong><span id="student-name"></span></strong>
      <p><span id="student-id"></span>@bcp.edu.ph</p>
    </div>

    <h4>Admin Dashboard</h4>
    <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-house"></i></span> Dashboard</a>
    </div>
    <div class="nav-item active">
      <a href="#"><span><i class="fa-regular fa-user"></i></span> Students</a>
    </div>
    <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-chalkboard"></i></span> Classes</a>
    </div>
    <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-person-chalkboard"></i></span> Teachers</a>
    </div>
        <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-book"></i></span> Subject</a>
    </div>
        <div class="nav-item">
      <a href="#"><span><i class="fa-regular fa-address-card"></i></span> Account Access</a>
    </div>
        <div class="nav-item">
      <a href="login.php"> <i class="fa-solid fa-right-from-bracket"></i></span> Logout</a>

    </div>
  </div>
   <div class="main-content">
    <div class="top-bar">
      <div class="menu">
        <h1 class="page-title">Students</h1>
        <span class="breadcrumb">Sections</span>

            <div class="container">
        <a href="#" class="card orange">
            <div class="content">
                <span class="number">BSIT22015</span>
                <span class="label">Section</span>
            </div>
        </a>
        <a href="#" class="card purple">
            <div class="content">
                <span class="number">BSIT22016</span>
                <span class="label">Section</span>
            </div>
        </a>
    </div>
</div>
</div>
</div>
   <script>
    // Select all nav-item elements
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach(item => {
      item.addEventListener('click', () => {
        // Remove 'active' from all
        navItems.forEach(i => i.classList.remove('active'));
        // Add 'active' to the clicked one
        item.classList.add('active');
      });
    });
  </script>
</body>
</html>