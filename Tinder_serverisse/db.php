<?php
$connection = mysqli_connect('localhost', 'st2014', 'progress'); //koht, kasutajanimi, parool

if (!$connection){
    die('Connection error: ' . mysqli_connect_error()); //stringide liitmine on punktiga
}

$db = mysqli_select_db($connection, 'st2014');
?>