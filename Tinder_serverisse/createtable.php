
<?php
$servername = "localhost";
$username = "st2014";
$password = "progress";
$dbname = "st2014";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE `usertable` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `firstname` VARCHAR(15) NOT NULL , `lastname` VARCHAR(15) NOT NULL , `username` VARCHAR(15) NOT NULL , `password` VARCHAR(15) NOT NULL , `email` VARCHAR(50) NOT NULL , `gender` CHAR(1) NOT NULL , `picture` VARCHAR(1000) NOT NULL , `picturetext` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

$likesql = "CREATE TABLE `kertrud_likes` ( `keslaikis` VARCHAR(15) NOT NULL , `kedalaikis` VARCHAR(15) NOT NULL , `likestatus` INT(1) NOT NULL ) ENGINE = InnoDB;";

if ($conn->query($likesql) === TRUE) {
    echo "Table likes created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

if ($conn->query($sql) === TRUE) {
    echo "Table tinder created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
