<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Banque.php';


// On va définir notre classe
class Compte extends Banque
{
	// Définition des variables correspondant à notre table dans la base
	protected $idCompte;
	protected $idBanque;
	protected $libelleCompte;
	protected $typeCompte;
	protected $idTitulaire;
	protected $soldeInitial;
	protected $comptePrincipal;
	protected $onArchive;
	
	protected $banque;
	protected $personne;
	protected $soldeCours;
	protected $soldeNonRapproche;
	protected $soldeReel;

	protected function getClasseDefinition() {
		$this->nomTable = "mycompta_comptes";
		$this->nomID = "idCompte";
		$this->suiviModification = true;
		$this->champTriDefaut = array('libelleCompte');
		$this->ordreTriDefaut = 'ASC';
	}

	
	public function __construct($args = null) {
		/* On va permettre la création de notre objet
		 * en saisissant un ID afin de l'initialiser directement
		 */
		$this->majDefinitionObjetTable();
		/* On va permettre la création de notre objet
		 * en saisissant un ID afin de l'initialiser directement
		 */
		if (isset($args) AND isset($args['idObjet']) AND (int)$args['idObjet'] > 0) {
			
		
			$maConnexion = $this->getConnexion();
			$requete = $maConnexion->query("SELECT * FROM " . $this->nomTable ." WHERE " . $this->nomID . " = " . $args['idObjet'] );
			$donnee = $requete->fetch();
			$tableChamps = $this->getBaseDefinition();
			foreach ( $tableChamps as $cle => $valeur){
				$this->$cle = $donnee[$cle];
			}
			$maBanque = new Banque(array('idObjet' => $this->idBanque));
			$this->idBanque = $maBanque->getValeur('idBanque');
			$this->nomBanque = $maBanque->getValeur('nomBanque');

			// Nous allons initialiser nos soldes
			$this->getSolde();
		
		}
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
				'idCompte' => $this->baseDefinition('int',true,true,true,true),
				'idBanque' => $this->baseDefinition('int',false,false,false,false),
				'libelleCompte' => $this->baseDefinition('varchar(45)',false,false,false,false),
				'typeCompte' => $this->baseDefinition('varchar(1)',false,false,false,false),
				'idTitulaire' => $this->baseDefinition('int',false,false,false,false),
				'soldeInitial' => $this->baseDefinition('float',false,false,false,false),
				'comptePrincipal' => $this->baseDefinition('tinyint',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idCompte' => setTableLigneDefinition('idCompte',false,$baseDefinition['idCompte']['typeChamp']),
				'libelleCompte' => setTableLigneDefinition("Libellé Compte",true,$baseDefinition['libelleCompte']['typeChamp'])
		);
	}
	
	
	public function getListeObjet($idBanque = null) {
		$maConnexion = $this->getConnexion();
	
		/* ------------------------------------------------
		 * On va r�cup�rer les �ch�ances en fonction du
		 * nombre de jours d�finis en param�tre
		 * ------------------------------------------------
		 */
		$requete = "SELECT c.idCompte as idObjet
			FROM " . $this->nomTable . " c LEFT JOIN mycompta_banques b ON c.idBanque = b.idBanque
			WHERE
				b.onArchive is null
			AND
				c.onArchive is null
			ORDER BY b.nomBanque,c.libelleCompte ASC";
		$requete = $maConnexion->query($requete);
		$tableID = $requete->fetchAll();
		$tableObjet = null;
		foreach ($tableID as $id) {
			$tableObjet[] = new Compte(array('idObjet' => $id['idObjet']));
		}
		return $tableObjet;
	}

	// Nous allons créer une fonction pour récupérer le solde en cours d'un compte
	public function getSolde() {
		/* Nous allons commencer par récupérer le montant du solde
		 * en ne tenant compte que des opérations rapprochés
		 */
		$requete = "SELECT round(sum(montant),2) as montant,
				type
			FROM mycompta_operations
			WHERE
				estRapproche = '1'
			AND
				idCompte = '" . $this->idCompte . "'
			GROUP BY type";
		$this->soldeCours = $this->soldeInitial;
		$montantOperationCours = $this->myQuery($requete);
		foreach ($montantOperationCours as $sommeOperation) {
			switch ($sommeOperation['type']) {
				case 'C':
					$this->soldeCours = $this->soldeCours + $sommeOperation['montant'];
					break;
				case 'D':
					$this->soldeCours = $this->soldeCours - $sommeOperation['montant'];
					break;
				default:
					$this->soldeCours = $this->soldeCours;
					break;
			}
		}
		$this->soldeCours = $this->soldeCours;
		
		/* Nous allons ensuite récupérer le montant des opérations
		 * non rapprochées
		 */
		$requete = "SELECT round(sum(montant),2) as montant,
				type
			FROM mycompta_operations
			WHERE
				estRapproche is null
			AND
				idCompte = '" . $this->idCompte . "'
			GROUP BY type";
		$this->soldeNonRapproche = 0;
		$montantOperationCours = $this->myQuery($requete);
		foreach ($montantOperationCours as $sommeOperation) {
			switch ($sommeOperation['type']) {
				case 'C':
					$this->soldeNonRapproche = $this->soldeNonRapproche + $sommeOperation['montant'];
					break;
				case 'D':
					$this->soldeNonRapproche = $this->soldeNonRapproche - $sommeOperation['montant'];
					break;
				default:
					$this->soldeNonRapproche = $this->soldeNonRapproche;
					break;
			}
		}
		/* nous allons ensuite récupérer la liste des échéances à intégrer pour
		 * ce compte
		 */
		
		
		/* Il ne nous reste plus qu'à calculer les différents soldes attendues 
		 * et utilisables dans notre application
		 */
		$this->soldeReel = (float)$this->soldeCours + (float)$this->soldeNonRapproche;
		
		// On va arrondir nos soldes 
		$this->soldeCours = number_format($this->soldeCours, 2);
		$this->soldeNonRapproche = number_format($this->soldeNonRapproche, 2);
		$this->soldeReel = number_format($this->soldeReel, 2);
	}

}

