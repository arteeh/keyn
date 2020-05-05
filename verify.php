<?php

// Check if the getters exist, otherwise error
if(!isset($_GET['username']) || !isset($_GET['token']))
{
	header("Location: error");
	die();
}

$username = $_GET['username'];
$token = $_GET['token'];

$status = verifyuser($username, $token);

require 'top.php' 

?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		<?php
		if($status == 0) 	echo "Something went wrong.";
		else if($status == 1)	echo "Verified!";
		?>
	</h1>
</div>

<?php require 'bot.php' ?>
