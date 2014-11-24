<link rel="stylesheet" type="text/class" href="<?php echo URL::base(); ?>resources/styles/match.css" />
<h1>Match page</h1>
<p>Normally, this would tell you useful information about a match.</p>
<table class="matchTable">
	<tr>
	<?php
	foreach($match as $property=>$value) {
	?>
		<th class="<?=$property?>Header header"><?=$property?></th>
	<?php
	}
	?>
	</tr>
	<tr>
	<?php
	foreach($match as $property=>$value) {
	?>
		<td class="<?=$value?>Value value"><?=$value?></td>
	
	<?php
	} ?>
	</tr>
</table>
<br />
<table class="performanceTable">
	<tr>
	<?php 
	foreach($performance[0] as $property=>$value) {
	?>
			<th class="<?=$property?>Header header"><?=$property?></th>
	<?php 
	}
	?>
	</tr>
	<?php
	foreach($performance as $performanceInfo) {
	?>
	<tr>
	<?php
		foreach($performanceInfo as $property=>$value) {
	?>
			<td class="<?=$value?>Value value"><?=$value?></td>	
	<?php
		} 
	?>
	</tr>
	<?php
	} 
	?>

</table>

