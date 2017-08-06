<?php
$nomPlugin = 'myCompta';

if (isset($_POST['formulaire'])){
	require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';
	require_once $GLOBALS['root'] . '_plugins/' . $nomPlugin . '/class/' . $_POST['formulaire'] . '.php';
	$idObjet = setDataForm($_POST['formulaire']);
}

// On affiche le menu à gauche
include($GLOBALS['root'] . '_plugins/' . $nomPlugin . '/views/parametresMenu.php');

/* On va vérifier si une demande d'action est en
 * cours et si oui, on  va afficher la page correspondante
 */
if (isset($_GET['param'])) {
	require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';
	$tentativeHack = 0;
	switch ($_GET['param']) {
		case 'banques':
			$nomClasse = 'Banque';
			$nomID = 'idBanque';
			$URL = 'index.php?module=' . $nomPlugin . '&rubrique=parametres&param=banques';
			$rupture = null;
			break;
		case 'comptes':
			$nomClasse = 'Compte';
			$nomID = 'idCompte';
			$URL = 'index.php?module=' . $nomPlugin . '&rubrique=parametres&param=comptes';
			$rupture = array(
					'cleRupture' =>	'idBanque',
					'libelleRupture' => 'nomBanque'
			);
			break;
		case 'categories':
			$nomClasse = 'Categorie';
			$nomID = 'idCategorie';
			$URL = 'index.php?module=' . $nomPlugin . '&rubrique=parametres&param=categories';
			$rupture = array(
					'cleRupture' =>	'idFamille',
					'libelleRupture' => 'nomFamille'
			);
			break;
		case 'familles':
			$nomClasse = 'Famille';
			$nomID = 'idFamille';
			$URL = 'index.php?module=' . $nomPlugin . '&rubrique=parametres&param=familles';
			$rupture = null;
			break;
		default:
			$tentativeHack = 1;
			break;
	}
	
	// On va afficher le contenu de notre page
	if ($tentativeHack === 1) {
		$corpsAffiche = '_templates/' .  $_SESSION['template'] . '/views/404.php';
	}
	else {
		/* A l'aide des informations de notre switch/case, nous allons pouvoir récupérer les informations
		 * correspondant au paramètre à afficher. 
		 */
		// On va définir notre classe
		require_once $GLOBALS['root'] . '_plugins/' . $nomPlugin . '/class/' . $nomClasse . '.php';
		$monObjet = new $nomClasse((isset($_GET['id']) ? array('idObjet' => (int)$_GET['id']) : null));
		
		$argsListeObjet = array(
				'afficheObjet' => (isset($_POST['afficheObjet']) ? $_POST['afficheObjet'] : '1'),
				'nbObjetAffiche' => (isset($_POST['nbObjetAffiche']) ? $_POST['nbObjetAffiche'] : '10'),
				'pageAffiche' => (isset($_POST['pageAffiche']) ? $_POST['pageAffiche'] : '1'),
				'champTri' => (isset($_POST['champTri']) ? $_POST['champTri'] : null),
				'ordreTri' => (isset($_POST['ordreTri']) ? $_POST['ordreTri'] : null),
				'champRecherche' => (isset($_POST['champRecherche']) ? $_POST['champRecherche'] : null),
				'cleRecherche' => (isset($_POST['cleRecherche']) ? $_POST['cleRecherche'] : null)
		);
				
		$listeObjet = $monObjet->getListeObjet($argsListeObjet);
		// Nous allons créer un tableau d'options
		$tableOptions = array (
				'idObjet' => $monObjet->getValeur('nomID'),
				'type' => array('affiche'),
				'lien' => $URL	
		);
				
				
		$argsTableau = array(
				'enTete' => $monObjet->getTableEnTeteDefinition(),
				'donnees' => $listeObjet,
				'options' => $tableOptions,
				'rupture' => $rupture
		);
		
		$corpsAffiche = $GLOBALS['root'] . '_plugins/myCompta/views/parametres' . $nomClasse . '.php';
	}
}
else {
	// Chargement de la page d'accueil
	$corpsAffiche = $GLOBALS['root'] . '_plugins/myCompta/views/parametresTableauBord.php';
}


// On affiche le corps de la page
include($corpsAffiche);



