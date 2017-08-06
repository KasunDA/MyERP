<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Societe extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idSociete;
	protected $statut;
	protected $nom;
	protected $enseigne;
	protected $adresseLogo;
	protected $url;
	protected $telephone;
	protected $fax;
	protected $email;
	protected $onArchive;
	
	// Variables n'étant pas dans la base
	protected $tableType;
	protected $tableSite;

	protected function getClasseDefinition() {
		$this->nomTable = "mycontacts_societes";
		$this->nomID = "idSociete";
		$this->suiviModification = true;
		$this->champTriDefaut = 'nom';
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
				'idSociete' => $this->baseDefinition('int',true,true,true,true),
				'statut' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'nom' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'enseigne' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'adresseLogo' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'url' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'telephone' => $this->baseDefinition('varchar(10)',false,false,false,false),
				'fax' => $this->baseDefinition('varchar(10)',false,false,false,false),
				'email' => $this->baseDefinition('varchar(200)',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idSociete' => setTableLigneDefinition(null,false,$baseDefinition['idSociete']['typeChamp']),
				'statut' => setTableLigneDefinition("Statut",true,$baseDefinition['statut']['typeChamp'],null,array('td80','center')),
				'nom' => setTableLigneDefinition("Nom",true,$baseDefinition['nom']['typeChamp']),
				'url' => setTableLigneDefinition("Site Web",true,$baseDefinition['url']['typeChamp'],'url',array('center td100'))
		);
	}
	
	public function getSocieteTypeListe () {
		require_once $GLOBALS['documentRoot'] . '_MyFramework/MyBDD.php';
		$maConnexion = new MyBDD();
		// On définit notre requète
		$requete = "SELECT fournisseur,prestataire,client,prospect,constructeur,editeur,banque,assurance FROM 
			myContacts_societesType WHERE idSociete = " . $this->idSociete;
		$this->tableType = $maConnexion->myQuery($requete);
		
		// on renvoie les données
		//return $donnees;
	}
	
	public function getSocieteSiteListe ($idSociete = null) {
		if ($idSociete) {
			$this->idSociete = $idSociete;
		}
		require_once $GLOBALS['documentRoot'] . '_MyFramework/MyBDD.php';
		$maConnexion = new MyBDD();
		// On définit notre requète
		$requete = "SELECT * FROM myContacts_sites WHERE idSociete = " . $this->idSociete;
		$this->tableSite = $maConnexion->myQuery($requete);
	
		// on renvoie les données
		return $this->tableSite;
	}

}
?>