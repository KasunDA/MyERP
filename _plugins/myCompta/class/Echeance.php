<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/FonctionSQL.php';


// On va définir notre classe
class Echeance extends FonctionSQL
{
	// Définition des variables correspondant à notre table dans la base
	protected $idEcheance;
	protected $typeMouvement;
	protected $dateDebut;
	protected $dateFin;
	protected $typePeriode;
	protected $nbEntrePeriode;
	protected $recalculEcheancesPassees;
	protected $recalculDateEcheances;
	protected $integrationAuto;
	protected $montantFixe;
	protected $description;
	protected $virementIdCompteEmetteur;
	protected $virementIdCompteDestinataire;
	protected $operationType;
	protected $operationMode;
	protected $operationEstVentile;
	protected $operationSourceBeneficiaire;
	protected $operationBeneficiaireID;
	protected $operationBeneficiaire;
	protected $operationIdCompte;
	protected $operationIdCategorie;
	protected $montant;
	protected $onArchive;

	protected $tableauEcheance;	
	protected $compteSource;
	protected $compteDestinataire;

	protected $typeMontantChampNom = "operationType";

	protected function getClasseDefinition() {
		$this->nomTable = "mycompta_echeances";
		$this->nomID = "idEcheance";
		$this->suiviModification = true;
		$this->champTriDefaut = array('dateDebut');
		$this->ordreTriDefaut = 'ASC';
	}

	public function __construct($args = null) {
		/* On va permettre la création de notre objet
		 * en saisissant un ID afin de l'initialiser directement
		 *
		
		* On va permettre la création de notre objet
		 * en saisissant un ID afin de l'initialiser directement
		 */
		
		$this->majDefinitionObjetTable();
		
		if (isset($args) AND isset($args['idObjet']) AND (int)$args['idObjet'] > 0) {
		
			$maConnexion = $this->ouvreConnexion();
			$requete = $maConnexion->query("SELECT * FROM " . $this->nomTable ." WHERE " . $this->nomID . " = " . $args['idObjet'] );
			$donnee = $requete->fetch();
			$tableChamps = $this->getBaseDefinition();
			foreach ( $tableChamps as $cle => $valeur){
				$this->$cle = $donnee[$cle];
			}
			if (isset($classeParent)) {
				if ($this->$classeParent['idLien'] > 0) {
					require_once $GLOBALS['root'] . '_plugins/' . $args['plugin'] . '/class/' . $args['classe'] . '.php';
		
					$monObjet = new $args['classe'](array('idObjet' => $this->$classeParent['idLien']));
					foreach ($args['champRecup'] as $cle) {
						$this->$cle = $monObjet->getValeur($cle);
					}
				}
			}
			require_once $GLOBALS['root'] . '_plugins/myCompta/class/Compte.php';
			switch ($this->typeMouvement){
				case 'O':
					$this->compteSource = new Compte(array('idObjet' =>$this->operationIdCompte));
					break;
				case 'V':
					$this->compteSource = new Compte(array('idObjet' =>$this->virementIdCompteEmetteur));
					$this->compteDestinataire = new Compte(array('idObjet' =>$this->virementIdCompteDestinataire));
					break;
				default:
					break;
			}
			// On calcule notre tableau d'échéance
			$idCompte = (isset($args['idCompte']) ? (int)$args['idCompte'] : null);
			$this->getTableauEcheances($idCompte);
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
				'idEcheance' => $this->baseDefinition('int',true,true,true,true),
				'typeMouvement' => $this->baseDefinition('varchar(1)',false,false,false,false),
				'dateDebut' => $this->baseDefinition('date',false,false,false,false),
				'dateFin' =>$this->baseDefinition('date',false,false,false,false),
				'typePeriode' => $this->baseDefinition('varchar(5)',false,false,false,false),
				'nbEntrePeriode' => $this->baseDefinition('int',false,false,false,false),
				'recalculEcheancesPassees' => $this->baseDefinition('tinyint',false,false,false,false),
				'recalculDateEcheances' => $this->baseDefinition('tinyint',false,false,false,false),
				'integrationAuto' => $this->baseDefinition('tinyint',false,false,false,false),
				'montantFixe' => $this->baseDefinition('tinyint',false,false,false,false),
				'description' => $this->baseDefinition('varchar(200)',false,false,false,false),
				'virementIdCompteEmetteur' => $this->baseDefinition('int',false,false,false,false),
				'virementIdCompteDestinataire' => $this->baseDefinition('int',false,false,false,false),
				'operationType' => $this->baseDefinition('varchar(1)',false,false,false,false),
				'operationMode' => $this->baseDefinition('varchar(3)',false,false,false,false),
				'operationEstVentile' => $this->baseDefinition('tinyint',false,false,false,false),
				'operationSourceBeneficiaire' => $this->baseDefinition('varchar(1)',false,false,false,false),
				'operationBeneficiaireID' => $this->baseDefinition('int',false,false,false,false),
				'operationBeneficiaire' => $this->baseDefinition('varchar(200)',false,false,false,false),
				'operationIdCompte' => $this->baseDefinition('int',false,false,false,false),
				'operationIdCategorie' => $this->baseDefinition('int',false,false,false,false),
				'montant' => $this->baseDefinition('float',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idEcheance' => setTableLigneDefinition('idEcheance',true,$baseDefinition['idEcheance']['typeChamp']),
				'dateDebut' => setTableLigneDefinition("Date",true,$baseDefinition['dateDebut']['typeChamp'])
		);
	}
	
	public function getTableauEcheances($idCompte = null) {
		$this->tableauEcheance = array();
		/* Nous allons affecter une date de fin pour les échéances ou la date de fin est null
		 * Par défaut, nous allons prendre les échéances des 365 prochains jours
		 */
		if ($this->dateFin === null) {
			$dateFin = date('Y-m-d', strtotime(date('Y-m-d') . ' + 365 day'));
		}
		else {
			$dateFin = $this->dateFin;
		}
		if ($this->onArchive === null) {
			/* Nous allons ensuite vérifier si notre échéance n'est pas
			 * arrivée à expiration
			 */
			if (($this->dateFin === null) or ($this->dateFin >= date("Y-m-d"))) {
				switch ($this->typePeriode){
					case 'J':
						/* Nous allons calculer la date de début de notre tableau afin de ne prendre en 
						 * compte que les échéances et ainsi alléger notre objet
						 */
						if ($this->dateDebut < date('Y-m-d')) {
							$dateEcheance = $this->getDateDebut($idCompte);
						}
						else {
							$dateEcheance = $this->dateDebut;
						}
						while ($dateEcheance < $dateFin){
							// On calcule la date de la prochaine écheance
							$dateProchaineEcheance = date('Y-m-d', strtotime($dateEcheance.' +'. $this->nbEntrePeriode . ' day'));
							if ($this->dateFin === null) {
								$this->tableauEcheance[] = $dateProchaineEcheance;
								$dateEcheance = $dateProchaineEcheance;
							}
							else {
								// On vérifie qu'elle ne dépasse pas la date de fin
								if($this->dateFin >= $dateProchaineEcheance) {
									$this->tableauEcheance[] = $dateProchaineEcheance;
								}
								$dateEcheance = $dateProchaineEcheance;
							}
						}
						break;
					case 'M':
						/* Nous allons boucler à partir de la date de début pour obtenir notre date
						 * d'échéanceen cours.
						 * Attention, si le nombre de jour dans le mois est inf�rieur au numéro de jour de
						 * l'échéance, il faut régler une règle sp�cifique qui affecte le dernier jour du
						 * mois comme date d'échéance
						 */
						/* Nous allons calculer la date de début de notre tableau afin de ne prendre en
						 * compte que les échéances et ainsi alléger notre objet
						 */
						$analyseEcheance = $this->getDateDebut($idCompte);
						if ($this->dateDebut < $analyseEcheance['dateDebut']) {
							$dateEcheance = $analyseEcheance['dateDebut'];
						}
						else {
							$dateEcheance = $this->dateDebut;
						}

						// On vérifie si le date de la dernière échéance correspond à une opération ou pas
						$echeanceIgnore = $analyseEcheance['operationDejaIntegree'];
						$jourEcheance = date_parse($dateEcheance)['day'];
						
						// On va créer une variable qui sera utilis� au cas ou l'échéanceest apr�s le 28 du mois
						$nbJourDiff = 0;
						/* Nous allons vérifier si la date de début est supérieur ou égal
						 * à la date du jour
						 */
						if ($dateEcheance >= date('Y-m-d)')) {
							$casParticulier = 1;
						}
						else {
							$casParticulier = 0;
						}
						while ($dateEcheance < $dateFin){
							// On boucle simplement si le jour est inf�rieur � 28
							if ($jourEcheance <= '28') {
								if ($casParticulier === 1) {
									$dateProchaineEcheance = $dateEcheance;
									// On revient dans une situation normale
									$casParticulier = 0;
								}
								else {
									$dateProchaineEcheance = date('Y-m-d', strtotime($dateEcheance.' +'. $this->nbEntrePeriode . ' month'));
								}
							}
							else {
								/*On va extraire le mois en cours et l'ann�e (pour vérifier si l'année est bisextille
								 * et calculer le nombre de jours dans le mois suivant
								 */
								$moisCours = date_parse($dateEcheance)['month'];
								$anCours = date_parse($dateEcheance)['year'];
								$moisSuivant = $moisCours + $this->nbEntrePeriode;
								if ($moisSuivant > 12){
									$nbJourMoisSuivant = date('t',mktime(0, 0, 0, $moisCours + $this->nbEntrePeriode - 12, 1, $anCours + 1));
								} else {
									$nbJourMoisSuivant = date('t',mktime(0, 0, 0, $moisCours + $this->nbEntrePeriode, 1, $anCours));
								}
								// On va v�rifier si le jour est dans l'intervalle du mois
								if ($jourEcheance > $nbJourMoisSuivant) {
									$nbJourDiff = $jourEcheance - $nbJourMoisSuivant;
									/* On retire le nombre de jours de diff�rence pour que l'échéance corresponde
									 * au dernier jour du mois
									 */
									$dateProchaineEcheance = date('Y-m-d', strtotime($dateEcheance.' -'. $nbJourDiff . ' day'));
									// echo 'date echeance recalcul�' . $dateEcheance . '<br>';
									/* On ajoute le mois pour obtenir l'échéancedu mois suivant
									 */
	
									$dateProchaineEcheance = date('Y-m-d', strtotime($dateProchaineEcheance.' +'. $this->nbEntrePeriode . ' month'));
								}
								else {
									// On cr�� notre échéanceau mois suivant
									$dateProchaineEcheance = date('Y-m-d', strtotime($dateEcheance.' +'. $this->nbEntrePeriode . ' month'));
									// On rajoute la diff�rence de jour pour retrouver notre date d'�ch�ance
									$dateProchaineEcheance = date('Y-m-d', strtotime($dateProchaineEcheance.' +'. $nbJourDiff . ' day'));
									$nbJourDiff = 0;
								}
							}
	
							/* On va v�rifier que la date de fin est bien respect�e
							 *
							 */
							// On v�rifie qu'elle ne dépasse pas la date de fin
							if($dateFin >= $dateProchaineEcheance) {
								if ($echeanceIgnore === '0') {
									$this->tableauEcheance[] = $dateEcheance;
									$echeanceIgnore = '1';
								}
								else {
									$this->tableauEcheance[] = $dateProchaineEcheance;
									$dateEcheance = $dateProchaineEcheance;
								}
							}
							else {
								$dateEcheance = $dateFin;
							}
						}
						break;
					default: $this->echeanceDateCours = null;
					break;
				}
			}
			else {
				// l'échéance est expirée
				$this->echeanceDateCours = null;
			}
		}
		else {
			// L'échéanceest archiv�e donc aucune action dessus
			$this->echeanceDateCours = null;
		}
	}
	
	public function getListeObjet($args = null) {
		$maConnexion = $this->ouvreConnexion();
		
		/* ------------------------------------------------
		 * On va r�cup�rer les �ch�ances en fonction du
		 * nombre de jours d�finis en param�tre
		 * ------------------------------------------------
		 */
		$requete = "SELECT idEcheance
			FROM " . $this->nomTable . "
			WHERE
				onArchive is NULL
			AND (
				dateFin is NULL
			OR
				dateFin >= curdate()
			)";
		// Nous allons vérifier si un filtre sur le compte doit être appliqué
		if (isset($args)){
			if (isset($args['idCompte'])) {
				$requete = $requete . "	AND (
					virementIdcompteEmetteur = '" . $args['idCompte'] . "'
				OR
					virementIdcompteDestinataire = '" . $args['idCompte'] . "'
				OR
					operationIdCompte = '" . $args['idCompte'] . "')";
			}
		}
		$requete = $requete . " ORDER BY day(dateDebut) ASC";
		$requete = $maConnexion->query($requete);
		$tableID = $requete->fetchAll();
		foreach ($tableID as $id) {
			$tableObjet[] = new Echeance(array(
					'idObjet' => $id['idEcheance'],
					'idCompte' => (isset($args['idCompte']) ? $args['idCompte'] : null)			
			));
		}
		return $tableObjet;
	}

	/* Cette fonction a pour but de déterminer la date de 
	 * début en fonction de plusieurs paramètres
	 * 1- Date de début de l'échéance
	 * 2- Recalcul ou pas des échéances passées
	 * 3- Prise en compte des opérations déjà intégrés
	 * 4- recalcul de la date d'échéance par rapport à la dernière date d'intégration 
	 */
	protected function getDateDebut($idCompte) {
		// on va d'abord vérifier que nous sommes sur une échéance déjà enregistrée
		if ($this->idEcheance > 0) {
			// On vérifie si l'on doit regarder les échéances passées
			//if ($this->recalculEcheancesPassees === '1' OR $this->recalculDateEcheances === '1') {

				require_once $GLOBALS['root'] . '_plugins/myCompta/class/Operation.php';
				$maConnexion = $this->ouvreConnexion();
 
				// On va récupérer la dernière opération lié à l'echeance
				$requete = "SELECT idOperation,date
				FROM mycompta_operations
				WHERE
					idEcheance = '" . $this->idEcheance . "'
				AND 
					idCompte = '" . $idCompte . "'
				 ORDER BY date DESC";

				$requete = $maConnexion->query($requete);

				$tableOperation = $requete->fetchAll();
				if ($tableOperation) {
					$retourFonction = array(
						'operationDejaIntegree' => '1',
						'dateDebut' => $tableOperation[0]['date']
					);
				}
				else {
					$retourFonction = array(
							'operationDejaIntegree' => '0',
							'dateDebut' => $this->dateDebut
					);
				}
			/*}
			else {
				// la date de début est simplement la date du jour
				$retourFonction = array(
						'operationDejaIntegree' => '0',
						'dateDebut' => date("Y-m-d")
				);
			}*/
		}
		else {
			$retourFonction = array(
					'operationDejaIntegree' => '0',
					'dateDebut' => $this->dateDebut
			);
		}
		return $retourFonction;
	}

	/* Nous allons créer une fonction qui va créer une échéance en fonction
	 * d'une date donnée en paramètre
	 */
	public function createMouvement($dateEcheance) {
		// On va créer un mouvement en fonction de son type
		switch ($this->typeMouvement) {
			case 'O':
				require_once $GLOBALS['root'] . '_plugins/myCompta/class/Compte.php';
				$monOperation = new Operation();
				$monOperation->setValeur('idCompte', $this->operationIdCompte);
				$monOperation->setValeur('montant', $this->montant);
				$monOperation->setValeur('type', $this->operationType);
				$monOperation->setValeur('idCategorie', $this->operationIdCategorie);
				$monOperation->setValeur('beneficiaire', $this->operationBeneficiaire);
				$monOperation->setValeur('description', $this->description);
				$monOperation->setValeur('idEcheance', $this->idEcheance);
				$monOperation->setValeur('date', $dateEcheance);
				$monOperation->setObjet();
				break;
			case 'V':
				require_once $GLOBALS['root'] . '_plugins/myCompta/class/Virement.php';
				$monVirement = new Virement();
				$monVirement->setValeur('date', $dateEcheance);
				$monVirement->setValeur('idCompteEmetteur', $this->virementIdCompteEmetteur);
				$monVirement->setValeur('idCompteDestinataire', $this->virementIdCompteDestinataire);
				$monVirement->setValeur('montant', $this->montant);
				$monVirement->setValeur('type', $this->operationType);
				$monVirement->setValeur('description', $this->description);
				$monVirement->setValeur('idEcheance', $this->idEcheance);
				$monVirement->setObjet();
				break;
			default:
				break;
		}
	}
}

