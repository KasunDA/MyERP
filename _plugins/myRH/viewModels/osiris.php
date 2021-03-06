<?php
/* Définitions générales du plugin et de la rubrique
 * -----------------------------------------------------
 */
$nomPlugin = 'myRH';
$nomClasse = 'Osiris'; // Doit être identique à la rubrique sinon erreur
$chargeListe = false; // Charger ou pas la liste des résultats à l'affiche de la homepage

/* Définitions générales sur l'affichage de la rubrique
 * -> Les pages peuvent être 'null' et affiche une page pré-défini
 * -> il ne faut pas renseigner l'extension php au nom de la page
 * ----------------------------------------------------
 */
$nomPageTableauBord = 'osiris'; // Page d'accueil de la classe
$menuGauche = null; // Page affichant un menu personnalisable pour la classe
$nomPageAffiche = null; // Page de l'affichage de l'objet
$nomPageFormulaire = null; // Page de saisie de l'objet


// Définition des variables pour le tableau
$titrePage = 'Projet OSIRIS : Migration vers ADP';

/* Définitions générales sur l'affichage des options
 * ----------------------------------------------------
 */
$champsRecherche = false;  // Affiche ou pas la possibilité de faire une recherche dans le tableau
$afficheOption = false;  // Affiche les options dans le tableau


/* On va vérifier en permanence que les droits attribués sont correct
 * ---------------------------------------------------
 */

if ($_SESSION[$nomPlugin] >= 1) {
	// On fait appel à la page générique du framework qui va gérer l'affichage et l'enregistrement des objets
	include_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/viewModels/myERP.php';
}
else {
	// Pas de droit donc suspicion de tentative de hack
	include_once $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
}

