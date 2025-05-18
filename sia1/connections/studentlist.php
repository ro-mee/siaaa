<?php
include 'db.php';

$sql = "SELECT * FROM students"; // replace 'students' with your table name
$result = $conn->query($sql);


$section_code = isset($_GET['section']) ? trim($_GET['section']) : '';

if (empty($section_code)) {
    die("No section specified.");
}

// Handle form submission to add a student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_name'])) {
    $student_name = trim($_POST['student_name']);
    if (!empty($student_name)) {
        $stmt = $conn->prepare("INSERT INTO students (student_name, section_code) VALUES (?, ?)");
        $stmt->bind_param("ss", $student_name, $section_code);
        $stmt->execute();
        $stmt->close();

        // Redirect to avoid resubmission
        header("Location: students.php?section=" . urlencode($section_code));
        exit();
    }
}

// Get students in this section
$stmt = $conn->prepare("SELECT student_id, fname, email, contact, admission, birthday FROM students WHERE section_code = ?");
$stmt->bind_param("s", $section_code);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students in Section <?= htmlspecialchars($section_code) ?></title>
          <link rel="stylesheet" href="format.css">
    <link rel="Stylesheet" href="css/all.min.css">
  <link rel="Stylesheet" href="css/fontawesome.min.css">
    <style>
        h1 {
            color: #333;
        }

        .student-form {
            margin-bottom: 20px;
        }

        .student-form input[type="text"] {
            padding: 8px;
            font-size: 16px;
            width: 250px;
        }

        .student-form input[type="submit"] {
            padding: 8px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            margin-left: 10px;
        }

        .student-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

table {
    border-collapse: collapse;
    width: 100%;
    table-layout: auto;
    word-wrap: break-word;
}

        th, td {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a.back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        a.back-link:hover {
            text-decoration: underline;
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
      <a href=""><span><i class="fa-regular fa-user"></i></span> Students</a>
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
    <h1>Section <?= htmlspecialchars($section_code) ?></h1>

    <div class="student-form">
        <a href="add students.php"><input type="submit" value="Add Student"></a>
    </div>

    <?php if (count($students) === 0): ?>
        <p>No students found in this section.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Status</th>
                    <th>Birthday</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $students): ?>
                    <tr>
                        <td><?= htmlspecialchars($students['student_id']) ?></td>
                        <td><?= htmlspecialchars($students['fname']) ?></td>
                        <td><?= htmlspecialchars($students['email']) ?></td>
                        <td><?= htmlspecialchars($students['contact']) ?></td>
                        <td><?= htmlspecialchars($students['admission']) ?></td>
                        <td><?= htmlspecialchars($students['birthday']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="try.php" class="back-link">← Back to Sections</a>
</div>
</div>
</div>

    
</body>
</html>
