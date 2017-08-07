<?php
/* Fonction qui va gérer l'affichage et les droits de notre plugin
 * 
 */
function myCompta($args) {
	$urlBase = 'index.php?module=myCompta';
	switch ($args) {
		case 'getMenu':
			return array (
				'libelle' => 'COMPTA',
				'niveauAcces' => '1',
				'url' => $urlBase,
				'sousMenu' => true,
				'plugin' => 'myCompta',
				'afficheTuile' => true
				);
			break;
		case 'getSousMenu' :
			$sousMenu[] = array ('libelle' => 'Comptes', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=Compte', 'logo' => 'myCompta_comptes_48x48.png', 'alt' => "Gestion des Comptes");
			$sousMenu[] = array ('libelle' => 'Echeances', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=Echeance', 'logo' => 'myCompta_echeance_48x48.png', 'alt' => "Gestion des Echéances");
			$sousMenu[] = array ('libelle' => 'Prets', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=Pret', 'logo' => 'myCompta_prets_48x48.png', 'alt' => "Gestion des Prêts");
			$sousMenu[] = array ('libelle' => 'Paramètres', 'niveauAcces' =>'9', 'url' => $urlBase . '&rubrique=Parametres', 'logo' => 'parametres_48x48.png', 'alt' =>"Gestion des Paramètres",'pull-right' => true);
			return $sousMenu;
			break;
		case 'getNomPlugin' :
			return 'myCompta';
			break;
		case 'getListeRubrique':
			$rubriques[] = array( 'nom' => 'Compte', 'page' => 'comptes');
			$rubriques[] = array( 'nom' => 'Operation', 'page' => 'comptes');
			$rubriques[] = array( 'nom' => 'Echeance', 'page' => 'echeances');
			$rubriques[] = array( 'nom' => 'Pret', 'page' => 'prets');
			$rubriques[] = array( 'nom' => 'Parametres', 'page' => 'parametres');
			return $rubriques;
			break;
		default:
			return null;
			break;
	}
}