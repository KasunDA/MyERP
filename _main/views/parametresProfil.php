<div class='content three_quarter'>
	<form method="post" action='index.php?module=parametres&rubrique=Profil'>
		<input type='hidden' name='formulaire'>
		<input type='hidden' name='profil'>
		<input type='hidden' name='idUser' value='<?php echo $user->getValeur('idUser'); ?>'>
		<h6><strong>GESTION DU PROFIL</strong></h6>
		<hr>
		<div class='group'>
			<h6>Identité</h6>
			
			<div class='one-line'>
				<div class='two_quarter first'>
					<strong><label>Utilisateur: <?php echo $user->getValeur('utilisateur'); ?></label></strong>
				</div>

			</div>
			<div class='one-line'>
				<div class='two_quarter first'>
					<label>Choix du contact</label>
				</div>
				<div class='two_quarter' id='contact'>
				</div>
			</div>
		</div>
		<hr>
		<div class='group'>
			<h6>Modifier Mot de passe</h6>
			
			<div class='one-line'>
				<div class='two_quarter first'>
					<label>Mot de passe</label>	
				</div>
				<div class='two_quarter'>
					<input type=password id="mdp" class='controlForm-pass'>
				</div>
			</div>
			<div class='one-line'>
				<div class='two_quarter first'>
					<label>Ressaisir mot de passe</label>	
				</div>
				<div class='two_quarter'>
					<input type=password id="password" name='' class='controlForm-pass'>
				</div>
			</div>
		</div>
		<hr>
		<div class='group'>
			<h6>Interface Graphique</h6>
			
			<div class='one-line'>
				<div class='two_quarter first'>
					<label for='template'>Template</label>
				</div>
			</div>
			<div class='two_quarter'>
				<select id='template' name='template' class='form-control'>
					<?php
					foreach ($listeTemplate as $dossier){
						?>
						<option value="<?php echo $dossier; ?>" <?php echo ($dossier === $user->getValeur('template')? 'SELECTED' : ''); ?>><?php echo $dossier; ?>
						<?php 
					}
					?>
				</select>
			</div>
		</div>
		<hr>
		<div class='one-line'>
			<div class='three_quarter'>
			<button type=submit name='enreg' id='enreg' class='btn btn-succes pull-right'>Valider</button>
			</div>
		</div>
	</form>
</div>

<script src="/_plugins/myContacts/scripts/myContacts.js"></script>
<script>
	$(function() {
		$(document).ready(function() {
			// On active le controle des formulaires
			controleFormulaire();
			
			//On charge la zone Personne
			idPersonne = <?php echo ($user->getValeur('idPersonne')> 0 ? "'" . $user->getValeur('idPersonne'). "'" : 'null'); ?>;
			getSelect('Personne',{nomChamp: 'contact', idSelect: idPersonne, libelle: null});
		});

		// Vérification à la validation du formulaire
		$('#enreg').click(function(e){
			if ($('#mdp').val() !== $('#password').val()) {
				// On annule l'enregistrement et on avertit l'utilisateur
				alert('Les mots de passe ne correspondent pas.\nMerci de les ressaisir');
				e.preventDefault();
			}
			else {
				// On enregistre uniquement la modification du mot de passe si le champ a été renseigné
				if ($('#password').val() !== '') {
					$('#password').attr('name','pass');
				}
				// On avertit l'utilisateur de se déconnecter
				alert('Merci de vous déconnecter et de vous reconnecter afin de prendre vos modifications en charge');
			}
		});

	});
</script>