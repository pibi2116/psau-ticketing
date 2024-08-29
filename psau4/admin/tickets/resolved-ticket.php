<?php
    include '../../authentication.php';
    include '../../connectivity.php';
    $ticketID = $_GET['id'];

    // Update ticket status query
    $updateStatusQuery = "UPDATE tickets SET status = 'Resolved' WHERE ticketID = ?";
    
    // Prepare and execute the update query
    $stmt = $conn->prepare($updateStatusQuery);
    $stmt->bind_param("i", $ticketID);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same ticket ID page
    echo "<script>window.location.href = 'http://localhost/psau4/admin/tickets/index.php?id=$ticketID';</script>";
    exit();
?>
