<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/FonctionSQL.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/fonctions/myERP.php';

// On va définir notre classe
class Virement extends FonctionSQL
{
	// Définition des variables correspondant à notre table dans la base
	protected $idVirement;
	protected $date;
	protected $idCompteEmetteur;
	protected $idCompteDestinataire;
	protected $description;
	protected $montant;
	protected $idEcheance;
	protected $estRapproche;

	protected $monCompte;

	protected function getClasseDefinition() {
		$this->nomTable = "mycompta_virements";
		$this->nomID = "idVirement";
		$this->suiviModification = false;
		$this->champTriDefaut = array('libeldatele');
		$this->ordreTriDefaut = 'ASC';
	}	


	public function getDefinition() {
		/* Le tableau d'en-tete sera construit de la même façon pour toutes les classes
	 * $nomChamp => nom du champ dans la table,
	 * $typeChamp => le type de champ dans la table,
	 * $lienBase => booleen pour savoir si le champ est dans la table,
	 * $afficheTableau => booleen pour savoir si on affiche dans le tableau,
	 * $nomAffiche => nom du label dans un tableau
		 */
		$tableEntete = array(
				'idVirement' => $this->setDefinition('idVirement','int',true,false,null),
				'date' => $this->setDefinition('Date','date',true,true,'Date'),
				'idCompteEmetteur' => $this->setDefinition('idCompteEmetteur','int',true,false,null),
				'idCompteDestinataire' => $this->setDefinition('idCompteDestintaire','int',true,false,null),
				'description' => $this->setDefinition('decription ','text',true,true,'Description'),
				'montant' => $this->setDefinition('montant','float',true,true,'Montant'),
				'idEcheance' => $this->setDefinition('idEcheance','int',true,false,null),
				'estRapproche' => $this->setDefinition('rapproche','tinyint',false,false,null)
		);
		return  $tableEntete;
	}
	
	/* Nous surchargeons la fonction générique compte tenu de la spécificité 
	 * de l'ajout => nous ajoutons le virement dans la base et nous créons deux
	 * opérations (une débit et une crédit pour les comptes choisis)
	 */
	public function setObjet() {
		/* La fonction virement se fera en deux étapes:
		 * 1- Ajout de l'opération de virement dans la table
		 * 2- Ajout des deux opérations débit/crédit sur les comptes
		 * 
		 */
		$maConnexion = $this->ouvreConnexion();
		$definitionTable = $this->getDefinition();
		// Nous commençons par le traitement de notre ligne virement
		if ($this->idVirement > 0){
			$maDefinition = $this->getDefinition();
			$champsUpdate = "";
			$executeArray = array();
			$executeArray['id'] = $this->getValeur($this->nomID);
			foreach ($maDefinition as $cle => $valeur){
				// on ne prend que les champs dont le type n'est pas null
				if ($valeur['lienBase']) {
					// On va construire la liste des champs à ajouter sauf l'ID
					if ( $cle != $this->nomID) {
						$champsUpdate = $champsUpdate . $cle . " = :" . $cle . ", ";
						$executeArray[$cle] = $this->getValeur($cle);
					}
				}
			}
			// On supprime les virgules dans notre tableau
			$champsUpdate = rtrim($champsUpdate, ", ");
			$requete = $maConnexion->prepare("UPDATE " . $this->nomTable ." SET " . $champsUpdate . " WHERE " . $this->nomID ." = :id");
			$requete->execute($executeArray);
			
			// On va aller chercher l'opération de débit correspondant à notre virement
			$requete = "SELECT idOperation FROM mycompta_operations WHERE idVirement = '" .
					$this->idVirement . "' AND type = 'D'";
			$resultat = $this->myQuery($requete);
			$idOperationDebit = $resultat[0]['idOperation'];
		
			// On va aller chercher l'opération de crédit correspondant à notre virement
			$requete = "SELECT idOperation FROM mycompta_operations WHERE idVirement = '" .
					$this->idVirement . "' AND type = 'C'";
			$resultat = $this->myQuery($requete);
			$idOperationCredit = $resultat[0]['idOperation'];
		}
		else { 
			$maDefinition = $this->getDefinition();
			$champsDefinition = "";
			$champsValeur = "";
			$executeArray = array();
			foreach ($maDefinition as $cle => $valeur){
				// on ne prend que les champs dont le type n'est pas null
				if ($valeur['lienBase']) {
					// On va construire la liste des champs à ajouter sauf l'ID
					if ( $cle != $this->nomID) {
						$champsDefinition = $champsDefinition . $cle . ",";
						$champsValeur = $champsValeur . ":" . $cle . ", ";
						$executeArray[$cle] = $this->getValeur($cle);
					}
				}
			}
			// On supprime les virgules dans nos tableaux
			$champsDefinition = rtrim($champsDefinition, ",");
			$champsValeur = rtrim($champsValeur, ", ");
			$requete = $maConnexion->prepare("INSERT INTO " . $this->nomTable . " (" . $champsDefinition . ") VALUES (" . $champsValeur .")");
			$requete->execute($executeArray);
			$this->idVirement = $maConnexion->lastInsertId();
			
			// On initialise nos ID à null pour créer deux opérations
			$idOperationDebit = null;
			$idOperationCredit = null;
		}

			
		// Nous allons ensuite créer/modifier nos opérations dans la table associée
		$monOperationDebit = new Operation($idOperationDebit);
		$monOperationDebit->setValeur('idCompte', $this->idCompteEmetteur);
		$monOperationDebit->setValeur('type','D');
		$monOperationDebit->setValeur('mode','VI');
		$monOperationDebit->setValeur('date', $this->date);
		$monOperationDebit->setValeur('description', $this->description);
		$monOperationDebit->setValeur('montant',$this->montant);
		$monOperationDebit->setValeur('idVirement',$this->idVirement);
		$monOperationDebit->setValeur('idEcheance',$this->idEcheance);
		$monOperationDebit->setValeur('estRapproche',$this->estRapproche);
		$monOperationDebit->setObjet();
		
		$monOperationCredit = new Operation($idOperationCredit);
		$monOperationCredit->setValeur('idCompte', $this->idCompteDestinataire);
		$monOperationCredit->setValeur('type','C');
		$monOperationCredit->setValeur('mode','VI');
		$monOperationCredit->setValeur('date', $this->date);
		$monOperationCredit->setValeur('description', $this->description);
		$monOperationCredit->setValeur('montant',$this->montant);
		$monOperationCredit->setValeur('idVirement',$this->idVirement);
		$monOperationCredit->setValeur('idEcheance',$this->idEcheance);
		$monOperationCredit->setValeur('estRapproche',$this->estRapproche);
		$monOperationCredit->setObjet();
	}

	/* On va surcharger la fonction de suppression
	 */
	public function suppObjet() {
		// On va supprimer l'opération de débit correspondant à notre virement
		$requete = "SELECT idOperation FROM mycompta_operations WHERE idVirement = '" .
			$this->idVirement . "' AND type = 'D'";
		$resultat = $this->myQuery($requete);
		$idOperationDebit = $resultat[0]['idOperation'];
		$monOperationDebit = new Operation($idOperationDebit);
		$monOperationDebit->suppObjet();
		
		// On va supprimer l'opération de crédit correspondant à notre virement
		$requete = "SELECT idOperation FROM mycompta_operations WHERE idVirement = '" .
			$this->idVirement . "' AND type = 'C'";
		$resultat = $this->myQuery($requete);
		$idOperationCredit = $resultat[0]['idOperation'];
		$monOperationCredit = new Operation($idOperationCredit);
		$monOperationCredit->suppObjet();
		
		// On supprimer le virement
		$maConnexion = $this->ouvreConnexion();
		$requete = $maConnexion->prepare("DELETE FROM " . $this->nomTable . " WHERE " . $this->nomID . " = '" . $this->getValeur($this->getValeur('nomID')) ."'" );
		$requete->execute();
	}

}

