<?php
    include '../../authentication.php';
    include '../../connectivity.php';

    // Get form data
    $fullname = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $image = $_POST['image'];
    $psauemail = $_POST['psau_email'];
    $role = "admin";

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query using prepared statement
    $query = $conn->prepare("INSERT INTO users (full_name, username, password, image, psau_email, role) 
                             VALUES (?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $query->bind_param("ssssss", $fullname, $username, $hashed_password, $image, $psauemail, $role);

    // Execute the query
    $query->execute();

    // Close the statement
    $query->close();

    // Redirect after insertion
    echo "<script>alert('New Admin Saved!'); window.location='index.php';</script>";
?>
