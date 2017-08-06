<?php
/* Fichier de point d'entrée dans le plugin
 * Un copié collé peut-etre fait afin de créer rapidement un nouveau plugin
 * Il suffit de modifier la variable ci-dessous  
 */
$plugin = 'myContacts';

/* Partie de code à ne touchee que pour adapter le plugin */
if (isset($_GET['module']) AND $_GET['module'] === $plugin) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $plugin . '/_definitions.php';
	$listeRubrique = $plugin('getListeRubrique');
	if (isset($_GET['rubrique'])) {
		//On va vérifier si une tentative de moficiation d'URL est en cours
		$tentativeHack = true;
		foreach ($listeRubrique as $rubrique) {
			if ($_GET['rubrique'] === $rubrique['nom']) {
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $plugin('getNomPlugin'). '/viewModels/' . $rubrique['page'] . '.php';
				
				$tentativeHack = false;
				break;
			}
		}
		// On affiche la page en fonction du résultat
		if (!$tentativeHack) {
			include ($corpsPage);
		}
		else {
			include ('_templates/' .  $_SESSION['template'] . '/views/accesInterdit.php');
		}
	}
	else {
		// On affiche notre tableau de bord avec le menu principal
		
		// !!! ADAPTATION PAR RAPPORT A LA PAGE D'ORIGINE !!! \\
		// Changement de la page par défaut qui redirige vers la
		// page des personnes 
		include ('_plugins/' . $plugin('getNomPlugin') . '/viewModels/personne.php');
		// ---------------------------------------------- !!! \\
	}
}
else {
	include('_templates/' .  $_SESSION['template'] . '/views/404.php'); // Affichage de la page 404 car l'option n'est pas bonne
}