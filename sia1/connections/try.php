<?php
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section_code'])) {
    $section_code = trim($_POST['section_code']);

    if (!empty($section_code)) {
        // Check if section already exists
        $check = $conn->prepare("SELECT * FROM sections WHERE section_code = ?");
        $check->bind_param("s", $section_code);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            // Section already exists
            echo "<p style='color: red;'>Section already exists!</p>";
        } else {
            // Insert new section
            $stmt = $conn->prepare("INSERT INTO sections (section_code) VALUES (?)");
            $stmt->bind_param("s", $section_code);
            $stmt->execute();
            $stmt->close();

            // Redirect to prevent form resubmission
            header("Location: try.php");
            exit();
        }

        $check->close();
    }
}


// Get all sections to display as cards
$sections = [];
$result = $conn->query("SELECT section_code FROM sections ORDER BY section_code ASC");
while ($row = $result->fetch_assoc()) {
    $sections[] = $row['section_code'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections</title>
          <link rel="stylesheet" href="format.css">
    <link rel="Stylesheet" href="css/all.min.css">
  <link rel="Stylesheet" href="css/fontawesome.min.css">
    <style>
        .form-container {
            margin-bottom: 30px;
        }

        .form-container input[type="text"] {
            padding: 10px;
            width: 200px;
            font-size: 16px;
        }

        .form-container input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            margin-left: 10px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            flex-direction: column;
        }

        .card {
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.2s;
            color: white;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .orange {
            background-color: rgb(20, 63, 125);
        }

        .number {
            font-size: 24px;
            font-weight: bold;
        }

        .label {
            font-size: 16px;
            margin-top: 10px;
            display: block;
        }
        
    </style>
</head>
<body>
      <div class="sidebar">
    <img src="bcp logo.png" alt="School Logo" class="logo" />
    <div class="profile-circle"><span id="student-initials"></span></div>
    <div class="profile-info">
      <strong><span id="student-name"></span></strong>
      <p><span id="student-id"></span>@bcp.edu.ph</p>
    </div>

    <h4>Admin Dashboard</h4>
    <div class="nav-item">
      <a href="adminhome.php"><span><i class="fa-solid fa-house"></i></span> Dashboard</a>
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

<div class="form-container">
        <form method="POST">
            <input type="text" name="section_code" placeholder="Enter Section (e.g., 2218)" required>
            <input type="submit" value="Add Section">
        </form>
    </div>

    <div class="container">
        <?php foreach ($sections as $section): ?>
            <a href="studentlist.php?section=<?= urlencode($section) ?>" class="card orange">
                <div class="content">
                    <div class="number"><?= htmlspecialchars($section) ?></div>
                    <div class="label">Section</div>
                </div>
            </a>
        <?php endforeach; ?>
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