<?php 
/* ---------------------------------------------------------------------------------
 * ---------------------------------------------------------------------------------
 		/!\ CODE GENERIQUE - NE PAS MODIFIER /!\
 
 	Objectif:
 	---------
 	Le but de ce fichier est de traiter de manière général le fonctionnement que l'on
 	va retrouver dans la majorité des pages. Le but de cette page est d'analyser une
 	demande sur la gestion d'une classe et d'en faire les actions suivantes:
 		- Analyser le classe et en récupérer une liste d'objet
 		- Rediriger vers une page par défaut ou personnalié pour chaque type
 		  d'action (affiche, ajout/modif)
 		- Par défaut, la page sera une liste d'objet mis en forme dans un tableau
 		- Il est possible de personnaliser la plupart des options
 		- Procéder à la mise à jour de la base pour un plugin
 		
 	Utilisation:
 	------------
 	1- Dans le dossier de plugin, il faut créer dans le dossier viewModels un fichier
 		dont le nom correspond à votre classe (sans majuscule) avec l'extension php
 	2- Dans ce fichier, il suffit de renseigner les variables ci-dessous et de finir
 		le pointage du fichier vers ce fichier
 		
 	Exemple:
 	--------
 	Comme aucune modification n'est nécessaire pour ce fichier, voici le fichier
 	source qui pointe vers ce fichier
 	
 	$nomPlugin = 'nom du plugin de la classe' // Obligatoire (peut-être null)
 	$nomClasse = 'nom de la classe principale' // Obligatoire
 	$menuGauche = 'nom de la page à afficher dans la sidebar' // Facultatif
 	$nomPageTableauBord = 'nom de la page à afficher comme tableau de bord' // Facultatif
 	$nomPageFormulaire* = 'nom de la page du formulaire de saisie de la classe' // Obligatoire  en fonction des options affichées
 	$nomPageAffiche = 'nom de la page d'affichage de la classe' // Obligatoire en fonction des options affichées
 	$afficheOption = 'definit si on affiche ou pas les options dans le tableau' // Obligatoire de type Bool (peut-être null)
 	$champsRecherche 'Affiche ou pas les champs de recherche dans les options de filtres' // Obligatoire de type Bool
 	$titrePage = 'Titre de la page à afficher' // Facultatif
 	$specifiqueClasse = 'Permet de définir une spécificité au niveau de la classse' // Facultatif
 * ---------------------------------------------------------------------------------
 * ---------------------------------------------------------------------------------
 */

// *************** DEBUT DU FICHIER ****************//

// On vérifie que la demande provient d'un plugin sinon on définit nos paramètres ici
if ($nomPlugin) {
	$lienPlugin = $nomPlugin;
	$cheminPlugin = '/_plugins/' . $nomPlugin;
	$niveauAcces = $_SESSION[$nomPlugin];
}
else {
	$lienPlugin = 'parametres';
	$cheminPlugin = '/_main';
	$niveauAcces = $_SESSION['niveauAccesGeneral'];
}

if ($nomClasse !== '__pluginUpdate__') {

	// Inclusion de nos classes
	require_once $_SERVER['DOCUMENT_ROOT'] . $cheminPlugin . '/class/' . $nomClasse . '.php';
	
	// On va vérifier si un enregistrement est en cours
	if (isset($_POST['formulaire'])){
		$idObjet = setDataForm($nomClasse);
	}
	
	// On va afficher ou pas le contenu de la sidebar et ainsi adapter la taille du content 
	$tailleContent = isset($tailleContent) ? $tailleContent : null;
	if (isset($menuGauche)) {
		include($_SERVER['DOCUMENT_ROOT'] . $cheminPlugin . '/views/' . $menuGauche .'.php');
		$tailleContent = 'three_quarter';
	}
	
	if (isset($_GET['action']) && $_GET['action'] != 'supprime') {
		switch (htmlspecialchars($_GET['action'])) {
			case 'ajout':
				$monObjet= new $nomClasse();
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . $cheminPlugin. '/views/' . $nomPageFormulaire;
				break;
			case 'affiche':
				$monObjet = new $nomClasse(array('idObjet' => htmlspecialchars($_GET['id'])));
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . $cheminPlugin. '/views/' . $nomPageAffiche;
				break;
			case 'modif':
				$monObjet = new $nomClasse(array('idObjet' => htmlspecialchars($_GET['id'])));
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . $cheminPlugin. '/views/' . $nomPageFormulaire;
				break;
			default:
				$corpsPage = '_templates/' . $_SESSION['template'] . '/views/404.php';
				break;
		}
	}
	else {
		if (isset($_GET['action']) && $_GET['action'] === 'supprime') {
			$monObjet = new $nomClasse(array('idObjet' => $_GET['id']));
			$monObjet->suppObjet();
		}
	
		// On va préparer notre tableau d'objet pour afficher notre page
		if ($chargeListe) {
			include $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/scripts/getTableauObjets.php';
		}
		$argsPage = array(
				'titrePage' => (isset($titrePage) ? $titrePage : null),
				'tableauDonnees' => ($chargeListe ? $argsTableau: array()),
				'champRecherche' => ($champsRecherche ? $monObjet->getTableEnTeteDefinition() : null)
		);

		if ($nomPageTableauBord !== null) {
			if ($nomPlugin) {
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . $cheminPlugin . '/views/' . $nomPageTableauBord;
			}
			else {
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/views/_defaultHomeListe';
			}
		}
		else {
			$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/views/_defaultHomeListe';
		}
	}
}
else {
	if ($nomClasse !== '__pluginUpdate__') {
		if ($lienPlugin !== 'parametres') {
			// On va afficher ou pas le contenu de la sidebar et ainsi adapter la taille du content
			$tailleContent = isset($tailleContent) ? $tailleContent : null;
			if (isset($menuGauche)) {
				include($_SERVER['DOCUMENT_ROOT'] . $cheminPlugin . '/views/' . $menuGauche .'.php');
				$tailleContent = 'three_quarter';
			}
			
			$listeClasse = listeDossiers(array('dossier' => 'classe' , 'plugin' => $lienPlugin));
			$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/views/_updatePlugin';
		}
	}
	else {
		// On va afficher ou pas le contenu de la sidebar et ainsi adapter la taille du content
			$tailleContent = isset($tailleContent) ? $tailleContent : null;
			if (isset($menuGauche)) {
				include($_SERVER['DOCUMENT_ROOT'] . $cheminPlugin . '/views/' . $menuGauche .'.php');
				$tailleContent = 'three_quarter';
			}
			
			$listeClasse = listeDossiers(array('dossier' => 'classe' , 'plugin' => $lienPlugin));
			$corpsPage = $_SERVER['DOCUMENT_ROOT'] . $cheminPlugin . '/views/' . $nomPageTableauBord;
	}
}
// On affiche le corps de la page
include ($corpsPage. '.php');



