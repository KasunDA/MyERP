<?php
require_once $GLOBALS['root'] . '_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Banque extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idBanque;
	protected $nomBanque;
	protected $email;
	protected $telephone;
	protected $onArchive;
	protected $url;
	
	protected $nomTable = "mycompta_banques";
	protected $nomID = "idBanque";
	
	/* On va définir notre table
	 * $typeChamp => le type de champ dans la table,
	 * $primaryKey => définit si le champ est la clé primaire (unique)
	 * $autoIncrement => si le champ s'incrémente automatiquement (nécessite un champ int)
	 * $notNull => Si le champ peut être null ou pas
	 * $unique => si le champ doit être unique
	 */
	public function getBaseDefinition() {
		$baseDefinition = array(
				'idBanque' => $this->baseDefinition('int',true,true,true,true),
				'nomBanque' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'email' => $this->baseDefinition('varchar(200)',false,false,false,false),
				'telephone' => $this->baseDefinition('varchar(45)',false,false,false,false),
				'url' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idBanque' => setTableLigneDefinition(null,false,$baseDefinition['idBanque']['typeChamp']),
				'nomBanque' => setTableLigneDefinition("Nom Banque",true,$baseDefinition['nomBanque']['typeChamp']),
				'url' => setTableLigneDefinition("URL",true,$baseDefinition['url']['typeChamp'])
		);
	}
}

