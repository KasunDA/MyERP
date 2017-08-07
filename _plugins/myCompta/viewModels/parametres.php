<?php
/* On va déclarer nos variables identiques à tous nos paramètres
 */
$nomPlugin = 'myCompta';
$menuGauche = 'parametresMenu'; // Page affichant un menu personnalisable pour la classe

// Variables pour l'affichage de la liste
$champsRecherche = true;  // Affiche ou pas la possibilité de faire une recherche dans le tableau
$afficheOption = true;  // Affiche les options dans le tableau

/* Nous allons gérer les variables par paramètre afin de pouvoir personnaliser 
 * les différentes pages et les informations à afficher 
 */ 
if (isset($_GET['referentiel'])){
	switch ($_GET['referentiel']) {
		case 'Banque':
			// Définition des variables pour le tableau
			$titrePage = 'Référentiel des Banque';
			$nomClasse = 'Banque'; // Doit être identique à la rubrique sinon erreur
			$nomPageTableauBord = null; // Page d'accueil de la classe
			$chargeListe = false;
			break;
		case 'Compte':
			// Définition des variables pour le tableau
			$titrePage = 'Référentiel des Comptes';
			$nomClasse = 'Compte'; // Doit être identique à la rubrique sinon erreur
			$nomPageTableauBord = null; // Page d'accueil de la classe
			$chargeListe = false;
			break;
		case 'Update':
			// Nous allons définir ici notre page de mise à jour du plugin
			$nomClasse = '__pluginUpdate__';
			break;
		default: 
			$nomClasse = null;
			break;
	}
}
else {
	// Définition des variables pour le tableau
	//$titrePage = 'Référentiel des villes';
	$nomPageTableauBord = 'parametresTableauBord'; // Page d'accueil de la classe
	$nomPageAffiche = null; // Page de l'affichage de l'objet
	$nomPageFormulaire = null; // Page de saisie de l'objet
	$nomClasse = 'Banque'; // Doit être identique à la rubrique sinon erreur
	$chargeListe = false;
}



if ($_SESSION[$nomPlugin] >= 1 && $nomClasse) {
	// On fait appel à la page générique du framework qui va gérer l'affichage et l'enregistrement des objets
	include_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/viewModels/myERP.php';
}
else {
	// Pas de droit donc suspicion de tentative de hack
	include_once $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
}