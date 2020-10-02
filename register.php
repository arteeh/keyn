<?php

require_once 'shared/top.php';
require_once 'shared/libusers.php';

$usernameerror = $emailerror = $passworderror = $passwordverror = "";
$username = $email = $password = $passwordv = "";
$willcreate = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (empty($_POST["username"]))
	{
		$usernameerror = "Username is required.";
		$willcreate = 0;
	}
	else
	{
		$username = testinput($_POST["username"]);
		if (!preg_match("/^[A-z\d_]{2,30}$/",$username))
		{
			$usernameerror = "Only letters and numbers are allowed. Username should be between 2 and 30 characters as well.";
			$willcreate = 0;
		}
		
		//check if username already exists
		$allusers = array_diff(scandir("db/users/"),array('..','.'));
		foreach($allusers as $thisuserpath)
		{
			$thisdatafile = fopen("db/users/$thisuserpath/data", "r");
			while(!feof($thisdatafile))
			{
				$line = fgets($thisdatafile);
				if(strpos($line, "username=") !== false)
					$thisusername = trim(str_replace("username=","",$line));
				if($username == $thisusername)
				{
					$usernameerror = "This username has already been taken.";
					$willcreate = 0;
				}
			}
			fclose($thisdatafile);
			if(!$willcreate) break;
		}
	}

	if (empty($_POST["email"]))
	{
		$emailerror = "Email is required.";
		$willcreate = 0;
	}
	else
	{
		$email = testinput($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$emailerror = "This doesn't look like an email address.";
			$willcreate = 0;
		}
	}
	
	if (empty($_POST["password"]))
	{
		$passworderror = "Password is required.";
		$willcreate = 0;
	}
	else
	{
		$password = testinput($_POST["password"]);
		if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,72}$/', $password))
		{
			$passworderror = "Your password needs to be at least 8 characters and has to contain at least 1 letter and 1 number.";
			$willcreate = 0;
		}
	}
	
	if (empty($_POST["passwordv"]))
	{
		$passwordverror = "You need to type your password a second time.";
		$willcreate = 0;
	}
	else
	{
		$passwordv = testinput($_POST["passwordv"]);
		if (strcmp($password, $passwordv))
		{
			$passwordverror = "These passwords don't match.";
			$willcreate = 0;
		}
	}
}
else
{
	$willcreate = 0;
}

function testinput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		Create an account
	</h1>
	
	<form	class="my-4"
		method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
	>
		<div class="form-group">
			<input
				type="text"
				class="form-control"
				name="username"
				value="<?php echo $username; ?>"
				placeholder="Username"
			>
			<?php echo $usernameerror;?>
		</div>
		<div class="form-group">
			<input
				type="email"
				class="form-control"
				name="email"
				value="<?php echo $email; ?>"
				placeholder="Email"
			>
			<small class="form-text text-muted">
				This is just for verification and password resets.
			</small>
			<?php echo $emailerror;?>
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
		<div class="form-group">
			<input
				type="password"
				class="form-control"
				name="passwordv"
				placeholder="Confirm password"
			>
			<?php echo $passwordverror;?>
		</div>
		<button type="submit" class="btn btn-primary">
			Create
		</button>
	</form>
	
	<?php
	
	if($willcreate == 1)
	{
		$userid = createuser($username, $email, $password);
		
		$token = hash("sha256", $userid);
		
		$subject = "Verify your Keyndb account";
		$message = "<html><head><title>Verify your Keyndb account</title>
			</head><body><h3>Hi $username, click 
			<a href='https://www.keyndb.com/verify?
			userid=$userid&token=$token'> here </a>
			to verify your account.</h3></body></html>";
		
		// Headers for HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: Keyndb <noreply@keyndb.com>' . "\r\n";
	
		mail($email,$subject,$message,$headers);

		echo "<h5>A verification email has just been sent to $email. Click the link in there to verify your account.</h5>";
	}
	?>

</div>

<?php require_once 'shared/bot.php' ?>
