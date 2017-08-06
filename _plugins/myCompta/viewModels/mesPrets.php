<?php
// Inclusion des fichiers de fonctions et classes
require_once $GLOBALS['root'] . '_plugins/myCompta/class/Pret.php';
require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';

/* On va vérifier si une action d'ajout ou modification
 * issue d'un formulaire est en cours
 */
setDataForm('Pret');


/* On va vérifier si une demande d'action est en
 * cours et si oui, on  va afficher la page correspondante
 */
if (isset($_GET['action'])) {
	$corpsAffiche = $GLOBALS['root'] . '_plugins/myCompta/views/mesPretsFormulaire.php';
	switch ($_GET['action']) {
		case 'ajout':
			$maClasse = new Pret();
			break;
		case 'modif':
			$maClasse = new Pret((int)$_GET['idPret']);
			$tableauAmortissement = $maClasse->getTableauAmortissement();
			break;
		default :
			break;
	}
}
else {
	// On va récupérer notre liste de Prêts
	$nomClasse = 'Pret';
	$nomID = 'idPret';
	$URL = 'index.php?module=myCompta&rubrique=pret&action=modif';
	$rupture = null;
	$argsTableau = recupArgsTableau($nomClasse, $nomID, $URL, $rupture);

	// Chargement de la page d'accueil
	$corpsAffiche = $GLOBALS['root'] . '_plugins/myCompta/views/mesPretsTableauBord.php';
}


// On affiche le corps de la page
include($corpsAffiche);

