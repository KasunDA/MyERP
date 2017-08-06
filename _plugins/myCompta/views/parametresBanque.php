<div class="content three_quarter">		
	<!-- Affichage de la partie contenu -->
	<div class='col-xs-6'>
		<h4><strong>GESTION DES BANQUES</strong></h4>
	</div>
	<div id='liste'>
		<a href="index.php?module=myCompta&rubrique=parametres&param=banques&action=ajout">
			<button type="button" class="btn btn-success pull-right" id="newBanque"><span class='glyphicon glyphicon-plus'></span> NOUVELLE BANQUE</button>
		</a>
		<?php 
			// On va créer notre tableau
		creationTableau($argsTableau);
		?>
	</div>
	<div id='formulaire' class='formulaire'>
		<form class='col-xs-4' method=post action='index.php?module=myCompta&rubrique=parametres&param=banques'>
			<?php echo ($monObjet->getValeur('idBanque')) ? '<input type=hidden name="idBanque" value=' . $monObjet->getValeur('idBanque') . '>':"";?>
			<input type=hidden name=formulaire value=Banque>
			<div class="three-quarter pull-right">
				<label for="onArchive" class="onArchive right form-control">Archivée</label> <input type=checkbox name='onArchive' id='onArchive' <?php echo ($monObjet->getValeur('onArchive') === '1' ? "CHECKED": ""); ?>>
			</div>
			<div class="one-line">
				<div class='one_quarter first'>
					<span class='long100'><label for='nom'>Nom </label></span>
				</div>
				<div class='two_quarter'>
					<input type='text' name='nomBanque' id='nom' <?php echo ($monObjet->getValeur('nomBanque')) ? 'value="' . $monObjet->getValeur('nomBanque') . '"' :"";?>>
				</div>
			</div>
			<div class="one-line">
				<div class='one_quarter first'>
					<label for='telephone'>Téléphone </label>
				</div>
				<div class='two_quarter'>
					<input type='text' name='telephone' id='telephone' <?php echo ($monObjet->getValeur('telephone')) ? 'value="' . $monObjet->getValeur('telephone') . '"' :"";?> class="form-control">
				</div>
			</div>
			<div class="one-line">
				<div class='one_quarter first'>
					<label for='email'>Email </label>
				</div>
				<div class='two_quarter'>
					<input type='text' name='email' id='email' <?php echo ($monObjet->getValeur('email')) ? 'value="' . $monObjet->getValeur('email') . '"' :"";?> class="form-control"><br />
				</div>
			</div>
			<div class="one-line">
				<div class='one_quarter first'>
					<label for='url'>URL </label>
				</div>
				<div class='two_quarter'>
					<input type='text' name='url' id='url' <?php echo ($monObjet->getValeur('url')) ? 'value="' . $monObjet->getValeur('url') . '"' :"";?> class="form-control"><br />
				</div>
			</div>	
			<div class='one-line'>
				<div class='one_quarter first'>
					<button type='submit' name='enreg' class="btn btn-success"><?php echo ($monObjet->getValeur('idBanque')) ? 'Modifier':'Ajouter';?></button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	// Fonction pour la gestion du formulaire operation
	function formulaire(afficheFormulaire) {
		if (afficheFormulaire == '1') {
			$('#liste').hide();
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
			afficheFormulaire = <?php echo ((isset($_GET['action']) OR $monObjet->getValeur('idBanque')) ? '1' : '0'); ?>;
			formulaire(afficheFormulaire);
		});
	});

	function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
	$(document).on("keydown", disableF5);

</script>
