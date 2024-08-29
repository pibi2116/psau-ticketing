
<?php
    include '../authentication.php';
    include '../connectivity.php';
// Retrieve department from URL query parameters
$department = $_GET['department'] ?? '';

// Function to check if an option is selected
function isSelected($value, $selected) {
    return $value == $selected ? 'selected' : '';
}
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
      <link rel="stylesheet" href="../../css/create-ticket.css" />
      <link rel="shortcut icon" href="../img/logo.png" type="image/xicon">   

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
            <div class="dropdown">
                <button class="btn  dropdown-toggle" type="button" data-toggle="dropdown">
 
                <?php
    // Retrieve full name from database based on username
    $username = $_SESSION["username"];
    $sql = "SELECT full_name FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $full_name = $row['full_name'];
    } else {
        // Handle error if user not found in database
        $full_name = "Unknown";
    }

    $stmt->close();
    ?>
                    <div class="button-container"><p class="fullname"><?php echo $full_name; ?></p>
                    <span class="caret"></span></div>
                
                </button>
                <ul class="dropdown-menu">
                    <li><a href="http://localhost/psau4/customer/manage_account/">My Account</a></li>
                    <li><a href="../logout.php">Logout</a></li>

                </ul>
            </div>
        </div>
    </div>
    <!-- End of Header -->

    <div class="content">     
        <div class="content_design">a</div>
            <div class="conten_text">
                <h3>New Ticket</h3>
                <a href="http://localhost/psau4/customer/ticket-view.php"><button class="return-ticket" style="width:85px;">Back</button></a>
            </div>
            <hr class="hr_content">

            <div class="createticket-container">
                <form action="save_ticket.php" method="post" class="ticketing" enctype="multipart/form-data">
                    <div class="createticket1">
                        <label for="title">Ticket Title: </label>
                        <label for="category">Select Department:</label>
                        <label for="priority">Priority Level:</label>
                        <label for="description" style="margin-bottom:150px;">Ticket body:</label>
                        <label for="">Attachment:</label>
                    </div>
                    <div class="createticket2">
                        <input type="text" name="title" placeholder="Ex. (Equipment Concern)" style="margin-top:-2px;">
                        <select class="form-select" aria-label="Default select example" name="category"  style="margin-top:16px;">
                            <option value="College of Engineering and Computer Studies (COECS)" <?php echo isSelected('College of Engineering and Computer Studies (COECS)', $department); ?>>College of Engineering and Computer Studies (COECS)</option>
                            <option value="College of Agriculture Systems and Technology (CASTECH)" <?php echo isSelected('College of Agriculture Systems and Technology (CASTECH)', $department); ?>>College of Agriculture Systems and Technology (CASTECH)</option>
                            <option value="College of Education (COED)" <?php echo isSelected('College of Education (COED)', $department); ?>>College of Education (COED)</option>
                            <option value="College of Hospitality, Entrepreneurship, and Food Sciences (CHEFS)" <?php echo isSelected('College of Hospitality, Entrepreneurship, and Food Sciences (CHEFS)', $department); ?>>College of Hospitality, Entrepreneurship, and Food Sciences (CHEFS)</option>
                            <option value="College of Arts and Sciences (CAS)" <?php echo isSelected('College of Arts and Sciences (CAS)', $department); ?>>College of Arts and Sciences (CAS)</option>
                            <option value="College of Veterinary Medicine (CVM)" <?php echo isSelected('College of Veterinary Medicine (CVM)', $department); ?>>College of Veterinary Medicine (CVM)</option>
                        </select>
                        <select name="priority"  style="margin-top:15px;">
                            <option value="low">LOW</option>
                            <option value="medium">MEDIUM</option>
                            <option value="high">HIGH</option>
                        </select>
                        <textarea name="description" placeholder="Explain your ticket" style="margin-top:26px;"></textarea>
                        <input type="file" name="attachment" style="margin-top:18px; width:200px !important; border:none !important;">
                        <button type="submit" class="submit">Submit</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-
BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384- BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>
</html>

