<?php
include '../../authentication.php';
include_once '../../connectivity.php';
    // Get form data
    $fullname = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $image = $_POST['image'];
    $department = $_POST['department'];
    $role = 'staff';
    $psau_email = $_POST['psau_email'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query using prepared statement
    $query = $conn->prepare("INSERT INTO users (full_name, username, password, image, department, psau_email, role) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $query->bind_param("sssssss", $fullname, $username, $hashed_password, $image, $department, $psau_email, $role);

    // Execute the query
    $query->execute();

    // Close the statement
    $query->close();

    // Redirect after insertion
    echo "<script>alert('New Agent Saved!'); window.location='index.php';</script>";
?>
