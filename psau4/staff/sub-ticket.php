<?php
    include '../authentication.php';
    include '../connectivity.php';
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

// Store user ID in session variable
$_SESSION['id'] = $user_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initialscale=1.0" />
      <title>PSAU - TICKET</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="../css/admin-ui.css" />
      <link rel="shortcut icon" href="../img/logo.png" type="image/xicon">   
      <style>
        .table-container {
            /* width: 80%;  */  
        height: 530px;
        overflow-x: hidden;
        margin-left: 15px ;
        margin-top: 20px;
        display: flex; /* Set display to flex */
        flex-direction: column;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: .2px solid gainsboro;
            text-align: left;
            padding: 8px;
        }

        th {
            background: #0A5419;
            color: white;
        }


        tbody tr:nth-child(even) {
            background-color: #4f5052;
        }

        tfoot {
            background-color: #4f5052;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="home-nav">
            <p>PSAU</p>
        </div>
        <ul>
        <p class="sub-title">General</p>
            <li class="dash"><a href="http://localhost/psau4/staff/index.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></li> 
            <li><a href="http://localhost/psau4/staff/ticket-view.php"><i class="fa-solid fa-boxes-stacked"></i>Tickets</a></li>
            <li><a href="http://localhost/psau4/staff/sub-ticket.php"><i class="fa-solid fa-boxes-stacked"></i>Submitted Tickets</a></li>
            <br />
        </ul>
    </div>
    <!-- End of Navigation Bar -->

    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <p>PSAU - Ticket Management System</p>
        </div>
        <div class="account-header">
    <!-- <a href="../logout.php"><button>Logout</button></a> -->
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
            <div class="button-container"><p class="fullname"><?php echo $full_name; ?></p>
            <span class="caret"></span></div>
        </button>
        <ul class="dropdown-menu">
            <li><a href="http://localhost/psau4/admin/manage_account/">My Account</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</div>

    </div>
    <!-- End of Header -->

    <!-- table -->
    <div class="content">

        <div class="content_design">a</div>
        <div class="conten_text">
            <h3>Ticket information</h3>
            <?php
                // echo "<a href='resolved-ticket.php?id=" . $_GET['id'] . "'><button >Mark as Resolved</button></a>";
            ?>
            <a href="create-ticket.php"><button ><i class="bi bi-plus"></i>Create New</button></a>
        </div>
        <hr class="hr_content">

        <div class="table-container">
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
            // Check if user ID is set
            if ($user_id !== null) {
                // SQL query to check if the user has submitted a ticket
                $sql = "SELECT * FROM tickets WHERE creatorID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // User has submitted a ticket, display ticket information
                    while ($row = $result->fetch_assoc()) {
                        // Define CSS color based on priority
                        $status_color = '';
                        switch ($row['priority']) {
                            case 'low':
                                $status_color = '#61BE55';
                                break;
                            case 'medium':
                                $status_color = '#F7AA3C';
                                break;
                            case 'high':
                                $status_color = '#F71B24';
                                break;
                            default:
                                $status_color = 'none';
                        }
                        echo "<tr>
                            <td>" . $row['ticketID'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['category'] . "</td>
                            <td><p style='background-color: $status_color; border-radius:20px; padding-top:4px; text-align:center; font-weight:bold; font-size:12px; width:80%; height:25px;'>" . $row['priority'] . "</p></td>
                            <td style='text-align:center;'>" . $row['status'] . "</td>
                            <td>" . $row['createdAt'] . "</td>
                            <td>
                                <a href='open-ticket.php?id=" . $row['ticketID'] . "'><button>OPEN</button></a>
                            </td>";
                    }
                } else {
                     // No ticket found for the user
                    echo '<p>You have no tickets.</p>';
                }
    
                $stmt->close();
            } else {
                // User ID not set. Please log in.
                echo '<p>User ID not set. Please log in.</p>';
            }
    
            $conn->close();
        ?>
                </tbody>
            </table>
        </div>
    </div>

<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-
BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384- BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<!-- DATATABLES CDN -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>
</html>

