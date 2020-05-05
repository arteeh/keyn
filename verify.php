<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'libusers.php';

// Check if the getters exist, otherwise error
if(!isset($_GET['username']) || !isset($_GET['token']))
{
	header("Location: error");
	die();
}

$username = $_GET['username'];
$token = $_GET['token'];

$status = verifyuser($username, $token);

require 'top.php';

?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		<?php
		if($status == 0) 	echo "Something went wrong.";
		else if($status == 1)	echo "Verified! You can log in now.";
		else if($status == 2)	echo "This user has already been verified.";
		else if($status == 3)	echo "This user doesn't exist.";
		?>
	</h1>
</div>

<?php require 'bot.php'; ?>
