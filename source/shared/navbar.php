<nav class="navbar navbar-expand-md navbar-light">
	<a class="navbar-brand" href="index">
		<img src="images/logo-400.png" width="30" height="30" class="d-inline-block align-top" alt="">
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
