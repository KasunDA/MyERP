<?php

$nomPlugin = 'myCompta';
$nomClasse = 'Echeance'; // Doit être identique à la rubrique
$nomPageFormulaire = 'echeanceFormulaire'; // ne pas mettre l'extension php
$nomPageTableauBord = '_tableauBord.php';
$champsOptions = array('affiche','supprime');
$champsRecherche = true;
$afficheOption = true;
$specifiqueClasse = array('idCompte' => '6');



include_once $GLOBALS['root'] . '_frameworks/myFrameWork/viewModels/rubrique.php';