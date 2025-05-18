<?php
include 'db.php';

$edit_id = null;
$edit_section_code = '';

// Handle edit request
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT section_code FROM sections WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $stmt->bind_result($edit_section_code);
    $stmt->fetch();
    $stmt->close();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM sections WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: try.php");
    exit();
}

// Handle create/update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_code = trim($_POST['section_code']);
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

    if (!empty($section_code)) {
        if ($id) {
            // Update
            $stmt = $conn->prepare("UPDATE sections SET section_code = ? WHERE id = ?");
            $stmt->bind_param("si", $section_code, $id);
            $stmt->execute();
            $stmt->close();
        } else {
            // Check for duplicates
            $check = $conn->prepare("SELECT id FROM sections WHERE section_code = ?");
            $check->bind_param("s", $section_code);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                echo "<p style='color: red;'>Section already exists!</p>";
            } else {
                $stmt = $conn->prepare("INSERT INTO sections (section_code) VALUES (?)");
                $stmt->bind_param("s", $section_code);
                $stmt->execute();
                $stmt->close();
            }

            $check->close();
        }

        header("Location: try.php");
        exit();
    }
}

// Get all sections
$sections = [];
$result = $conn->query("SELECT id, section_code FROM sections ORDER BY section_code ASC");
while ($row = $result->fetch_assoc()) {
    $sections[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections - CRUD Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width:50%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .form-container {
            margin-bottom: 30px;
        }

        input[type="text"] {
            padding: 10px;
            width: 200px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            margin-left: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a.button {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
        }

        .edit-btn {
            background-color: #ffc107;
        }

        .delete-btn {
            background-color: #dc3545;
        }
        .actions {
    display: inline-block;
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.2s ease-in-out;
}

tr:hover .actions {
    visibility: visible;
    opacity: 1;
}
    </style>
</head>
<body>

<h1>Manage Sections</h1>

<div class="form-container">
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($edit_id) ?>">
        <input type="text" name="section_code" placeholder="Enter Section (e.g., 2218)" value="<?= htmlspecialchars($edit_section_code) ?>" required>
        <input type="submit" value="<?= $edit_id ? 'Update' : 'Add' ?> Section">
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Section Code</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($sections) > 0): ?>
            <?php foreach ($sections as $section): ?>
                <tr>
                    <td><?= htmlspecialchars($section['id']) ?></td>
                    <td><?= htmlspecialchars($section['section_code']) ?></td>
<td>
    <div class="actions">
        <a href="try.php?edit=<?= $section['id'] ?>" class="button edit-btn">Edit</a>
        <a href="try.php?delete=<?= $section['id'] ?>" class="button delete-btn" onclick="return confirm('Delete this section?')">Delete</a>
    </div>
</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No sections found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
