<?php 

$nomPlugin = 'myCompta';
$nomClasse = 'Pret'; // Doit être identique à la rubrique
$nomPageFormulaire = 'pretsFormulaire'; // ne pas mettre l'extension php
$nomPageTableauBord = null;
$champsOptions = array('affiche','supprime');
$champsRecherche = true;
$afficheOption = true;


include_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/viewModels/rubrique.php';