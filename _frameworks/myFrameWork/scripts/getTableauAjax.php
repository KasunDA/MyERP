<?php
/* Ce fichier aura pour but de créer une réponse AJAX qui renverra les données issues de la base
 * En cas d'un select, il faudrait  envoyer les informations suivantes:
 * 		$('#ville').load('_frameworks/myFrameWork/scripts/ajax.php',{   // Ou #ville correspond à l'id du div ou doit être affiché le select
 *			source : 'AJAX',											// Obligatoire pour vérifier qu'il s'agit bien d'une rquete ajax
 * 			fonction: 'getListeObjet',									// définit la fonction à utiliser
 * 			plugin: 'myContacts',										// définit le plugin pour charger le contenu
 * 			classe: 'Ville',											// Classe sur laquelle se porte la requete
 * 			miseEnForme: 'select',										// Type de mise en forme 'select' ou 'tableau'
 *         	label  : 'Ville', 											// Label à affiche devant le select (peut etre null)
 *         	attrName : 'idVille',										// Attribut id pour le champ select
 *         	valueName : 'codePostal',									// nom de la colonne dans la base envoyé par la requete
 *         	valueSelected : $(this).val(),							// valeur envoyé ou selectionné
 *         	disabled: false,											// désactiver le select
 *         	champAffiche: 'libelleNom',									// Champ à afficher dans la zone
 *          urlAjout: false												// Si on doit afficher un lien pour ajouter une valeur dans la liste (renvoie vers une autre page)
 *      });
 */

/* On va vérifier si une requète AJAX est en cours et si ce n'est
 * pas le cas, nous allons afficher simplement le sous menu
 */
session_start();
if (isset($_POST['source']) AND $_POST['source'] === 'AJAX'){
	// On vérifie que la demande provient d'un plugin sinon on définit nos paramètres ici
	if ($_POST['plugin']) {
		$lienPlugin = $_POST['plugin'];
		$cheminPlugin = '_plugins/' . $_POST['plugin'];
		$niveauAcces = $_SESSION[$_POST['plugin']];
	}
	else {
		$lienPlugin = 'parametres';
		$cheminPlugin = '_main';
		$niveauAcces = $_SESSION['niveauAccesGeneral'];
	}
	
	// On va définir le chemin relatif à notre dossier root
	$GLOBALS['root'] = '../../../';
	
	// On va créer une instance de notre objet
	if (isset($_POST['plugin']) && $_POST['plugin'] != '') {
		require_once $GLOBALS['root'] . '_plugins/' . $_POST['plugin'] . '/class/' . $_POST['classe'] . '.php';
	}
	else {
		require_once $GLOBALS['root'] . '_main/class/' . $_POST['classe'] . '.php';
	}
	include_once ($GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/_myERP.php');
	
	$monObjet = new $_POST['classe']();
				
	// On va définir notre tableau d'argument
	$argsObjet = array(
	'classe' => $_POST['classe'],
	'nomTable' => $monObjet->getValeur('nomTable'),
	'nomID' => $monObjet->getValeur('nomID'),
	'afficheArchive' => (isset($_POST['afficheArchive']) && $_POST['afficheArchive']? $_POST['afficheArchive'] : '1'),
	'nbObjetAffiche' => ($_POST['nbObjetAffiche'] ? $_POST['nbObjetAffiche'] : '10'),
	'pageAffiche' => ($_POST['pageAffiche'] ? $_POST['pageAffiche'] : '2'),
	'champRecherche' => ($_POST['valeurCle'] ? $_POST['nomCle'] : null),
	'cleRecherche' => $_POST['valeurCle']
	);
	
	$tableauObjet = $monObjet->getListeObjet($argsObjet);
	
	// Nous allons constituer notre tableau de variables
	$argsTableau = array(
			'niveauAcces' => $niveauAcces,
			'enTete' => $monObjet->getTableEnTeteDefinition(),
			'donnees' => $tableauObjet,
			'options' => ($_POST['afficheOption'] === '' ? null : array (
					'idObjet' => $monObjet->getValeur('nomID'),
					'type' => $monObjet->getDroits($_POST['plugin']),
					'lien' => 'index.php?module=' . $lienPlugin. '&rubrique=' . $_POST['classe']
			)),
			'nbPage' => ($tableauObjet ? getNombrePage($monObjet->getNombreObjet($argsObjet), $_POST['nbObjetAffiche']) : '0'),
			'niveauDroitAjout' => getNiveauDroit($monObjet->getDroits($_POST['plugin'])['droits'],'ajout'),
			'urlAjout' => $_POST['urlAjout']
	);
	
	/* On construit notre tableau via la fonction définie
	 * dans le fichier se trouvant
	 * _frameworks/myFrameWork/fonctions/myERP.php
	 */
	creationTableau($argsTableau);
}
