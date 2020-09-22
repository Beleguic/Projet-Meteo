<?php

session_start();

if (empty($_SESSION["name"])) {

	header("location: index.php");

}
else{

$_SESSION=array();
session_destroy();

header('location:index.php');
}

?>