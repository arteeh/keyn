<!doctype html>
<html lang="en">

<head>
	<!-- Favicon stuff -->
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#b91d47">
	<meta name="theme-color" content="#cefcab">
	
	<!-- Other -->
	<meta charset="utf-8">
	<title>Keyn</title>
	<meta name="description" content="Keyn mod hosting site!">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

	<div class="header">
		<img src="logo-text.png" alt="Keyn logo" height="52" width="200" />
		<ul class="nav-links">
			<li class="nav-item"><a href="#">Games</a></li>
			<li class="nav-item"><a href="#">Log In</a></li>
			<li class="nav-item"><a href="#">Register</a></li>
		</ul>
	</div>
	
	<div class="main">
		<p>
			Welcome! Keyndb is a website where you can find, upload and download video game mods. Rather than downloading the mods directly however, you get a torrent file, which you can use to download the mod in your favourite torrenting software. While this is a small hoop to jump through for you, it has many benefits. For one, download speeds will be very high and will never be artificially limited like on the Nexus. Secondly, this keeps the bandwidth needs for this website low, making it much cheaper to host the site. Because of this, there is no need for ads or subscriptions. This website is still under development, but you can try it out if you want. Enjoy!
		</p>
	</div>
	
	<div class="main">
		<?php
		
		// DB Credentials
		$servername = "localhost";
		$username = "phpselect";
		$password = "ZIbv54wn2LP3WXl9";

		// Connect to keyndb database
		try
		{
			$pdo = new PDO("mysql:host=$servername;dbname=keyndb", $username, $password);
			// set the PDO error mode to exception
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			print("Connected successfully<br>");
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		
		// Get all names from the games table
		$stmt = $pdo->prepare("SELECT name FROM game");
		$stmt->execute();
		
		print("\nGames:<br>");
		
		while($row = $stmt->fetch())
		{
			$name = $row["name"];
			print($name . "<br>");
		}
		
		$conn = null; 
		?>
	</div>
	
	<div class="footer">
	
	</div>

</body>
</html>
