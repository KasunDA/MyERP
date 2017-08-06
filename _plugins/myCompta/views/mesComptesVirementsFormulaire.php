<div class='corps'>
	<div class="container-fluid">
	<!-- Affichage de la partie contenu -->
		<section>
			<article>
				<form class='col-xs-4' method=post action='index.php?module=myCompta&rubrique=Compte&idCompte=<?php echo $_GET['idCompte']; ?>'>
					<input type=hidden name='classe' value='Virement'>
					<input type='hidden' name='formulaire' value='virement'>
					<?php echo ($maClasse->getValeur('idVirement')) ? '<input type=hidden name="idVirement" value=' . $maClasse->getValeur('idVirement') . '>':"";?>
					
					<fieldset class=''>
						<div class='pull-right'>  
							<label>Rapproché </label>
							<input type='checkbox' name='estRapproche' <?php echo ($maClasse->getValeur('estRapproche')) ? 'CHECKED' :"";?>>
						</div>
						<label for='date'>Date </label>
						<input type='date' name='date' id='date' <?php echo ($maClasse->getValeur('date')) ? 'value=' . baseToFormDate($maClasse->getValeur('date')) :'value=' . date('d-m-Y');?> class="form-control">
						<div id="compte"></div>
					</fieldset>	
			
					<fieldset>
						<div id="compteEmetteur"></div>
						<div id="compteDestinataire"></div>
					</fieldset>
			
					<fieldset>
						<label for='description'>Description </label>
						<input type='text' name='description' id='description' <?php echo ($maClasse->getValeur('description')) ? 'value="' . $maClasse->getValeur('description') . '"' :"Transfert de fonds";?> class="form-control">
						<label for='montant'>Montant </label>
						<input type='text' name='montant' id='montant' <?php echo ($maClasse->getValeur('montant')) ? 'value=' . $maClasse->getValeur('montant') :"";?> class="form-control">
					</fieldset>
			
					<input type='submit' name='enreg' value=<?php echo ($maClasse->getValeur('idVirement')) ? 'Modifier':'Ajouter';?> class="btn btn-success pull-right">
					<button id='retour' class="btn btn-warning pull-right">Retour</button>
				</form>
			</article>
		</section>
	</div>
</div>

<script src="_plugins/myCompta/scripts/operations.js"></script>
<script>
$(function() {
	// Fonction qui va affiche le tableau au chargement du programme
	$(document).ready(function() {
		//On charge les zone de comptes
		idCompteEmetteurSelected = <?php echo ($maClasse->getValeur('idCompteEmetteur')) ? "'" . $maClasse->getValeur('idCompteEmetteur') . "'" : $_GET['idCompte']; ?>;
		idCompteDestinataireSelected = <?php echo ($maClasse->getValeur('idCompteDestinataire')) ? "'" . $maClasse->getValeur('idCompteDestinataire') . "'" : $_GET['idCompte']; ?>;

		// Zone Emetteur
        $('#compteEmetteur').load('_plugins/myCompta/scripts/myCompta.php',{
  			source : 'AJAX',
  			fonction: 'getListeObjet',
  			plugin: 'myCompta',
  			classe: 'Compte',
  			miseEnForme: 'select',
   			idSelected : idCompteEmetteurSelected,
           	label  : 'Compte Emetteur', 
           	attrName : 'idCompteEmetteur',
           	rupture : 'nomBanque'
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
           	attrName : 'idCompteDestinataire',
           	rupture : 'nomBanque'
        });
	});	
});
</script>