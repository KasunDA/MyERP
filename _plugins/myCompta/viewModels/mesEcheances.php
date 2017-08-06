<?php
// Inclusion des fichiers de fonctions et classes
require_once $GLOBALS['root'] . '_plugins/myCompta/class/Echeance.php';
require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';


// On va vérifier si une action AJAX est en cours
if (isset($_POST['formulaire'])){
	// Nous allons vérifier le type d'opération en cours
	switch ($_POST['formulaire']) {
		case 'operation':
			$idOperation = setDataForm('Operation');
			break;
		case 'virement':
			$idOperation = setDataForm('Virement');
			break;
		default:
			break;
	}
}
// On vérifie si une action d'enregistrement d'un nouvel échéancier est en cours
elseif (isset($_POST['enreg'])) {
	$idEcheance = setDataForm('Echeance');
	$corpsAffiche = $GLOBALS['root'] . '_plugins/myCompta/views/mesEcheancesTableauBord.php';
}
// On va véfirier si une action d'ajout/modification est en cours
elseif (isset($_GET['action'])){
	if (isset($_GET['idEcheance'])) {
		$maClasse = new Echeance(array( 'idEcheance' => (int)$_GET['idEcheance']));
	}
	else {
		$maClasse = new Echeance();
	}
	$corpsAffiche = $GLOBALS['root'] . '_plugins/myCompta/views/mesEcheancesFormulaire.php';
}
else {
	$corpsAffiche = $GLOBALS['root'] . '_plugins/myCompta/views/mesEcheancesTableauBord.php';
}

// On affiche le corps de la page
include($corpsAffiche);

