<?php
require_once 'config.php';

// Get all students
$sql = "SELECT * FROM students ORDER BY name";
$result = $conn->query($sql);
$students = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Print Grades - Registrar Portal</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        .header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .header img {
            width: 32px;
            height: 32px;
        }
        .student-list {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .student-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }
        .student-row:hover {
            background-color: #f5f5f5;
        }
        .student-row:last-child {
            border-bottom: none;
        }
        .student-info {
            display: flex;
            flex-direction: column;
        }
        .student-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }
        .student-section {
            font-size: 0.9em;
            color: #666;
        }
        .select-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .select-btn:hover {
            background-color: #1976D2;
        }
        .add-student-btn {
            display: inline-block;
            background: #28a745;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        .add-student-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="bcplogo.png" alt="School Logo" class="logo" />
        <p class="email">registrar123@gmail.com</p>
        <button class="nav-btn active">
            Students
            <img src="gradcap.png" alt="Graduation Cap" />
        </button>
        <a href="add_student.php" class="nav-btn">
            +Add Students
        </a>
        <button class="logout-btn">Log out</button>
    </div>

    <div class="main-content">
        <h1>Welcome, Maam/Sir</h1>
        <div class="students-section">
            <div class="header">
                <h2>Students</h2>
            </div>
            <div class="student-list">
                <?php if (count($students) > 0): ?>
                    <?php foreach ($students as $student): ?>
                        <div class="student-row">
                            <div class="student-info">
                                <span class="student-name"><?php echo htmlspecialchars($student['name']); ?></span>
                                <span class="student-section"><?php echo htmlspecialchars($student['section']); ?></span>
                            </div>
                            <button class="select-btn" onclick="window.location.href='view_grades.php?id=<?php echo $student['id']; ?>'">
                                View Grades
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No students found.</p>
                    <a href="add_student.php" class="add-student-btn">+Add Students</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        });
    </script>
</body>
</html> 