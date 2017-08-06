<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Personne extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idPersonne;
	protected $civilite;
	protected $nom;
	protected $nomJF;
	protected $prenom;
	protected $numVoie;
	protected $indRepetition;
	protected $libelleVoie;
	protected $complementVoie;
	protected $idVille;
	protected $telephone;
	protected $mobile;
	protected $email;
	protected $dateNaissance;
	protected $onArchive;
	
	protected function getClasseDefinition() {
		$this->nomTable = "mycontacts_personnes";
		$this->nomID = "idPersonne";
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
				'idPersonne' => $this->baseDefinition('int',true,true,true,true),
				'civilite' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'nom' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'nomJF' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'prenom' => $this->baseDefinition('varchar(200)',false,false,false,false),
				'numVoie' => $this->baseDefinition('int',false,false,false,false),
				'indRepetition' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'libelleVoie' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'complementVoie' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'idVille' => $this->baseDefinition('int',false,false,false,false),
				'telephone' => $this->baseDefinition('varchar(10)',false,false,false,false),
				'mobile' => $this->baseDefinition('varchar(10)',false,false,false,false),
				'email' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'dateNaissance' => $this->baseDefinition('date',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idPersonne' => setTableLigneDefinition(null,false,$baseDefinition['idPersonne']['typeChamp']),
				'nom' => setTableLigneDefinition("Nom",true,$baseDefinition['nom']['typeChamp']),
				'prenom' => setTableLigneDefinition("Prénom",true,$baseDefinition['prenom']['typeChamp']),
				'telephone' => setTableLigneDefinition("Téléphone",true,$baseDefinition['telephone']['typeChamp'],null,array('center')),
				'mobile' => setTableLigneDefinition("Mobile",true,$baseDefinition['mobile']['typeChamp'],null,array('center')),
				'email' => setTableLigneDefinition("Email",true,$baseDefinition['email']['typeChamp'],'mail',array('center'))
		);
	}
}
?>

