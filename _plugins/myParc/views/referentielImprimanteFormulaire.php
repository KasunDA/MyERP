<div class="col-xs-8">
	<form method=post action="index.php?module=myParc&rubrique=referentiel&param=imprimantes">
		<input type='hidden' name='formulaire' value='referentielImprimante'>
		<input type=hidden name='referenceOrdinateur' value="<?php //echo $monObjet->getValeur('idReferenceOrdinateur'); ?>"/>
		<label for="onArchive" class="onArchive right form-control">Archivé <input type=checkbox name='onArchive' <?php //echo ($monObjet->getValeur('onArchive') === '1' ? "CHECKED": ""); ?>></label>
		
		<fieldset>
			<legend>Informations Générales</legend>
			<div>
				<label>Type d'impression</label>
				<?php 
					// On va construire notre tableau pour créer le champ SELECT
					$tableSelect = array(
						'champCle' => 'typeMachine',
						'listeChoix' => array(
							setArraySelectListe('','----'),
							setArraySelectListe('ENCR','Jet d\'encres'),
							setArraySelectListe('THER','Thermique'),
							setArraySelectListe('LASNB','Laser (NB)'),
							setArraySelectListe('LASCOU','Laser (Couleurs)'),
							setArraySelectListe('MULNB','Multifonction Laser (NB)'),
							setArraySelectListe('MULCOU','Multifonction Laser (Couleurs)'),
							setArraySelectListe('COPNB','Copieur (NB)'),
							setArraySelectListe('COPCOU','Copieur (Couleur)'),
							),
						'champSelected' => ''
					);
					// On va appeler notre fonction de création de SELECT
					selectVariablesCreate($tableSelect) ;
				?>
			</div>
			
			<div id=constructeur></div>
			<label>Modèle</label><input type=text class='form-control' name='modele'>
			<label>Nom commercial</label><input type=text class='form-control' name='nomCommercial'>
			<label>Product Number (P/N)</label><input type=text class='form-control' name='productNumber'>
		</fieldset>
	
		<fieldset>
			<legend>Caractéristiques</legend>
			<div>
				<label>Mémoire</label><input type=text class='form-control' name='memoire'><br>
				<label>Carte Réseau</label><input type=checkbox name='reseau'>
			</div>
			
			<div id=constructeur></div>
		</fieldset>
			
		<button type=submit name="enreg" class="btn btn-info pull-right">Valider</button>
		<button id='retour' class="btn btn-warning pull-right">Retour</button>
	</form>
</div>


<script>
function listeConstructeurs() {
	//On charge la zone Tiers correspondant à une personne
	//idConstructeur = <?php //echo ($maClasse->getValeur('idConstructeur')) ? "'" . $maClasse->getValeur('idConstructeur') . "'" : 'null'; ?>;
	idConstructeur = '';
    $('#constructeur').load('_plugins/myContacts/scripts/myContacts.php',{
		source : 'AJAX',  			
		fonction: 'getListeObjet',
		plugin: 'myContacts',
		classe: 'Societe',
		miseEnForme: 'select',
		idSelected : idConstructeur,
       	label  : 'Constructeur', 
       	attrName : 'idConstructeur'
    });
};

function afficheTailleEcran() {
	$('#typeMachine').change(function() {
		if ($(this).val() == 'AIO' || $(this).val() == 'LAP' || $(this).val() == 'TAB') {
			$('#tailleEcran').show();
		}
		else {
			$('#tailleEcran').hide();
		}
	});
}
$(function() {

	$(document).ready(function() {
		listeConstructeurs();
		afficheTailleEcran();
		$('#tailleEcran').hide();
	});
});
</script>