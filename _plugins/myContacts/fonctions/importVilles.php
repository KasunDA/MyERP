<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyBDD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/fonctions/_myERP.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myContacts/class/Ville.php';

$maConnexion = new MyBDD();

// On va commencer par vider la table
$maConnexion->videTable('mycontacts_villes');

// On va ensuite lire notre fichier de référentiel et contruire notre requete
$monFichier = $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myContacts/referentiels/villes.csv';
$tab = createTableauNominatif ($monFichier);


foreach ($tab as $ville) {
	$maVille = new Ville();
	
	$maVille->setValeur('codePostal', $ville['codePostal']);
	$maVille->setValeur('codeInsee', $ville['codeInsee']);
	$maVille->setValeur('libelleVille', $ville['libelleVille']);
	
	$maVille->setObjet();
	unset($maVille);
}

?>
<div class='btmspace-15 center'>
	<strong>Import terminé avec succès</strong>
	<hr>
	<a href='index.php?module=myContacts&rubrique=Parametres&referentiel=Ville'><button class='btn btn-succes'>Retour Liste</button></a>
</div>