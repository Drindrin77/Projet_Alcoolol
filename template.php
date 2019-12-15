<!DOCTYPE html>	

<html lang="fr">
	<head>
		<title>		
			<?php echo $mod->getControleur()->getVue()->getTitre();?>
		</title>
		<?php require_once "css/import.php"?>

	</head>
	
	<body id="bodyMain" class="main-container">
		<header>
			<?php require_once "components/header.php";?>
		</header>

		<section id="sectionTemplate" class="ui container">
			<?php echo $mod->getControleur()->getVue()->getContenu();?>
		</section>

		<footer id="footer" class="footer">
			<?php require_once "components/footer.php";?>
		</footer>
	</body>
	
	
</html>
