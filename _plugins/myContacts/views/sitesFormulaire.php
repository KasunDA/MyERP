<div class="col-xs-8">
	<form method=post action="index.php?module=referentiel&option=societes&action=modif&id=<?php echo $monObjet->getValeur('idSociete'); ?>">
		<input type=hidden name='idSite' value="<?php echo $monObjet->getValeur('idSite'); ?>"/>
		<input type=hidden name='idSociete' value="<?php echo $monObjet->getValeur('idSociete'); ?>"/>
		<fieldset>
			<legend>Identification</legend>
			<div class="inline-form">
				<div class="inline-form">
					<label>Société</label>
					<span id="societe"></span>
				</div>
				<div class="inline-form" id="ville">
					<label for="libelleSite">Site</label>
					<input class="form-control" type='text' placeholder="Libellé Site" name='libelleSite' id="libelleSite" value="<?php echo $monObjet->getValeur('libelleSite'); ?>"/>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Coordonnées</legend>
			<div class="inline-form">
				<div class="inline-form">
					<label for="telephone">Téléphone</label>
					<input class="form-control" placeholder="Téléphone" id="telephone" name="telephone" value="<?php echo $monObjet->getValeur('telephone'); ?>"/>
				</div>
				<div class="inline-form">
					<label for="fax">Fax</label>
					<input class="form-control" placeholder="fax" id="fax" name="fax" value="<?php echo $monObjet->getValeur('fax'); ?>"/>
				</div>
				<div class="inline-form">
					<label for="mail">Email</label>
					<input class="form-control" placeholder="mail" id="mail" name="mail" value="<?php echo $monObjet->getValeur('mail'); ?>"/>
				</div>
				<hr />
			</div>
		</fieldset>
		<br />
		<button type=submit name="siteAction" class="btn btn-info pull-right">Valider</button>
	</form>
</div>

<script src="_scripts/jquery.js"></script>
<script src="_scripts/myScripts.js"></script>
<script>
$(function() {
	$('#libelleSite').blur(function(){
		resultat = controleText('libelleSite',<?php echo $monObjetDefinition['libelleSite']['longueurVarchar']; ?>);
	});
	$('#telephone').blur(function(){
		resultat = controleTel('telephone',<?php echo $monObjetDefinition['telephone']['longueurVarchar']; ?>);
	});
	$('#fax').blur(function(){
		resultat = controleTel('fax',<?php echo $monObjetDefinition['fax']['longueurVarchar']; ?>);
	});
	$('#mail').blur(function(){
		resultat = controleMail('mail',<?php echo $monObjetDefinition['mail']['longueurVarchar']; ?>);
	});
	

	// On va créer une fonction callback pour désactiver le champ select de la société
	function disableChampSociete() {
		$('#idSociete').prop('disabled', true);
	};
	
	// Fonction qui va affiche le tableau au chargement du programme
	$(document).ready(function() {		
		$('#societe').load('_default/fonctions/referentiel/societes.php',{idSociete: '<?php echo $monObjet->getValeur('idSociete'); ?>', fonction: 'champSelect'},disableChampSociete);
	});	
});
</script>