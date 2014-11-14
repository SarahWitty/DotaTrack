<link rel="stylesheet" type="text/class" href="<?php echo URL::base(); ?>resources/styles/match.css" />
<script type="text/javascript" src="<?php echo URL::base() ?>resources/scripts/matches.js"></script>
<h1>Matches page</h1>
<p>Normally, this would tell you useful information about matches.</p>
<table class="matchTable">
	<tr>
	<?php
	foreach($titles as $title) {
	?>
		<th class="<?=$title?>Header mHeader"><?=$title?></th>
	<?php
	}
	?>
	</tr>
	<tr id="loading">
		<td colspan="7">
			<div>Loading...</div>
		</td>
	</tr>
	<?php
	foreach($statistics as $static) {
		$counter = 0;
		?><tr><?php
		foreach($static as $property=>$value){
			if($counter == 0){
				?> 
				<td class="<?=$value?>Value mValue"">
					<a href="<?php echo URL::base() ?>Match/index/<?=$value?>"><?=$value?></a>
				</td> 
				<?php
				$counter++;
			} else{
	?>
			<td class="<?=$value?>Value mValue""><?=$value?></td>
	<?php
			}
		}
	?></tr><?php
	}
	?>
</table>
<div id="ourTest"></div>
