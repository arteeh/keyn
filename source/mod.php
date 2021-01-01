<?php

include_once "shared/database.php";

$gameid = $_GET['game'];
checkGame($gameid);

$id = $_GET['mod'];
checkMod($gameid,$id);

include_once "shared/top.php";

$game = getFolderR("games/$gameid",1);
$mod = getFolderR("games/$gameid/mods/$id",5);

?>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<a href="game.php?game=<?php echo $gameid; ?>" type="button" class="btn btn-primary">
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
	<img class="card-img" src="<?php echo $mod['banner']; ?>" alt="Game banner image">
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
		<div class="tab-pane fade border rounded-bottom border-top-0 p-3 show active" id="description" role="tabpanel">
			<?php echo $mod["description"];?>
		</div>
		<div class="tab-pane fade border rounded-bottom border-top-0 p-3" id="downloads" role="tabpanel">
			<?php
			$otherPrinted = 0;
			if(count($mod["torrents"]) == 0)
			{
				echo "<h4 class='mt-1'>This mod currently doesn't have any files.</h4>";
			}
			foreach($mod["torrents"] as $torrent)
			{
				if($torrent['type'] == 'main') echo "<h4 class='mt-1'>Main file</h4>";
				else if($torrent['type'] == 'xtra' && $otherPrinted == 0)
				{
					echo "<h4>Other files</h4>";
					$otherPrinted = 1;
				}
				?>
				<div class="card my-4">
					<img class="card-img-top" src="<?php echo $torrent['banner'] ?>" alt="Torrent image">
					<div class="card-body">
						<h5 class="card-title">
							<?php echo $torrent['name']; ?>
						</h5>
						<p class="card-text">
							<?php echo $torrent['description'] ?>
						</p>
						<div class="btn-group">
							<a	href="<?php echo $torrent['versions'][0]['torrent']; ?>"
								type="button" class="btn btn-primary">Download</a>
							<button	type="button"
								class="btn btn-primary dropdown-toggle dropdown-toggle-split"
								data-toggle="dropdown">
								<span><?php echo $torrent['versions'][0]['version']; ?></span>
							</button>
							<div class="dropdown-menu">
								<?php
								foreach($torrent["versions"] as $version)
								{
								?>
									<a	class='dropdown-item'
										href="<?php echo $version["torrent"]; ?>">
										<?php echo $version["version"] ?>
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

<?php include_once "shared/bot.php"; ?>
