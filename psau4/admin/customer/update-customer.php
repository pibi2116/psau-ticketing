<?php
include '../../authentication.php';
include_once '../../connectivity.php';

// Retrieve existing password if no new password is provided
if (empty($_POST['password'])) {
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $password = $row['password'];
    $stmt->close();
} else {
    // If a new password is provided, hash it
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
}

$id = $_POST['id'];
$username = $_POST['username'];
$full_name = $_POST['full_name'];
$psau_email = $_POST['psau_email'];

// Check if a new image is uploaded
$image_query = "";
if (!empty($_FILES['image']['name'])) {
    $target_dir = "../../img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image_query = "image='" . basename($_FILES["image"]["name"]) . "',";
}

// Prepare and execute the update query
$query = "UPDATE users
          SET
          username = ?,
          password = ?,
          $image_query
          full_name = ?,
          department = ?,
          psau_email = ?
          WHERE id = ?";

$stmt = $conn->prepare($query);
if ($image_query) {
    $stmt->bind_param("sssssi", $username, $password, $full_name, $department, $psau_email, $id);
} else {
    $stmt->bind_param("sssssi", $username, $password, $full_name, $department, $psau_email, $id);
}
$stmt->execute();
$stmt->close();
?>

<script>
    alert("Customer Updated!");
    location.replace('index.php');
</script>
