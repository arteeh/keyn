<?php

require_once 'libmod.php';

$gameid = $modname = $moddescription = "";

// Check if something is in post already
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$gameid = $_POST['gameid'];
	$modname = $_POST['modname'];
	$moddescription = $_POST['moddescription'];
	
	if(	$gameid == "" || $modname == "" || $moddescription == "")
	{
		echo "Something's missing.<br>";
	}
	else if($gameid == "null")
	{
		echo "Select a game!<br>";
	}
	else
	{
		$modid = createMod($gameid,$modname,$moddescription);
		// If createMod is successful, send user to mod page
		header("Location: mod?game=$gameid&mod=$modid");
		die();
	}
}

require_once 'top.php';
require_once 'libgame.php';

?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		Create a mod
	</h1>
	<form	class="my-4"
			method="post"
			action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
	>
		<div class="form-group">
			<select name="gameid" class="custom-select">
				<option value="null">
					Game
				</option>
				<?php
				// Get all game names, ideally sorted by popularity
				$games = getGames();
				foreach($games as $game)
				{
					?>
					<option value="<?php echo $game['id']; ?>">
						<?php echo $game['name']; ?>
					</option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="form-group">
			<input
				type="text"
				class="form-control"
				name="modname"
				value="<?php echo $modname; ?>"
				placeholder="Title"
			>
		</div>
		<div class="form-group">
			<textarea	class="form-control"
						rows="4"
						name="moddescription"
						placeholder="Description (optional)"
			><?php echo $moddescription; ?></textarea>
		</div>
		<small class="form-text text-muted my-3">
			You can add files later.
		</small>
		<button type="submit" class="btn btn-primary">
			Upload
		</button>
	</form>
</div>

<?php require_once 'bot.php' ?>


