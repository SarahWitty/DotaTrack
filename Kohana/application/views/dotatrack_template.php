<html>
	<head>
		<title>Dota Track</title>
		<link rel='stylesheet' href="<?php echo URL::base() ?>resources/styles/dotatrack.css">
		<link rel='stylesheet' href="<?php echo URL::base() ?>resources/styles/nv.d3.css">
		<link rel="shortcut icon" href="<?php echo URL::base() ?>resources/BrowserTabIcon.png?v=2">
		<script type="text/javascript" src="<?php echo URL::base() ?>resources/scripts/jquery-2.1.1.js"></script>
		<script type="text/javascript" src="<?php echo URL::base() ?>resources/scripts/d3.v3.js"></script>
		<script type="text/javascript" src="<?php echo URL::base() ?>resources/scripts/nv.d3.js"></script>
		<script type="text/javascript">
			<?=$javascript?>
		</script>
	</head>
	<body>
		<div id="logo">
			<?=$body?>
		</div>
	</body>
</html>
