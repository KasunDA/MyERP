<?php
// Déclaration de nos classes
require_once $_SERVER['DOCUMENT_ROOT'] . '/_main/class/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/_main/class/General.php';

// On affiche le menu à gauche
include_once $_SERVER['DOCUMENT_ROOT'] . '/_main/views/parametresMenu.php';

// On va vérifier quel paramètre nous devons afficher
if (isset($_GET['rubrique'])){
	switch ($_GET['rubrique']) {
		case 'Profil':
			// On va vérifier si un enregistrement est en cours
			if (isset($_POST['formulaire']) && isset($_POST['enreg'])){
				$idObjet = setDataForm('User',isset($_POST['idUser']) ? $_POST['idUser'] : null);
			}
			
			// Récupération des informations utilisateurs/liste de nos templates
			$user = new User(array('idObjet' => $_SESSION['id']));
			$listeTemplate = listeDossiers(array('dossier' => 'templates'));
			
			$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_main/views/parametresProfil.php';
			break;
		case 'User':
			if ($_SESSION['niveauAccesGeneral']=== '9') {
				// On prépare nos variables utilisés dans certaines pages
				$listePlugins= listeDossiers(array('dossier' => 'plugins'));
				$listeTemplate = listeDossiers(array('dossier' => 'templates'));
				
				// On définit nos variables qui ne serviront que si nous affichons la liste
				$nomPlugin = null;
				$nomClasse = 'User'; // Doit être identique à la rubrique
				$nomPageFormulaire = 'parametresUserFormulaire'; // ne pas mettre l'extension php
				$nomPageTableauBord = null;
				$champsRecherche = true;
				$afficheOption = true;
				$specifiqueClasse = null;
				$tailleContent = 'three_quarter';
				$titrePage = 'Gestion des utilisateurs';
				$chargeListe = true;
				
				$corpsPage = '_frameworks/myFrameWork/viewModels/myERP.php';
			}
			else {
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
			}
			break;
		case 'SQL':
			if ($_SESSION['niveauAccesGeneral']=== '9') {
				// On va charger les paramètres SQL
				require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyConfig.php';
				$maConfig = new MyConfig();
				$maConfig = $maConfig->getSQLConfig();
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_main/views/parametresSQL.php';
			}
			else {
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
			}
			break;
		case 'General':
			if ($_SESSION['niveauAccesGeneral']=== '9') {
				// On va vérifier si un enregistrement est en cours
				if (isset($_POST['formulaire']) && isset($_POST['enreg'])){
					$idObjet = setDataForm('General');
				}
				
				$monObjet = new General(array('idObjet' => '1'));
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_main/views/parametresGeneral.php';
			}
			else {
				$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/accesInterdit.php';
			}
			break;
		default:
			$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_templates/' . $_SESSION['template'] . '/views/404.php';
			break;
	}
}
else {
	/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! 
	 * 
	 * INFORMATIONS RECOPIEES DU CASE 'profil'
	 * 
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 */
	$user = new User(array('idObjet' => $_SESSION['id']));
	$listeTemplate = listeDossiers(array('dossier' => 'templates'));
	$corpsPage = $_SERVER['DOCUMENT_ROOT'] . '/_main/views/parametresProfil.php';
}

include $corpsPage;

