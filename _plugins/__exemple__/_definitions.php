<?php
/* Fonction qui va gérer l'affichage et les droits de notre plugin
 *
 */
function myParc($args) {
	$urlBase =  $GLOBALS['root'] . 'index.php?module=myParc';
	switch ($args) {
		case 'getMenu':
			return array (
			'libelle' => 'EXEMPLE',
			'niveauAcces' => '1',
			'url' => $urlBase,
			'sousMenu' => true,
			'plugin' => '__exemple__',
			'afficheTuile' => true
					);
			break;
		case 'getSousMenu' :
			$sousMenu[] = array ('libelle' => 'Exemple', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=__exemple','logo' => 'logo_48x48.png', 'alt' => "Exemple");
			return $sousMenu;
			break;
		case 'getNomPlugin' :
			return '__exemple__';
			break;
		case 'getListeRubrique':
			return null;
			break;
		default:
			return null;
			break;
	}
}
