<?php
include 'db.php';
include 'session.php';

session_start();

$loggedIn = isset($_SESSION['username']);

if($loggedIn){
    include('session.php');
}

if($user_from_db['gender'] == 'M'){
    $sql = "select username, gender, picture, picturetext from usertable where gender='F' order by rand()";
    $result = mysqli_query($connection, $sql);
}else if($user_from_db['gender'] == 'F'){
    $sql = "select username, gender, picture, picturetext from usertable where gender='M' order by rand()";
    $result = mysqli_query($connection, $sql);
}

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Tinder</title>
		<link rel="stylesheet" href="laikima.css"> 
	</head>
	<body>
		<div id = "topbar">
			<div id = "header">
				<a id ="tinder_hall"><img src="tinder_hall.png"border="0"></a>
                <a href="tinder.php" id= "Tagasi" class="Tagasi">Tagasi</a>
			</div>
		</div><br><br>
        <form id="laikimised" method="post">
            <div id="nope_div">
                <button name="like" type="submit" id="nope" value="0">NOPE</button>
            </div>
            <div id="like_div">
                <button name="like" type="submit" id="like" value="1">LIKE</button>
            </div>
            <div id ="postitused">
<?php

$array = array();
while($row = mysqli_fetch_array($result)){
    array_push($array, $row['picture']);
    $tekstike = $row['picturetext'];
    //$kedalaigiti = $row['username'];
}

$x = array_rand($array, 1);
$pildike = $array[$x];
//$tekstike = $row['picturetext'];
echo "<p><img id='pilt' src='$pildike'><br> <b>tekst: </b>$tekstike </p>";

if(isset($_POST['like'])){
    unset($array[$x]);
}
?>
            </div>
        </form>
	</body>
</html>

