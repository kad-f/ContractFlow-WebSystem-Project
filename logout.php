<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== "true") {
	header("Location: login.php");
	exit();
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['logged']);
	header("Location: login.php");
	exit();
}
?>