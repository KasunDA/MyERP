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
//	require_once($GLOBALS['documentRoot'] . '_default/fonctions/fonctions.php');
	//require_once($GLOBALS['documentRoot'] . '_default/Models/Collaborateurs.php');
	
	// On va commencer par définir le chemin par rapport au dossier root
	$GLOBALS['documentRoot'] = '';
	
	/* On va vérifier si une action est en cours
	 *
	 */
	if (isset($_GET['action'])) {
		require_once '_default/class/Collaborateur.php';
		require_once '_default/class/Site.php';
		require_once '_default/class/Personne.php';
		
		// On va créer notre tableau de personnes pour afficher dans le SELECT
		$maListe = new Personne();
		$listePersonne = $maListe->getListeSelect();
		foreach ($listePersonne as $cle => $donnees){
			$listeDonnees[] = array(
				'valeur' => $donnees['idPersonne'],
				'valeurAffiche' => $donnees['nom'] . " " . $donnees['prenom']
			);
		}
		$tableauSelectPersonne = array(
			'champCle' => "idPersonne",
			'listeChoix' => $listeDonnees,
			'champSelected' => null,
		);
		
		// On va vérifier notre action
		switch ($_GET['action']){
			case 'nouveau':
				// On va créer notre objet que l'on va lier à notre formulaire
				$corpsPage = '_default/php/collaborateursFormulaire.php';
				$monObjet = new Collaborateur();
				$monObjetDefinition = $monObjet->getDefinition();
				$monSite = new Site((int)$_GET['id']);
				break;
			case 'modif':
				// On va charger notre objet que l'on va afficher dans le formulaire
				$corpsPage = '_default/php/collaborateursFormulaire.php';
				$monObjet = new Collaborateur((int)$_GET['id']);
				$monObjetDefinition = $monObjet->getDefinition();
				// On va récupérer la définiton de notre société
				$monSite = new Site($monObjet->getValeur('idSite'));
				$tableauSelectPersonne['champSelected'] = $monObjet->getValeur('idPersonne');
				break;
			default :
				$corpsPage = '_templates/' . $_SESSION['template'] . '/php/hacking.php';
				break;
		}
	
	}
	else {
		// Pas d'action donc on affiche la page 404
		$corpsPage = '_template/' . $_SESSION['template'] . '/php/404.php';
	}
	
	
	// On affiche le corps de la page
	include($corpsPage);
}

function createTableauObjet() {
	// on va ajouter notre classe
	require_once ($GLOBALS['documentRoot'] .'_default/Models/Collaborateur.php');
	$monObjet = new Collaborateur();

	/* On va récupérer notre liste d'objet et préparer notre
	 * tableau de paramètre à envoyer à notre fonction
	 */
	$maListeObjet = $monObjet->getListeRequeteID($args = array('idSociete' => $_POST['idSociete'], 'idSite' => $_POST['idSite']));
	$tableauAffiche = array (
			'definition' => $monObjet->getDefinition('tableau'),
			'listeObjet' => $maListeObjet['donnees'],
			'afficheSelectPage' => false,
			'nombreParPage' => '',
			'pageAffiche' => '',
			'nombreResultat' => $maListeObjet['nbResultat'],
			'urlPage' => 'index.php?module=annuaire&option=collaborateurs&action=modif&id=',
			'presenceRupture' => false,
			'champRupture' => null
	);

	// On va créer notre tableau pour le select du site à l'aide du résultat ci-dessus
	/*	$tableauSiteCours = array();
	 foreach ($maListeObjet['donnees'] as $objet){
		$tableauSiteCours[] = setArraySelectListe($objet->getValeur('idSite'),$objet->getValeur('libelleSite'));
		}*/

	// On créé le tableau que l'on affiche sur la page
	include_once ($GLOBALS['documentRoot'] . '_MyFramework/tableau.php');
	createTableau($tableauAffiche);
}
	
	
	
