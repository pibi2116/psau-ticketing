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
        height: 530px;
        overflow-x: hidden;
        margin-left: 15px ;
        margin-top: 20px;
        display: flex; 
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
            <li class="dash"><a href="http://localhost/psau4/customer/index.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></li> 
            <li><a href="http://localhost/psau4/customer/ticket-view.php"><i class="fa-solid fa-boxes-stacked"></i>Tickets</a></li>
        </ul>
    </div>
    <!-- End of Navigation Bar -->

    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <p>PSAU - Ticket Management System</p>
        </div>
        <div class="account-header">
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
            <div class="button-container"><p class="fullname"><?php echo $full_name; ?></p>
            <span class="caret"></span></div>
        </button>
        <ul class="dropdown-menu">
            <li><a href="http://localhost/psau4/staff/manage_account/">My Account</a></li>
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
            <h3>Ticket Information</h3>
                <?php
                // echo "<a href='resolved-ticket.php?id=" . $_GET['id'] . "'><button >Mark as Resolved</button></a>";
                ?>
        </div>
        <hr class="hr_content">
        <?php 
         $q = "SELECT tickets.*, users.full_name AS creator_name 
                FROM tickets 
                LEFT JOIN users ON tickets.creatorID = users.id 
                WHERE ticketID = {$_GET['id']}";
         $r = $conn->query($q);
         $row = $r->fetch_assoc();
        ?>
        <div class="openTicket-container">
            <div class="ticket-container" >
                <div class="ticket-content" style="margin-top:-5px; padding-right:150px;">
                    <label for="ticket-sender" style="color: #868787; font-weight:lighter;">SENDER:</label>
                    <p style="font-size:20px; margin-top:-20px;">
                        <?php 
                        echo $row['creator_name'];
                        ?>
                    </p>   
                    <br>
                    <label for="ticket-title" style="color: #868787; font-weight:lighter;">TITLE:</label>
                    <p style="font-size:18px; margin-top:-20px;">
                        <?php 
                        echo $row['title'];
                        ?>
                    </p>   
                    <br>
                    <label for="" style="color: #868787; font-weight:lighter;">DESCRIPTION:</label>
                    <fieldset style="font-size:15px; margin-top:-20px;">
                        <?php 
                        echo $row['description'];
                        ?>
                    </fieldset>
                    <?php if (!empty($row['attachment'])): ?>
                        <!-- Show the image only if there is an attachment -->
                        <img src="../img/<?php echo $row['attachment']; ?>" alt="" style="max-width:80%; max-height:250px;">
                    <?php endif; $conn ->close();?>
                    
                </div>

            </div>
            <?php
                // Assuming you have already retrieved the ticket status and stored it in $row['status']
                $ticketStatus = $row['status'];

                // Check if the ticket status is 'Open'
                if ($ticketStatus === 'Open') {
                    // If the ticket status is 'Open', hide the message container
                    $messageContainerStyle = 'display: none;';
                } else {
                    // If the ticket status is not 'Open', show the message container
                    $messageContainerStyle = '';
                }
            ?>
            <div class="message-container" style="<?php echo $messageContainerStyle; ?>">
                <div class="message-divider1">
                <?php
                    $conn = new mysqli("localhost", "root", "", "ticket_db4");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to retrieve messages for ticketID 35
                    $id = isset($_GET['id']) ? $_GET['id'] : ''; // Sanitize input
                    $sql = "SELECT tc.*, u.id AS user_id, u.full_name AS user_full_name 
                            FROM ticketcommunication tc 
                            LEFT JOIN users u ON tc.senderID = u.id 
                            WHERE tc.ticketID = " . $conn->real_escape_string($id);

                    $result = $conn->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="message-content" style="width:500px;">';
                            echo '<h5><strong>' . $row['user_full_name'] . '</strong></h5>'; // Display user's full name
                            echo '<br>';
                            
                            echo '<p>' . $row['message'] . '</p>';
                            if (!empty($row['attachment'])) {
                                // Show the image only if there is an attachment
                                echo '<img src="../img/' . $row['attachment'] . '" alt="" class="message-avatar" style="max-width:80%; max-height:400px;">';
                                echo '<br>';
                            }
                            // Format the createdAt timestamp to display only hours
                            echo '<span class="time-right">' . date("H:i", strtotime($row['createdAt'])) . '</span>';
                            echo '</div>'; // Close message-content div
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    $conn->close();
                    ?>
                </div>


                <div class="message-divider2">
                    <?php
                

                    // Sanitize input
                    $ticketId = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    $q = "SELECT * FROM users WHERE id = ?";
                    

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    } else {
                        // Handle case where staff member is not found
                        // For example: redirect or show an error message
                    }       
                    
                    // Close prepared statement
                
                    ?>

                    <div class="chatplace">
                        <form action="send-message.php" method="post" enctype="multipart/form-data" id="myForm" onsubmit="return validateForm()">
                            <input type="hidden" name="senderID" value="<?= $user_id ?>">
                            <input type="hidden" name="ticketID" value="<?= $ticketId ?>">
                            <textarea class="txtarea" name="message" placeholder="Place your message here"></textarea><button type="submit">Send</button>
                            <input type="file" name="attachment">
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
function validateForm() {
    var message = document.getElementsByName("message")[0].value;
    var attachment = document.getElementsByName("attachment")[0].value;

    // Check if either message or attachment is filled
    if (message.trim() === '' && attachment.trim() === '') {
        alert("PLEASE FILL OUT THE FIELDS!");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>
<script>
var container = document.querySelector('.message-divider1');
container.scrollTop = container.scrollHeight;
</script>
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

