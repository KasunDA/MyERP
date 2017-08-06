<?php
require_once $GLOBALS['root'] . '_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class ReferentielImprimante extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idReferenceImprimante;
	protected $typeMachine;
	protected $idConstructeur;
	protected $modele;
	protected $nomCommercial;
	protected $productNumber;
	protected $memoire;
	protected $onReseau;
	protected $onArchive;
	
	/* Information sur notre base mais ne devant pas figurer dans
	 * notre tableau de définitions
	 */
	protected $nomTable = "myparc_referentielImprimantes";
	protected $nomID = "idReferenceImprimante";
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
				'idReferenceImprimante' => $this->baseDefinition('int',true,true,true,true),
				'typeMachine' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'idConstructeur' => $this->baseDefinition('int',false,false,false,false),
				'modele' => $this->baseDefinition('varchar(50)',false,false,false,false),
				'nomCommercial' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'productNumber' => $this->baseDefinition('varchar(50)',false,false,false,false),
				'memoire' => $this->baseDefinition('float',false,false,false,false),
				'onReseau' => $this->baseDefinition('tinyint',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idReferenceImprimante' => setTableLigneDefinition(null,false,$baseDefinition['idReferenceImprimante']['typeChamp']),
				'typeMachine' => setTableLigneDefinition("Type",true,$baseDefinition['typeMachine']['typeChamp']),
				'modele' => setTableLigneDefinition("Modèle",true,$baseDefinition['modele']['typeChamp']),
				'productNumber' => setTableLigneDefinition("P/N",true,$baseDefinition['productNumber']['typeChamp'])
		);
	}
}
