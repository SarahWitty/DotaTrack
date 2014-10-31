<div id='appTitle'>
	<p>DOTA<br />TRACK</p>
</div>
<div id='login'>
	<form method='POST'>
		<p>PlayerId: <input type='text' name='pid'/><br /></p>
		<input type='submit' value="Login" name='submit' />
	<?php if ($has_pid):?>
		<p>Welcome, <?=$pid ?></p>
		<p>Match History:</p>
		<p><?php echo Debug::dump($output) ?></p>
	<?php endif;?>
	<p><?php  ?></p>
	</form>
</div>
