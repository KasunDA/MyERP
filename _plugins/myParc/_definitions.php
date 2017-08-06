<?php
/* Fonction qui va gérer l'affichage et les droits de notre plugin
 *
 */
function myParc($args) {
	$urlBase =  'index.php?module=myParc';
	switch ($args) {
		case 'getMenu':
			return array (
			'libelle' => 'GIAO',
			'niveauAcces' => '1',
			'url' => $urlBase,
			'sousMenu' => true,
			'plugin' => 'myParc',
			'afficheTuile' => true
					);
			break;
		case 'getSousMenu' :
			$sousMenu[] = array ('libelle' => 'Matériel', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=parc','logo' => 'parc_48x48.png', 'alt' => "Gestion du parc matériel");
			$sousMenu[] = array ('libelle' => 'Achats', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=parc','logo' => 'achats_48x48.png', 'alt' => "Gestion du achats");
			$sousMenu[] = array ('libelle' => 'Helpdesk', 'niveauAcces' =>'1', 'url' => $urlBase . '&rubrique=helpdesk','logo' => 'helpdesk_48x48.png', 'alt' => "Gestion des Appels");
			$sousMenu[] = array ('libelle' => 'Référentiel', 'niveauAcces' =>'9', 'url' => $urlBase . '&rubrique=referentiel','logo' => 'liste_48x48.png', 'alt' => "Gestion des référentiels",'pull-right' => true);
			return $sousMenu;
			break;
		case 'getNomPlugin' :
			return 'myParc';
			break;
		case 'getListeRubrique':
			return null;
			break;
		default:
			return null;
			break;
	}
}
