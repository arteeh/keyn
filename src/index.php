<?php

include_once "shared/top.php";
include_once "shared/database.php";

$games = getFolderR("games",2);
$gamescount = count($games);

?>

<div class="jumbotron my-4">
	<h2 class="display-5">
		Keyndb is a website where you can find, upload and download video game mods.
	</h2>
	<hr class="my-4">
	<h5>
		Rather than downloading the mods directly however, you get a torrent file, which you can use to download the mod using your favourite torrenting software. While this is a small hoop to jump through for you, it has many benefits. For one, download speeds will be very high and will never be artificially limited like on the Nexus. Secondly, this keeps the bandwidth needs for this website low, making it much cheaper to host the site. Because of this, there is no need for ads or subscriptions. This website is still under development, but you can try it out if you want. Enjoy!
	</h5>
</div>

<div class="my-4 p-0">
	<div class="row justify-content-center p-0">
		<?php
		for($i = 0; $i < $gamescount; $i++)
		{
			?>
			<a class="item" href="game?game=<?php echo $i; ?>" >
				<div class="card text-dark m-1" style="width: 11.5rem;">
					<img class="card-img-top img-fluid" src="<?php echo $games[$i]['logo']; ?>" alt="Game logo">
					<div class="card-body">
						<h5 class="card-title">
							<?php echo $games[$i]['name']; ?>
						</h5>
						<!--
						<p class="card-text">
							<?php echo $games[$i]['description']; ?>
						</p>
						-->
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<?php echo $games[$i]['modcount']; ?>
							mods, 
							<?php echo $games[$i]['downloads']; ?>
							downloads
						</small>
					</div>
				</div>
			</a>
		<?php
		}
		?>
	</div>
</div>

<?php
include_once "shared/bot.php";
?>
