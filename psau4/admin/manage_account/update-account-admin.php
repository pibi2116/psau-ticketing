<?php
    include '../../authentication.php';
    include '../../connectivity.php';
// Retrieve user information from the form
$id = $_POST['id'];
$username = $_POST['username'];
$full_name = $_POST['full_name'];
$psau_email = $_POST['psau_email'];

// Check if a new password is provided
if (!empty($_POST['password'])) {
    // If a new password is provided, hash it
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Update the password query
    $password_query = "password='$password',";
} else {
    // If no new password is provided, keep the existing password
    $password_query = ""; 
}

if (!empty($_POST['image'])) {
    $image = $_POST['image'];
    $image_query = "image='$image',";
} else {
    $image_query = ""; 
}

// Construct the SQL query
$query = "UPDATE users
          SET
          username='$username',
          $password_query
          $image_query
          full_name='$full_name',
          psau_email='$psau_email'
          WHERE
          id='$id';";

// Execute the query
$result = $conn->query($query);
?>
<script>
    alert("Account Updated!");
    location.replace('http://localhost/psau4/index.php');
</script>   
