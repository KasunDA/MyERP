<div class="content three_quarter">
	<h6><strong>FORMULAIRE SAISIE: PERSONNE</strong></h6>
	<form method=post action="index.php?module=myContacts&rubrique=Personne">
		<input type=hidden name='idPersonne' value="<?php echo $monObjet->getValeur('idPersonne'); ?>"/>
		<input type=hidden name='formulaire' />
		
		<div class="one-quarter pull-right">
			<label for="onArchive" class="onArchive right form-control">Archivé</label> <input type=checkbox name='onArchive' id='onArchive' <?php echo ($monObjet->getValeur('onArchive') === '1' ? "CHECKED": ""); ?>>
		</div>
		<hr>
		
		<div>
			<h6>Identité</h6>
			<div class="one-line">
				<label for="civilite">Civilité</label>
				<select name=civilite class='form-control'>
				<option value='Mlle' <?php echo ($monObjet->getValeur('civilite') === 'Mlle' ? 'SELECTED' : ''); ?>>Mademoiselle
					<option value='Mme' <?php echo ($monObjet->getValeur('civilite') === 'Mme' ? 'SELECTED' : ''); ?>>Madame
					<option value='M' <?php echo ($monObjet->getValeur('civilite') === 'M' ? 'SELECTED' : ''); ?>>Monsieur
				</select>
				<input type='text' placeholder="Nom" name='nom' id="nom" value="<?php echo $monObjet->getValeur('nom'); ?>" REQUIRED/>
				<input placeholder="Nom de jeune fille" type='text' id="nomJF" name="nomJF" value="<?php echo $monObjet->getValeur('nomJF'); ?>"/>
				<input placeholder="Prenom" id="prenom" name="prenom" value="<?php echo $monObjet->getValeur('prenom'); ?>"/>
			</div>
		</div>
		<hr>
		
		<div>
			<h6>Adresse</h6>
			<div class="one-line">
				<input placeholder="N°" id="numVoie" name="numVoie" class='controlForm-int' value="<?php echo $monObjet->getValeur('numVoie'); ?>"/>
				<input placeholder="Indice" id="indRepetition" name="indRepetition" value="<?php echo $monObjet->getValeur('indRepetition'); ?>"/>
				<input placeholder="Libellé Voie" id="libelleVoie" name="libelleVoie" value="<?php echo $monObjet->getValeur('libelleVoie'); ?>"/>
			</div>
			<div class="one-form">		
				<input placeholder="Complément Voie" id="complementVoie" name="complementVoie" value="<?php echo $monObjet->getValeur('complementVoie'); ?>"/>
			</div>
			<div class="one-line">
				<input id="codePostal" placeholder="codePostal" id="codePostal"/>
				<span id=ville></span>
			</div>
		</div>
		<hr />
		<div>
			<h6>Coordonnées</h6>
			<div class="one-line">
				<input placeholder="Téléphone" class='controlForm-tel' id="telephone" name="telephone" value="<?php echo $monObjet->getValeur('telephone'); ?>">
				<input placeholder="Mobile" class='controlForm-tel' id="mobile" name="mobile" value="<?php echo $monObjet->getValeur('mobile'); ?>"/>
				<input placeholder="Email" class='controlForm-email' id="email" name="email" value="<?php echo $monObjet->getValeur('email'); ?>"/>
			</div>
		</div>
		<hr>
		<div>
			<h6>Ephéméride</h6>
			<div class="one-line">
				<input placeholder="Date de naissance" class='controlForm-date' id="dateNaissance" name="dateNaissance" value="<?php echo baseToFormDate($monObjet->getValeur('dateNaissance')); ?>">
			</div>
		</div>
		<button type=submit name="enreg" class="btn btn-info pull-right">Valider</button>
	</form>
</div>

<script src="/_plugins/myContacts/scripts/villes.js"></script>
<script>
	$(function() {
		$(document).ready(function() {
			controleFormulaire();
			<?php
				/* On va voir si une ville est présente dans la classe
				 * afin de l'afficher si besoin
				 */
				if ($monObjet->getValeur('idVille')) {
					require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myContacts/class/Ville.php';
					$maVille = new Ville(array('idObjet' => $monObjet->getValeur('idVille'))); ?>
							
					codePostal = <?php echo $maVille->getValeur('codePostal'); ?>;
					idVille = <?php echo $maVille->getValeur('idVille'); ?>;
					$('#codePostal').val(codePostal);
					getVilleSelect('ville','select','idVille','idVille',idVille,'libelleVille',label = null,true,url = false);
			<?php } ?>
		});
	
	
	
	
		// Fonction pour activer le champ ville si un code postal est saisi
		$('#codePostal').blur(function() {
		    getVilleSelect('ville','select','idVille','codePostal',$(this).val(),'libelleVille');
		});	
	});
</script>