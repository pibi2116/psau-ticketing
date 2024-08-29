<?php
    include '../authentication.php';
    include '../connectivity.php';
    $ticketID = $_POST['ticketID'];
    $senderID = $_POST['senderID'];
    $message = $_POST['message'];

    // Check if a file was uploaded
    if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded file
        $attachment = $_FILES['attachment']['name'];
        $attachment_temp = $_FILES['attachment']['tmp_name'];
        // Move the uploaded file to a permanent location
        move_uploaded_file($attachment_temp, "../img/" . $attachment);
    } else {
        $attachment = ""; // If no file was uploaded, set attachment to an empty string
    }

    $query = "INSERT INTO ticketcommunication (
                    senderID,
                    ticketID,
                    message,
                    attachment
                )
                VALUES (
                    '$senderID',
                    '$ticketID',
                    '$message',
                    '$attachment'
                )";
    $result = $conn->query($query);
    $updateStatusQuery = "UPDATE tickets SET status = 'In Progress' WHERE ticketID = ?";
    $stmt = $conn->prepare($updateStatusQuery);
    $stmt->bind_param("i", $ticketID);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same ticket ID page
    echo "<script>window.location.href = 'http://localhost/psau4/staff/open-ticket.php?id=$ticketID';</script>";
    exit();
?>
