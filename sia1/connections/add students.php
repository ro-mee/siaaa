<?php
include 'db.php';

$fname = "";
$student_id = "";
$contact = "";
$email = "";
$admission = "";
$section = "";
$course = "";
$birthday = "";

$errorMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
$fname = $_POST['fname'];
$student_id = $_POST['student_id'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$admission = $_POST['admission'];
$section = $_POST['section'];
$course = $_POST['course'];
$birthday = $_POST['birthday'];

do {
    if (empty($fname) || empty($student_id) || empty($contact) ||empty($email) || empty($admission) ||
    empty($section) || empty($course) || empty($birthday) ) {
        $errorMessage = "All the fields are required"
        break;
    }

} while(false);


}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="format.css">
    <link rel="Stylesheet" href="css/all.min.css">
  <link rel="Stylesheet" href="css/fontawesome.min.css">
    <style>
        /* General form styles */
        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 500px;
            margin: 50px;
        }

        /* Title styles */
        .form-title {
            font-size: 24px;
            color: rgb(20, 63, 125);
            margin-bottom: 20px;
            text-align: center;
        }

        /* Input field styles */
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Label styles */
        .label {
            font-size: 14px;
            color: #333;
            display: flex;
            margin-bottom: 5px;
        }

        /* Button styles */
        .button {
            background-color:rgb(20, 63, 125);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        .button:hover {
            background-color: #073d8a;
        }
        .flex-row {
    display: flex;
    gap: 10px; /* space between inputs */
}

.flex-row .input-group {
    flex: 1; /* make each input take equal width */
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
      <a href="#"><span><i class="fa-solid fa-house"></i></span> Dashboard</a>
    </div>
    <div class="nav-item active">
      <a href="add students.php"><span><i class="fa-regular fa-user"></i></span> Students</a>
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

    </div>
    <div class="form-container">
        <h2 class="form-title">Add Student</h2>
<?php if (!empty($errorMessage)): ?>
    <div class="custom-alert">
        <?= htmlspecialchars($errorMessage) ?>
        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
<?php endif; ?>

        <form action="" method="POST">
            <div>
                <label class="label">Full Name</label>
                <input type="text" name="name" class="input-field">
            </div>
<div class="flex-row">
    <div class="input-group">
        <label class="label">Section</label>
        <input type="text" name="section" class="input-field">
    </div>
<div class ="input-group">
    <label class="label">Course</label>
    <select name="Year Level" class="input-field">
        <option value="" disabled selected>Select Year Level</option>
        <option value="BSIT">1st Year College</option>
        <option value="BSCE">2nd Year College</option>
        <option value="BSCS">3rd Year College</option>
        <option value="BSIS">4th Year College</option>
    </select>
</div>
</div>
<div>
    <label class="label">Course</label>
    <select name="course" class="input-field">
        <option value="" disabled selected>Select Course</option>
        <option value="BSIT">Bachelor of Science in Information Technology</option>
        <option value="BSCE">Bachelor of Science in Computer Engineering</option>
        <option value="BSCS">Bachelor of Science in Computer Science</option>
        <option value="BSIS">Bachelor of Science in Information Systems</option>
    </select>
</div>
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" class="input-field">
            </div>
<div class="flex-row">
    <div class="input-group">
        <label class="label">Birthday</label>
        <input type="date" name="Birthday" class="input-field">
    </div>
<div class ="input-group">
    <label class="label">Contact No.</label>
    <input type="text" name ="Contact" class="input-field">
</div>
</div>
            <div>
                <input type="submit" name="add_student" value="Add Student" class="button">
            </div>
        </form>
    </div>
</body>
</html>
    