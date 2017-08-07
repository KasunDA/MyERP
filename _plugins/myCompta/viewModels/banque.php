<?php

$nomPlugin = 'myCompta';
$nomClasse = 'Banque'; // Doit être identique à la rubrique
$nomPageFormulaire = 'parametreBanqueFormulaire'; // ne pas mettre l'extension php
$nomPageTableauBord = null;
$champsOptions = array('affiche','supprime');
$champsRecherche = true;
$afficheOption = true;
//$specifiqueClasse = array('idCompte' => '6');

include_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/viewModels/myERP.php';