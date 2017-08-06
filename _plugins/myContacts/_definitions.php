<?php

/* Fonction qui va gérer l'affichage et les droits de notre plugin
 *
 */
function myContacts($args) {
	$urlBase = 'index.php?module=myContacts';
	switch ($args) {
		case 'getMenu':
			return array (
			'libelle' => 'CONTACTS',
			'niveauAcces' => '1',
			'url' => $urlBase,
			'sousMenu' => true,
			'plugin' => 'myContacts',
			'afficheTuile' => true
			);
			break;
		case 'getSousMenu' :
			$sousMenu[] = array ('libelle' => 'Personnes', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=Personne','logo' => 'personne_48x48.png', 'alt' => "Gestion des Personnes");
			$sousMenu[] = array ('libelle' => 'Sociétés', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=Societe','logo' => 'entreprise_48x48.png', 'alt' => "Gestion des Sociétés");
			$sousMenu[] = array ('libelle' => 'Parametres', 'niveauAcces' =>'9', 'url' => $urlBase . '&rubrique=Parametres','logo' => 'parametres_48x48.png', 'alt' => "Gestion des Paramètres",'pull-right' => true);
			return $sousMenu;
			break;
		case 'getNomPlugin' :
			return 'myContacts';
			break;
		case 'getListeRubrique':
			$rubriques[] = array( 'nom' => 'Personne', 'page' => 'personne');
			$rubriques[] = array( 'nom' => 'Societe', 'page' => 'societe');
			$rubriques[] = array( 'nom' => 'Parametres', 'page' => 'parametres');
			return $rubriques;
			break;
		default:
			return null;
			break;
	}
}