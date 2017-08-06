<?php
require_once 'Personne.php';
require_once $GLOBALS['root']. '_MyFrameWork/fonctions.php';

// On va définir notre classe
class Collaborateur extends Personne
{
	// Définition des variables correspondant à notre table dans la base
	protected $idCollaborateur;
	protected $idPersonne;
	protected $idSociete;
	protected $idSite;
	protected $fonction;
	protected $telephone;
	protected $telIntraSite;
	protected $telInterSite;
	protected $mobile;
	protected $fax;
	protected $mail;
	protected $dateDebut;
	protected $dateSortie;
	protected $onArchive;
	
	
	/* Variable permettant l'afficheage du nom, prenom ou les deux 
	 * 
	 */
	protected $nomPrenom;
	
	/* Information sur notre base mais ne devant pas figurer dans
	 * notre tableau de définitions
	 */
	protected $nomTable = "caCollaborateurs";
	protected $nomID = "idCollaborateur";
	protected $champTriDefaut = 'idCollaborateur';
	protected $ordreTriDefaut = "ASC";
	
	public function __construct($idObjet = null) {
		/* On va permettre la création de notre objet
		 * en saisissant un ID afin de l'initialiser directement
		 */
		if (isset($idObjet) AND (int)$idObjet > 0) {
			$this->getObjet($idObjet);
			//var_dump(parent::__construct($this->idPersonne));
			
			$personne = new Personne($this->idPersonne);
			//var_dump($personne);
			//$this->nom = parent::getValeur('nom');
			$this->nom = $personne->getValeur('nom');
			$this->prenom = $personne->getValeur('prenom');
			$this->nomPrenom = $personne->getValeur('nom') . " " . $personne->getValeur('prenom');
		}
	}
		
	public function getDefinition() {
		/* cette fonction a pour but de définir la construction de notre classe 
		 * en indiquant les différents comportements en fonction de son utilisation 
		 * dans l'application
		 */
		$tableDefinition = array (
				'idCollaborateur' => setTableDefinition('int',null,false,'idCollaborateur'),
				'idPersonne' => setTableDefinition('int',null,false,'idPersonne'),
				'idSociete' => setTableDefinition('int',null,false,'idSociete'),
				'idSite' => setTableDefinition('int',null,false,'idSite'),
				'nom' =>  setTableDefinition(null,null,True,'Nom'),
				'prenom' =>  setTableDefinition(null,null,True,'Prenom'),
				'fonction' => setTableDefinition('varchar','255',true,'fonction'),
				'telephone' => setTableDefinition('varchar','15',true,'Téléphone'),
				'telIntraSite' => setTableDefinition('varchar','10',false,'Tél. intraSite'),
				'telInterSite' => setTableDefinition('varchar','10',false,'Tél. interSite'),
				'mobile' => setTableDefinition('varchar','15',true,'Mobile'),
				'fax' => setTableDefinition('varchar','15',false,'Fax'),
				'mail' => setTableDefinition('varchar','255',false,'Email'),
				'dateDebut' => setTableDefinition('date',null,false,'Date Entrée'),
				'dateSortie' => setTableDefinition('date',null,false,'Date Sortie'),
				'onArchive' => setTableDefinition('tinyint',null,false,'Archivé')				
		);
		return  $tableDefinition;
	}
	
	/* On va surcharger la fonction getListeRequeteID pour pouvoir récupérer uniquement
	 * les colaborateurs à partir d'un idSociete donné
	 */
	public function getListeRequeteID($args) {
		$maConnexion = parent::ouvreConnexion();
		// On va d'abord compte le nombre de résultat sans le filte des pages
		$requete = "SELECT count(idCollaborateur) as NbResultat 
				FROM caCollaborateurs 
				WHERE 
					dateSortie is null
				AND
					idSite = " . $args['idSite'] .
				" AND
					idSociete = " . $args['idSociete'];
		$query = $maConnexion->query($requete);
		$nbResultat = $query->fetchAll();
		// On va maintenant récupérer les données
		$requete = "SELECT idCollaborateur 
				FROM caCollaborateurs INNER JOIN refPersonnes ON caCollaborateurs.idPersonne = refPersonnes.idPersonne
				WHERE 
					dateSortie is null
				AND
					idSite = " . $args['idSite'] . " 
				AND
					idSociete = " . $args['idSociete'] . "
				ORDER BY nom ASC";
		$query = $maConnexion->query($requete);
		$tableID = $query->fetchAll();
	
		$tableObjet = array();
		// On prépare notre tableau d'objet
		foreach ( $tableID as $valeur){
			$tableObjet[] = new Collaborateur($valeur[$this->getValeur('nomID')]);
		}
	
		// on ajoute notre résultat à notre tableau
		$tableRetour['nbResultat'] = $nbResultat[0]['NbResultat'];
		$tableRetour['donnees'] = $tableObjet;
		// On renvoie notre tableau
		return $tableRetour;
	}
}
?>

