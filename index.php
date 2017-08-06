<?php
/* On ouvre une session pour chaque page
 * vu que la finalité du site repose sur les sessions */
session_start();

/* on va vérifier que notre utilisateur est valide
 * sinon bascule sur l'écran de login
 */
include ($_SERVER['DOCUMENT_ROOT'] . '/_main/viewModels/login.php');

if (isset($_SESSION) AND isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyBDD.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_main/class/General.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/fonctions/_myERP.php';
	
	// Affiche du bandeau haut identique à chaque page
	$mesVariablesAffichage = new General(array('idObjet' => '1'));
	include( $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/header.php');
	
	/* On vérifie à chaque chargement de page le module désiré
	 * si pas de module ou tentative de modification, envoi vers la page 404
	 */
	if (isset($_GET['module'])){
		// Variable qui va nous permettre d'afficher une page 404 en cas d'erreur
		$page404= true;
		
		// On parcourt les plugins pour affiche le bon
		$listePlugin = listeDossiers(array('dossier' => 'plugins'));
		foreach ($listePlugin as $plugin) {
			if ($_GET['module'] === $plugin) {
				include ($_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $plugin . '/' . $plugin . '.php');
				$page404 = false;
			}
		}
		// On vérifie si la page demandée est celle des paramètres
		if ($_GET['module'] === 'parametres') {
			include ($_SERVER['DOCUMENT_ROOT'] . '/_main/viewModels/parametres.php');
			$page404 = false;
		}

		// Affiche de la page 404 si aucune page n'a été trouvée
		if ($page404) {
			include( $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/404.php'); // Affichage de la page 404 car l'option n'est pas bonne
		}
	}
	else {
		include($_SERVER['DOCUMENT_ROOT'] . '/_main/views/tableauBord.php'); 
	}
	
	
	// Affiche du footer identique à chaque page
	include( $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/footer.php');
}