<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Ville extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idVille;
	protected $codePostal;
	protected $codeInsee;
	protected $libelleVille;
	protected $onArchive;
	
	protected function getClasseDefinition() {
		$this->nomTable = "mycontacts_villes";
		$this->nomID = "idVille";
		$this->suiviModification = false;
		$this->champTriDefaut = 'libelleVille';
		$this->ordreTriDefaut = 'ASC';
	}
	
	/* On va définir notre table
	 * $typeChamp => le type de champ dans la table,
	 * $primaryKey => définit si le champ est la clé primaire (unique)
	 * $autoIncrement => si le champ s'incrémente automatiquement (nécessite un champ int)
	 * $notNull => Si le champ peut être null ou pas
	 * $unique => si le champ doit être unique
	 */
	public function getBaseDefinition() {
		$baseDefinition = array(
				'idVille' => $this->baseDefinition('int',true,true,true,true),
				'codePostal' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'codeInsee' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'libelleVille' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idVille' => setTableLigneDefinition(null,false,$baseDefinition['idVille']['typeChamp']),
				'codePostal' => setTableLigneDefinition("Code Postal",true,$baseDefinition['codePostal']['typeChamp']),
				'libelleVille' => setTableLigneDefinition("Ville",true,$baseDefinition['libelleVille']['typeChamp'])
		);
	}
	
	// Cette fonction va nous permettre de retourner une seule valeur selon le champ choisi
	public function getValeur($cle) {
		return $this->$cle;
	}
	
	public function getDroits($nomPlugin) {
		return array(
				'plugin' => $nomPlugin,
				'droits' => array(
						array('option' => 'modif',
								'niveauAcces' => '9')
				)
		);
	}
	
	/* On va créer une fonction qui va nous retourner un tableau
	 * qui sera utilisé pour les champs select
	*/
	/*public function getListeObjet($args = null) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyBDD.php';
		$maConnexion = new MyBDD();
		/* On va permettre le retour des différentes requetes en fonction de variables
		*/
		/*if ($args !== null){
			$requete = "SELECT idVille, codePostal, libelleVille FROM " . $this->nomTable . " WHERE onArchive is null AND " . $args['champ'] . " = '" . $args['valeur'] . "'  ORDER BY libelleVille ASC";
		}
		else {
			// Pas d'argument donc requete par défaut
			$requete = "SELECT idVille, codePostal, libelleVille FROM " . $this->nomTable . " WHERE onArchive is null ORDER BY codePostal ASC";
		}
	
		// On exécute la requète que l'on affecte à notre tableau d'objet
		$tableID = $maConnexion->myQuery($requete);		
		foreach ($tableID as $ligne){
			$tableObjet[] = new Ville(array('idObjet' => $ligne['idVille']));
		}
		return (isset($tableObjet) ? $tableObjet: null);
	} */
}
	
	
?>
