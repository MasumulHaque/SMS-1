<?php
// Include your database connection file (e.g., db.php)
require_once "db.php";

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student details from the database based on the provided 'id'
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
    } else {
        echo "Student not found.";
        exit();
    }
} else {
    echo "Invalid request. Please provide a student ID.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="view.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="heder1">Student Management System</h1>
    <div class="container">
        <h2>Student Details</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $id; ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo $name; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo $phone; ?></td>
            </tr>
        </table>
        <p ><a class="input" href="index.php">Back to List</a></p>
    </div>
</body>
</html>
