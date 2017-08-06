<?php 

// On va vérifier si un enregistrement est en cours
if (isset($_POST['enreg'])) {
	require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';
	require_once $GLOBALS['root'] . '_plugins/' . $plugin . '/class/' . $nomClasse . '.php';
	$idInsert = setDataForm($nomClasse);
	$corpsPage = '_plugins/' . $plugin . '/views/_Home.php';
}
/* On va vérifier si une action est en cours
 *
 */
elseif (isset($_GET['action'])) {
	require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';
	require_once $GLOBALS['root'] . '_plugins/' . $plugin . '/class/' . $nomClasse . '.php';
	switch ($_GET['action']){
		case 'ajout':
			$corpsPage = $GLOBALS['root'] . '_plugins/' . $plugin . '/views/' . strtolower($nomClasse) . 'Formulaire.php';
			$monObjet = new $nomClasse();
			$monObjetDefinition = $monObjet->getDefinition();
			break;
		case 'affiche':
			$corpsPage = $GLOBALS['root'] . '_plugins/' . $plugin . '/views/' . strtolower($nomClasse) . 'Formulaire.php';
			$monObjet = new $nomClasse((int)$_GET['id' . $nomClasse]);
			$monObjetDefinition = $monObjet->getDefinition();
			break;
		case 'suppr':
			$corpsPage = $GLOBALS['root'] . '_plugins/' . $plugin . '/views/_Home.php';
			$monObjet = new $nomClasse((int)$_GET['id' . $nomClasse]);
			$monObjetDefinition = $monObjet->suppObjet();
			break;
		default :
			$corpsPage = $GLOBALS['root'] . '_templates/' . $_SESSION['template'] . '/views/404.php';
			break;
	}
}
else {
	// Pas d'action donc on affiche la page Home
	$corpsPage = $GLOBALS['root'] . '_plugins/' . $plugin . '/views/_Home.php';
}

// On affiche le corps de la page
include($corpsPage);