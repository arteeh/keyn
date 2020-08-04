<?php
// Get the session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy(); 

// Get previous location and go there
$prev = trim($_GET['from'],"/");
header("Location: $prev");
die();
?>
