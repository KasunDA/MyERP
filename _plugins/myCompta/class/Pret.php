<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Pret extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idPret;
	protected $idCompte;
	protected $libelle;
	protected $typeEmprunt;
	protected $montantEmprunt;
	protected $montantAssurance;
	protected $tauxBase;
	protected $TEAG;
	protected $dateSignature;
	protected $date1erEcheance;
	protected $dureePret;
	protected $nbPalier;
	protected $onArchive;
	
	protected function getClasseDefinition() {
		$this->nomTable = "mycompta_prets";
		$this->nomID = "idPret";
		$this->suiviModification = true;
		$this->champTriDefaut = array('libelle');
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
				'idPret' => $this->baseDefinition('int',true,true,true,true),
				'idCompte' => $this->baseDefinition('int',false,false,true,false),
				'libelle' => $this->baseDefinition('varchar(100)',false,false,false,false),
				'typeEmprunt' => $this->baseDefinition('varchar(30)',false,false,false,false),
				'montantEmprunt' => $this->baseDefinition('double',false,false,false,false),
				'montantAssurance' => $this->baseDefinition('double',false,false,false,false),
				'tauxBase' => $this->baseDefinition('float',false,false,false,false),
				'TEAG' => $this->baseDefinition('float',false,false,false,false),
				'dateSignature' => $this->baseDefinition('varchar(255)',false,false,false,false),
				'date1erEcheance' => $this->baseDefinition('date',false,false,false,false),
				'dureePret' => $this->baseDefinition('int',false,false,false,false),
				'nbPalier' => $this->baseDefinition('int',false,false,false,false),
				'onArchive' => $this->baseDefinition('tinyint',false,false,false,false)
		);
		return  $baseDefinition;
	}
	
	public function getTableEnTeteDefinition() {
		$baseDefinition = $this->getBaseDefinition();
		return array(
				'idPret' => setTableLigneDefinition(null,false,$baseDefinition['idPret']['typeChamp']),
				'libelle' => setTableLigneDefinition("Libellé",true,$baseDefinition['libelle']['typeChamp']),
				'montantEmprunt' => setTableLigneDefinition("Montant",true,$baseDefinition['montantEmprunt']['typeChamp']),
				'dureePret' => setTableLigneDefinition("Durée (en mois)",true,$baseDefinition['dureePret']['typeChamp'])
		);
	}
	
	public function getTableauAmortissement() {
		// On va initialiser nos variables pour chaque echéance
		$dateEcheance = null;
		$dateProchaineEcheance = $this->date1erEcheance;
		$capitalRestant = $this->montantEmprunt;
		$numEcheance = 1;
		
		// On va boucler en fonction du nombre de mois
		while ($dateEcheance !== $dateProchaineEcheance AND $numEcheance <= $this->dureePret) {
			// On va incrémenter nos dates
			$dateEcheance = $dateProchaineEcheance;
			$dateProchaineEcheance = date('Y-m-d', strtotime($dateEcheance.' + 1 month'));
			$capitalEcheancePrecedante = $capitalRestant;
			// Règle de calcul du tableau d'amortissement
			// Attention, le montantEcheance est calculé sans l'assurance, qu'il faut rajouter dans le tableau
			// Attention, particularité pour un pret à taux 0
			if ($this->tauxBase > 0) {
				$tauxPeriodique = ($this->tauxBase/100)/12;
				$montantEcheance = round($this->montantEmprunt * $tauxPeriodique / (1 - pow((1 + $tauxPeriodique),$this->dureePret * -1)),2);
				$capitalRestant = round(($capitalRestant * (1 + $tauxPeriodique) - $montantEcheance),2);
				$capitalRembourse = round($capitalEcheancePrecedante - $capitalRestant,2);
				$interet = round($montantEcheance - $capitalRembourse,2);
			}
			else {
				$montantEcheance = round($this->montantEmprunt / $this->dureePret,2);
				$capitalRestant = round($capitalEcheancePrecedante - $montantEcheance,2);
				$capitalRestant - $montantEcheance;
				$capitalRembourse = round($capitalEcheancePrecedante - $capitalRestant,2);
				$interet = '0.00';
			}
			// On ajoute notre échéance à notre tableau qui sera renvoyé
			$tableauAmortissement[] = array (
				'dateEcheance' => $dateEcheance,
				'montantEcheance' => $montantEcheance + $this->montantAssurance,
				'capitalRembourse'=> $capitalRembourse,
				'interets'=> $interet,
				'assurance'	=>$this->montantAssurance,
				'capitalRestant' => ( $capitalRestant > 0 ? $capitalRestant : '0.00')
			);
			
			// On incrémente notre numéro d'échéance
			$numEcheance++;
		}
		return $tableauAmortissement;
	}
}

