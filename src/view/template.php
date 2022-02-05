<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?php echo $title ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="src/style/style.css" />
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>

	<nav class="menu">
		<ul>
		<?php
			foreach ($menu as $text => $link) {
				echo "<li><a href=\"$link\">$text</a></li>";
			}
		?>
		</ul>
	</nav>
	
	<main>
		<nav>
		<div class="sidebar-button">
			<i class='bx bx-menu sidebarBtn'></i>
			<span class="homepage">Homepage</span>
      	</div>
		</nav>

		<div class="section">
			<div class="content">
				<h1 class='title'><?php echo $title; ?></h1>
				<?php echo $content; ?>
				<?php if ($this->feedback !== '') { ?>
				<div class="feedback"><?php echo $this->feedback; ?></div>
				<?php } ?>
			</div>
		</div>
	</main>
	
	<script src="src/style/script.js"></script>
</body>
</html>