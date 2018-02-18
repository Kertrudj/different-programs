<?php
if(!isset($_SESSION)){
    session_start();
}

if(empty($_SESSION['username'])){
    header('Location: index.php');
    exit;
} else{
    $id = $_SESSION['username'];
    $query = mysqli_query($connection, "select * from usertable where id=$id");
    
    $user_from_db = mysqli_fetch_assoc($query);
}
?>