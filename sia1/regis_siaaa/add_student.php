<?php
require_once 'config.php';

// Define subjects arrays at the top level for use in both POST handling and form display
$first_sem_subjects = array(
    'Information Management (CCS2205)',
    'Web Development (WEB 2)',
    'System Integration and Architecture (CCS2111)',
    'Software Engineering (SE)',
    'Object Oriented Programming (OOP)'
);

$second_sem_subjects = array(
    'Mobile Application Development (MAD)',
    'Database Management Systems (DBMS)',
    'Network Administration (NET)',
    'Cybersecurity Fundamentals (CSF)',
    'Cloud Computing (CC)'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get student data
    $name = $_POST['name'];
    $section = $_POST['section'];
    
    // Insert student
    $sql = "INSERT INTO students (name, section) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $section);
    
    if ($stmt->execute()) {
        $student_id = $stmt->insert_id;
        
        // Process first semester grades
        foreach ($first_sem_subjects as $subject) {
            $prelim = isset($_POST['prelim'][$subject]) ? $_POST['prelim'][$subject] : 0;
            $midterm = isset($_POST['midterm'][$subject]) ? $_POST['midterm'][$subject] : 0;
            $finals = isset($_POST['finals'][$subject]) ? $_POST['finals'][$subject] : 0;
            
            // Calculate average and remarks
            $average = ($prelim + $midterm + $finals) / 3;
            $remarks = ($average >= 75) ? 'PASSED' : 'FAILED';
            
            $sql = "INSERT INTO grades (student_id, subject, semester, prelim, midterm, finals, remarks) 
                   VALUES (?, ?, '1st', ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isddds", $student_id, $subject, $prelim, $midterm, $finals, $remarks);
            $stmt->execute();
        }
        
        // Process second semester grades
        foreach ($second_sem_subjects as $subject) {
            $prelim = isset($_POST['prelim'][$subject]) ? $_POST['prelim'][$subject] : 0;
            $midterm = isset($_POST['midterm'][$subject]) ? $_POST['midterm'][$subject] : 0;
            $finals = isset($_POST['finals'][$subject]) ? $_POST['finals'][$subject] : 0;
            
            // Calculate average and remarks
            $average = ($prelim + $midterm + $finals) / 3;
            $remarks = ($average >= 75) ? 'PASSED' : 'FAILED';
            
            $sql = "INSERT INTO grades (student_id, subject, semester, prelim, midterm, finals, remarks) 
                   VALUES (?, ?, '2nd', ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isddds", $student_id, $subject, $prelim, $midterm, $finals, $remarks);
            $stmt->execute();
        }
        
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            background: #f0f2f5;
        }
        .main-content {
            flex: 1;
            background-color: #2196F3;
            padding: 20px;
            color: white;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .semester-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 25px 0;
        }
        .semester-title {
            color: #1976D2;
            margin: 0 0 20px 0;
            padding-bottom: 12px;
            border-bottom: 2px solid #2196F3;
            font-size: 1.4rem;
            font-weight: 600;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .grades-table th {
            background: #1976D2;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        .grades-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            color: #333;
        }
        .grades-table td:first-child {
            font-weight: 500;
            color: #1976D2;
            width: 40%;
        }
        .grades-table tr:hover {
            background-color: #f5f5f5;
        }
        .grades-table input[type="number"] {
            width: 80px;
            padding: 8px;
            border: 1px solid #bdbdbd;
            border-radius: 4px;
            text-align: center;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }
        .grades-table input[type="number"]:focus {
            border-color: #2196F3;
            outline: none;
            box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.1);
        }
        .student-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .save-btn {
            background: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
        }
        .save-btn:hover {
            background: #1976D2;
        }
        h2 {
            color: white;
            margin: 0 0 20px 0;
            font-size: 1.8rem;
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

    <div class="main-content">
        <h2>Add New Student</h2>
        
        <div class="form-container">
            <form method="POST">
                <div class="student-info">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" required placeholder="Enter student name">
                    </div>
                    <div class="form-group">
                        <label>Section:</label>
                        <input type="text" name="section" required placeholder="Enter section">
                    </div>
                </div>
            
                <!-- First Semester -->
                <div class="semester-section">
                    <h3 class="semester-title">First Semester</h3>
                    <table class="grades-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Prelim</th>
                                <th>Midterm</th>
                                <th>Finals</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($first_sem_subjects as $subject): ?>
                            <tr>
                                <td><?php echo $subject; ?></td>
                                <td><input type="number" step="0.01" min="0" max="100" name="prelim[<?php echo $subject; ?>]" value="0"></td>
                                <td><input type="number" step="0.01" min="0" max="100" name="midterm[<?php echo $subject; ?>]" value="0"></td>
                                <td><input type="number" step="0.01" min="0" max="100" name="finals[<?php echo $subject; ?>]" value="0"></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Second Semester -->
                <div class="semester-section">
                    <h3 class="semester-title">Second Semester</h3>
                    <table class="grades-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Prelim</th>
                                <th>Midterm</th>
                                <th>Finals</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($second_sem_subjects as $subject): ?>
                            <tr>
                                <td><?php echo $subject; ?></td>
                                <td><input type="number" step="0.01" min="0" max="100" name="prelim[<?php echo $subject; ?>]" value="0"></td>
                                <td><input type="number" step="0.01" min="0" max="100" name="midterm[<?php echo $subject; ?>]" value="0"></td>
                                <td><input type="number" step="0.01" min="0" max="100" name="finals[<?php echo $subject; ?>]" value="0"></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <button type="submit" class="save-btn">Add Student</button>
            </form>
        </div>
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