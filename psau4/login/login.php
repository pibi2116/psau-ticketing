<?php
session_start();
include_once '../connectivity.php';


// Define the validateCredentials function
function validateCredentials($username, $password, $role) {
    global $conn;

    // Prepare the SQL query
    $sql = "SELECT id, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password']) && $row['role'] === $role) {
            // Password is correct and role matches, return user ID and role
            return array('id' => $row['id'], 'role' => $role);
        }
    }

    // Either user doesn't exist, password is incorrect, or role doesn't match
    return false;
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["userType"];

    // Validate credentials
    $userData = validateCredentials($username, $password, $role);
    if ($userData) {
        // Set username, userType, and userID in session
        $_SESSION["username"] = $username;
        $_SESSION["userType"] = $userData['role'];
        $_SESSION["id"] = $userData['id'];

        // Redirect users based on their access level
        switch ($userData['role']) {
            case "customer":
                // Redirect customer to customer-specific page
                header("Location: http://localhost/psau4/customer/index.php");
                break;
            case "staff":
                // Redirect staff to staff-specific page
                header("Location: http://localhost/psau4/staff/index.php");
                break;
            case "admin":
                // Redirect admin to admin-specific page
                header("Location: http://localhost/psau4/admin/index.php");
                break;
        }
        
        exit(); // Make sure to exit after redirection
    } else {
        // Show error message and redirect to login page
        echo '<script>alert("Invalid username, password, or role"); 
        window.location.href = "http://localhost/psau4/index.php";</script>';
    }
}

?>
