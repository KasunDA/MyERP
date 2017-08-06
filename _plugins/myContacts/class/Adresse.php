<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myContacts/class/Ville.php';

// On va définir notre classe
class Adresse extends Ville
{
	// Définition des variables correspondant à notre table dans la base
	protected $idAdresse;
	protected $numVoie;
	protected $indRepetition;
	protected $libelleVoie;
	protected $complementVoie;
	protected $onArchive;

	/* Information sur notre base mais ne devant pas figurer dans
	 * notre tableau de définitions
	 */
	protected $nomTable = "refAdresses";
	protected $nomID = "idAdresse";
	protected $champTriDefaut = "numVoie";
	protected $ordreTriDefaut = "ASC";
	
	
	protected function getClasseDefinition() {
		$this->nomTable = "mycontacts_adresses";
		$this->nomID = "idAdresse";
		$this->suiviModification = true;
		$this->champTriDefaut = array('libelleVoie','numVoie');
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
				'idAdresse' => $this->baseDefinition('int',true,true,true,true),
				'idVille' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'numVoie' => $this->baseDefinition('int',false,false,false,false),
				'indRepetition' => $this->baseDefinition('varchar(10)',false,false,false,false),
				'libelleVoie' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'complementVoie' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idAdresse' => setTableLigneDefinition(null,false,$baseDefinition['idAdresse']['typeChamp']),
				'numVoie' => setTableLigneDefinition("N°",true,$baseDefinition['numVoie']['typeChamp']),
				'indRepetition' => setTableLigneDefinition("Indice",true,$baseDefinition['indRepetition']['typeChamp']),
				'libelleVoie' => setTableLigneDefinition("Voie",true,$baseDefinition['libelleVoie']['typeChamp']),
				'codePostal' => setTableLigneDefinition("Code Postal",true,'varchar(5)'),
				'libelleVille' => setTableLigneDefinition("Ville",true,'varchar(100)')
		);
	}
	

}
?>
