<?php 
if ((isset($_SESSION[$nomPlugin]) && $_SESSION[$nomPlugin] >= '1') || $_SESSION['niveauAccesGeneral'] === '9') {
?>		
	<div class="content <?php echo $tailleContent; ?>">
		<?php
			if ($argsPage['titrePage']) { ?>
				<h6><strong><?php echo $argsPage['titrePage']; ?></strong></h6>
			<?php } 
		?>
		<hr>
		<div id="pageVille">
			<?php
				// affichage du bandeau d'option
				include ('villesFiltreAffichage.php');
			?>
			<input type=hidden id=numPageDebut value='1'>
			
			<div id='tableauListe' class='center'>
				<p><strong>Merci d'utiliser la fonction Recherche pour charger la liste</strong></p>
				<p><em>Pour rappel, vous pouvez utiliser le caractère % pour compléter une chaine de caractère. Par exemple, la recherche 35% sur le code postal renverra toutes les villes du département 35.</em></p>
				<p><em>La commande de recherche %% permet d'afficher toutes les entrées de la base.</em></p>
			</div>
			<hr>
			<div class='four_quarter first center'>
				<button id=reset type="button" class="btn btn-success">REINITIALISER LISTE VILLES</button>
			</div>
		</div>
	</div>
	<script src="/_plugins/myContacts/scripts/villes.js"></script>
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


				$('#reset').click(function(e) {
					reponse = confirm('!! ATTENTION !! La réinitialisation des villes pourra entrainer une problème de lien avec les adresses\n\nEtes vous sur de vouloir réinitialiser la table des villes?');
					if (reponse) {					
						$('#pageVille').html('');
						messageChargement('pageVille','Réinitialisation des villes');
						$('#pageVille').load('_plugins/myContacts/fonctions/importVilles.php');
					}
					else {
						e.preventDefault();
					}
				});
			});
		});
	</script>
<?php } else 
	include '_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
?>
