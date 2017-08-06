<?php
require_once $GLOBALS['root'] . '_plugins/myCompta/class/Famille.php';

// On va définir notre classe
class Categorie extends Famille
{
	// Définition des variables correspondant à notre table dans la base
	protected $idCategorie;
	protected $idFamille;
	protected $nomCategorie;
	protected $typeOperation;
	protected $onArchive;

	protected $nomTable = "mycompta_categories";
	protected $nomID = "idCategorie";

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
			$mafamille = new Famille(array('idObjet' => $this->idFamille));
			$this->nomFamille = $mafamille->getValeur('nomFamille');
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
				'idCategorie' => $this->baseDefinition('int',true,true,true,true),
				'idFamille' => $this->baseDefinition('int',false,false,false,false),
				'nomCategorie' => $this->baseDefinition('varchar(45)',false,false,false,false),
				'typeOperation' => $this->baseDefinition('varchar(1)',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idCategorie' => setTableLigneDefinition(null,false,$baseDefinition['idCategorie']['typeChamp']),
				'nomCategorie' => setTableLigneDefinition("Catégorie",true,$baseDefinition['nomCategorie']['typeChamp']),
				'typeOperation' => setTableLigneDefinition("Type",true,$baseDefinition['typeOperation']['typeChamp']),
		);
	}

	public function getListeObjet($args = null) {
		$maConnexion = $this->getConnexion();
	
		/* ------------------------------------------------
		 * On va r�cup�rer les �ch�ances en fonction du
		 * nombre de jours d�finis en param�tre
		 * ------------------------------------------------
		 */
		$requete = "SELECT c.idCategorie as idObjet
			FROM " . $this->nomTable . " c LEFT JOIN mycompta_familles f ON c.idFamille = f.idFamille
			WHERE
				c.onArchive is null ";
		if (isset($args['typeOperation'])){
			$requete = $requete . "
		AND
			c.typeOperation = '" . $args['typeOperation'] . "'" ;
		}
		$requete = $requete . " ORDER BY f.nomFamille,c.nomCategorie ASC";
		$requete = $maConnexion->query($requete);
		$tableID = $requete->fetchAll();
		$tableObjet = null;
		foreach ($tableID as $id) {
			$tableObjet[] = new Categorie(array('idObjet' => $id['idObjet']));
		}
		return $tableObjet;
	}
}