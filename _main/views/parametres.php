<div class="wrapper row3">
	<div class="hoc container clear"> 
    	<div class="content"> 
				<article>
					<h3>GESTION DES PARAMETRES</h3>
				</article>
				<article>
					<a class='parametre' id='profil' href=''>MON PROFIL</a>
					<?php
					// On affiche les modifications de paramètres que pour les administrateurs
					if ($_SESSION['droit'] === '9') {
					?>
						<a class='parametre' id='general' href=''>GENERAL</a>
						<a class='parametre' id='user' href=''>UTILISATEURS</a>
					<?php }	?>
				</article>
				<article>
					<div id='param'>
					</div>
				</article>
		</div>
	</div>
</div>

<script src="<?php echo $GLOBALS['root']; ?>_main/scripts/parametres.js"></script>
<script>
$(function() {
	// Au chargement de la page, on affiche les paramètres de profil
	$(document).ready(function() {
    	messageChargement('param','Chargement des paramètres');
    	$('#param').load('_main/viewModels/parametres.php',
    			{	affiche: 'profil',
    			},masqueFormulaire);
      });	


	// Fonctions qui vont afficher la page de paramètre demandée
    $("a.parametre").click(function(event){
        event.preventDefault();
    	messageChargement('param','Chargement des paramètres');
    	$('#param').load('_main/viewModels/parametres.php',
    			{	affiche: $(this).attr("id"),
    			},masqueFormulaire);
      });
});
</script>
