<?php

require_once 'shared/libmod.php';

$gameid		= $modname	= $moddescription	= "";
$gameiderror	= $modnameerror	= $moddescriptionerror	= "";

// Check if something is in post already
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$gameid = $_POST['gameid'];
	$modname = $_POST['modname'];
	$moddescription = $_POST['moddescription'];
	
	$success = 1;
	
	if($gameid == "")
	{
		$gameiderror = "You haven't selected a game!";
		$success = 0;
	}
	if($modname == "")
	{
		$modnameerror = "You haven't given your mod a title!";
		$success = 0;
	}
	if($moddescription == "")
	{
		$moddescriptionerror = "You haven't given your mod a description!";
		$success = 0;
	}
	
	if($success == 1)
	{
		$modid = createMod($gameid,$modname,$moddescription);
		header("Location: mod?game=$gameid&mod=$modid");
		die();
	}
}

require_once 'shared/top.php';
require_once 'shared/libgame.php';

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
				<option value="">
					Game
				</option>
				<?php
				// Get all game names, ideally sorted by popularity
				$games = getGames();
				foreach($games as $game)
				{
					?>
					<option	value="<?php echo $game['id']; ?>"
							<?php if($game['id'] == $gameid) echo "selected"; ?>
					>
						<?php echo $game['name']; ?>
					</option>
					<?php
				}
				?>
			</select>
			<?php echo $gameiderror; ?>
		</div>
		<div class="form-group">
			<input
				type="text"
				class="form-control"
				name="modname"
				value="<?php echo $modname; ?>"
				placeholder="Title"
			>
			<?php echo $modnameerror; ?>
		</div>
		<div class="form-group">
			<textarea	class="form-control"
						rows="4"
						name="moddescription"
						placeholder="Description (optional)"
			><?php echo $moddescription; ?></textarea>
			<?php echo $moddescriptionerror; ?>
		</div>
		<small class="form-text text-muted my-3">
			You can add files later.
		</small>
		<button type="submit" class="btn btn-primary">
			Upload
		</button>
	</form>
</div>

<?php require_once 'shared/bot.php' ?>


