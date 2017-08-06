<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyBDD.php';

class MyERP extends MyBDD{
	/* Nous allons créer une function générique pour le _construct
	 * Son but sera de mettre à jour la base de données avec les données de la classe.
	 * Ainsi, en créant une nouvelle classe ou en modifiant une existante, celle-ci sera
	 * directement mise à jour
	 */
	
	protected $nomTable = null;
	protected $nomID = null;
	protected $suiviModification = false;
	protected $champTriDefaut = null;
	protected $ordreTriDefaut = null;

	public function __construct($args = null) {
		$this->getClasseDefinition();
		/* On va permettre la création de notre objet
		 * en saisissant un ID afin de l'initialiser directement
		 */

		if (isset($args) AND (int)$args['idObjet'] > 0) {
			$maConnexion = $this->getConnexion();
			$requete = $maConnexion->query("SELECT * FROM " . $this->nomTable ." WHERE " . $this->nomID . " = " . $args['idObjet'] );
			$donnee = $requete->fetch();
			$requete->closeCursor();
			$tableChamps = $this->getBaseDefinition();
			foreach ( $tableChamps as $cle => $valeur){
				$this->$cle = $donnee[$cle];
			}
			if (isset($args['classeParent'])) {
				if ($this->getValeur($args['classeParent']['idLien']) > 0) {
					require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $args['classeParent']['plugin'] . '/class/' . $args['classeParent']['maClasse'] . '.php';
					$monObjet = new $args['classeParent']['maClasse'](array('idObjet' => $this->getValeur($args['classeParent']['idLien'])));
					foreach ($monObjet->getBaseDefinition()as $entete => $cle) {
						$this->$entete= $monObjet->getValeur($entete);
					}
				}
			}
			
			/* Dans cette partie, on va gérer la récupération des liens de notre classe
			 * correspondant par exemple à des lignes de commandes, des échéances, etc.
			 * le tout sera renvoyé sous forme de tableau portant le nom de la classe lié
			 * 
			 */
			if (isset($args['classeLiens'])) {
				foreach ($args['classeLiens'] as $lien) {
					if ($lien['plugin']) {
						require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins' . $lien['plugin'] . '/class/' . $lien['classe'] . '.php';
					}
					else {
						require_once $_SERVER['DOCUMENT_ROOT'] . '/_main/class/' . $lien['classe'] . '.php';
					}
					$monLien = new $lien['classe']();
					$args = array(
						'classe' => $lien['classe'],
						'nomTable' => $monLien->getValeur('nomTable'),
						'nomID' => $monLien->getValeur('nomID'),
						'champRecherche' => $lien['idReference'],
						'cleRecherche' => $this->getValeur($lien['idReference'])
					);
					$listeLiens = $monLien->getListeObjet($args);
					$this->setValeur($lien['classe'],$listeLiens);
				}
			}
		}
	}
	
	// Cette fonction va nous permettre de retourner une seule valeur selon le champ choisi
	public function getValeur($cle) {
		return $this->$cle;
	}

	public function getDroits($nomPlugin) {
		return array(
				'plugin' => $nomPlugin,
				'droits' => array(
						array('option' => 'ajout',
								'niveauAcces' => '5'),
						array('option' => 'affiche',
								'niveauAcces' => '1'),
						array('option' => 'modif',
								'niveauAcces' => '5'),
						array('option' => 'supprime',
								'niveauAcces' => '5')
				)
		);
	}
	
	/* On va récupérer notre liste d'objet
	 * nous passons en paramètre le tableau suivant la norme suivante
	 * $args = array(
	 *   'classe' => nom de la classe,
	 *   'nomTable' => nom de la table dans la bdd,
	 *   'nomID' => nom de l'id qui servira de clé d'index,
	 * 	 'afficheObjet' => variable si on affiche les actifs/archivés/tous
	 *	 'nbObjetAffiche' => limitation du nombre de résultat demandé,
	 *	 'pageAffiche' => page pour laquelle on doit afficher le résultat,
	 *	 'champTri' => champ servant au tri du résultat,
	 *	 'ordreTri' => type de tri,
	 *	 'champRecherche' => nom du champ qui sera le support de recherche
	 *   'cleRecherche' => mot cle de la recherche
	 */
	public function getListeObjet($args = null) {
		$classe = isset($args['classe'])? $args['classe'] : get_class($this);
		$nomID =  isset($args['nomID'])? $args['nomID'] : $this->getValeur('nomID');
		// On va d'abord récupérer la liste des ID pour générer notre tableau d'objet
		// Préparation de la requète générique
		$requete = "SELECT " . $nomID .
		" FROM " . (isset($args['nomTable']) ? $args['nomTable'] : $this->nomTable);

		// On va ensuite définir nos options
		$option = false;
		// On vérifie si on affiche ou pas les archivés
		if (isset($args['afficheArchive'])) {
			$prefixe = ($option ? ' AND ' : ' WHERE ');		
			switch ($args['afficheArchive']) {
				case '1' :
					$requete = $requete. $prefixe . 'onArchive is null';
					$option = true;
					break;
				case '-1' :
					$requete = $requete. $prefixe . 'onArchive is not null';
					$option = true;
					break;
				case '9' :
					$requete = $requete;
					break;
			}
			
		}
		// On regarde ensuite si la demande est basée sur une recherche
		if (isset($args['cleRecherche']) AND isset($args['valeurRecherche'])) {
			$prefixe = ($option ? ' AND ' : ' WHERE ');
			/* ! ATTENTION A LA REQUETE LIKE QUI NE DOIT PAS CONTENIR LE CHAMP %, IL FAUT LE METTRE PLUTOT
			 * AU MOMENT DE LA PREPRATION DU TABLEAU D'ARGUMENTS
			 */
			$requete = $requete . ($option ? ' AND ' : ' WHERE ') . $args['cleRecherche'] . ' LIKE \'' . $args['valeurRecherche'] . '\'';
		}
		// On regarde ensuite si la demande est basée sur une recherche
		if (isset($args['champTri'])) {
			$requete = $requete . ' ORDER BY ' . $args['champTri'] . ' ' . ($args['ordreTri'] ? $args['ordreTri'] : 'ASC ');
		}
		
		// On limite le nombre de réponses en fonction du nombre d'objet à afficher
		// 0 correspond à tous
		if (isset($args['pageAffiche'])) {
			if ((int)$args['pageAffiche'] === 1) {
				$debutListe = '0'; 
			}
			else {
				$debutListe = (($args['pageAffiche'] - 1 )  * $args['nbObjetAffiche'] -1);
			}
			if (isset($args['nbObjetAffiche']) AND $args['nbObjetAffiche'] != '0' AND isset($args['pageAffiche'])) {
				$requete = $requete . ' LIMIT ' . $debutListe . ',' . $args['nbObjetAffiche'];
			}
		}
		// On execute notre requète et on constitue notre tableau
		$maConnexion = new MyBDD();
		$resultat = $maConnexion->myQuery($requete);
		if ($resultat)	{
			foreach ($resultat as $cle => $valeur) {
				$tableObjet[] = new $classe(array('idObjet' => $valeur[$nomID]));
			}
		}
		else {
			$tableObjet = null;
		}
		
		return $tableObjet;
	}
	
	
	/* On va récupérer notre liste d'objet
	 * nous passons en paramètre le tableau suivant la norme suivante
	 * $args = array(
	 *   'classe' => nom de la classe,
	 *   'nomTable' => nom de la table dans la bdd,
	 *   'nomID' => nom de l'id qui servira de clé d'index,
	 * 	 'afficheObjet' => variable si on affiche les actifs/archivés/tous
	 *	 'nbObjetAffiche' => limitation du nombre de résultat demandé,
	 *	 'pageAffiche' => page pour laquelle on doit afficher le résultat,
	 *	 'champTri' => champ servant au tri du résultat,
	 *	 'ordreTri' => type de tri,
	 *	 'champRecherche' => nom du champ qui sera le support de recherche
	 *   'cleRecherche' => mot cle de la recherche
	 */
	public function getNombreObjet($args) {
		$classe = isset($args['classe'])? $args['classe'] : get_class($this);
		$nomID =  isset($args['nomID'])? $args['nomID'] : $this->getValeur('nomID');
		// On va d'abord récupérer la liste des ID pour générer notre tableau d'objet
		// Préparation de la requète générique
		$requete = "SELECT count(" . $nomID .
		") as nombre FROM " . (isset($args['nomTable']) ? $args['nomTable'] : $this->nomTable);
		
		// On va ensuite définir nos options
		$prefixe = false;
		// On vérifie si on affiche ou pas les archivés
		if (isset($args['afficheArchive'])) {
			switch ($args['afficheArchive']) {
				case '1' :
					$requete = $requete. ' WHERE onArchive is null';
					$prefixe= true;
					break;
				case '-1' :
					$requete = $requete. ' WHERE onArchive is not null';
					$prefixe= true;
					break;
				case '0' :
					$requete = $requete;
					break;
			}
			
		}
		// On regarde ensuite si la demande est basée sur une recherche
		if (isset($args['cleRecherche']) AND isset($args['valeurRecherche'])) {
			$requete = $requete . ($prefixe ? ' AND ' : ' WHERE ') . $args['cleRecherche'] . ' LIKE \'' . $args['valeurRecherche'] . '\'';
		}	
		// On execute notre requète et on constitue notre tableau
		require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyBDD.php';
		$maConnexion = new MyBDD();
		$resultat = $maConnexion->myQuery($requete);
		if ($resultat)	{
			$nbObjet = $resultat[0]['nombre'];
		}
		else {
			$nbObjet = null;
		}
		
		return $nbObjet;
	}
	
	/* Fonction qui va enregistrer notre objet dans la base en fonction de l'objet
	 * Il va définir automatique s'il s'agit d'un ADD ou UPDATE
	 */
	public function setObjet() {
		$maConnexion = $this->getConnexion();
		$definitionTable = $this->getBaseDefinition();
		if ((int)$this->getValeur($this->getValeur('nomID')) > 0) {
			//$maDefinition = $this->getDefinition();
			$champsUpdate = "";
			$executeArray = array();
			$executeArray['id'] = $this->getValeur($this->nomID);
			foreach ($definitionTable as $cle => $valeur){
				// On va construire la liste des champs à ajouter sauf l'ID
				if ( $cle != $this->nomID) {
					$champsUpdate = $champsUpdate . $cle . " = :" . $cle . ", ";
					$executeArray[$cle] = $this->getValeur($cle);
				}
			}
			// On supprime les virgules dans notre tableau
			$champsUpdate = rtrim($champsUpdate, ", ");
			
			// On va gérer le suivi des modifications
			if ($this->suiviModification) {
				$requete = $maConnexion->prepare("UPDATE " . $this->nomTable ." SET " . $champsUpdate . ", idModification = " . $_SESSION['id'] . ", dateModification = '" . date("Y-m-d G:i:s") . "' WHERE " . $this->nomID ." = :id");
			}
			else {
				$requete = $maConnexion->prepare("UPDATE " . $this->nomTable ." SET " . $champsUpdate . " WHERE " . $this->nomID ." = :id");
			}
			$requete->execute($executeArray);
			$idInsert = (int)$this->getValeur($this->getValeur('nomID'));
			
			

		}
		else {
			//$maDefinition = $this->getDefinition();
			$champsDefinition = "";
			$champsValeur = "";
			$executeArray = array();
			foreach ($definitionTable as $cle => $valeur){
				// On va construire la liste des champs à ajouter sauf l'ID
				if ( $cle != $this->nomID) {
					$champsDefinition = $champsDefinition . $cle . ",";
					$champsValeur = $champsValeur . ":" . $cle . ", ";
					$executeArray[$cle] = $this->getValeur($cle);
				}
			}
			
			// On va gérer le suivi des modifications
			if ($this->suiviModification) {
				$champsDefinition = $champsDefinition . 'idCreation,dateCreation';
				$champsValeur = $champsValeur . ':idCreation,:dateCreation';
				$executeArray['idCreation'] = $_SESSION['id'];
				$executeArray['dateCreation'] =  date("Y-m-d G:i:s");
			}
			else {
				// On supprime les virgules dans nos tableaux
				$champsDefinition = rtrim($champsDefinition, ",");
				$champsValeur = rtrim($champsValeur, ", ");
			}
			
			$requete = $maConnexion->prepare("INSERT INTO " . $this->nomTable . " (" . $champsDefinition . ") VALUES (" . $champsValeur .")");
			$requete->execute($executeArray);
			$idInsert = $maConnexion->lastInsertId();
		}
		
		return $idInsert;
	}
	
	/* On va créer une fonction pour supprimer notre objet de manière générqiue
	 */
	public function suppObjet() {
		$maConnexion = $this->getConnexion();
		$requete = $maConnexion->prepare("DELETE FROM " . $this->nomTable . " WHERE " . $this->nomID . " = '" . $this->getValeur($this->getValeur('nomID')) ."'" );
		$requete->execute();
	}
	
	public function setValeur($cle, $valeur) {
		$this->$cle = $valeur;
	}
	
	public function setArchive() {
		$maConnexion = $this->getConnexion();
		$requete = $maConnexion->prepare("UPDATE " . $this->nomTable . " SET onArchive = '1' WHERE " . $this->nomID . " = :idObjet ");
		$requete->execute(array(
				'idObjet' => $this->getValeur($this->getValeur('nomID'))
		));
	}
	
	public function setRapprochement() {
		$maConnexion = $this->getConnexion();
		$requete = $maConnexion->prepare("UPDATE " . $this->nomTable . " SET estRapproche = '1' WHERE " . $this->nomID . " = '" . $this->getValeur($this->getValeur('nomID')) ."'");
		$requete->execute();
	}
	
	
	/* ------------------------------------------------------------------------ //
	 * 		FONCTIONS GENERIQUES												//
	 * ------------------------------------------------------------------------	//
	 */
	
	/* Fonction qui va analyser notre classe et la comparer à la base de données
	 * Elle créera automatique les tables & champs dans la base. Cela permet ainsi
	 * de se dédouaner des outils SQL et surtout de pouvoir être à jour facilement
	 * après un changement de version
	 */
	public function majDefinitionObjetTable($args = null) {
		if ($args != null) {
			// On va définir nos variables en fonction de notre tableau envoyé en paramètre
			$nomTable = $args['nomTable'];
			$tableDefinition = $args['definition'];
			
		}
		else {
			$nomTable = $this->nomTable;
			$tableDefinition = $this->getBaseDefinition();
		}
		$maConnexion = $this->getConnexion();
		// On va récupérer le nom des tables présentes dans la base
		$requete = $maConnexion->query("SHOW TABLES") or die(print_r($maConnexion->errorInfo()));
		$resultat = $requete->fetchAll();
		$requete->closeCursor();
		// On va d'abord vérifier que la table existe et si nous avons déjà ajouté les champs pour le suivi des modifications
		$tableExiste = false;

		//On va parcourir notre résultat à la recherche de notre table
		foreach ($resultat  as $baseNomTable) {
			if ($baseNomTable[0] === $nomTable) {
				$tableExiste= true;
				// La table existe, on va vérifier le contenu de chaque ligne
				$requete = $maConnexion->query("SHOW COLUMNS FROM " . $nomTable);
				$listeTables = $requete->fetchAll();
				$requete->closeCursor();
				/* On va analyser dans un premier temps la définition de la table dans le fichier
				 * des classes afin d'ajouter ou modifier des lignes
				 */
				
				foreach ($tableDefinition as $cle => $ligne){
					$champExiste = false;
					foreach ($listeTables as $champ) {
						if ($cle === $champ['Field']) {
							$champExiste = true;
							$modificationLigne = false;
							// On va vérifier que chaque information de la table est à jour
							// On va extraire le type de champ de la base au format de notre classe
							if (substr($champ['Type'],0,7) === "varchar") {
								$valeurType = $champ['Type'];
							}
							else {
								$valeurType = preg_replace('#[(0-9)]+#i','', $champ['Type']);
							}
							if ($ligne['typeChamp'] !== $valeurType) { $modificationLigne = true; }
							
							// On vérifie les paramètres de la clé primaire
							if ($ligne['primaryKey'] AND $champ['Key'] !== 'PRI') { $modificationLigne = true; }
							if ($ligne['primaryKey'] AND $champ['Extra'] !== 'auto_increment') { $modificationLigne = true; }
							
							// On vérifie les options
							if ($ligne['notNull'] AND $champ['Null'] === 'YES') { $modificationLigne = true; }
							if (!$ligne['primaryKey'] AND $ligne['unique'] AND $champ['Key'] !== 'UNI') { $modificationLigne = true; }
							
							// On va préparer la requete de mise à jour du champ
							if ($modificationLigne) {
								$requete = "ALTER TABLE " . $nomTable . " CHANGE COLUMN `" . $cle. "` " .
										"`" . $cle . "` " . $ligne['typeChamp'] . " " .
										(($ligne['autoIncrement']) ? "AUTO_INCREMENT" : "") . " " .
										(($ligne['notNull']) ? "NOT NULL" : "NULL") . ",";
										// On supprime la dernière virgule et on assemble la requete
										$requete = rtrim($requete, ",");
							}
							break;
						}
						// On va vérifier si le nom du champ n'a pas été modifié
						elseif ($ligne['ancienNom'] === $champ['Field']) {
							$champExiste = true;
							$modificationLigne = true;
							// On va modifier le champ
							$requete = "ALTER TABLE " . $nomTable . " CHANGE COLUMN `" . $ligne['ancienNom']. "` " .
									"`" . $cle . "` " . $ligne['typeChamp'] . " " .
									(($ligne['autoIncrement']) ? "AUTO_INCREMENT" : "") . " " .
									(($ligne['notNull']) ? "NOT NULL" : "NULL") . ",";
									// On supprime la dernière virgule et on assemble la requete
									$requete = rtrim($requete, ",");
									
									break;
						}
					}
					if($champExiste) {
						if ($modificationLigne) {
							// On exécute la modification
							$requete = $maConnexion->prepare($requete);
							$requete->execute();
						}
					}
					else {
						// On va ajouter le champ à la table
						$requete = "ALTER TABLE " . $nomTable . " ADD COLUMN " .
								"`" . $cle . "` " . $ligne['typeChamp'] . " " .
								(($ligne['autoIncrement']) ? "AUTO_INCREMENT" : "") . " " .
								(($ligne['notNull']) ? "NOT NULL" : "NULL") . ",";
								// On supprime la dernière virgule et on assemble la requete
								$requete = rtrim($requete, ",");
								// On exécute la modification
								$requete = $maConnexion->prepare($requete);
								$requete->execute();
					}
					

				}
				
				// On va remettre à jour la définition de la table
				$requete = $maConnexion->query("SHOW COLUMNS FROM " . $nomTable);
				$listeTables = $requete->fetchAll();
				$requete->closeCursor();
				/* On va ensuite refaire le parcours inverse pour vérifier la présence d'un champ
				 * dans la base mais supprimé ou modifié dans la table
				 */
				foreach ($listeTables as $champ){
					$champExiste = false;
					foreach ($tableDefinition as $cle => $ligne) {
						if ($cle === $champ['Field']) {
							$champExiste = true;
							break;
						}
						// On ne supprime pas les champs si le suivi des modifications est activé
						if ($this->suiviModification) {
							if ( $champ['Field']=== 'idCreation' || $champ['Field']=== 'dateCreation' || $champ['Field']=== 'idModification' || $champ['Field']=== 'dateModification') {
								$champExiste = true;
								break;
							}
						}
					}
					// Le champ n'existe pas dans la classe, on supprime
					if (!$champExiste) {
						// On va supprimer le champ
						$requete = "ALTER TABLE " . $nomTable . " DROP COLUMN `" . $champ['Field']. "` ";
						// On supprime la dernière virgule et on assemble la requete
						$requete = rtrim($requete, ",");
						// On exécute la modification
						$requete = $maConnexion->prepare($requete);
						$requete->execute();
					}
				}
				
				// On va ajouter dans la table la gestion des dates de creation/modification
				$ajoutMod = true;
				foreach ($listeTables as $nomChamp) {
					if ( $nomChamp['Field'] === 'dateModification') {
						$ajoutMod = false;
						break;
					}
				}
				if ($this->suiviModification && $ajoutMod) {
					$requete = "ALTER TABLE " . $nomTable . " ADD COLUMN idCreation int NOT NULL AFTER onArchive";
					$requete = $maConnexion->prepare($requete);
					$requete->execute();
					
					$requete = "ALTER TABLE " . $nomTable . " ADD COLUMN dateCreation datetime NOT NULL AFTER idCreation";
					$requete = $maConnexion->prepare($requete);
					$requete->execute();
					
					$requete = "ALTER TABLE " . $nomTable . " ADD COLUMN idModification int NULL AFTER dateCreation";
					$requete = $maConnexion->prepare($requete);
					$requete->execute();
					
					$requete = "ALTER TABLE " . $nomTable . " ADD COLUMN dateModification datetime NULL AFTER idModification";
					$requete = $maConnexion->prepare($requete);
					$requete->execute();
				}
			}
		}
		
		// Pas de résultat donc on va créer la table
		if (!$tableExiste) {
			// On préparer la requête de création
			$requete = "CREATE TABLE " . $nomTable . " (";
			$champs = "";
			foreach ($tableDefinition as $cle => $ligne) {
				// On va définir notre PIRMARY KEY
				if (($ligne['primaryKey'])) {
					$primaryKey = ($cle);
				}
				// ON va définir nos champs
				$champs =  $champs . "`" . $cle . "` " . $ligne['typeChamp'] . " " .
						(($ligne['autoIncrement']) ? "AUTO_INCREMENT" : "") . " " .
						(($ligne['notNull']) ? "NOT NULL" : "NULL") . ",";
			}
			// On supprime la dernière virgule et on assemble la requete
			$champs = rtrim($champs, ",");
			// On assemble notre requete finale
			$requete = $requete . $champs;
			
			// On va ajouter dans la table la gestion des dates de creation/modification
			if ($this->suiviModification) {
				$requete = $requete . ' ,' .
					' `idCreation` int NOT NULL, ' . 
					' `dateCreation` datetime NOT NULL, ' .
					' `idModification` int NULL, ' .
					' `dateModification` datetime NULL ';
			}
			
			// On ajoute la PIRMARY KEY si elle existe
			if (isset($primaryKey)) {
				$requete = $requete . ',PRIMARY KEY (`' . $primaryKey . '`));';
			}
			var_dump($requete);
			// On ajoute notre table
			$requete = $maConnexion->prepare($requete);
			$requete->execute();
		}
	}
	
	/* Fonction qui va définir les caractérisques du champ dans la base 
	 * array ( $typeChamp => le type de champ dans la table,
	 * $primaryKey => définit si le champ est la clé primaire (unique)
	 * $autoIncrement => si le champ s'incrémente automatiquement (nécessite un champ int)
	 * $notNull => Si le champ peut être null ou pas
	 * $unique => si le champ doit être unique )
	 * */
	protected function baseDefinition ($typeChamp, $primaryKey, $autoIncrement, $notNull,$unique,$ancienNom = null) {
		return array(
				'typeChamp' => $typeChamp,
				'primaryKey' => $primaryKey,
				'autoIncrement' => $autoIncrement,
				'notNull' => $notNull,
				'unique' => $unique,
				'ancienNom' => $ancienNom
		);
	}
	

}