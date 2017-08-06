<?php
require_once $GLOBALS['root'] . '_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class ReferentielOrdinateur extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idReferenceOrdinateur;
	protected $typeMachine;
	protected $idConstructeur;
	protected $modele;
	protected $nomCommercial;
	protected $productNumber;
	protected $processeur;
	protected $processeurModele;
	protected $memoire;
	protected $hdd;
	protected $tailleEcran;
	protected $onArchive;
	
	/* Information sur notre base mais ne devant pas figurer dans
	 * notre tableau de définitions
	 */
	protected $nomTable = "myparc_referentielOrdinateurs";
	protected $nomID = "idReferenceOrdinateur";
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
				'idReferenceOrdinateur' => $this->baseDefinition('int',true,true,true,true),
				'typeMachine' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'idConstructeur' => $this->baseDefinition('int',false,false,false,false),
				'modele' => $this->baseDefinition('varchar(50)',false,false,false,false),
				'nomCommercial' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'productNumber' => $this->baseDefinition('varchar(50)',false,false,false,false),
				'processeur' => $this->baseDefinition('varchar(10)',false,false,false,false),
				'processeurModele' => $this->baseDefinition('varchar(50)',false,false,false,false,'referenceProcesseur'),
				'memoire' => $this->baseDefinition('float',false,false,false,false),
				'hdd' => $this->baseDefinition('int',false,false,false,false),
				'tailleEcran' => $this->baseDefinition('float',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idReferenceOrdinateur' => setTableLigneDefinition(null,false,$baseDefinition['idReferenceOrdinateur']['typeChamp']),
				'typeMachine' => setTableLigneDefinition("Type",true,$baseDefinition['typeMachine']['typeChamp']),
				'modele' => setTableLigneDefinition("Modèle",true,$baseDefinition['modele']['typeChamp']),
				'productNumber' => setTableLigneDefinition("P/N",true,$baseDefinition['productNumber']['typeChamp'])
		);
	}
}
?>