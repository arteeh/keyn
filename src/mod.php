<?php

include_once "common/database.php";

checkIfExists("mods",$_GET['id']);

include_once "common/top.php";

$mod = new Mod();
$mod->load($_GET['id']);
$mod->loadTorrentArray();

?>

<div class="btn-toolbar justify-content-between my-4" role="toolbar">
	<a href="game.php?id=<?=$mod->getGame()->getId()?>" type="button" class="btn btn-primary">
		Back to <?=$mod->getGame()->getName()?>
	</a>
	<span class="my-auto">
		Downloads: <?=$mod->getDownloadCount()?>
		&nbsp
		Seeders: <?=$mod->getSeederCount()?>
		&nbsp
		Leechers: <?=$mod->getLeecherCount()?>
	</span>
</div>

<div class="card bg-light text-white my-4">
	<img class="card-img" src="<?=$mod->getBanner()?>" alt="Game banner image">
	<div class="card-img-overlay text-shadow">
		<h2 class="card-title"><?=$mod->getName()?></h2>
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
		<div class="tab-pane fade border rounded-bottom border-top-0 p-3 show active"
			id="description" role="tabpanel">
			<?=$mod->getDescription()?>
		</div>
		<div class="tab-pane fade border rounded-bottom border-top-0 p-3"
			id="downloads" role="tabpanel">
			<?php
			$othersArePrinted = 0;
			if(count($mod->getTorrentArray()) == 0)
			{
				echo "<h4 class='mt-1'>This mod currently doesn't have any files.</h4>";
			}
			foreach($mod->getTorrentArray() as $torrent)
			{
				$torrent->loadVersionArray();
				
				if($torrent->getIsMain()) echo "<h4 class='mt-1'>Main file</h4>";
				else if($othersArePrinted == 0)
				{
					echo "<h4>Other files</h4>";
					$othersArePrinted = 1;
				}
				?>
				<div class="card my-4">
					<img class="card-img-top" src="<?=$torrent->getBanner()?>"
						alt="Torrent image">
					<div class="card-body">
						<h5 class="card-title">
							<?=$torrent->getName()?>
						</h5>
						<p class="card-text">
							<?=$torrent->getDescription()?>
						</p>
						<div class="btn-group">
							<a	href="<?=$torrent->getVersionArray()[0]->getFileName()?>"
								type="button" class="btn btn-primary">Download</a>
							<button	type="button"
								class="btn btn-primary dropdown-toggle dropdown-toggle-split"
								data-toggle="dropdown">
								<span><?=$torrent->getVersionArray()[0]->getNumber()?></span>
							</button>
							<div class="dropdown-menu">
								<?php
								foreach($torrent->getVersionArray() as $version)
								{
									?>
									<a class='dropdown-item'
									href="<?=$version->getFileName()?>">
										<?=$version->getNumber()?>
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
		<div class="tab-pane fade border rounded-bottom border-top-0 p-3"
		id="comments" role="tabpanel">
			<h4 class='mt-1'>Comments coming soon!</h4>
		</div>
	</div>
</div>

<?php include_once "common/bot.php"; ?>
