<link rel="stylesheet" type="text/class" href="<?php echo URL::base(); ?>resources/styles/match.css" />
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
	<tr>
	<?php
	foreach($statistics as $static) {
		$counter = 0;
		echo "<tr>";
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
		echo "</tr>";
	}
	?>
	</tr>
</table>
