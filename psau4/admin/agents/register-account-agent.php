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
    $department = $_POST['department'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href = 'http://localhost/psau4/admin/agents/create-agent.php';</script>";
        exit(); // Exit to prevent further execution
    } else {
        // Hash the password for security
        // Prepare SQL statement to insert data into the staff table using prepared statements
        $sql = "INSERT INTO staff (username, password, full_name, psau_email, department) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $hashed_password, $full_name, $psau_email, $department);

        // Execute the statement
        if ($stmt->execute()) {
            // Prompt user
            echo "<script>alert('Account created successfully.'); window.location.href = 'http://localhost/psau4/admin/agents/index.php';</script>";
            exit(); // Make sure to exit after redirect
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
}

$conn->close();
?>
