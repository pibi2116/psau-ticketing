<?php
include '../../authentication.php';
include_once '../../connectivity.php';
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
      <title>PSAU - CUSTOMER</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="../../css/admin-ui.css" />
      <link rel="shortcut icon" href="../../img/logo.png" type="image/xicon">   
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
            <li class="dash"><a href="http://localhost/psau4/admin/index.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></li>
            <li><a href="http://localhost/psau4/admin/tickets/index.php"><i class="fa-solid fa-boxes-stacked"></i>Tickets</a></li>
            <li><a href="http://localhost/psau4/admin/tickets/ticket-view.php"><i class="fa-solid fa-boxes-stacked"></i>Submitted Ticket</a></li>
            <br />
            <p class="sub-title">Administration</p>
            <li><a href="http://localhost/psau4/admin/agents/index.php"><i class="fa-solid fa-list"></i>Agent</a></li>
            <li><a href="http://localhost/psau4/admin/admin/index.php"><i class="fa-solid fa-users"></i>Admin</a></li>
            <li><a href="http://localhost/psau4/admin/customer/index.php"><i class="fa-solid fa-users"></i>Customer</a></li>
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
            <li><a href="http://localhost/psau4/admin/manage_account/">My Account</a></li>
            <li><a href="../../logout.php">Logout</a></li>
        </ul>
    </div>
</div>

    </div>
    <!-- End of Header -->

    <!-- table -->
    <<div class="content">

<div class="content_design">a</div>
    <div class="conten_text">
        <h3>List of Customer</h3>
        <a href="create-customer.php"><button ><i class="bi bi-plus"></i>Create New</button></a>
    </div>
    <hr class="hr_content">

        <div class="table-container">
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>PSAU Email</th>
                        <th>VIEW</th>


                    </tr>
                </thead>
                <tbody>
                    <?php
                   $query = "SELECT * FROM users WHERE role = 'customer'";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td style='width:65px;'><img src='../../img/" . $row['image'] . "' alt='' id='table-image'></td>
                        <td>" . $row['full_name'] . "</td>
                        <td>" . $row['psau_email'] . "</td>
                        <td>
                        <a href='open-customer.php?id=" . $row['id'] . "'><button>OPEN</button></a>
                        </td>";


                    }
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

