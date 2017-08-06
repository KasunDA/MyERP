<?php 

// Définition des variables liés au plugin/classe
$nomPlugin = 'myParc';
$tentativeHack = false;
if (isset($_GET['param'])) {
	$tentativeHack = false;
	switch ($_GET['param']) {
		case 'ordinateurs':
			$titrePage = 'Référentiel des ordinateurs';
			$nomClasse = 'ReferentielOrdinateur';
			$nomPageAffiche = 'referentielOrdinateurAffiche';
			$nomPageFormulaire = 'referentielOrdinateurFormulaire';
			break;
		case 'imprimantes':
			$titrePage = 'Référentiel des imprimantes';
			$nomClasse = 'ReferentielImprimante';
			break;
		default:
			$tentativeHack = true;
			break;
	}
}
else {
	$titrePage = 'Référentiel des ordinateurs';
	$nomClasse = 'ReferentielOrdinateur';
	$nomPageAffiche = 'referentielOrdinateurAffiche';
	$nomPageFormulaire = 'referentielOrdinateurFormulaire';
	$nomClasse = 'ReferentielOrdinateur'; // Doit être identique à la rubrique
}

// Définition des liens vers les pages à afficher (ne pas mettre l'extension php)
$nomPageTableauBord = null;

// Définition des options d'affichage
$menuGauche = 'referentielSidebar';
$champsRecherche = true;
$afficheOption = true;


// Appel à notre page générique
if (!$tentativeHack) {
	include_once $GLOBALS['root'] . '_frameworks/myFrameWork/viewModels/rubrique.php';
}
else {
	include_once $GLOBALS['root'] . '_templates/' . $_SESSION['template'] .'/views/404.php';
}



/*$nomPlugin = 'myParc';

// On va vérifier si un enregistrement est en cours
if (isset($_POST['formulaire'])){
	// Nous allons vérifier le type d'opération en cours
	switch ($_POST['formulaire']) {
		case 'referentielOrdinateur':
			require_once '_plugins/' . $nomPlugin . '/class/ReferentielOrdinateur.php';
			$idOperation = setDataForm('referentielOrdinateur');
			break;
		case 'referentielImprimante':
			require_once '_plugins/' . $nomPlugin . '/class/ReferentielImprimante.php';
			$idOperation = setDataForm('referentielImprimante');
			break;
		default:
			break;
	}
}

if (isset($_GET['param'])) {
	$tentativeHack = false;
	switch ($_GET['param']) {
		case 'ordinateurs':
			$nomClasse = 'ReferentielOrdinateur';
			break;
		case 'imprimantes':
			$nomClasse = 'ReferentielImprimante';
			break;
		default:
			$tentativeHack = true;
			break;
	}
	if (!$tentativeHack) {
		// On va générer notre objet de classe
		require_once '_plugins/' . $nomPlugin . '/class/' . $nomClasse . '.php';
		$monObjet = new$nomClasse();
		
		require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/_myERP.php';
		// On affiche le menu des paramètres dans le bandeau gauche prévu à cet effet
		include '_plugins/' . $nomPlugin . '/views/' . $_GET['rubrique'] . 'Menu.php';
		// On va vérifier si une demande de formulaire est en cours
		if (isset($_GET['action'])) {
			$corpsPage = '_plugins/' . $nomPlugin . '/views/' . lcfirst($nomClasse) . 'Formulaire';
		}
		else {
			// On va récupérer les différentes informations nécessaires à la récupération de notre
			// liste d'objets
			$argsListeObjet = array(
				'afficheObjet' => (isset($_POST['afficheObjet']) ? $_POST['afficheObjet'] : '1'),
				'nbObjetAffiche' => (isset($_POST['nbObjetAffiche']) ? $_POST['nbObjetAffiche'] : '20'),
				'pageAffiche' => (isset($_POST['pageAffiche']) ? $_POST['pageAffiche'] : '1'),
				'champTri' => (isset($_POST['champTri']) ? $_POST['champTri'] : null),
				'ordreTri' => (isset($_POST['ordreTri']) ? $_POST['ordreTri'] : null),
				'champRecherche' => (isset($_POST['champRecherche']) ? $_POST['champRecherche'] : null),
				'cleRecherche' => (isset($_POST['cleRecherche']) ? $_POST['cleRecherche'] : null)
			);
			
			// On va récupérer notre liste d'objets
			$listeObjets = $monObjet->getListeObjet($argsListeObjet);
			// On va calculer le nombre de page à afficher en fonction du résultat
			if ($listeObjets) {
				$nbObjet = $monObjet->getNombreObjet($argsListeObjet);
				$nbPage = (isset($_POST['nbObjetAffiche']) ? $_POST['nbObjetAffiche'] : '20') % $nbObjet;
				if ($nbPage != 0) {
					$nbPage = $nbObjet / (isset($_POST['nbObjetAffiche']) ? $_POST['nbObjetAffiche'] : '20') + 1;
				}
				else {
					$nbPage = (isset($_POST['nbObjetAffiche']) ? $_POST['nbObjetAffiche'] : '20') / $nbObjet;
				}
			}
			else {
				$nbPage = 0;
			}
		/* Fonction qui va créer les liens ainsi que les icones à afficher dans les options des tableaux
		 * en paramètre, nous allons demander un tableau d'option suivant la norme
		 * $argsTableau = array(
		 * 		'idObjet' => 'id de l'objet pour lequel s'applique les options',
		 'options' => array(
		 'type' => 'Type de ligne pour définir notre option',
		 'lien' => 'Lien vers lequel pointe l'option'
		 )
		 * )
		 * ainsi qu'un deuxième paramètre qui sera l'ID de l'objet (pour lier les options au bon objet)
		 * exemple: fichier '_plugins\myCompta\viewModels\operations
			 */
			// On va préparer notre tableau d'objet pour afficher notre page
			/*$argsPage = array(
				'urlAjout' => "index.php?module=" . $nomPlugin . "&rubrique=referentiel&param=" . $_GET['param'] . "&action=ajout",
				'nbPage' => $nbPage,
				'tableauDonnees' => array(
						'enTete' => $monObjet->getTableEnTeteDefinition(),
						'donnees' => $listeObjets,
						'options' => array (
							'idObjet' => 'idReferenceImprimante',
							'type' => 'affiche',
							'lien' => 'index.php?module=myParc&rubrique=referentiel&param=imprimantes'
						)
				),
				'champRecherche' => $monObjet->getTableEnTeteDefinition()
			);
			$corpsPage = '_frameworks/myFrameWork/views/_defaultHomeListe';
		}
		
		// On affiche le corps de la page
		include ($corpsPage . '.php');
	}
	else {
		// On affiche la page 404
		include ('_templates/' .  $_SESSION['template'] . '/views/404.php');
	}
}
else {
	
	include_once '_plugins/' . $nomPlugin . '/views/referentielTableauBord.php';
}*/