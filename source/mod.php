<?php

$gameid = $_GET['game'];
$gamedir = "database/games/$gameid";

// Check if game and mod in GET exist to prevent issues
if(!is_dir($gamedir))
{
	header("Location: error.php");
	die();
}

$modid = $_GET['mod'];
$moddir = "$gamedir/mods/$modid";

if(!is_dir($moddir))
{
	header("Location: error.php");
	die();
}

require_once 'shared/top.php';
require_once 'shared/libmod.php';
require_once 'shared/libgame.php';

$game = getGame($gameid);
$mod = getMod($gameid,$modid);

?>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<a href="game.php?game=<?php echo $game['id']; ?>" type="button" class="btn btn-primary">
		Back to <?php echo $game['name']; ?>
	</a>
	<span class="my-auto">
		Downloads: <?php echo $mod['downloads']; ?>
		&nbsp
		Seeders: <?php echo $mod['seeders']; ?>
		&nbsp
		Leechers: <?php echo $mod['leechers']; ?>
	</span>
</div>

<div class="card bg-light text-white my-4">
	<object	class="card-img"
			data="<?php echo "database/placeholdermod/banner.webp"; ?>"
			type="image/webp"
	>
		<img class="card-img" src="<?php echo $mod['bannerdir']; ?>" alt="Game banner image">
	</object>
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?php echo $mod['name']; ?></h2>
	</div>
</div>

<div class="my-4">
	<ul	class="nav nav-tabs"
		role="tablist"
	>
		<li class="nav-item">
			<a	class="nav-link active" id="description-tab"
				data-toggle="tab" href="#description"
				role="tab"
			>Description</a>
		</li>
		<li class="nav-item">
			<a	class="nav-link" id="downloads-tab"
				data-toggle="tab" href="#downloads"
				role="tab"
			>Downloads</a>
		</li>
		<li class="nav-item">
			<a	class="nav-link" id="comments-tab"
				data-toggle="tab" href="#comments"
				role="tab"
			>Comments</a>
		</li>
	</ul>
	<div class="tab-content">
		<div	class="	tab-pane fade
						border rounded-bottom border-top-0 p-3
						show active"
				id="description"
				role="tabpanel"
		>
			<?php
			$moddescriptionfile = fopen($mod['descriptiondir'], "r");
			while(!feof($moddescriptionfile))
				echo fgets($moddescriptionfile);
			fclose($moddescriptionfile);
			?>
		</div>
		<div	class="	tab-pane fade
						border rounded-bottom border-top-0 p-3"
				id="downloads"
				role="tabpanel"
		>
			<?php
			$files = getFiles($gameid,$modid);
			$otherPrinted = 0;
			if(count($files) == 0)
			{
				echo "<h4 class='mt-1'>This mod currently doesn't have any files.</h4>";
			}
			foreach($files as $file)
			{
				if($file['type'] == 'main') echo "<h4 class='mt-1'>Main file</h4>";
				else if($file['type'] == 'xtra' && $otherPrinted == 0)
				{
					echo "<h4>Other files</h4>";
					$otherPrinted = 1;
				}
				?>
				<div class="card my-4">
					<img class="card-img-top" src="<?php echo $file['banner'] ?>" alt="">
					<div class="card-body">
						<h5 class="card-title">
							<?php echo $file['name']; ?>
						</h5>
						<p class="card-text">
							<?php echo $file['description'] ?>
						</p>
						<div class="btn-group">
							<a href="<?php
								// The 0 is not a bug. The download button returns the 0th torrent, which is the latest version
								$filedir = "";
								$dir = $file['torrents'][0]['dir'];
								echo "$filedir/$dir";
							?>" type="button" class="btn btn-primary">Download</a>
							<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
								<span>
									<?php echo $file['torrents'][0]['version']; ?>
								</span>
							</button>
							<div class="dropdown-menu">
								<?php
								foreach($file['torrents'] as $torrent)
								{
									?>
									<a class='dropdown-item' href="<?php 
										$dir = $torrent['dir'];
										echo "$filedir/$dir" ?>">
										<?php echo $torrent['version']; ?>
									</a>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<div	class="	tab-pane fade
						border rounded-bottom border-top-0 p-3"
				id="comments"
				role="tabpanel"
		>
			<h4 class='mt-1'>Comments coming soon!</h4>
		</div>
	</div>
</div>

<?php require_once 'shared/bot.php'; ?>
