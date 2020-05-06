<?php
$login = $password = "";
$loginerror = $passworderror = "";

$_SESSION["loggedin"] = 0;

//if the user has tried to log in and there's data in POST
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$login = htmlspecialchars($_POST["login"]);
	$password = htmlspecialchars($_POST["password"]);

	//check if login is a username or an email
	if(filter_var($login, FILTER_VALIDATE_EMAIL))
		$loginisemail = 1;
	else	$loginisemail = 0;
	
	//check if login exists
	$found = 0;
	$allusers = array_diff(scandir("db/users/"),array('..','.'));
	$userid = -1;
	foreach($allusers as $thisuserpath)
	{
		$thisdatafile = fopen("db/users/$thisuserpath/data", "r");
		while(!feof($thisdatafile))
		{
			$line = fgets($thisdatafile);
			if($loginisemail)
			{
				$thislogin = "";
				if(strpos($line, "email=") !== false)
				{
					$thislogin =
						trim(str_replace("email=","",$line));
					if($thislogin === $login)
					{
						$userid = $thisuserpath;
						break;
					}
				}
			}
			else
			{
				$thislogin = "";
				if(strpos($line, "username=") !== false)
				{
					$thislogin =
						trim(str_replace("username=","",$line));
					if($thislogin === $login)
					{
						$userid = $thisuserpath;
						break;
					}
				}
			}
		}
		fclose($thisdatafile);
		if($userid !== -1) break;
	}
	
	if($userid == -1) $loginerror = "There's no account that goes by this name.";
	else
	{
		//check if password matches username		
		$matcheddatafile = fopen("db/users/$userid/data", "r");
		while(!feof($matcheddatafile))
		{
			$line = fgets($matcheddatafile);
			if(strpos($line, "password=") !== false)
				$matchedpassword =
					trim(str_replace("password=","",$line));
		}
		fclose($matcheddatafile);
		
		if(!password_verify($password, $matchedpassword))
			$passworderror = "Password is incorrect.";
		else
		{
			//Place info in session
			$_SESSION["loggedin"] = 1;
			$_SESSION["userid"] = $userid;
			header("Location: index");
			die();
		}
	}
}

require 'top.php';
?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		Log in
	</h1>
	
	<form	class="my-4"
		method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
	>
		<div class="form-group">
			<input
				type="text"
				class="form-control"
				name="login"
				value="<?php echo $login; ?>"
				placeholder="Username or email"
			>
			<?php echo $loginerror;?>
		</div>
		<div class="form-group">
			<input
				type="password"
				class="form-control"
				name="password"
				placeholder="Password"
			>
			<?php echo $passworderror;?>
		</div>
		<button type="submit" class="btn btn-primary">
			Log in
		</button>
	</form>
</div>

<?php require 'bot.php' ?>
