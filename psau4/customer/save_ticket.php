<?php
    include '../authentication.php';
    include '../connectivity.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];

    // Check if a file was uploaded
    if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded file
        $attachment = $_FILES['attachment']['name'];
        $attachment_temp = $_FILES['attachment']['tmp_name'];
        // Move the uploaded file to a permanent location
        $target_dir = "../img/";
        $target_file = $target_dir . basename($attachment);
        if (move_uploaded_file($attachment_temp, $target_file)) {
            error_log("File uploaded successfully: " . $target_file);
        } else {
            error_log("Error uploading file: " . $target_file);
        }
    } else {
        $attachment = ""; // If no file was uploaded, set attachment to an empty string
    }

    // Retrieve username and user type from session
    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];
    // Check if $_SESSION["id"] is set
    if(isset($_SESSION["id"])) {
        $userID = $_SESSION["id"];

        // Determine the type of user who created the ticket
        // In this case, $userID will be used as the creator ID
        $creatorID = $userID;
    } else {
        // Handle error if $_SESSION["id"] is not set
        $error_message = "Error: User ID not set in session";
        error_log($error_message);
        echo "<script>alert('$error_message'); window.location.href = 'index.php';</script>";
        exit(); // Terminate script
    }

    // Retrieve assigneeID from the staff table based on the category
    $sql_assignee = "SELECT id FROM users WHERE department = ?";
    $stmt_assignee = $conn->prepare($sql_assignee);
    $stmt_assignee->bind_param("s", $category);
    $stmt_assignee->execute();
    $result_assignee = $stmt_assignee->get_result();

    // Check if staff member found in the department
    if ($result_assignee->num_rows > 0) {
        $row_assignee = $result_assignee->fetch_assoc();
        $assigneeID = $row_assignee['id'];
    } else {
        // Handle error if no staff member found in the department
        $error_message = "Error: No staff member found in the department";
        error_log($error_message);
        echo "<script>alert('$error_message'); window.location.href = 'index.php';</script>";
        exit(); // Terminate script
    }

    // Close statement
    $stmt_assignee->close();

    // Prepare SQL statement to insert ticket into the database
    $sql_insert = "INSERT INTO tickets (title, category, priority, description, attachment, creatorID, assigneeID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssssssi", $title, $category, $priority, $description, $attachment, $creatorID, $assigneeID); // Change 's' to 'i' for attachment
    
    // Execute the statement
    if ($stmt_insert->execute()) {
        echo "<script>alert('Ticket submitted successfully!'); window.location.href = 'http://localhost/psau4/customer/ticket-view.php';</script>";
    } else {
        $error_message = "Error executing SQL statement: " . $sql_insert . " - Error: " . $conn->error;
        error_log($error_message);
        echo "<script>alert('$error_message'); window.location.href = 'http://localhost/psau4/customer/create-ticket.php';</script>";
    }
    
    // Close statement
    $stmt_insert->close();
    

}

// Close database connection
$conn->close();
?>
