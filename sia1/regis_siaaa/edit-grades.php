<?php
require_once 'config.php';

// Get student and grade information
if (isset($_GET['id']) && isset($_GET['subject'])) {
    $student_id = $_GET['id'];
    $subject = $_GET['subject'];
    $semester = $_GET['semester'] ?? '1st';  // Get semester from URL
    
    // Get current grades
    $sql = "SELECT * FROM grades WHERE student_id = ? AND subject = ? AND semester = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $student_id, $subject, $semester);
    $stmt->execute();
    $grade = $stmt->get_result()->fetch_assoc();
    
    // Get student info
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $semester = $_POST['semester'];
    $prelim = $_POST['prelim'];
    $midterm = $_POST['midterm'];
    $finals = $_POST['finals'];
    
    // Calculate if passed or failed (assuming passing grade is 75)
    $average = ($prelim + $midterm + $finals) / 3;
    $remarks = $average >= 75 ? 'PASSED' : 'FAILED';
    
    // Update grades
    $sql = "UPDATE grades SET prelim = ?, midterm = ?, finals = ?, remarks = ? WHERE student_id = ? AND subject = ? AND semester = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dddssss", $prelim, $midterm, $finals, $remarks, $student_id, $subject, $semester);
    $stmt->execute();
    
    // Redirect back to view grades
    header("Location: view_grades.php?id=" . $student_id . "&semester=" . $semester);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Grades</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .content {
            flex: 1;
            padding: 40px;
            background: #f5f5f5;
        }
        h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }
        .student-info {
            font-size: 1.2rem;
            margin-bottom: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .grade-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        .grade-item {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .actions {
            margin-top: 20px;
        }
        .save-btn {
            background: #2196f3;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
        }
        .save-btn:hover {
            background: #1976d2;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 1rem;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .passed {
            color: #28a745;
            font-weight: bold;
            padding: 5px 10px;
            background: #d4edda;
            border-radius: 4px;
            display: inline-block;
        }
        .failed {
            color: #dc3545;
            font-weight: bold;
            padding: 5px 10px;
            background: #f8d7da;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="bcplogo.png" alt="School Logo" class="logo" />
        <p class="email">registrar123@gmail.com</p>
        <button class="nav-btn" onclick="window.location.href='index.php'">
            ← Back to Student List
            <img src="gradcap.png" alt="Graduation Cap" />
        </button>
        <button class="logout-btn">Log out</button>
    </div>

    <div class="content">
        <?php if (isset($student) && isset($grade)): ?>
            <h1>Edit Grades</h1>
            
            <div class="edit-form">
                <h2>Student: <?php echo htmlspecialchars($student['name']); ?></h2>
                <h3>Subject: <?php echo htmlspecialchars($subject); ?></h3>
                <h3>Semester: <?php echo htmlspecialchars($semester); ?></h3>
                
                <form method="POST">
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                    <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                    <input type="hidden" name="semester" value="<?php echo $semester; ?>">
                    
                    <div class="form-group">
                        <label>Prelim:</label>
                        <input type="number" step="0.01" name="prelim" value="<?php echo $grade['prelim']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Midterm:</label>
                        <input type="number" step="0.01" name="midterm" value="<?php echo $grade['midterm']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Finals:</label>
                        <input type="number" step="0.01" name="finals" value="<?php echo $grade['finals']; ?>" required>
                    </div>
                    
                    <button type="submit" class="save-btn">Save Changes</button>
                    <a href="view_grades.php?id=<?php echo $student_id; ?>&semester=<?php echo $semester; ?>" class="cancel-btn">Cancel</a>
                </form>
            </div>
        <?php else: ?>
            <p>Invalid student or subject selected.</p>
        <?php endif; ?>
    </div>

    <script>
        // Add input validation
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function() {
                let value = parseFloat(this.value);
                if (value > 100) this.value = 100;
                if (value < 0) this.value = 0;
            });
        });

        // Logout functionality
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        });
    </script>
</body>
</html> 