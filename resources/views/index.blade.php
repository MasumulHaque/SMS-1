<?php
include 'db.php';
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

// List of resources (students)
$sqlList = "SELECT * FROM students";
$resultList = $conn->query($sqlList);

// Show individual resource (student)
if (isset($_GET['id'])) {
    $id = sanitizeInput($_GET['id']);
    $sqlShow = "SELECT * FROM students WHERE id = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sqlShow);
    $stmt->bind_param("i", $id); // "i" indicates integer type for the parameter
    $stmt->execute();
    $resultShow = $stmt->get_result();
    
    if ($resultShow->num_rows > 0) {
        $row = $resultShow->fetch_assoc();
        // Display student details
    } else {
        echo "Student not found.";
    }
    exit(); // Stop further execution
}

// Create new resource (student)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    // Sanitize input data
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);

    // SQL query to insert a new student record
    $sqlInsert = "INSERT INTO students (name, email, phone) VALUES (?, ?, ?)";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sqlInsert);
    
    // Bind parameters and execute the statement
    $stmt->bind_param("sss", $name, $email, $phone); // "sss" indicates three string parameters
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Success message
        echo "Student created successfully.";
    } else {
        // Error message
        echo "Error: Unable to create student.";
    }

    // Close the statement
    $stmt->close();
}


// Edit existing resource (student)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = sanitizeInput($_POST['id']);
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);

    $sqlEdit = "UPDATE students SET name='$name', email='$email', phone='$phone' WHERE id=$id";
    if ($conn->query($sqlEdit) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating student: " . $conn->error;
    }
}

// Delete resource (student)
if (isset($_GET['delete'])) {
    $id = sanitizeInput($_GET['delete']);
    $sqlDelete = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting student: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="heder1">Student Management System</h1>
    <h2>List of Students</h2>
    <?php
    if ($resultList->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>";

        while ($row = $resultList->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td><a href='view.php?id={$row['id']}'>View</a> | <a href='edit.php?id={$row['id']}'>Edit</a> | <a href='index.php?delete={$row['id']}'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No students found.";
    }
    ?>
    <h2>Create New Student</h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    @csrf <!-- CSRF protection -->
    <label for="name">Name:</label>
    <input type="text" name="name" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" required><br>

    <input type="submit" name="create" value="Create">
</form>

</body>
</html>

<?php
$conn->close();
?>
