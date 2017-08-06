<?php 
if ((isset($_SESSION[$nomPlugin]) && $_SESSION[$nomPlugin] >= '1') || $_SESSION['niveauAccesGeneral'] === '9') {
?>
	<div class="content <?php echo $tailleContent; ?>">
		<?php
			if ($argsPage['titrePage']) { ?>
				<h6><strong><?php echo $argsPage['titrePage']; ?></strong></h6>
				<hr>
			<?php } 
		?>
	
		<?php
			// affichage du bandeau d'option
			include ('optionsAffichage.php');
		?>
		<input type=hidden id=numPageDebut value='1'>
		
		<div id='tableauListe'>
			<?php
				if ($argsPage['tableauDonnees']['nbPage'] > 0) {
					creationTableau($argsPage['tableauDonnees']);
				}
				else { ?>
					<div><strong>Pas de résultats</strong></div>
			<?php } ?>
		</div>
	</div>
	<script>
		function getArgsDefault() {
			return {
				plugin: '<?php echo $nomPlugin; ?>',
				classe: '<?php echo $nomClasse; ?>',
				urlAjout: '<?php echo $argsPage['tableauDonnees']['urlAjout']; ?>',
				nomChamp: 'tableauListe',
				afficheOption: '<?php echo ($argsPage['tableauDonnees']['options'] ? 'on' : ''); ?>',
				numPageDebut: $('#numPageDebut').val()
			};
		}
		$(function() {
			$(document).ready(function() {
				controleFormulaire();

				afficheTableauFiltre(getArgsDefault());
			});
		});
	</script>
<?php } else 
	include '_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
?>



