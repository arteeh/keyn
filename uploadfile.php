<?php
require_once 'libgame.php';
require_once 'libmod.php';

$modid = $_GET['modid'];
$filetitle = $filetorrent = $filedescription = $filebanner = "";

// Check if something is in post already
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$filetitle = $_POST['filetitle'];
	$filetorrent = $_POST['filetorrent'];
	$filedescription = $_POST['filedescription'];
	$filebanner = $_POST['filebanner'];
	
	createFile($modid,$filetitle,$filetorrent,$filedescription,$filebanner);
}

require_once 'top.php';

?>

<div class="jumbotron my-4">
	<h1 class="display-5">
		Add a new file to mod <?php echo $modid; ?>
	</h1>
	<form	class="my-4"
			method="post"
			action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
	>
		<div class="card form-group p-3">
			<div class="form-group">
				<input
					type="text"
					class="form-control"
					name="filetitle"
					value="<?php echo $filetitle; ?>"
					placeholder="File title"
				>
			</div>
			<div class="form-group">
				<div class="custom-file">
					<input	type="file"
							class="custom-file-input"
							id="customFile1"
							name="filetorrent"
					>
					<label	class="custom-file-label"
							for="customFile1"
							placeholder="Torrent"
					>
					Torrent
					</label>
				</div>
			</div>
			<div class="form-group">
				<input
					type="text"
					class="form-control"
					name="filedescription"
					value="<?php echo $filedescription; ?>"
					placeholder="File description (optional)"
				>
			</div>
			<div class="form-group">
				<div class="custom-file">
					<input	type="file"
							class="custom-file-input"
							id="customFile2"
							name="filebanner"
					>
					<label	class="custom-file-label"
							for="customFile2"
							placeholder="Banner image (optional)"
					>
					Banner image (optional)
					</label>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">
			Upload
		</button>
	</form>
</div>
		
<script>
// Show the name of the file on select
$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

<?php require_once 'bot.php' ?>