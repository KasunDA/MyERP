<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Operation extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idOperation;
	protected $date;
	protected $idCompte;
	protected $type;
	protected $mode;
	protected $numCheque;
	protected $idCategorie;
	protected $typeTiers;
	protected $beneficiaire;
	protected $idTiers;
	protected $description;
	protected $montant;
	protected $idVirement;
	protected $idEcheance;
	protected $estVentile;
	protected $estRapproche;

	
	protected $monCompte;
	protected $maCategorie;
	protected $monTiers;
	protected $typeMontantChampNom = "type";

	protected function getClasseDefinition() {
		$this->nomTable = "mycompta_operations";
		$this->nomID = "idOperation";
		$this->suiviModification = true;
		$this->champTriDefaut = array('date');
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
				'idOperation' => $this->baseDefinition('int',true,true,true,true),
				'date' => $this->baseDefinition('date',false,false,false,false),
				'idCompte' => $this->baseDefinition('int',false,false,false,false),
				'type' => $this->baseDefinition('varchar(1)',false,false,false,false),
				'mode' => $this->baseDefinition('varchar(3)',false,false,false,false),
				'numCheque' => $this->baseDefinition('int',false,false,false,false),
				'idCategorie' => $this->baseDefinition('int',false,false,false,false),
				'typeTiers' => $this->baseDefinition('varchar(1)',false,false,false,false),
				'beneficiaire' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'idTiers' => $this->baseDefinition('int',false,false,false,false),
				'description' => $this->baseDefinition('varchar(200)',false,false,false,false),
				'montant' => $this->baseDefinition('float',false,false,false,false),
				'idVirement' => $this->baseDefinition('int',false,false,false,false),
				'idEcheance' => $this->baseDefinition('int',false,false,false,false),
				'estVentile' => $this->baseDefinition('tinyint',false,false,false,false),
				'estRapproche' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}

	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idOperation' => setTableLigneDefinition(null,false,$baseDefinition['idOperation']['typeChamp']),
				'date' => setTableLigneDefinition("Date",true,$baseDefinition['date']['typeChamp']),
				'beneficiaire' => setTableLigneDefinition("Bénéficiaire",true,$baseDefinition['beneficiaire']['typeChamp']),
				'description' => setTableLigneDefinition("Description",true,$baseDefinition['description']['typeChamp']),
				'montant' => setTableLigneDefinition("Montant",true,$baseDefinition['montant']['typeChamp'])
		);
	}
	
	public function getListeObjet($args = null) {
		$maConnexion = $this->getConnexion();
	
		/* ------------------------------------------------
		 * On va r�cup�rer les �ch�ances en fonction du
		 * nombre de jours d�finis en param�tre
		 * ------------------------------------------------
		 */
		$requete = "SELECT idOperation
			FROM " . $this->nomTable . "
			WHERE
				idCompte = '" . $args['specifiqueClasse']['idCompte'] . "'
			AND
				(
				date >= '" . $args['specifiqueClasse']['debutPeriode'] . "'
			AND
				DATE <= '" . $args['specifiqueClasse']['finPeriode'] . "')";
		// Nous allons analyser si nous devons récupérer les opérations non rapprochées
		switch (isset($args['specifiqueClasse']) && $args['specifiqueClasse']['estRapproche']) {
			case '-1':
				$requete = $requete . " AND estRapproche is NULL";
				break;
			case '1':
				$requete = $requete . " AND estRapproche = '1'";
				break;
			default:
				$requete = $requete;
				break;
		}
		$requete = $requete . " ORDER BY date DESC";
		$requete = $maConnexion->query($requete);
		$tableID = $requete->fetchAll();
		$tableObjet = null;
		foreach ($tableID as $id) {
			$tableObjet[] = new Operation(array('idObjet'=>$id['idOperation']));
		}
	
		return $tableObjet;
	}
}

