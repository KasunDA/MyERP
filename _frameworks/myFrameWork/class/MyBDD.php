<?php
// On va définir notre classe
class MyBDD
{
	// Définition des variables correspondant à notre table dans la base
	private $myConnexion = array();
	private $myDonnees = array();
	
	/* Le fichier de configuration sera chargé à chaque création d'un objet
	 * Il ne sera donc plus utile de faire appel au fichier de configuration
	 * dans le reste du code
	 */
	public function __construct() {
		return $this->etablirConnexion();
	}
	
	
	public function myQuery($requeteRemote){
		$requete = $this->myConnexion->query($requeteRemote);
		$donnees = $requete->fetchAll();
		$requete->closeCursor();
		foreach ($donnees as $cle => $valeur) {
			$this->myDonnees[$cle] = $valeur;
		}
		return $this->myDonnees;
	}
	
	/* On va créer notre fonction qui va établir la connexion
	 * Celle-ci sera renvoyé pour être réutilisé dans d'autres fonctions 
	 * ou endroit sur le site
	 */
	public function getConnexion(){
		return $this->etablirConnexion();
	}
	
	
	/* On va créer une fonction pour récupérer l'intégralité de notre table
	 * en fonction de l'argument qui correspond à un tableau associatif
	 */
	public function getDonnees($args) {
		// On prépare notre requete en fonction des paramètres envoyés
		switch ($args['type']) {
			case 'table':	$requetePrepare = "SELECT * FROM " .$args['chaine'];
				if (isset($args['tri'])) {
					//on trie
				}
				if (isset($args['limit'])) {
					//on trie
				}
				break;
			case 'requete': $requetePrepare = $args['chaine']; 
			default: break; // Pas de valeur par défaut
		}		
		/* On exécute la requete et on créer notre tableau de données
		 * que l'on va renvoyer
		 */
		$requete = $this->myConnexion->query($requetePrepare);
		$donnees = $requete->fetchAll();
		$requete->closeCursor();
		foreach ($donnees as $cle => $valeur) {
			$this->myDonnees[$cle] = $valeur;
		}
		return $this->myDonnees;
	}
	
/*	public function executeRequete($requete)
	{
		echo $requete;
		try {
			return $this->myDonnees->query($requete);
		}
		catch (Exception $e) {
			echo $e;
		}		
	}*/
	
	public function getTableID($args) {
	// On prépare notre requete en fonction des paramètres envoyés
	if ($args['tri']){
		$requete = "SELECT " . $args['nomID'] . "
 		FROM " . $args['nomTable'] . "
 		ORDER BY " . $args['tri'] . " " . $args['ordreTri'];
	}
	else {
		$requete = "SELECT " . $args['nomID'] . "
		FROM " . $args['nomTable'];
	}
	$requete = $this->myConnexion->query($requete);
	$donnees = $requete->fetchAll();
	$reponse->closeCursor();
	foreach ($donnees as $cle => $valeur) {
		$this->myDonnees[$cle] = $valeur;
	}
	return $this->myDonnees;
	}
	
	private function etablirConnexion() {
		//if (isset($GLOBALS['root'])) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyConfig.php';
/*		}
		else {
			require_once MyConfig.php';
		}*/
		$maConfig = new MyConfig();
		$tabSqlParam = $maConfig->getSQLConfig();
		switch ($tabSqlParam['typeBase']) {
			case 'mysql' :	try {
				$this->myConnexion = new PDO('mysql:host='. $tabSqlParam['address'] .';dbname=' . $tabSqlParam['baseName'] .
						';charset=utf8',$tabSqlParam['username'],$tabSqlParam['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch (Exception $e)
			{
				$this->myConnexion = null;
				die('bdd.php => Erreur SQL: ' . $e->getMessage());
			}
			break;
			default: $this->myConnexion = null;
			break;
		}
		unset($maConfig);
		return $this->myConnexion;
	}
	
	public function videTable($nomTable) {
		$requete = 'TRUNCATE TABLE ' . $nomTable;
		$requete = $this->myConnexion->prepare($requete);
		$requete->execute();
		$requete->closeCursor();
	}
}
?>
