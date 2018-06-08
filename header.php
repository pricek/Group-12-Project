

	<header>
		Wholesale Management <span id="username"><?php echo $user;?></span>
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
