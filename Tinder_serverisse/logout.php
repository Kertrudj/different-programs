<?php
session_start(); //php loogika on et enne destroy-d peab olema session_start
session_destroy();
header('Location: index.php');
?>