<?php
// On initialise notre filtre sur l'affichage des opérations en cours
$date = new DateTime();
$dateDebut = $date -> format('Y-m-01');
$dateFin = $date -> format('Y-m-t');

// On initialise notre filtre sur l'affichage des comptes sur le compte par défaut
$compteID = (isset ($_GET['idCompte']) ? $_GET['idCompte']: '6');

require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Compte.php';
$monCompte = new Compte(array('idObjet' => $compteID ));

$nomPlugin = 'myCompta';
$nomClasse = 'Operation'; // Doit être identique à la rubrique
$nomPageFormulaire = 'operationFormulaire'; // ne pas mettre l'extension php
$nomPageTableauBord = 'comptes';
$champsOptions = array('affiche','supprime');
$champsRecherche = true;
$afficheOption = true;
$tailleContent = 'three_quarter';
$specifiqueClasse = array( 'idCompte' => $compteID , 'estRapproche' => null, 'debutPeriode' => $dateDebut, 'finPeriode' => $dateFin);

// On affiche le menu à gauche
include($_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $nomPlugin . '/views/comptesMenu.php');

include_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/viewModels/rubrique.php';
/*
// On va vérifier si une action est en cours
if (isset($_POST['formulaire'])){
	require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';
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

if(isset($_GET['idCompte'])) {
	if (isset($_GET['action'])) {
		// On va ouvrir le compte sélectionné
		$monCompte = new Compte(array('idObjet' => (int)$_GET['idCompte']));
		switch ($_GET['action']) {
			case 'ajout':
				$maClasse = new Operation();
				$corpsPage = '_plugins/myCompta/views/mesComptesOperationsFormulaire.php';
				break;
			case 'modif': 
				$maClasse = new Operation(array('idObjet' => (int)$_GET['idOperation']));
				if ($maClasse->getValeur('idVirement') > 0) {
					$maClasse = new Virement($maClasse->getValeur('idVirement'));
					$corpsPage = '_plugins/myCompta/views/mesComptesVirementsFormulaire.php';
				}
				else {
					$corpsPage = '_plugins/myCompta/views/mesComptesOperationsFormulaire.php';
				}
				break;
			case 'suppr':
				$maClasse = new Operation((int)$_GET['idOperation']);
				if ($maClasse->getValeur('idVirement') > 0) {
					$maClasse = new Virement(array('idObjet' => $maClasse->getValeur('idVirement')));
				}
				$maClasse->suppObjet();
				$corpsPage = '_plugins/myCompta/views/mesComptesReleve.php';
				break;
			case 'rapproch': 
				$maClasse = new Operation(array('idObjet' => (int)$_GET['idOperation']));
				$maClasse->setRapprochement();
				$corpsPage = '_plugins/myCompta/views/mesComptesReleve.php';
				break;
			case 'virement': 
				$maClasse = new Virement();
				$corpsPage = '_plugins/myCompta/views/mesComptesVirementsFormulaire.php';
				break;
			case 'createOperation':
				require_once $GLOBALS['root'] . '_plugins/myCompta/class/Echeance.php';
				$maClasse = new Echeance(array( 'idEcheance' => (int)$_GET['idEcheance']));
				$maClasse->createMouvement($_GET['date']);
				$corpsPage = '_plugins/myCompta/views/mesComptesReleve.php';
				break;
			default :
				$corpsPage = '_templates/' . $GLOBALS['template'] . '/views/404.php';
				break;
		}
	}
	else {
		if ((int)$_GET['idCompte'] > 0) {
			// On récupère les informations de notre compte
			$monCompte = new Compte((array('idObjet' => (int)$_GET['idCompte'])));
			$corpsPage = '_plugins/myCompta/views/mesComptesReleve.php';
		}
		else {
			// Affichage de la page 404 car l'option n'est pas bonne
			$corpsPage = '_templates/' . $GLOBALS['template'] . '/views/404.php';
		}
	}
}
else {
	$corpsPage = '_plugins/myCompta/views/comptes.php';
}


// On affiche le corps de la page en fonction de la demande
include($corpsPage);

?>*/