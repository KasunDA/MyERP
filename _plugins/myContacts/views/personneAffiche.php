<?php if ($_SESSION[$nomPlugin] >= 1) {?>
	<div class="content three_quarter">
	
		<h6><strong><?php echo $monObjet->getValeur('civilite'); ?> <?php echo $monObjet->getValeur('nom'); ?> <?php echo $monObjet->getValeur('prenom'); ?></strong></h6>
		<div class="one-quarter pull-right">
			<label for="onArchive" class="onArchive right form-control">Archivé</label> <input type=checkbox name='onArchive' id='onArchive' <?php echo ($monObjet->getValeur('onArchive') === '1' ? "CHECKED": ""); ?> DISABLED>
		</div>
				
		<div class='group optionsAffiche btmspace-30'>
			<div class='one_quarter first'>
				<label><strong>Adresse Postale</strong></label>
			</div>
	
			<div class='three_quarter'>
			<?php echo $monObjet->getValeur('numVoie'); ?> <?php echo $monObjet->getValeur('indRepetition'); ?> <?php echo $monObjet->getValeur('libelleVoie'); ?><br>
			<?php echo $monObjet->getValeur('complementVoie'); ?><br>
			<?php 
				if ($monObjet->getValeur('idVille')) {
					require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myContacts/class/Ville.php';
					$maVille = new Ville(array('idObjet' => $monObjet->getValeur('idVille')));
					echo $maVille->getValeur('codePostal'); ?> <?php echo $maVille->getValeur('libelleVille'); } ?>
			
			</div>
		</div>
		
		<div class='group optionsAffiche btmspace-30'>
			<div class='one_quarter first'>
				<label><strong>Coordonnées</strong></label>
			</div>
			<div class='two_quarter'>
				<div><span class='fa fa-phone'></span> : <?php echo $monObjet->getValeur('telephone'); ?></div>
				<div><span class='fa fa-android'></span> : <?php echo $monObjet->getValeur('mobile'); ?></div>
				<div><span class='fa fa-envelope'></span> : <a href='mailto:<?php echo $monObjet->getValeur('email'); ?>'><?php echo $monObjet->getValeur('email'); ?></a></div>
			</div>
		</div>
			
		<div class='group optionsAffiche btmspace-30'>
			<div class='one_quarter first'>
				<label><strong>Ephéméride</strong></label>
			</div>
			<div class='two_quarter'>
				<div><span class='fa fa-birthday-cake'></span> : <?php echo baseToFormDate($monObjet->getValeur('dateNaissance')); ?></div>
			</div>
		</div>
	
		<div class='group'>
			<?php if ($_SESSION[$nomPlugin] >= 5) { ?>
				<a href='index.php?module=myContacts&rubrique=Personne&action=modif&id=<?php echo $monObjet->getValeur('idPersonne'); ?>'><button type=submit name="enreg" class="btn btn-info pull-right">Modifier</button></a>
			<?php } ?>
			<a href='index.php?module=myContacts&rubrique=Personne'><button type=submit name="retour" class="btn btn-info pull-right">Retour</button></a>
		</div>
	</div>
<?php } else 
	include '_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
?>

