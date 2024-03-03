<?php
require_once "db.php"; // Include your database connection file

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

// Handle form submission to update student details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Update student details in the database
    $sqlUpdate = "UPDATE students SET name='$name', email='$email', phone='$phone' WHERE id=$id";
    
    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Student details updated successfully!";
    } else {
        echo "Error updating student details: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="heder1">Student Management System</h1>
    <h2>Edit Student</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id"; ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo $phone; ?>" required><br>

        <input type="submit" name="update" value="Update">
        <a class="input" href="index.php">Back</a>
    </form>

</body>
</html>
