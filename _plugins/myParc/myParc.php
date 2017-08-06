<?php

/* On va définir les variables en fonction du choix effectué
 * dans le menu aside
*
*/
if (isset($_GET['module']) AND $_GET['module'] === 'myParc') {
	if (isset($_GET['rubrique'])) {
		//On va vérifier si une tentative de moficiation d'URL est en cours
		$tentativeHack = false;
		switch (htmlSpecialChars($_GET['rubrique'])) {
			case 'Materiel': 
				$corpsPage = $GLOBALS['root'] . '_plugins/myParc/viewModels/materiel.php';
				break;
			case 'Logiciel': 
				$corpsPage = $GLOBALS['root'] . '_plugins/myParc/viewModels/materiel.php';
				break;
			case 'referentiel':
				$corpsPage = $GLOBALS['root'] . '_plugins/myParc/viewModels/referentiel.php';
				break;
			case 'update':
				// On va créer une fonction de mise à jour
				$corpsPage = $GLOBALS['root'] . '_plugins/myParc/views/_tableauBord.php';
				break;
			default:
				$tentativeHack = true;
				break;
		}
		// On affiche la page en fonction du résultat
		if (!$tentativeHack) {
			include ($corpsPage);
		}
		else {
			include ('_templates/' .  $_SESSION['template'] . '/views/404.php');
		}
	}
	else {
		// On affiche notre tableau de bord avec le menu principal	
		include ('_plugins/myParc/views/_tableauBord.php');
	}
}
else {
	include('_templates/' .  $_SESSION['template'] . '/views/404.php'); // Affichage de la page 404 car l'option n'est pas bonne
}
