<?php 
if ((isset($_SESSION[$nomPlugin]) && $_SESSION[$nomPlugin] >= '9') || $_SESSION['niveauAccesGeneral'] === '9') {
?>
	<div class="content <?php echo $tailleContent; ?>">
	<h6><?php echo $lienPlugin; ?>: Mise à jour de la base de données</h6>
	<hr>
	<?php
	foreach ($listeClasse as $classe) {
		// On prépare les classes de notre plugins
		require_once $GLOBALS['root'] . '_plugins/' .  $lienPlugin . '/class/' . $classe;
		$classe = rtrim($classe,'.php');
		$maClasse = new $classe;

		// On met à jour notre classe
		$maClasse->majDefinitionObjetTable();
		echo 'Mise à jour de la classe ' . $classe . ': OK<br>'; 
	}
	?>
	</div>
<?php } ?>
