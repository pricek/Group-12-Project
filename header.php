

	<header>
		Wholesale Management - <span id="username"> <b> <?php echo $_SESSION['logged_in_user'];?> </b></span>
	</header>
	<nav>
		<ul>
		<?php
		foreach ($content as $page => $location){
			echo "<li><a href='$location?user=".$user."' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
		}
		?>
		</ul>

	</nav>
