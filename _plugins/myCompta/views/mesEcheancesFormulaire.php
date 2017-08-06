<div class='corps'>
	<div class="container-fluid">
		<!-- Affichage de la partie contenu -->
		<section>
			<article>
				<form class='col-xs-9' method=post action='index.php?module=myCompta&rubrique=Echeance'>
					<?php echo ($maClasse->getValeur('idEcheance')) ? '<input type=hidden name="idEcheance" value=' . $maClasse->getValeur('idEcheance') . '>':"";?>
					<fieldset>
						<label>Type de mouvement</label>
						<?php echo ($maClasse->getValeur('idEcheance')? '<input type=hidden name=typeMouvement value=' . $maClasse->getValeur('typeMouvement') . '>':''); ?>
						<input type=radio class='typeMouvement' name="typeMouvement" value='O' CHECKED <?php echo ($maClasse->getValeur('idEcheance') ? 'DISABLED':'');?>> Operation
						<input type=radio class='typeMouvement' name="typeMouvement" value='V' <?php echo ($maClasse->getValeur('idEcheance')? 'DISABLED':'');?>> Virement
	
						
						<input 
							class='pull-right'
							type='checkbox' 
							name='onArchive' 
							<?php echo ($maClasse->getValeur('onArchive')) ? 'CHECKED' :"";?> 
							><label class='pull-right'>Archivé </label>
					</fieldset>
					
					<fieldset>
						<div class='row center'>
							<div class='col-xs-3'>
							<label>Intégration Automatique </label>
							<input 
								type='checkbox' 
								name='integrationAuto' 
								<?php echo ($maClasse->getValeur('integrationAuto')) ? 'CHECKED' :"";?> 
								>
							</div>
							<div class='col-xs-4'>
							<label>Recalcul écheances non intégrées </label>
							<input 
								type='checkbox' 
								name='recalculEcheancesPassees' 
								<?php echo ($maClasse->getValeur('recalculEcheancesPassees')) ? 'CHECKED' :"";?> 
								>
							</div>
							<div class='col-xs-5'>
							<label>Date échéance Variable (recalcul date opération) </label>
							<input 
								type='checkbox' 
								name='recalculDateEcheances' 
								<?php echo ($maClasse->getValeur('recalculDateEcheances')) ? 'CHECKED' :"";?> 
								>
							</div>
						</div>
						<hr>
						<label for=typePeriode>Periodicité</label>
						<div class="form-control">
							<input type="number" name="nbEntrePeriode" value="<?php echo ($maClasse->getValeur('nbEntrePeriode')) ? $maClasse->getValeur('nbEntrePeriode') :"";?>">
							<select name="typePeriode" >
								<option value="J" <?php echo ($maClasse->getValeur('typePeriode') === 'J') ? 'SELECTED' :"";?>>Jour</option>
								<option value="M" <?php echo ($maClasse->getValeur('typePeriode') === 'M') ? 'SELECTED' :"";?>>Mois</option>
								<option value="A" <?php echo ($maClasse->getValeur('typePeriode') === 'A') ? 'SELECTED' :"";?>>An</option>
							</select>
						</div>						
						<label for=dateDebut>Date de début</label>
						<input
							type="date"
							name="dateDebut"
							id="dateDebut"
							value="<?php echo ($maClasse->getValeur('dateDebut')) ? baseToFormDate($maClasse->getValeur('dateDebut')) : baseToFormDate(date('Y-m-j'));?>"
							class="form-control">
						<label for=dateFin>Date de fin</label>
						<input
							type="date"
							name="dateFin"
							id="dateFin"
							value="<?php echo ($maClasse->getValeur('dateFin') ? baseToFormDate($maClasse->getValeur('dateFin')) : null );?>"
							class="form-control">
					</fieldset>	
					
					<!-- Zone d'affiche du formulaire d'opération ou de virement -->
					<div id='mouvement'></div>
					
					<input 
						type='submit' 
						name='enreg' 
						value=<?php echo ($maClasse->getValeur('idEcheance')) ? 'modifier':'ajouter';?> 
						class="btn btn-success pull-right">
					<button id='retour' class="btn btn-warning pull-right">Retour</button>
				</form>
			</article>
		</section>
	</div>
</div>

<script src="_plugins/myCompta/scripts/myCompta.js"></script>
<script>
	// Fonction pour la gestion du formulaire operation
	function operation() {
		//On charge la zone compte
		idSelected = '<?php echo $maClasse->getValeur('operationIdCompte'); ?>';
        $('#compte').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Compte',
  			miseEnForme: 'select',
   			idSelected : idSelected,
           	label  : 'Compte', 
           	attrName : 'idCompte'
        });
		
		
		// On charge la zone catégorie
		typeOperation = '<?php echo ($maClasse->getValeur('operationType') ? $maClasse->getValeur('operationType'): 'D'); ?>';
		idCategorieSelected = '<?php echo $maClasse->getValeur('operationIdCategorie'); ?>';
		modeSelected = '<?php echo $maClasse->getValeur('operationMode'); ?>';
        $('#categorie').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Categorie',
  			miseEnForme: 'select',
   			idSelected : idCategorieSelected,
           	label  : 'Categorie', 
           	attrName : 'idCategorie',
           	typeOperation: typeOperation
        });
		//selectCategorie('myCompta','Categorie', 'operationIdCategorie', idCategorieSelected,'categorie','Categorie',typeOperation);
		afficheModeOperation(typeOperation,'operationMode',modeSelected);
		
		// On efface la zone de ventilation par défaut
		$('#zoneVentilation').html('');
		$('#zoneVentilation').hide('');

		// Fonction pour la gestion du type d'opération
		$('input[name=operationType]:radio').change(function(){
			modeSelected = '<?php echo $maClasse->getValeur('operationMode'); ?>';
	        $('#categorie').load('_plugins/myCompta/scripts/myCompta.php',{
	  			source : 'AJAX',
	  			fonction: 'getListeObjet',
	  			plugin: 'myCompta',
	  			classe: 'Categorie',
	  			miseEnForme: 'select',
	   			idSelected : idCategorieSelected,
	           	label  : 'Categorie', 
	           	attrName : 'idCategorie',
	           	typeOperation: this.value
	        });
			//selectCategorie('myCompta','Categorie', 'operationIdCategorie', idCategorieSelected,'categorie','Categorie',this.value);
			afficheModeOperation(this.value,'operationMode',modeSelected);
		});
	}

	// Fonction pour la gestion du formulaire operation
	function virement() {
		//On charge les zone de comptes
		idCompteEmetteurSelected = <?php echo ($maClasse->getValeur('virementIdCompteEmetteur')) ? "'" . $maClasse->getValeur('virementIdCompteEmetteur') . "'" : 'null'; ?>;
		idCompteDestinataireSelected = <?php echo ($maClasse->getValeur('virementIdCompteDestinataire')) ? "'" . $maClasse->getValeur('virementIdCompteDestinataire') . "'" : 'null'; ?>;

		// Zone Emetteur
        $('#compteEmetteur').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Compte',
  			miseEnForme: 'select',
   			idSelected : idCompteEmetteurSelected,
           	label  : 'Compte Emetteur', 
           	attrName : 'idCompteEmetteur'
        });

		// Zone Emetteur
        $('#compteDestinataire').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Compte',
  			miseEnForme: 'select',
   			idSelected : idCompteDestinataireSelected,
           	label  : 'Compte Destinataire', 
           	attrName : 'idCompteDestinataire'
        });
	}

	$(function() {
		// Fonction qui va affiche le tableau au chargement du programme
		$(document).ready(function() {
			messageChargement('mouvements','Chargement du mouvement');
			if ('<?php echo $maClasse->getValeur('typeMouvement'); ?>' == 'V') {
				$('#mouvement').load('_plugins/myCompta/scripts/myCompta.php',{
					fonction: 'echeanceVirement',
					idEcheance : '<?php echo $maClasse->getValeur('idEcheance'); ?>'},virement);
			}
			else {
				$('#mouvement').load('_plugins/myCompta/scripts/myCompta.php',{
					fonction: 'echeanceOperation',
					idEcheance : '<?php echo $maClasse->getValeur('idEcheance'); ?>'},operation);
			}
		});

		$('.typeMouvement').change(function(){
			switch($(this).attr("value")) {
				case 'V':
					messageChargement('mouvements','Chargement du mouvement');
					$('#mouvement').load('_plugins/myCompta/scripts/myCompta.php',{
						fonction: 'echeanceVirement',
						idEcheance : '<?php echo $maClasse->getValeur('idEcheance'); ?>'},virement);
					break;
				case 'O':
					messageChargement('mouvements','Chargement du mouvement');
					$('#mouvement').load('_plugins/myCompta/scripts/myCompta.php',{
						fonction: 'echeanceOperation',
						idEcheance : '<?php echo $maClasse->getValeur('idEcheance'); ?>'},operation);
					break;
				default:
					alert('Erreur');
					break;
			};
		});
	});
</script>
