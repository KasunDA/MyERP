<div class='content three_quarter'>
	<h6><strong>EDITION D'UN UTILISATEUR</strong></h6>
	<div class='group'>
		<hr>
		<form action='index.php?module=parametres&rubrique=User' method='post' class='userForm'>
			<input type=hidden name=formulaire>
			<input type=hidden name=idUser value='<?php echo $monObjet->getValeur('idUser'); ?>'>
			<div class='group'>		
				<div class='one-line'>
					<div class='pull-right'>
						<label>Archivé</label>
						<input type=checkbox>
					</div>
					<div class='one_quarter first'>
						<label for='utilisateur'>Nom d'utilisateur</label>
	
					</div>
					<div class='two_quarter'>
						<input type='text' name='utilisateur' id='user' placeholder="Nom d'utilisateur" class="controlForm-username" value='<?php echo $monObjet->getValeur('utilisateur'); ?>' REQUIRED>
					</div>
				</div>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label for='pass'>Mot de passe</label>
					</div>
					<div class='one_quarter'>
						<input type='password' id='pass' placeholder="Saisir mot de passe" class="controlForm-pass" value='<?php echo $monObjet->getValeur('pass'); ?>'  REQUIRED>
					</div>
					<div class='pull-right'>
						<input type='password' name='' id='password' placeholder="Ressaisir mot de passe"  class="controlForm-pass pull-right" value='<?php echo $monObjet->getValeur('pass'); ?>'>
					</div>
				</div>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Type d'accès</label>
					</div>
					<div class='one_quarter'>
						<select name=acces id='acces' class='form-control'>
							<option value=0 <?php echo ($monObjet->getValeur('acces') === '0' ? 'SELECTED': ''); ?>>Aucun Accès
							<option value=1 <?php echo ($monObjet->getValeur('acces') === '1' ? 'SELECTED': ''); ?>>Utilisateur
							<option value=9 <?php echo ($monObjet->getValeur('acces') === '9' ? 'SELECTED': ''); ?>>Administrateur
						</select>
					</div>

				</div>
			</div>
			<hr>
			<h6>Détails du contact</h6>
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Contact existant</label><input type=checkbox id='contactPlugin'>
				</div>
				<div id='contact' class='one_quarter'>
				</div>
			</div>
			<div id='userDetail' class='group'>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Nom</label>
					</div>
					<div class='one_quarter'>
						<input type='text' placeholder="Nom" class="controlForm-nom" name='nom' id="nom" value="<?php echo $monObjet->getValeur('nom'); ?>"/>
					</div>
				</div>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Prénom</label>
					</div>
					<div class='one_quarter'>
						<input placeholder="Prenom" id="prenom" class="controlForm-prenom" name="prenom" value="<?php echo $monObjet->getValeur('prenom'); ?>"/>
					</div>
				</div>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Email</label>
					</div>
					<div class='one_quarter'>
						<input placeholder="Email" id="email" class="controlForm-email" name="email" value="<?php echo $monObjet->getValeur('email'); ?>"/>
					</div>
				</div>
			</div>
			<div class='group'>
				<hr>
				<h6>Interface Graphique</h6>
				
				<div class='one-line'>
					<div class='one_quarter first'>
						<label for='template'>Template</label>
					</div>
				</div>
				<div class='one_quarter'>
					<select id='template' name='template'>
						<?php
						foreach ($listeTemplate as $dossier){
							?>
							<option value="<?php echo $dossier; ?>" <?php echo ($dossier === $monObjet->getValeur('template')? 'SELECTED' : ''); ?>><?php echo $dossier; ?>
							<?php 
						}
						?>
					</select>
				</div>
			</div>
			<div class='group'>
				<hr>
				<h6>Gestion des accès</h6>				
				<table>
					<tr>
						<th>Plugin</th>
						<th>Type d'accès</th>
					</tr>
					
					<?php foreach ($listePlugins as $plugin) { ?>
					<tr>
						<td><?php echo $plugin; ?></td>
						<td>
							<select name='<?php echo $plugin; ?>'>
								<option value=0 <?php echo ($monObjet->getDroit($plugin) === '0' ? 'SELECTED': ''); ?>>Aucun Accès
								<option value=1 <?php echo ($monObjet->getDroit($plugin)=== '1' ? 'SELECTED': ''); ?>>Utilisateur
								<option value=5 <?php echo ($monObjet->getDroit($plugin)=== '5' ? 'SELECTED': ''); ?>>Editeur
								<option value=9 <?php echo ($monObjet->getDroit($plugin)=== '9' ? 'SELECTED': ''); ?>>Administrateur
							</select>
						</td>
					</tr>
					<?php } ?>
				</table>	
			</div>
			<div class='one-line'>
				<button name='enreg' id='enreg' class='pull-right btn btn-default'>Valider</button>
				<button name='retour' id='retour' class='pull-right btn btn-default'>Retour</button>
			</div> 
		</form>
	</div>
</div>

<script src="/_plugins/myContacts/scripts/myContacts.js"></script>
<script>
	function afficheContact (idPersonne = null) {
		if ($('#contactPlugin').is(':checked') || idPersonne > 0)  {
			getSelect('Personne',{nomChamp: 'contact', idSelect: idPersonne, libelle: null});
			$('#userDetail :input').val('');
			$('#userDetail').hide();
			
		}
		else {
			$('#contact').html('');
			$('#userDetail').show();
		}
	}
	$(function() {
		$(document).ready(function() {
			// On active le controle des formulaires
			controleFormulaire();
			
			// Gestion de la zone contact
			idPersonne = <?php echo ($monObjet->getValeur('idPersonne')> 0 ? "'" . $monObjet->getValeur('idPersonne'). "'" : 'null'); ?>;
			afficheContact(idPersonne);
			$('#contactPlugin').change(function() {
				afficheContact();
			});
			
			// On réorganise notre fomulaire s'il s'agit d'une édition d'un utilisateur
			if (<?php echo ($monObjet->getValeur('idUser')> 0 ? "'" . $monObjet->getValeur('idUser'). "'" : 'null'); ?>) {
				$('#user').attr('disabled','disabled');
				$('#password').val('');
				$('#pass').val('');
				$('#pass').prop('required',false);
				if (idPersonne > 0) {
					$('#contactPlugin').attr('checked', 'checked');
				}
			} 
		});

		// On annule les champs required pour revenir en arrière
		$('#retour').click(function() {
			$( "#nom" ).prop('required',false);
			$( "#pass" ).prop('required',false);
		});

		// Vérification à la validation du formulaire
		$('#enreg').click(function(e){
			if ( $('#password').val() != $('#pass').val()) {
				e.preventDefault();
				alert('Les mots de passe ne correspondent pas\nMerci de reconfirmer');
			}
			else {
				$('#user').attr('disabled',false);
				if($('#password').val() !== '') {
					$('#password').attr('name','pass');
				}
			}
		});

	});
</script>