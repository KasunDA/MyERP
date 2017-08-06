<?php
require_once $GLOBALS['documentRoot'] . '_default/Models/Societe.php';
require_once $GLOBALS['documentRoot'] . '_MyFramework/fonctions.php';

// On va définir notre classe
class Site extends Societe
{
	// Définition des variables correspondant à notre table dans la base
	protected $idSite;
	protected $idSociete;
	protected $libelleSite;
	protected $telephone;
	protected $fax;
	protected $mail;
	protected $idVille;
	protected $onArchive;

	/* Information sur notre base mais ne devant pas figurer dans
	 * notre tableau de définitions
	 */
	protected $nomTable = "casites";
	protected $nomID = "idSite";
	protected $champTriDefaut = "libelleSite";
	protected $ordreTriDefaut = "ASC";
	
	public function __construct($idObjet = null) {
		/* On va permettre la création de notre objet
		 * en saisissant un ID afin de l'initialiser directement
		 */
		if (isset($idObjet) AND (int)$idObjet > 0) {
			$this->getObjet($idObjet);
			$maSociete = new Societe($this->idSociete);
			$this->nom = $maSociete->getValeur('nom');
		}
		
	}
	
	public function getDefinition() {
		/* cette fonction a pour but de définir la construction de notre classe
		 * en indiquant les différents comportements en fonction de son utilisation
		 * dans l'application
		 */
		$tableDefinition = array(
				'idSite' => setTableDefinition('int',null,false,'idSite'),
				'idSociete' => setTableDefinition('int',null,false,'idSociete'),
				'libelleSite' => setTableDefinition('varchar','45',true,'libelle Site'),
				'telephone' => setTableDefinition('varchar','15',true,'Telephone'),
				'fax' => setTableDefinition('varchar','15',true,'Fax'),
				'mail' => setTableDefinition('varchar','255',false,null),
				'idVille' => setTableDefinition('tinyint',null,false,null),
				'onArchive' => setTableDefinition('tinyint',null,false,null)
		);
		return  $tableDefinition;
	}
	
	/* On va surcharger la fonction getListeRequeteID pour pouvoir récupérer uniquement
	 * les sites à partir d'un idSociete donné
	 */
	
	public function getListeRequeteID($idSociete) {
		$maConnexion = parent::ouvreConnexion();
		
		// On va d'abord compte le nombre de résultat sans le filte des pages
		$requete = "SELECT count(idSite) as NbResultat FROM caSites WHERE idSociete = " . $idSociete;
		$query = $maConnexion->query($requete);
		$nbResultat = $query->fetchAll();
		// On va maintenant récupérer les données
		$requete = "SELECT idSite FROM caSites WHERE idSociete = " . $idSociete;
		$query = $maConnexion->query($requete);
		$tableID = $query->fetchAll();
		
		$tableObjet = array();
		// On prépare notre tableau d'objet
		foreach ( $tableID as $valeur){
			$tableObjet[] = new Site($valeur[$this->getValeur('nomID')]);
		}
		
		// on ajoute notre résultat à notre tableau
		$tableRetour['nbResultat'] = $nbResultat[0]['NbResultat'];
		$tableRetour['donnees'] = $tableObjet;
		// On renvoie notre tableau
		return $tableRetour;
	}

}
?>