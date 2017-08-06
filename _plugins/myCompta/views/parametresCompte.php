<div class="content three_quarter">
	<!-- Affichage de la partie contenu -->
	<div id='titre'>
		<h4><strong>GESTION DES COMPTES</strong></h4>
	</div>
	
	<div id='liste'>
		<a href="index.php?module=myCompta&rubrique=parametres&param=comptes&action=ajout">
			<button type="button" class="btn btn-success pull-right"><span class='glyphicon glyphicon-plus'></span> NOUVEAU COMPTE</button>
		</a>
		<?php 
			// On va créer notre tableau
			creationTableau($argsTableau);
		?>
	</div>

	<div id=formulaire>
		<form class='col-xs-4' method=post action='index.php?module=myCompta&rubrique=parametres&param=comptes'>
			<input type=hidden name=formulaire value=Compte>
			<?php echo ($monObjet->getValeur('idCompte')) ? '<input type=hidden name="idCompte" value=' . $monObjet->getValeur('idCompte') . '>':"";?>
			<div class='one-line'>
				<label for='comptePrincipal'>Compte Principal</label>
				<input type='checkbox' name='comptePrincipal' id='comptePrincipal' <?php echo ($monObjet->getValeur('comptePrincipal')) ? 'CHECKED' :"";?> class="form-control">
				<label for='archive'>Archivé </label>
				<input type='checkbox' name='onArchive' id='archive' <?php echo ($monObjet->getValeur('onArchive')) ? 'CHECKED' :"";?> class="form-control">
			</div>
			
			<div class='one-line'>
				<div class='one_quarter first'>
					<label for='libelleCompte'>Banque</label>
				</div>
				<div id=banque class='two_quarter'></div>
			</div>

			<div class='one-line'>
				<div class='one_quarter first'>
					<label for='libelleCompte'>Libellé</label>
				</div>
				<div class='two_quarter'>
					<input type='text' name='libelleCompte' id='libelleCompte' <?php echo ($monObjet->getValeur('libelleCompte')) ? 'value="' . $monObjet->getValeur('libelleCompte') . '"' :"";?> class="form-control" REQUIRED>
				</div>
			</div>
			
			<div class='one-line'>
				<div class='one_quarter first'>
					<label for='libelleCompte'>Titulaire</label>
				</div>
				<div id=titulaire class='two_quarter'></div>
			</div>
			
			<div class='one-line'>
				<div class='one_quarter first'>
					<label for='soldeInitial'>Solde initial </label>
				</div>
				<div class='two_quarter'>					
					<input type='text' name='soldeInitial' id='soldeInitial' <?php echo ($monObjet->getValeur('soldeInitial')) ? 'value="' . $monObjet->getValeur('soldeInitial') . '"' :"0.00";?> class="form-control">
				</div>
			</div>
			
			<div class='one-line'>
				<div class='one_quarter first'>
					<button type='submit' name='enreg' class="btn btn-success"><?php echo ($monObjet->getValeur('idCompte')) ? 'Modifier':'Ajouter';?></button>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="<?php echo $GLOBALS['root'] .'_plugins/myCompta/scripts/myCompta.js'; ?>"></script>
<script>
	// Fonction pour la gestion du formulaire operation
	function formulaire(afficheFormulaire) {
		if (afficheFormulaire == '1') {
			$('#liste').hide();
			//On charge la zone Banque
			idBanque = <?php echo ($monObjet->getValeur('idBanque')) ? "'" . $monObjet->getValeur('idBanque') . "'" : 'null'; ?>;
			selectMyCompta('Banque',{nomChamp: 'banque', idSelect: idBanque, libelle: null});

			//On charge la zone Titulaire
			idTitulaire = <?php echo ($monObjet->getValeur('idTitulaire')) ? "'" . $monObjet->getValeur('idTitulaire') . "'" : 'null'; ?>;
			$('#titulaire').load('_frameworks/myFrameWork/scripts/ajax.php',{
 				source : 'AJAX',
 				fonction: 'getListeObjet',
 				plugin: 'myContacts',
 				classe: 'Personne',
 				miseEnForme: 'select',	
 				label  : 'Titulaire',
 				attrName : 'idTitulaire',
 				valueName : 'idPersonne',
 				valueSelected : idTitulaire,
 				disabled: false,
 				champAffiche: ['nom', 'prenom'],
 				urlAjout: false
			});
			$('#formulaire').show();
		}
		else {
			$('#formulaire').hide();
			$('#liste').show();
		}
	}

	$(function() {
		// Fonction qui va affiche le tableau au chargement du programme
		$(document).ready(function() {
			afficheFormulaire = <?php echo ((isset($_GET['action']) OR $monObjet->getValeur('idCompte')) ? '1' : '0'); ?>;
			formulaire(afficheFormulaire);
		});
	});
</script>
