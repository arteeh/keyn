<?php
session_start();

// If loggedin var is not set, set to 0
if(!isset($_SESSION["loggedin"])) $_SESSION["loggedin"] = 0;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'top-cache.php';
require_once 'libusers.php';
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Other -->
	<meta charset="utf-8">
	<title>Keyndb ALPHA</title>
	<meta	name="description"
			content="Keyn mod hosting site!"
	>
	<meta	name="viewport"
			content="width=device-width, initial-scale=1, shrink-to-fit=no"
	>
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<!-- Bootstrap CSS -->
	<link	rel="stylesheet"
		href="css/bootstrap.min.css"
	>
	
	<!-- Favicon stuff -->
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#b91d47">
	<meta name="theme-color" content="#cefcab">
</head>

<body>

<div class="container-lg">
	<nav class="navbar navbar-expand-md navbar-light">
		<a class="navbar-brand" href="index">
			<img src="assets/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
			Keyndb ALPHA
		</a>
		<button	class="navbar-toggler"
			type="button"
			data-toggle="collapse"
			data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="
						https://trello.com/b/C4gNR6Fs">
						Feature requests
					</a>
				</li>
			</ul>
			<ul class="navbar-nav">
			<?php
			if($_SESSION["loggedin"] == 0)
			{
			?>
				<li class="nav-item">
					<a	class="nav-link"
						href="login"
					>
					Log in</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="
					register">
					Register</a>
				</li>
			<?php
			}
			else
			{
				?>
				<li class="nav-item">
					<a class="nav-link" href="uploadmod">
						Upload
					</a>
				</li>
				<?php
				
				// Get username and profile picture
				$userid = $_SESSION["userid"];
				$userdir = "db/users/$userid";
				$useravatardir = "$userdir/avatar.webp";
				$userdatadir = "$userdir/data";
				$username = getsingleitem($userdatadir, "username");
			?>
				<li class="nav-item">
					<a	class="nav-link"
						href="profile"
					>
						<img
						src="<?php echo $useravatardir;?>"
						alt="Your profile picture"
						width="15"
						height="15"
						>
						<?php echo $username; ?>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link"
					href="
					logout?from=
					<?php
					echo $_SERVER['REQUEST_URI'];
					?>">
					Log out</a>
				</li>
			<?php
			}
			?>
			</ul>
		</div>
	</nav>
