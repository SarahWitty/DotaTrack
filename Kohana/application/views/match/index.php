<link rel="stylesheet" type="text/class" href="<?php echo URL::base(); ?>resources/styles/match.css" />
<h1>Match page</h1>
<p>Normally, this would tell you useful information about a match.</p>
<!-- <pre><?php echo Debug::dump($output)?></pre> -->
<table class="matchTable">
	<tr>
	<?php
	foreach($match as $property=>$value) {
	?>
		<th class="<?=$property?>Header mHeader"><?=$property?></th>
	<?php
	}
	?>
	</tr>
	<tr>
	<?php
	foreach($match as $property=>$value) {
	?>
		<td class="<?=$value?>Value mValue"><?=$value?></td>
	
	<?php
	} ?>
	</tr>
</table>
<table class="performanceTable">
	<tr>
	<?php 
	foreach($performance[0] as $property=>$value) {
	?>
			<th class="<?=$property?>Header pHeader"><?=$property?></th>
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
			<td class="<?=$value?>Value pValue"><?=$value?></td>	
	<?php
		} 
	?>
	</tr>
	<?php
	} 
	?>

</table>

