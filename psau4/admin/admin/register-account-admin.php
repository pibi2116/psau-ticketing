<?php
include '../../authentication.php';
include_once '../../connectivity.php';


// Process form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $psau_email = $_POST['psau_email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href = 'http://localhost/psau4/admin/admin/create-admin.php';</script>";
        exit(); // Exit to prevent further execution
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Set role to "admin"
        $role = "admin";

        // Prepare SQL statement to insert data into the database using prepared statements
        $sql = "INSERT INTO users (username, password, full_name, psau_email, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters to the statement
        $stmt->bind_param("sssss", $username, $hashed_password, $full_name, $psau_email, $role);

        // Execute the statement
        if ($stmt->execute()) {
            // Prompt user
            echo "<script>alert('Account created successfully.'); window.location.href = 'http://localhost/psau4/admin/admin/index.php';</script>";
            exit(); // Make sure to exit after redirect
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
}

$conn->close();
?>
