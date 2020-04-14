<nav class="m-0 p-0">
	<ul class="pagination my-auto">
		<!-- Link of the first page -->
		<li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
			<a class='page-link' href="game.php?
			game=<?php echo $gameid; ?>&
			<?php if($issearching) echo "query=$query&" ?>
			page=1&
			">First</a>
		</li>
		<!-- Link of the previous page -->
           <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
			<a class='page-link' href="game.php?
			game=<?php echo $gameid; ?>&
			<?php if($issearching) echo "query=$query&" ?>
			page=<?php ($page>1 ? print($page-1) : print 1)?>
			">Previous</a>
		</li>
		<!-- Links of the pages with page number -->
		<?php
		for($i=$start; $i<=$end; $i++)
		{
		?>
		<li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
			<a class='page-link' href="game.php?
			game=<?php echo $gameid; ?>&
			<?php if($issearching) echo "query=$query&" ?>
			page=<?php echo $i;?>
			"><?php echo $i;?></a>
		</li>
		<?php
		}
		?>
		<!-- Link of the next page -->
		<li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
			<a class='page-link' href="game.php?
			game=<?php echo $gameid; ?>&
			<?php if($issearching) echo "query=$query&" ?>
			page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>
			">Next</a>
		</li>
		<!-- Link of the last page -->
		<li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
			<a class='page-link' href="game.php?
			game=<?php echo $gameid; ?>&
			<?php if($issearching) echo "query=$query&" ?>
			page=<?php echo $total_pages;?>
			">Last</a>
		</li>
	</ul>
</nav>