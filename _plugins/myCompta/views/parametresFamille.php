<div class="content three_quarter">	
	<!-- Affichage de la partie contenu -->
	<div class='titre'>
		<h4><strong>GESTION DES FAMILLES</strong></h4>
	</div>
	
	<div id='liste'>
		<a href="index.php?module=myCompta&rubrique=parametres&param=familles&action=ajout">
			<button type="button" class="btn btn-success pull-right"><span class='glyphicon glyphicon-plus'></span> NOUVELLE FAMILLE</button>
		</a>
		<?php 
		// On va créer notre tableau
		creationTableau($argsTableau);
		?>
	</div>

	<div id=formulaire>
		<form class='col-xs-4' method=post action='index.php?module=myCompta&rubrique=parametres&param=familles'>
			<input type=hidden name=formulaire value=Famille>
			<?php echo ($monObjet->getValeur('idFamille')) ? '<input type=hidden name="idFamille" value=' . $monObjet->getValeur('idFamille') . '>':"";?>
			<label for='nomFamille'>Nom </label><input type='text' name='nomFamille' id='nomFamille' <?php echo ($monObjet->getValeur('nomFamille')) ? 'value="' . $monObjet->getValeur('nomFamille') . '"' :"";?> class="form-control">
			<input type='submit' name='enreg' value=<?php echo ($monObjet->getValeur('idFamille')) ? 'Modifier':'Ajouter';?> class="btn btn-success"><br />
		</form>
	</div>
</div>

<script>
	// Fonction pour la gestion du formulaire operation
	function formulaire(afficheFormulaire) {
		if (afficheFormulaire == '1') {
			$('#formulaire').show();
			$('#liste').hide();
		}
		else {
			$('#formulaire').hide();
			$('#liste').show();
		}
	}

	$(function() {
		// Fonction qui va affiche le tableau au chargement du programme
		$(document).ready(function() {
			afficheFormulaire = <?php echo ((isset($_GET['action']) OR $monObjet->getValeur('idFamille')) ? '1' : '0'); ?>;
			formulaire(afficheFormulaire);
		});
	});
</script>
