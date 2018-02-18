<?php
include 'db.php';
include 'session.php';

$loggedIn = isset($_SESSION['username']);

//if($loggedIn){
 //   include('session.php');
//}

$new_path = '';

if(isset($_FILES['pilt']) || isset($_POST['tekst'])){
    $current_path = $_FILES['pilt']['tmp_name'];
    //tmp_name = temporary name. Siukses kaustas siukse nimega
    $new_path = 'user_images/' . basename($_FILES['pilt']['name']);
    //kui on userite loogika, siis võib panna user numbrite järgi nime, aga praegu teeme sama nimega, millega me ta uploadime. 'Name' paneb ta andmebaasi oma originaalnimega.
    //basename võtab peale viimast kaldkriipsu faili nime nt: /suvakaust/minion.jpg
    $username = $_SESSION['username'];
    $text = $_POST['tekst'];
    
    $text_sql = "UPDATE usertable set picturetext = '$text' where id = '$username'";
    mysqli_query($connection, $text_sql);
    
    if(move_uploaded_file($current_path, $new_path)){
        echo "Üleslaadimine õnnestus: $new_path";
        $sql = "UPDATE usertable set picture = '$new_path' where id = '$username'";
        
        mysqli_query($connection, $sql);
    }else{
        'Viga üleslaadimisel. Proovi uuesti.';
    }
}
$username = $_SESSION['username'];

$sqli_postitus = "SELECT * FROM usertable where id = '$username'";
$result = mysqli_query($connection, $sqli_postitus);

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Tinder</title>
		<link rel="stylesheet" href="tinder.css"> 
	</head>
	<body>
		<div id = "topbar">
			<div id = "header">
				<a id ="tinder_hall"><img src="tinder_hall.png"border="0"></a>
                <a href="logout.php" id= "SignOut" class="SignOut">Sign Out</a>
			</div>
		</div>
			<div id ="postitused"><br><br>
                <a href="laikima.php">Vaata teiste pilte</a><br>
                <b>Minu pilt ja tekst: </b><br>
<!--enctype ütleb et see on kodeeritud mingis tüübis?-->
                <form method="post" enctype="multipart/form-data">
                    <input id="picturefile" type="file" name="pilt"><br>
                    <input id="picturetext" type="text" name="tekst"><br>
                    <button id="upload" type="submit">Upload</button>
                </form>
                <div>
                    <?php
                    while($row = mysqli_fetch_assoc($result)){
                        $text_postitus = $row['picturetext'];
                        $pildike = $row['picture'];

                        $id = $row['id'];
                        if($user_from_db['id'] == $row['id']){
                            echo "<p><img src='$pildike'><br> <b>tekst: </b>                               $text_postitus</p>";
                        }else{
                            echo "Midagi on nässus";
                        }
                    }

                    ?>
                </div>
			</div>
	</body>

</html>
