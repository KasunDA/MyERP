<div class="content three_quarter">
	<h4>FORMULAIRE SAISIE: SOCIETE</h4>
	<form method=post action="index.php?module=myContacts&rubrique=Societe">
		<input type=hidden name="idSociete" value="<?php echo $monObjet->getValeur('idSociete'); ?>"/>
		<input type=hidden name='formulaire' />
		
		
		<div class="one-quarter pull-right">
			<label for="onArchive" class="form-control">Archivé <input type='checkbox' name='onArchive' <?php echo ($monObjet->getValeur('onArchive') === '1' ? "CHECKED": ""); ?>></label>		
		</div>
		<hr>
		
		<div>
			<h6>Identité</h6>
			<div class="one-line">
				<!--  GESTION DE LA PARTIE PRINCIPALE DE LA SOCIETE -->
				<label for="Statut">Statut</label>
				<?php 
				// On va construire notre tableau pour créer le champ SELECT
				$tableSelect = array(
					'champCle' => 'statut',
					'listeChoix' => array(
						setArraySelectListe('','----'),
						setArraySelectListe('SARL','SARL'),
						setArraySelectListe('SAS','SAS'),
						setArraySelectListe('SA','SA')
						),
					'champSelected' => $monObjet->getValeur('statut')
				);
				// On va appeler notre fonction de création de SELECT
				selectVariablesCreate($tableSelect) ;
				?>
	
				<input class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php echo $monObjet->getValeur('nom'); ?>"/>
				<input class="form-control" name="enseigne"  id="enseigne" placeholder="Enseigne" value="<?php echo $monObjet->getValeur('enseigne'); ?>"/>
			</div>
		</div>

		<hr>
		<!--  GESTION DE LA PARTIE TYPE DE SOCIETE -->
		<div>
			<h6>Type de Société</h6>
			<div class="two-quarter one-line">
				<label for="fournisseur">Fournisseur</label>
				<input type="checkbox" name="fournisseur" <?php echo (($monObjet->getValeur('tableType')[0]['fournisseur']) ? "CHECKED" : "" ); ?>/>
				<label for="prestataire">Prestataire</label>
				<input type="checkbox" name="prestataire" <?php echo (($monObjet->getValeur('tableType')[0]['prestataire']) ? "CHECKED" : "" ); ?>/>
				<label for="client">Client</label>
				<input type="checkbox" name="client" <?php echo (($monObjet->getValeur('tableType')[0]['client']) ? "CHECKED" : "" ); ?>/>
				<label for="prospect">Prospect</label>
				<input type="checkbox" name="prospect" <?php echo (($monObjet->getValeur('tableType')[0]['prospect']) ? "CHECKED" : "" ); ?>/>
				<label for="constructeur">Constructeur</label>
				<input type="checkbox" name="constructeur" <?php echo (($monObjet->getValeur('tableType')[0]['constructeur']) ? "CHECKED" : "" ); ?>/>
				<label for="editeur">Editeur</label>
				<input type="checkbox" name="editeur" <?php echo (($monObjet->getValeur('tableType')[0]['editeur']) ? "CHECKED" : "" ); ?>/>
				<label for="client">Banque</label>
				<input type="checkbox" name="banque" <?php echo (($monObjet->getValeur('tableType')[0]['banque']) ? "CHECKED" : "" ); ?>/>
				<label for="Assurance">Assurance</label>
				<input type="checkbox" name="assurance" <?php echo (($monObjet->getValeur('tableType')[0]['assurance']) ? "CHECKED" : "" ); ?>/>	
			</div>
		</div>			
		
		<hr>
		<!--  GESTION DE LA PARTIE SITE PAR DEFAUT -->
		<div>
			<h6>SIEGE SOCIAL</h6>
			<div>
				<strong>Adresse</strong>
				<div class="one-line">
					<input placeholder="N°" id="numVoie" name="numVoie" value=""/>
					<input placeholder="Indice" id="indRepetition" name="indRepetition" value=""/>
					<input placeholder="Libellé Voie" id="libelleVoie" name="libelleVoie" value=""/>
				</div>
				<div class="one-form">		
					<input placeholder="Complément Voie" id="complementVoie" name="complementVoie" value=""/>
				</div>
				<div class="one-line">
					<input id="codePostal" placeholder="codePostal" id="codePostal"/>
					<span id=ville></span>
			</div>
			</div>
			
			<div>
				<strong>Coordonnées</strong>
				<div class="one-line">
					<input placeholder='Téléphone' id="telephone" name="telephone" value="<?php echo $monObjet->getValeur('telephone'); ?>">
					<input placeholder='Fax' id="fax" name="fax" value="<?php echo $monObjet->getValeur('fax'); ?>">
					<input placeholder='Email' id="email" name="email" value="<?php echo $monObjet->getValeur('email'); ?>">
				</div>
				<div>
					<input name="url" placeholder="Site internet" id="url" value="<?php echo $monObjet->getValeur('url'); ?>"/>
				</div>
			</div>		
		</div>
	
		<button type=submit name="enreg" class="btn btn-info pull-right">Valider</button>
	</form>
</div>

<script src="<?php echo $GLOBALS['root']; ?>_plugins/myContacts/scripts/villes.js"></script>
<script>
$(function() {
	// On va faire un controle de saisie sur les différents champs
	// en plus des controles grace au type d'input afin d'éviter
	// les caratères inutiles ou les champs trop grands qui donnent des erreurs
	// de bases 
	$('#nom').blur(function(){
		//resultat = controleText('nom',);
	});
	$('#enseigne').blur(function(){
		//resultat = controleText('enseigne',);
	});
	$('#url').blur(function(){
		//resultat = controleUrl('url',);
	});

	function choixSiteCollaborateur() {
		$('#idSite').change(function() {
			rSiteID = $('#idSite').val();
			
			$('#tableauCollaborateur').html('<div class="center"><img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif"></div>');
			$('#tableauCollaborateur').load('_default/fonctions/referentiel/collaborateurs.php',
				{	fonction: 'createTableau',
					idSociete: '',		
					idSite: rSiteID
				});
			// On modifie le lien d'ajout du collaborateur pour charger le site en cours
			$("a#newCollaborateur").attr('href','index.php?module=referentiel&option=collaborateurs&action=nouveau&id=' + rSiteID);
		});
	};


	//Fonction générique pour afficher le tableau en fonction des filtres sur cette page
	function afficheTableauSite() {
		$('#tableauSite').html('<div class="center"><img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif"></div>');
		$('#tableauSite').load('_default/ViewModels/sites.php',
				{	fonction: 'createTableau',
					idSociete: ''		
				});
	};


	//Fonction générique pour afficher le tableau en fonction des filtres sur cette page
	function afficheTableauCollaborateur(rSiteID,rSocieteID) {
		$('#tableauCollaborateur').html('<div class="center"><img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif"></div>');
		$('#tableauCollaborateur').load('_default/ViewModels/collaborateurs.php',
			{	fonction: 'createTableau',
				idSociete: rSocieteID,		
				idSite: rSiteID
			},choixSiteCollaborateur);
	};

	// Fonction pour activer le champ ville si un code postal est saisi
    $('#codePostal').blur(function() {
    	getVilleSelect('ville','select','idVille','codePostal',$(this).val(),'libelleVille');
    });	

	$(document).ready(function() {
		rSiteID = $('#idSite').val();
		rSocieteID = '';
		afficheTableauSite();
		afficheTableauCollaborateur(rSiteID,rSocieteID);
		// On modifie le lien d'ajout du collaborateur pour charger le site en cours
		$("a#newCollaborateur").attr('href','index.php?module=annuaire&option=collaborateurs&action=nouveau&id=' + rSiteID);
	});	
});
</script>