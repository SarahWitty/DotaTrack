<link rel="stylesheet" type="text/css" href="<?php echo URL::base(); ?>resources/styles/mainpage.css" />
<div id="playerTitle">
	<h1><?=$playerName ?></h1>
	<a href="<?php echo URL::base(); ?>Login/logout">Logout</a>
</div>
<div id="modeMenu">
	<a id="matchesMode" class="modeButton" href="<?php echo URL::base(); ?>matches">
		Matches
	</a>
	<a id="statisticsMode" class="modeButton" href="<?php echo URL::base(); ?>statistics">
		Statistics
	</a>
	<div class="spacer"></div>
</div>
