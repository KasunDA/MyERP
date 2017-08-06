<?php
/* Fonction qui va gérer l'affichage et les droits de notre plugin
 *
 */
function myRH($args) {
	$urlBase =  'index.php?module=myRH';
	switch ($args) {
		case 'getMenu':
			return array (
			'libelle' => 'GIRH',
			'niveauAcces' => '1',
			'url' => $urlBase,
			'sousMenu' => true,
			'plugin' => 'myRH',
			'afficheTuile' => true
					);
			break;
		case 'getSousMenu' :
			//$sousMenu[] = array ('libelle' => 'Projet Osiris', 'niveauAcces' =>'5', 'url' => $urlBase . '&rubrique=osiris','logo' => 'parc_48x48.png', 'alt' => "Projet Osiris");
			//return $sousMenu;
			return array();
			break;
		case 'getNomPlugin' :
			return 'myRH';
			break;
		case 'getListeRubrique':
			$rubriques[] = array( 'nom' => 'Osiris', 'page' => 'osiris');
			return $rubriques;
			break;
		default:
			return null;
			break;
	}
}
