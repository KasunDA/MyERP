<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Famille extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idFamille;
	protected $nomFamille;
	protected $onArchive;

	protected function getClasseDefinition() {
		$this->nomTable = "mycompta_familles";
		$this->nomID = "idFamille";
		$this->suiviModification = true;
		$this->champTriDefaut = array('nomFamille');
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
				'idFamille' => $this->baseDefinition('int',true,true,true,true),
				'nomFamille' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idFamille' => setTableLigneDefinition(null,false,$baseDefinition['idFamille']['typeChamp']),
				'nomFamille' => setTableLigneDefinition("Famille",true,$baseDefinition['nomFamille']['typeChamp'])
		);
	}
}

