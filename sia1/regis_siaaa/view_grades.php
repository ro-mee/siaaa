<?php
// Start output buffering to hide messages
ob_start();
require_once 'config.php';

// Get student data
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    
    // Get selected semester (default to 1st if not set)
    $semester = isset($_GET['semester']) ? $_GET['semester'] : '1st';
    
    // Get student info
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
    
    // Get student grades for selected semester
    $sql = "SELECT * FROM grades WHERE student_id = ? AND semester = ? ORDER BY subject ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $student_id, $semester);
    $stmt->execute();
    $grades = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Clear any previous output
ob_end_clean();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Grades</title>
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
            padding: 30px;
            color: white;
        }
        .student-header {
            background: white;
            color: #333;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .student-header h2 {
            margin: 0 0 15px 0;
            color: #2196F3;
            font-size: 1.8rem;
        }
        .student-header p {
            margin: 8px 0;
            font-size: 1.1rem;
            color: #555;
        }
        .grades-section {
            background: white;
            color: black;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .grades-section h3 {
            margin: 0 0 20px 0;
            color: #2196F3;
            font-size: 1.5rem;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }
        .grades-table th {
            background: #2196F3;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 1rem;
        }
        .grades-table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            font-size: 1rem;
        }
        .grades-table tr:last-child td {
            border-bottom: none;
        }
        .grades-table tr:hover {
            background-color: #f8f9fa;
        }
        .grade-value {
            font-weight: 600;
            color: #333;
        }
        .passed {
            color: #28a745;
            font-weight: bold;
            padding: 6px 12px;
            background: #d4edda;
            border-radius: 6px;
            display: inline-block;
            font-size: 0.9rem;
        }
        .failed {
            color: #dc3545;
            font-weight: bold;
            padding: 6px 12px;
            background: #f8d7da;
            border-radius: 6px;
            display: inline-block;
            font-size: 0.9rem;
        }
        .edit-btn {
            display: inline-block;
            background: #2196F3;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }
        .edit-btn:hover {
            background: #1976D2;
        }
        .print-btn {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        .print-btn:hover {
            background: #218838;
        }
        .semester-select {
            padding: 10px 20px;
            font-size: 1rem;
            border: 2px solid #2196F3;
            border-radius: 6px;
            background: white;
            color: #2196F3;
            cursor: pointer;
            margin-top: 15px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .semester-select:hover {
            background: #2196F3;
            color: white;
        }
        .semester-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.3);
        }
        .semester-select option {
            padding: 10px;
            font-size: 1rem;
        }
        h3 {
            color: #2196F3;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 20px;
                background: white;
            }
            .main-content {
                background: white;
                color: black;
                padding: 0;
            }
            .grades-table th {
                background: #f8f9fa !important;
                color: #333 !important;
                border: 1px solid #dee2e6;
            }
            .grades-table td {
                border: 1px solid #dee2e6;
            }
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
        <?php if (isset($student)): ?>
            <h1>Student Grades</h1>
            
            <div class="student-header">
                <h2>Student Information</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
                <p><strong>Section:</strong> <?php echo htmlspecialchars($student['section']); ?></p>
                
                <div class="no-print">
                    <select class="semester-select" onchange="changeSemester(this.value)">
                        <option value="1st" <?php echo $semester === '1st' ? 'selected' : ''; ?>>1st Semester</option>
                        <option value="2nd" <?php echo $semester === '2nd' ? 'selected' : ''; ?>>2nd Semester</option>
                    </select>
                </div>
            </div>
            
            <div class="grades-section">
                <h3>Grades - <?php echo htmlspecialchars($semester); ?> Semester</h3>
                <?php if (!empty($grades)): ?>
                    <table class="grades-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Prelim</th>
                                <th>Midterm</th>
                                <th>Finals</th>
                                <th>Total</th>
                                <th>Remarks</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($grades as $grade): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($grade['subject']); ?></td>
                                    <td class="grade-value"><?php echo number_format($grade['prelim'], 2); ?></td>
                                    <td class="grade-value"><?php echo number_format($grade['midterm'], 2); ?></td>
                                    <td class="grade-value"><?php echo number_format($grade['finals'], 2); ?></td>
                                    <td class="grade-value">
                                        <?php 
                                            $total = ($grade['prelim'] + $grade['midterm'] + $grade['finals']) / 3;
                                            echo number_format($total, 2);
                                        ?>
                                    </td>
                                    <td>
                                        <span class="<?php echo strtolower($grade['remarks']); ?>">
                                            <?php echo $grade['remarks']; ?>
                                        </span>
                                    </td>
                                    <td class="no-print">
                                        <a href="edit-grades.php?id=<?php echo $student_id; ?>&subject=<?php echo urlencode($grade['subject']); ?>&semester=<?php echo urlencode($semester); ?>" 
                                           class="edit-btn">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No grades found for this semester.</p>
                <?php endif; ?>
                
                <div class="no-print">
                    <button onclick="window.print()" class="print-btn">
                        Print Grades 🖨️
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="student-header">
                <h2>Error</h2>
                <p>No student selected. Please return to the student list and select a student.</p>
                <button class="edit-btn" onclick="window.location.href='print.php'">
                    Return to Student List
                </button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        });

        function changeSemester(semester) {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('semester', semester);
            window.location.href = currentUrl.toString();
        }
    </script>
</body>
</html> 