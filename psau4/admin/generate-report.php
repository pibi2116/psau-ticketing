<?php
session_start();
include_once '../connectivity.php';

// Retrieve total tickets count
$q_total_tickets = "SELECT COUNT(*) AS total_tickets FROM tickets";
$r_total_tickets = $conn->query($q_total_tickets);
$row_total_tickets = $r_total_tickets->fetch_assoc();

// Retrieve total customers count
$q_total_customers = "SELECT COUNT(*) AS total_customers FROM users where role='customer'";
$r_total_customers = $conn->query($q_total_customers);
$row_total_customers = $r_total_customers->fetch_assoc();

// Retrieve total agents count
$q_total_agents = "SELECT COUNT(*) AS total_agents FROM users where role='staff'";
$r_total_agents = $conn->query($q_total_agents);
$row_total_agents = $r_total_agents->fetch_assoc();

// Retrieve resolved tickets count
$q_resolved_tickets = "SELECT COUNT(*) AS resolved_tickets FROM tickets where status='Resolved'";
$r_resolved_tickets = $conn->query($q_resolved_tickets);
$row_resolved_tickets = $r_resolved_tickets->fetch_assoc();


// Retrieve full name from database based on username
$username = $_SESSION["username"];
$sql = "SELECT id, full_name FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['id'];
    $full_name = $row['full_name'];
} else {
    // Handle error if user not found in database
    $user_id = null;
    $full_name = "Unknown";
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Report</title>
</head>

<style>
    body, html {
        height: 100%;
        margin-bottom: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: #a89c8c;
        color: ;
    }
    h5, h1{
        text-align: center;
    }
    .main-container {
        /* text-align: center; */
        font-size: 25px;
        border: 3px solid #0A5419;
        padding: 40px;
    }
    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    li {
        margin: 10px 0;
    }
    h5{
        font-size:40px;
        margin: 10px 0;
    }
    hr {
        background-color: #000;
        height:2px;
        width: 100%;
        border: none;
    }

    .second-container{
        /* background-color: grey; */
    }

    .button-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .button-container button {
        margin: 0 10px;
        padding: 10px 20px;
        font-size: 18px;
        cursor: pointer;
        background-color: #0A5419;
        color: white;
        border: none;
        border-radius: 5px;
        width: 150px;
    }
</style>

<body>
    <h1>Summary Report for PSAU Ticketing Management System</h1>
    <br><br><br>
    <div class="main-container">
        <h5>Total Resolved Tickets</h5>
        <h1><?php echo $row_resolved_tickets['resolved_tickets'];?></h1>
        <hr>
        <div class="second-container">
            <ul>
                <li>Name: <?php echo $full_name?></li>
                <li>Number of tickets created: <?php echo $row_total_tickets['total_tickets'];?></li>
                <li>Total customers: <?php echo $row_total_customers['total_customers'];?></li>
                <li>Total agents: <?php echo $row_total_agents['total_agents'];?></li>
            </ul>
            <div class="button-container">
                <button onclick="location.href='index.php';">Go back</button>
                <button onclick="location.href='';">Print</button>
            </div>
        </div>
    </div>
</body>
</html>