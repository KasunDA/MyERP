<?php

// Définition des variables liés au plugin/classe
$nomPlugin = 'myContacts';
$nomClasse = 'Societe'; // Doit être identique à la rubrique

// Définition des liens vers les pages à afficher (ne pas mettre l'extension php)
$nomPageTableauBord = null;
$nomPageAffiche = 'societeFormulaire';
$nomPageFormulaire = 'societeFormulaire';

// Définition des options d'affichage
$menuGauche = null;
$champsRecherche = true;
$afficheOption = true;
$chargeListe = true;

// Définition des variables pour le tableau
$titrePage = 'Gestion des Sociétés';

// Appel à notre page générique
include_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/viewModels/myERP.php';