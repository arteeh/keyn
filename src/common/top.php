<?php

session_start();

// If loggedin var is not set, set to 0
if(!isset($_SESSION["loggedin"])) $_SESSION["loggedin"] = 0;

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!doctype html>
<html lang="en">

<?php require_once 'head.php'; ?>

<body>

<div class="container-lg">

<?php require_once 'navbar.php'; ?>

<script	src="javascript/darkmode.js"></script>
