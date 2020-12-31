<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'shared/libusers.php';

// Check if the getters exist, otherwise error
if(!isset($_GET['userid']) || !isset($_GET['token']))
{
	header("Location: error");
	die();
}

$userid = $_GET['userid'];
$token = $_GET['token'];

$status = verifyuser($userid, $token);

require 'shared/top.php';

?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		<?php
		switch($status)
		{
			case 0:		echo "Something went wrong."; break;
			case 1:		echo "Verified! You can log in now."; break;
			case 2:		echo "This user has already been verified."; break;
			case 3:		echo "This user doesn't exist."; break;
		}
		?>
	</h1>
</div>

<?php require 'shared/bot.php'; ?>
