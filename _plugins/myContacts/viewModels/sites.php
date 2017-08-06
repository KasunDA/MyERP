<?php

/* On vérifie si une fonction est appelé par notre script jquery
 * et l'on va chercher la fonction correspondante
 */
if (isset($_POST['fonction'])) {
	/* Variable à renseigner pour éviter les erreurs de chemin relatif/absolu
	 * qui accède au fichier de configuration en particulier
	 */
	$GLOBALS['documentRoot'] = '../../';


	switch ($_POST['fonction']) {
		case 'createTableau':
			createTableauObjet();
			break;
	}
}
else {
	// On appelle notre fichier de fonctions génériques
	//require_once($GLOBALS['documentRoot'] . '_default/fonctions/fonctions.php');
	//require_once($GLOBALS['documentRoot'] . '_default/fonctions/referentiel/sites.php');
	
	// On va commencer par définir le chemin par rapport au dossier root
	$GLOBALS['documentRoot'] = '';
	
	/* On va vérifier si une action est en cours
	 *
	 */
	if (isset($_GET['action'])) {
		require_once '_default/Models/Site.php';
		switch ($_GET['action']){
			case 'nouveau':
				// On va créer notre objet que l'on va lier à notre formulaire
				$corpsPage = '_default/Views/sitesFormulaire.php';
				$monObjet = new Site();
				$monObjet->setValeur('idSociete',(int)$_GET['id']);
				$monObjetDefinition = $monObjet->getDefinition();
				break;
			case 'modif':
				// On va charger notre objet que l'on va afficher dans le formulaire
				$corpsPage = '_default/Views/sitesFormulaire.php';
				$monObjet = new Site((int)$_GET['id']);
				$monObjetDefinition = $monObjet->getDefinition();
				break;
			default :
				$corpsPage = '_templates/' . $_SESSION['template'] . '/Views/hacking.php';
				break;
		}
	}
	else {
		session_start();
		// Pas d'action donc on affiche la page 404
		$corpsPage = $GLOBALS['documentRoot'] . '_templates/' . $_SESSION['template'] . '/Views/404.php';
	}
	
	
	// On affiche le corps de la page
	include($corpsPage);
}


// Fonctions utilisé pour notre tableau personne
function createTableauObjet() {
	// on va ajouter notre classe
	include_once ($GLOBALS['documentRoot'] .'_default/Models/Site.php');
	$monObjet = new Site();

	/* On va récupérer notre liste d'objet et préparer notre
	 * tableau de paramètre à envoyer à notre fonction
	 */
	$maListeObjet = $monObjet->getListeRequeteID($_POST['idSociete']);
	$tableauAffiche = array (
			'definition' => $monObjet->getDefinition('tableau'),
			'listeObjet' => $maListeObjet['donnees'],
			'afficheSelectPage' => false,
			'nombreParPage' => '1',
			'pageAffiche' => '1',
			'nombreResultat' => $maListeObjet['nbResultat'],
			'urlPage' => 'index.php?module=annuaire&option=sites&action=modif&id=',
			'presenceRupture' => false,
			'champRupture' => null
	);

	// On créé le tableau que l'on affiche sur la page
	include_once ($GLOBALS['documentRoot'] . '_MyFramework/tableau.php');
	createTableau($tableauAffiche);
}


