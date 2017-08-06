<?php
require_once $GLOBALS['root'] . '_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class ReferentielLogiciel extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idReferenceLogiciel;
	protected $type;
	protected $idEditeur;
	protected $famille;
	protected $nom;
	protected $version;
	protected $productNumber;
	protected $onArchive;
	
	/* Information sur notre base mais ne devant pas figurer dans
	 * notre tableau de définitions
	 */
	protected $nomTable = "myparc_referentielLogiciels";
	protected $nomID = "idReferenceLogiciel";
	protected $suiviModification = true;
	
	
	/* On va définir notre table
	 * $typeChamp => le type de champ dans la table,
	 * $primaryKey => définit si le champ est la clé primaire (unique)
	 * $autoIncrement => si le champ s'incrémente automatiquement (nécessite un champ int)
	 * $notNull => Si le champ peut être null ou pas
	 * $unique => si le champ doit être unique
	 */
	public function getBaseDefinition() {
		$baseDefinition = array(
				'idReferenceLogiciel' => $this->baseDefinition('int',true,true,true,true),
				'type' => $this->baseDefinition('varchar(15)',false,false,false,false),
				'idEditeur' => $this->baseDefinition('int',false,false,false,false),
				'famille' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'nom' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'version' => $this->baseDefinition('varchar(10)',false,false,false,false),
				'productNumber' => $this->baseDefinition('varchar(50)',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idReferenceLogiciel' => setTableLigneDefinition(null,false,$baseDefinition['idReferenceLogiciel']['typeChamp']),
				'famille' => setTableLigneDefinition("Famille",true,$baseDefinition['famille']['typeChamp']),
				'nom' => setTableLigneDefinition("Nom",true,$baseDefinition['nom']['typeChamp']),
				'productNumber' => setTableLigneDefinition("P/N",true,$baseDefinition['productNumber']['typeChamp'])
		);
	}
}