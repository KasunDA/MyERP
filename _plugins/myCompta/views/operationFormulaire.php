<?php require_once '_frameworks/myFrameWork/fonctions/myERP.php'; ?>
<?php require_once '_plugins/myCompta/scripts/myCompta.php'; ?>

<div class="content three_quarter">
	<h4><?php echo ($monObjet->getValeur('idOperation') > 0 ? 'MODIFICATION' : 'AJOUT'); ?> D'UNE OPERATION</h4>
	<!-- Affichage de la partie contenu -->
	<form method=post action='index.php?module=myCompta&rubrique=Compte&idCompte=<?php echo $monCompte->getValeur('idCompte'); ?>'>
		<input type='hidden' name='formulaire' value='operation'>
		<?php echo ($monObjet->getValeur('idOperation')) ? '<input type=hidden name="idOperation" value=' . $monObjet->getValeur('idOperation') . '>':"";?>
		<?php echo ($monObjet->getValeur('idEcheance')) ? '<input type=hidden name="idEcheance" value=' . $monObjet->getValeur('idEcheance') . '>':"";?>
		
		<div class='one-line pull-right'>
			<label>Ventilé </label>
			<input type='checkbox' name='estVentile' id='ventilation' <?php echo ($monObjet->getValeur('estRapproche')) ? 'CHECKED' :"";?> disabled>   
			<label>Rapproché </label>
			<input type='checkbox' name='estRapproche' <?php echo ($monObjet->getValeur('estRapproche')) ? 'CHECKED' :"";?>>
		</div>
		
		<div class='one-line'>
			<label for='date'>Date </label>
			<input type='date' name='date' id='date' <?php echo ($monObjet->getValeur('date') ? 'value="' . baseToFormDate($monObjet->getValeur('date')) . '"' :'value="' . date('d-m-Y') . '"');?> class="form-control">
		</div>
		
		<div class='group btmspace-15 optionsAffiche'>
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Compte</label>
				</div>
				<div class='three_quarter'>
					<div id="compte"></div>
				</div>
			</div>
			<div class='one_quarter first'>
				<label for='type'>Type d'opération </label>
			</div>
			<div class='three_quarter'>
				<input type='radio' name='type' value='D' CHECKED> Débit
				<input type='radio' name='type' value='C' <?php echo ($monObjet->getValeur('type') === 'C') ? 'CHECKED' :'';?>> Crédit
			</div>
			
			<div class='one_quarter first'>
				<label>Mode de paiement</label>
			</div>
			<div class='three_quarter one-line'>
				<div id='mode'></div>
			</div>
			
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Catégorie</label>
				</div>
				<div class='three_quarter'>
					<div id="categorie"></div>
				</div>
			</div>
		</div>

		<div class='group btmspace-15 optionsAffiche'>
			<div class='one_quarter first'>
				<label for='typeTiers'>Tiers </label>
			</div>
			<div class='one_quarter'>
				<div id="tiers"></div>
			</div>
			<!-- <div class='two_quarter one-line'>
					<label>Carnet d'adresses</label>
					<select id=typeTiers name=typeTiers>
						<option value=''>
						<option value=P> Personne 
						<option value=S> Société
					</select>

			</div> -->
			
			<div class='one_quarter first'>
				<label for='description'>Description </label>
			</div>
			<div class='three_quarter'>
				<input type='text' name='description' id='description' <?php echo ($monObjet->getValeur('description')) ? 'value="' . $monObjet->getValeur('description') . '"' :"";?> class="form-control">
			</div>
			
			<div class='one_quarter first'>
				<label for='montant'>Montant </label>
			</div>
			<div class='three_quarter'>
				<input type='text' name='montant' id='montant' <?php echo ($monObjet->getValeur('montant')) ? 'value="' . $monObjet->getValeur('montant') .'"' :"";?> class="form-control">
			</div>				
		</div>
		
		<div class='one-line pull-right'>
			<button type='submit' name='enreg' value=<?php echo ($monObjet->getValeur('idOperation')) ? 'Modifier':'Ajouter';?> class="btn pull-right">Valider</button>
			<button id='retour' class="btn btn-warning pull-right">Retour</button>
		</div>
	</form>
</div>


<script src="_plugins/myCompta/scripts/myCompta.js"></script>
<script>
function choixTiers() {
	switch ($('#typeTiers').val()) {
		case 'P':
			//On charge la zone Tiers correspondant à une personne
			idTiers = <?php echo ($monObjet->getValeur('idTiers')) ? "'" . $monObjet->getValeur('idTiers') . "'" : 'null'; ?>;
	        $('#tiers').load('_plugins/myContacts/scripts/myContacts.php',{
	  			source : 'AJAX',  			
	  			fonction: 'getListeObjet',
	  			plugin: 'myContacts',
	  			classe: 'Personne',
	  			miseEnForme: 'select',
	   			idSelected : idTiers,
	           	label  : '', 
	           	attrName : 'idTiers'
	        });
			break;
		case 'S':
			//On charge la zone Tiers correspondant à une personne
			idTiers = <?php echo ($monObjet->getValeur('idTiers')) ? "'" . $monObjet->getValeur('idTiers') . "'" : 'null'; ?>;
	        $('#tiers').load('_plugins/myContacts/scripts/myContacts.php',{
	  			source : 'AJAX',  			
	  			fonction: 'getListeObjet',
	  			plugin: 'myContacts',
	  			classe: 'Societe',
	  			miseEnForme: 'select',
	   			idSelected : idTiers,
	           	label  : '', 
	           	attrName : 'idTiers'
	        });
			break;	
		default:
			$('#tiers').html('<input type=text placeholder=\'Nom du bénéficiaire\' name=\'beneficiaire\' <?php echo ($monObjet->getValeur('beneficiaire')) ? 'value="' . $monObjet->getValeur('beneficiaire') . '"' :"";?> class="form-control" >');
			break;	
	};
}
$(function() {
	// Fonction qui va gérer l'affichage d'une personne/société au niveau du tiers
	$('#typeTiers').change(function() {
		choixTiers();
	});

	// Fonction pour la gestion du type d'opération
	$('input[name=type]:radio').change(function(){
        $('#categorie').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Categorie',
  			miseEnForme: 'select',
   			idSelected : idCategorieSelected,
           	label  : null, 
           	attrName : 'idCategorie',
           	rupture: 'nomFamille',
           	typeOperation: this.value
        });
		afficheModeOperation(this.value,'mode');
	});

	// Fonction qui va affiche le tableau au chargement du programme
	$(document).ready(function() {
		//On charge la zone compte
		idSelected = <?php echo ($monObjet->getValeur('idCompte')) ? "'" . $monObjet->getValeur('idCompte') . "'" : 6; ?>;
        $('#compte').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Compte',
  			miseEnForme: 'select',
   			idSelected : idSelected,
           	label  : null, 
           	attrName : 'idCompte',
           	rupture: 'nomBanque',
           	urlAjout: null
        });
				
		// On charge la zone catégorie
		typeOperation = <?php echo ($monObjet->getValeur('type')) ? "'" . $monObjet->getValeur('type') . "'" : "'D'"; ?>;
		idCategorieSelected = <?php echo ($monObjet->getValeur('idCategorie')) ? "'" . $monObjet->getValeur('idCategorie') . "'" : "null"; ?>;
        $('#categorie').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Categorie',
  			miseEnForme: 'select',
   			idSelected : idCategorieSelected,
           	label  : null, 
           	attrName : 'idCategorie',
           	rupture: 'nomFamille',
           	typeOperation: typeOperation
        });

        // On affiche les type de paiement selon le type d'opération
        modeSelected = <?php echo ($monObjet->getValeur('mode')) ? "'" . $monObjet->getValeur('mode') . "'" : "null"; ?>;
		numCheque = <?php echo ($monObjet->getValeur('numCheque')) ? "'" . $monObjet->getValeur('numCheque') . "'" : "null"; ?>;
		afficheModeOperation(typeOperation,'mode',modeSelected,numCheque);

		choixTiers();
	});	
});
</script>
