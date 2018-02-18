<?php
include ('db.php');

if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}

//include turvanõuded, et ei saaks urlis minna suvalisele lehele

//Sisselogimine
$error = '';

if (empty($_POST['signinusername']) || empty($_POST['signinpassword'])){
    $error = 'Both fields have to be filled';
}else{
    $user = $_POST['signinusername'];
    $pass = $_POST['signinpassword'];

    $query = mysqli_query($connection, "select * from usertable where username='$user' and password='$pass'");

    $rowCount = mysqli_num_rows($query);

    if($rowCount == 1){
        $row = mysqli_fetch_assoc($query);
        $_SESSION['username'] = $row['id'];
        header('Location: tinder.php');
        exit;   
    }else{
        $error = 'Username or password is invalid';
    }
}

//kui registreerimisvorm on täidetud
if(isset($_POST['FirstName']) && isset($_POST['LastName']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['GenderSelect'])){
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['GenderSelect'];
    
    $sql = "INSERT INTO usertable (firstname, lastname, username, password, email, gender) " . "VALUES ('$firstname', '$lastname', '$username', '$password', '$email', '$gender')";
    
    if(mysqli_query($connection, $sql)){
        //uus kasutaja loodi edukalt
        $_SESSION['tinder'] = mysqli_insert_id($connection); //siis ei pea eraldi sisse logima
        header('Location: tinder.php'); //saab suunata kuskile
        exit;
    } else {
        echo 'Kõik on tuksis';
    }
}
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Tinder</title>
		<link rel="stylesheet" href="main.css"> 
	</head>
	<body>
		<div id = "topbar">
			<div id = "header">
				<a id ="tinder_hall"><img src="tinder_hall.png"border="0"></a>
                <form method="post">
				<input type = "submit" value ="Sign in" id= "SignIn">
                <input type = "password" placeholder="Password" autocomplete="off" id="SignInPassword" name="signinpassword">
				<input type = "text" placeholder="Username" autocomplete="off" id="SignInUsername" name="signinusername">
                </form>
			</div>
		</div>
			<div id ="DivSignUp">
				<h1 > Sign Up</h1>
				<br>
                <form method="post">
                    <!--onkeyup- kui lasta klahv vabaks, siis teeb funktsiooni. autocomplete lubab browseril ennustada välja täitmist. default on 'on'. -->
                    <input type = "text" placeholder="First Name" autocomplete="off"id="SignUpFirstName" class = "FirstName" name = "FirstName">

                    <input type = "text" placeholder="Last Name" id="SignUpLastName" class = "LastName" name = "LastName">
                    <br>
                    <input type = "text" placeholder="Username" id="SignUpUsername" class = "Username" name = "username">
                    <br>
                    <input type = "password" placeholder="Password" id="SignUpPassword" class = "Password" name = "password">
                    <br>
                    <input type = "text" placeholder="E-mail" id="SignUpE-mail" class = "E-mail" name = "email">
                    <br>
                    <select id="GenderSelect" class="GenderSelect" name="GenderSelect">
                        <option value="">Gender</option>
                        <option value="F">Female</option>
                        <option value="M">Male</option>
                    </select>
                    <br>
                    <button type="submit" id="SignUp" class="SignUp" >Sign up</button>
                </form>
			</div>
        <p><?=$error?></p>
	</body>

</html>
