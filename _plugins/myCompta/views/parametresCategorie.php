<div class="content three_quarter">
	<div id='titre'>
		<h4><strong>GESTION DES CATEGORIES</strong></h4>
	</div>

	<div id='liste'>
		<a href="index.php?module=myCompta&rubrique=parametres&param=categories&action=ajout">
			<button type="button" class="btn btn-success pull-right"><span class='glyphicon glyphicon-plus'></span> NOUVELLE CATEGORIE</button>
		</a>
		<?php 
			// On va créer notre tableau
			creationTableau($argsTableau);
		?>
	</div>
	<div id='formulaire'>
		<form class='col-xs-4' method=post action='index.php?module=myCompta&rubrique=parametres&param=categories'>
			<div>
				<input type=hidden name=formulaire value=Categorie>
				<?php echo ($monObjet->getValeur('idCategorie')) ? '<input type=hidden name="idCategorie" value=' . $monObjet->getValeur('idCategorie') . '>':"";?>
			</div>
			<div class='one-line'>
				<label for='archive'>Archivé </label>
				<input type='checkbox' name='onArchive' id='archive' <?php echo ($monObjet->getValeur('onArchive')) ? 'CHECKED' :"";?> class="form-control">
			</div>
			<div id=famille class='one-line'></div>
			
			<div class='one-line'>			
				<label for='nomCategorie'>Nom </label>
				<input type='text' name='nomCategorie' id='nomCategorie' <?php echo ($monObjet->getValeur('nomCategorie')) ? 'value="' . $monObjet->getValeur('nomCategorie') . '"' :"";?> class="form-control" REQUIRED>
			</div>
			
			<div class='one-line'>
				<label>Type Operation </label>
				<select name='typeOperation'>
					<option value='D' <?php echo ($monObjet->getValeur('typeOperation') === 'D') ? 'SELECTED' :"";?>>Débit</option>
					<option value='C' <?php echo ($monObjet->getValeur('typeOperation') === 'C') ? 'SELECTED' :"";?>>Crédit</option>
				</select>
			</div>
			<div class='one-line'>
				<input type='submit' name='enreg' value=<?php echo ($monObjet->getValeur('idCategorie')) ? 'Modifier':'Ajouter';?> class="btn btn-success">
			</div>
		</form>
	</div>
</div>

<script>
	// Fonction pour la gestion du formulaire operation
	function formulaire(afficheFormulaire) {
		if (afficheFormulaire == '1') {
			//On charge la zone Banque
			idFamille = <?php echo ($monObjet->getValeur('idFamille')) ? "'" . $monObjet->getValeur('idFamille') . "'" : 'null'; ?>;
			$('#famille').load('_frameworks/myFrameWork/scripts/ajax.php',{
 				source : 'AJAX',
 				fonction: 'getListeObjet',
 				plugin: 'myCompta',
 				classe: 'Famille',
 				miseEnForme: 'select',	
 				label  : 'Famille',
 				attrName : 'idFamille',
 				valueName : 'idFamille',
 				valueSelected : idFamille,
 				disabled: false,
 				champAffiche: 'nomFamille',
 				urlAjout: false
	        });
			$('#formulaire').show();
			$('#liste').hide();;
		}
		else {
			$('#formulaire').hide();
			$('#liste').show();
		}
	}

	$(function() {
		// Fonction qui va affiche le tableau au chargement du programme
		$(document).ready(function() {
			afficheFormulaire = <?php echo ((isset($_GET['action']) OR $monObjet->getValeur('idCategorie')) ? '1' : '0'); ?>;
			formulaire(afficheFormulaire);
		});
	});
</script>