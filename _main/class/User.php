<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myContacts/class/Personne.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/_main/class/Droits.php';

// On va définir notre classe
class User extends Personne
{
	// Définition des variables correspondant à notre table dans la base
	protected $idUser;
	protected $utilisateur;
	protected $pass;
	protected $acces;
	protected $idPersonne;
	protected $template;
	protected $onArchive;
	protected $Droits;

	/* On va surcharger la fonction de construction de l'objet
	 * afin d'aller récuperer les champs nom,prenom
	 */
	public function __construct($args = null) {
		$args = array(
				'idObjet' => ((isset($args) AND (int)$args['idObjet'] > 0) ? (int)$args['idObjet']: null),
				'classeParent' => array (
						'plugin' => 'myContacts',
						'maClasse' => 'Personne',
						'idLien' => 'idPersonne'
				),
				'classeLiens' => array(
						array(
								'plugin' => null,
								'classe' => 'Droits',
								'typeLien' => 'unique',
								'idReference' => 'idUser'
						)
				)
		);
		parent::__construct($args);
	}
	
	public function getClasseDefinition() {
		$this->suiviModification = false;
		$this->nomTable = "_users";
		$this->nomID = "idUser";
	}

	public function getBaseDefinition() {
		/* Le tableau d'en-tete sera construit de la même façon pour toutes les classes
* $nomChamp => nom du champ dans la table,
	 * $typeChamp => le type de champ dans la table,
	 * $lienBase => booleen pour savoir si le champ est dans la table,
	 * $afficheTableau => booleen pour savoir si on affiche dans le tableau,
	 * $nomAffiche => nom du label dans un tableau
		 */
		$baseDefinition = array(
				'idUser' =>  $this->baseDefinition('int',true,true,true,true),
				'utilisateur' => $this->baseDefinition('varchar(30)',false,false,false,false),
				'pass' =>  $this->baseDefinition('varchar(255)',false,false,false,false),
				'acces' =>  $this->baseDefinition('varchar(1)',false,false,false,false),
				'nom' =>  $this->baseDefinition('varchar(100)',false,false,false,false),
				'prenom' =>  $this->baseDefinition('varchar(200)',false,false,false,false),
				'email' =>  $this->baseDefinition('varchar(255)',false,false,false,false),
				'idPersonne' =>  $this->baseDefinition('int',false,false,false,false),
				'template' =>  $this->baseDefinition('varchar(30)',false,false,false,false),
				'onArchive' =>  $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idUser' => setTableLigneDefinition(null,false,$baseDefinition['idUser']['typeChamp']),
				'utilisateur' => setTableLigneDefinition("Utilisateur",true,$baseDefinition['utilisateur']['typeChamp']),
				'nom' => setTableLigneDefinition("Nom",true,$baseDefinition['nom']['typeChamp']),
				'prenom' => setTableLigneDefinition("Prénom",true,$baseDefinition['prenom']['typeChamp']),
				'email' => setTableLigneDefinition("Email",true,$baseDefinition['email']['typeChamp']),
		);
	}
	
	// On va surcharger la fonction setObjet afin de crypter le mot de passe
	public function setObjet() {
		// On ne re-crypte le mot de passe que si une demande de changement est demandée
		if (isset ($_POST['pass'])) {
			$this->pass = md5($_POST['pass']);
		}
		else {
			// On va gérer une exception pour le mot de passe afin de ne pas l'afficher dans le code source de la page
			if (isset ($_POST['idUser'])) {
				$userTemp = new User(array('idObjet' => $_POST['idUser']));
				$this->pass = $userTemp->pass;
			}
		}
		$idObjet = parent::setObjet();
		
		
		/* On ne va mettre à jour les droits que si la modification provient
		 * de la page utilisateur et non la page profil
		 */
		if (!isset($_POST['profil'])) {
			// On va ensuite enregistrer les droits par plugins
			$listePlugins= listeDossiers(array('dossier' => 'plugins'));
	
			// On va reconstruire notre objet pour remplir les liens
			$this->__construct(array('idObjet'=>$idObjet));
			foreach (listeDossiers(array('dossier' => 'plugins')) as $plugin){
				if ($this->getValeur('Droits')) {
					$droitExiste = false;
					foreach ($this->getValeur('Droits') as $droit) {
						if ($droit->getValeur('plugin') === $plugin) {
							$droit->setValeur('typeAcces',$_POST[$plugin]);
							$droit->setObjet();
							$droitExiste = true;
						}
					}
					if (!$droitExiste) {
						$droit = new Droits();
						$droit->setValeur('idUser',$idObjet);
						$droit->setValeur('plugin',$plugin);
						$droit->setValeur('typeAcces',$_POST[$plugin]);
						$droit->setObjet();
					}
				}
				else {
					$droit = new Droits();
					$droit->setValeur('idUser',$idObjet);
					$droit->setValeur('plugin',$plugin);
					$droit->setValeur('typeAcces',$_POST[$plugin]);
					$droit->setObjet();
				}
			}
		}
	}
	
	/* On va créer une fonction pour supprimer notre objet de manière générqiue
	 */
	public function suppObjet() {
		// On va reconstruire notre objet pour remplir les liens
		if ($this->getValeur('Droits')) {
			foreach ($this->getValeur('Droits') as $droits) {
				$droits->suppObjet();
			}
		}
		
		parent::suppObjet();
	}
	
	public function getDroit($nomPlugin) {
		if ($this->getValeur('Droits')) {
			
			$valDroit = 0;
			foreach ($this->getValeur('Droits') as $droits) {
				if ($droits->getValeur('plugin') === $nomPlugin ) {
					$valDroit = $droits->getValeur('typeAcces');
				}
			}
		}
		else {
			$valDroit = 0;
		}
		return $valDroit;
	}
	
	/* On va surcharger cette fonction afin de ne pas faire apparaitre la fonction
	 * affiche dans le tableau
	 */
	public function getDroits($nomPlugin) {
		return array(
				'plugin' => $nomPlugin,
				'droits' => array(
						array('option' => 'ajout',
								'niveauAcces' => '9'),
						array('option' => 'modif',
								'niveauAcces' => '9'),
						array('option' => 'supprime',
								'niveauAcces' => '9')
				)
		);
	}
}

