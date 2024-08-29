<?php
    include '../../authentication.php';
    include '../../connectivity.php';
    $id = $_GET['id'];
    $query = "delete from users
              where
              id =  '$id' 
                ;";
    $result = $conn->query($query);
?>
<script>
    alert("Account Deleted!");
    location.replace('http://localhost/psau4/index.php');
</script>