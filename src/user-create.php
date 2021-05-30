<?php
require_once "common/database.php";
require_once "common/top.php";

$name		= $email		= $password			= $verification			= "";
$nameError	= $emailError	= $passwordError	= $verificationError	= "";

$willCreate = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["name"]))
	{
		$nameError = "Username is required.";
		$willCreate = 0;
	}
	else
	{
		$name = testInput($_POST["name"]);
		if(!preg_match("/^[A-z\d_]{2,30}$/",$name))
		{
			$nameError = "Only letters and numbers are allowed. Username should be between 2 and 30 characters as well.";
			$willCreate = 0;
		}
		
		//check if username already exists
		$userArray = array_diff(scandir("database/objects/users/"),array('..','.'));
		foreach($userArray as $thisId)
		{
			$d = $GLOBALS["directory"];
			$thisName = file_get_contents("$d/objects/users/$thisId/name");
			if($name == $thisName)
			{
				$nameError = "This username has already been taken.";
				$willCreate = 0;
			}
			if(!$willCreate) break;
		}
	}

	if (empty($_POST["email"]))
	{
		$emailError = "Email is required.";
		$willCreate = 0;
	}
	else
	{
		$email = testInput($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$emailError = "This doesn't look like an email address.";
			$willCreate = 0;
		}
	}
	
	if(empty($_POST["password"]))
	{
		$passwordError = "Password is required.";
		$willCreate = 0;
	}
	else
	{
		$password = testInput($_POST["password"]);
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,72}$/', $password))
		{
			$passwordError = "Your password needs to be at least 8 characters and has to contain at least 1 letter and 1 number.";
			$willCreate = 0;
		}
	}
	
	if(empty($_POST["verification"]))
	{
		$verificationError = "You need to type your password a second time.";
		$willCreate = 0;
	}
	else
	{
		$verification = testInput($_POST["verification"]);
		if(strcmp($password, $verification))
		{
			$verificationError = "These passwords don't match.";
			$willCreate = 0;
		}
	}
}
else
{
	$willCreate = 0;
}

function testInput($data)
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
		action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>"
	>
		<div class="form-group">
			<input
				type="text"
				class="form-control"
				name="name"
				value="<?=$name?>"
				placeholder="Username"
			>
			<?=$nameError?>
		</div>
		<div class="form-group">
			<input
				type="email"
				class="form-control"
				name="email"
				value="<?=$email?>"
				placeholder="Email"
			>
			<small class="form-text text-muted">
				This is just for verification and password resets.
			</small>
			<?=$emailError?>
		</div>
		<div class="form-group">
			<input
				type="password"
				class="form-control"
				name="password"
				placeholder="Password"
			>
			<?=$passwordError?>
		</div>
		<div class="form-group">
			<input
				type="password"
				class="form-control"
				name="verification"
				placeholder="Confirm password"
			>
			<?=$verificationError?>
		</div>
		<button type="submit" class="btn btn-primary">
			Create
		</button>
	</form>
	
	<?php
	
	if($willCreate == 1)
	{
		$user = new User();
		$user->create($name,$email,$password);
		$user->save();
	}
	
	?>

</div>

<?php require_once "common/bot.php" ?>
