<?php 
/* On va analyser le user/pass
 * saisie à l'écran du login
 * 
 */
if (!isset($_SESSION['connexionValid'])) {
	if (isset($_POST['login'])) {
		// On se connecte à la base pour récupérer les informations de l'objet
		require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyBDD.php';
		$maConnexion = new MyBDD();
		$maConnexion = $maConnexion->getConnexion();
		$requete = $maConnexion->query("SELECT idUser FROM _users WHERE utilisateur= '" . htmlSpecialChars($_POST['user']) . "' AND pass = '" . md5(htmlspecialchars($_POST['password'])) . "'");
		$donnees = $requete->fetch();
		if (isset($donnees['idUser'])) {
			require_once $_SERVER['DOCUMENT_ROOT'] . '/_main/class/User.php';
			$monUser = new User(array('idObjet' => $donnees['idUser']));

			// Notre connexion est valide, on va donc renseigner nos variables de session
			if ($monUser->getValeur('onArchive') === null) {
				
				if ($monUser->getValeur('acces') > 0) {
					$_SESSION['connexionValid'] = true;
					$_SESSION['id'] = $donnees['idUser'];
					$_SESSION['template'] = $monUser->getValeur('template');
					$_SESSION['user'] = $monUser->getValeur('utilisateur');
					$_SESSION['idPersonne'] = $monUser->getValeur('idPersonne');
					$_SESSION['identite'] = $monUser->getValeur('nom') . ' ' . $monUser->getValeur('prenom'); 
					
					$_SESSION['niveauAccesGeneral'] = $monUser->getValeur('acces');
					
					// On va définir les niveau d'accès pour chaque plugin
					require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/fonctions/_myERP.php';
					$listePlugin = listeDossiers(array('dossier' => 'plugins'));
					foreach ($listePlugin as $plugin) {
						if ($monUser->getDroit($plugin)) {
							$_SESSION[$plugin] = $monUser->getDroit($plugin);
						}
						else {
							$_SESSION[$plugin] = 0;
						}
					}
				}
				else {
					$_SESSION['connexionValid'] = false;
					$erreur = '?error=3';
				}
			}
			else {
				$_SESSION['connexionValid'] = false;
				$erreur = '?error=2';
			}		
		}
		else {
			$_SESSION['connexionValid'] = false;
			$erreur = '?error=1';
		}
	}
	else {
		$erreur = null;
		$_SESSION['connexionValid'] = false;
	}
}
else {
	if (isset($_GET['module']) AND $_GET['module'] === 'logout') {
		$_SESSION['connexionValid'] = false;
		$erreur = null;
	}
}

// Si pas de connexion valide, on renvoie sur l'écran de login
if (!$_SESSION['connexionValid']) {
	session_destroy();
	header('Location: login.php' . $erreur);	
}