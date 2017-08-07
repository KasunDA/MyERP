<?php
/* On va vérifier si une requète AJAX est en cours 
*/
if (isset($_POST['source']) AND $_POST['source'] === 'AJAX'){

	switch ($_POST['fonction']) {
		case 'getListeObjet':
			// On va créer une instance de notre objet
			require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $_POST['plugin'] . '/class/' . $_POST['classe'] . '.php';
			include_once ($_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/fonctions/myERP.php');
			$monObjet = new $_POST['classe']();
			
			//On va ensuite définir  le type d'affichage désiré
			switch ($_POST['miseEnForme']){
				case 'tableau':
					// On va récupérer notre liste d'objet
					$tableauObjet = $monObjet->getListeObjet(array('specifiqueClasse' =>
						array('idCompte' => $_POST['valueSelected'],
						'debutPeriode' => formToBaseDate($_POST['dateDebut']),
						'finPeriode' => formToBaseDate($_POST['dateFin']),
							   'estRapproche' => '0'
						)));

					// Nous allons recréer un tableau
					$tableOptions = array();
					/*'options' => (!$afficheOption ? null : array (
							'idObjet' => $monObjet->getValeur('nomID'),
							'type' => $champsOptions,
							'lien' => 'index.php?module=' . $nomPlugin . '&rubrique=' . $nomClasse
					))*/
					if ($tableauObjet) {
						foreach ($tableauObjet as $objet){
							$tableDetails = array();
							//------------------------------------
							// Création du tableau d'option
							// Option pour afficher l'opératoin
							$tableDetails[] = array(
									'type' => 'affiche',
									'lien' => 'index.php?module=' . $_POST['plugin'] . '&rubrique=' . $_POST['classe'] . '&action=affiche&id' . $_POST['classe'] . '=' . $objet->getValeur($objet->getValeur('nomID'))
							);
							$tableDetails[] = array(
									'type' => 'suppr',
									'lien' => 'index.php?module=' . $_POST['plugin'] . '&rubrique=' . $_POST['classe'] . '&action=suppr&id' . $_POST['classe'] . '=' . $objet->getValeur($objet->getValeur('nomID'))
							);
							//------------------------------------
							$tableOptions[] = array(
									'idObjet' => $objet->getValeur($objet->getValeur('nomID')),
									'options' => $tableDetails
							);
						}
						
						// Nous allons constituer notre tableau pour la création du tableau
						$argsTableau = array(
								'enTete' => $monObjet->getTableEnTeteDefinition(),
								'donnees' => $tableauObjet,
								'options' => null
						);
	
						// On construit notre tableau
						creationTableau($argsTableau);
					}
					else {
						echo "Aucune opération sur la période";
					}
					break;
				case 'select':
					$tentativeHack = false;
					// On va définir nos variables spécifiques à nos classes
					switch ($_POST['classe']) {
						case 'Compte':
							$champAffiche = array('libelleCompte');
							$url = 'index.php?module=' . $_POST['plugin'] . '&rubrique=parametres&param=comptes&action=ajout';
							break;
						case 'Famille':
							$champAffiche = array('nomFamille');
							$url = 'index.php?module=' . $_POST['plugin'] . '&rubrique=parametres&param=familles&action=ajout';
							break;
						case 'Banque':
							$champAffiche = array('nomBanque');
							$url = 'index.php?module=' . $_POST['plugin'] . '&rubrique=parametres&param=banques&action=ajout';
							break;
						case 'Categorie':
							$champAffiche = array('nomCategorie');
							$url = 'index.php?module=' . $_POST['plugin'] . '&rubrique=parametres&param=categories&action=ajout';
							break;
						default:
							$tentativeHack = true;
							break;
					}

					/* On va afficher préparer nos variables pour créer
					 * notre select
					 */
					if (!$tentativeHack) {
						// On va récupérer notre liste de catégorie
						// On vérifie si le type d'opération est défini
						$idSelected = (isset($_POST['idSelected'])) ? $_POST['idSelected'] : null;
						$label = (isset($_POST['label'])) ? $_POST['label'] : $_POST['classe'];
						$attrName = (isset($_POST['attrName'])) ? $_POST['attrName'] : $monObjet->getValeur('nomID');

						/* On prend en compte la spécificité pour le type d'opération
						 *
						 */
						$listeObjet = $monObjet->getListeObjet(isset($_POST['typeOperation']) ? $_POST['typeOperation'] : null);
						$argsSelect =  array(
								'libelleLabel' => $label,
								'donnees' => $listeObjet,
								'attrName' => $attrName,
								'champIDBase' => $monObjet->getValeur('nomID'),
								'champAffiche' => $champAffiche,
								'urlAjout' => $url,
								'idSelected' => $idSelected,
								'champRupture' => isset($_POST['rupture']) ? $_POST['rupture'] : null,
								'disabled' => false
						);
						selectObjetCreate($argsSelect);
					}
					else {
						echo "Erreur dans le chargement du SELECT";
					}
					break;
				default:
					break;
			}
			break;
		case 'operation':	
			if ($_POST['estRapproche'] === '-1'){
				$debutPeriode = '2016-01-01';
				$finPeriode = '2017-12-31';
			} else {
				$debutPeriode = '2017-01-15';
				$finPeriode = '2017-03-31';
			}

			$args = array(
					'idCompte' => $_POST['idCompte'],
					'estRapproche' => $_POST['estRapproche'],
					'MEF' => 'tableau',
					'debutPeriode' => $debutPeriode,
					'finPeriode' => $finPeriode
		
			);
			getListeOperationMEF($args);
		
			break;
		case 'echeances':
			// On va récupérer notre liste déchéances
			require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Echeance.php';
			$args = array(
					'idCompte' => ($_POST['idCompte'] === 'null' ? null : $_POST['idCompte']),
					'dateDebut' => ($_POST['dateDebut'] === 'null'? null : $_POST['dateDebut']),
					'dateFin' => ($_POST['dateFin'] === 'null' ? null : $_POST['dateFin'])
			);
			// On va récupérer notre liste d'échéance
			$mesEcheances = funcGetListeEcheances($args);
			afficheEcheances($mesEcheances);
			break;
		case 'echeanceSynthese':
			$args = array(
			'typeMouvement' => $_POST['typeMouvement'],
			'MEF' => 'tableau',
			'debutPeriode' => $_POST['dateDebut'],
			'finPeriode' => $_POST['dateFin']
			);
			getListeEcheanceMEF($args);
			break;
			/* On va gérer les deux cas suivants qui correspondent à l'affichage des
			 * formulaire de saisies des opérations/virements
			 */
		case 'echeanceOperation':
			// On va récupérer notre liste déchéances
			require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Echeance.php';
			if ((int)$_POST['idEcheance'] > 0) {
				$maClasse = new Echeance(array('idEcheance' => (int)$_POST['idEcheance']));
			}
			else {
				$maClasse = new Echeance();
			}
			include($_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/views/mesEcheancesOperation.php');
			break;
		case 'echeanceVirement':
			// On va récupérer notre liste déchéances
			require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Echeance.php';
			if ((int)$_POST['idEcheance'] > 0) {
				$maClasse = new Echeance(array('idEcheance' => (int)$_POST['idEcheance']));
			}
			else {
				$maClasse = new Echeance();
			}
			include($_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/views/mesEcheancesVirement.php');
			break;
		default:
			break;
	}
}

/* ------------------------------------------
 * FONCTIONS DIVERSES
 * ------------------------------------------

 */

/* Cette fonction aura pour but de renvoyer un tableau d'objet
 * contenant les objets banques actifs
 */
function getListeObjetCompte() {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyBDD.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Compte.php';
	$maConnexion = new MyBDD();
	$parametreCompte = array(
			'nomID' => 'idCompte',
			'nomTable' => 'mycompta_comptes',
			'tri' => 'idBanque',
			'ordreTri' => 'ASC'
	);
	$listeID = $maConnexion->getTableID($parametreCompte);
	// On va construire notre tableau d'objet
	$listeComptes = array();
	if ($listeID){
		foreach ($listeID as $ligne) {
			$listeComptes[] = new Compte(array('idObjet' => $ligne['idCompte']));
		}
	}
	// On renvoie notre tableau
	return $listeComptes;
}
/* Cette fonction aura pour but de récupérer toutes les opérations
 * avec une option de mise en forme
 * $args = array (
 * 	'idCompte' = 'l'ID du compte pour lequel nous devons récupérer les opérations',
 *  'estRapproche' = 'Pour récupérer les opérations en fonction de la valeur 1 pour rapproché, -1 pour non rapproché 0 pour toutes
 *  'MEF' = 'type de mise en forme avec valeur possible liste ou tableau
 */
function getListeOperationMEF($args) {
	// On va inclure notre classe
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Operation.php';
	$monOperation = new Operation();
	// On récupère la liste de nos opérations
	$listeOperation = $monOperation->getListeObjet($args);
	if ($listeOperation) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/fonctions/myERP.php';
		switch ($args['MEF']) {
			case 'tableau':
				// Nous allons recréer un tableau
				$tableOptions = array();
				foreach ($listeOperation as $objet){
					$tableDetails = array();
					//------------------------------------
					// Création du tableau d'option
					// Option pour afficher l'opératoin
					$tableDetails[] = array(
							'type' => 'affiche',
							'lien' => 'index.php?module=myCompta&rubrique=Compte&idCompte=' . (int)$_POST['idCompte'] . '&action=modif&idOperation=' . $objet->getValeur('idOperation')
					);
					// On crée la possibilité de supprimer une opération si elle n'est pas rapproché
					if ($objet->getValeur('estRapproche') === null) {
						// Option pour rapprocher l'operation
						$tableDetails[] = array(
								'type' => 'rapprochement',
								'lien' => 'index.php?module=myCompta&rubrique=Compte&idCompte=' . (int)$_POST['idCompte'] . '&action=rapproch&idOperation=' . $objet->getValeur('idOperation')
						);
						$tableDetails[] = array(
								'type' => 'suppr',
								'lien' => 'index.php?module=myCompta&rubrique=Compte&idCompte=' . (int)$_POST['idCompte'] . '&action=suppr&idOperation=' . $objet->getValeur('idOperation')
						);
					}
					else {
						// Option pour dé-rapprocher l'operation
						$tableDetails[] = array(
								'type' => 'rapprochementAnnul',
								'lien' => 'index.php?module=myCompta&rubrique=Compte&idCompte=' . (int)$_POST['idCompte'] . '&action=deRapproch&idOperation=' . $objet->getValeur('idOperation')
						);
					}
					//------------------------------------
					$tableOptions[] = array(
							'idObjet' => $objet->getValeur('idOperation'),
							'options' => $tableDetails
					);
				}
				// Nous allons constituer notre tableau pour la création du tableau
				$argsTableau = array(
						'enTete' => $objet->getTableEnTeteDefinition(),
						'donnees' => $listeOperation,
						'options' => $tableOptions
				);
				creationTableau($argsTableau);
				break;
			default:
				?><em>Erreur de mise en forme</em><?php
				break;
		}
		
	}
	else {
		?><em>Pas d'opération</em><?php 
	}
}
/*-------------------------------------------------------------------------
 * FONCTIONS SPECIFIQUES AUX ECHEANCES
 * ------------------------------------------------------------------------
 */
/* On va créer une fonction qui va récupérer toutes nos échéances
 * et les regrouper dans un tableau d'objet
 * Nous allons demander un tableau en paramètre de la façon suivante
 * $args = array (
 *   'dateDebut' => 'date de la première échéance du tableau a récupérer',
 *   'dateFin' => date de la dernière échéance du tableau,
 *   'idCompte' => l'id du compte
 * )
 */
function funcGetListeEcheances($args) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Echeance.php';
	$monEcheance = new Echeance();
	$argsEcheance = array(
			'idCompte' => ($args['idCompte']  ? $args['idCompte'] : null)
	);
	$listeEcheance = $monEcheance->getListeObjet($argsEcheance);
	$tableauEcheances = null;
	// On va séparer nos échéances en tableaux triés par compte
	foreach ($listeEcheance as $objet){
		//if ($objet->getValeur('idEcheance') === '17');
		if ($args['dateDebut'] === null) {
			//on va vérifier si nous devons recalculer les échéances passées
			if ($objet->getValeur('recalculEcheancesPassees') === '1') {
				$dateDebut = $objet->getValeur('dateDebut');
			}
			else {
				$dateDebut = date('Y-m-d');
			}
		}
		else {
			$dateDebut = $args['dateDebut'];
		}
		// Nous allons créer notre tableau d'échéance appartenant à l'intervalle
		foreach ($objet->getValeur('tableauEcheance') as $dateEcheance){
			//On ne va conserver que les objets dont la date d'échéance est dans l'intervalle
			if (($dateDebut <= $dateEcheance) and ($args['dateFin'] >= $dateEcheance)){
				// On va traiter les virements internes et opérations différement
				if ($objet->getValeur('typeMouvement') === 'O') {
					$tableauEcheances[] = array(
							'idCompte' => $objet->getValeur('operationIdCompte'),
							'idEcheance' => $objet->getValeur('idEcheance'),
							'description' => $objet->getValeur('description'),
							'montant' => $objet->getValeur('montant'),
							'operationType' => $objet->getValeur('operationType'),
							'echeanceDate'  => $dateEcheance,
							'integrationAuto' => $objet->getValeur('integrationAuto')
					);
				}
				elseif ($objet->getValeur('typeMouvement') === 'V') {
					if ($args['idCompte'] === $objet->getValeur('virementIdCompteEmetteur')) {
						$tableauEcheances[] = array(
								'idCompte' => $objet->getValeur('virementIdCompteEmetteur'),
								'idEcheance' => $objet->getValeur('idEcheance'),
								'description' => $objet->getValeur('description'),
								'montant' => $objet->getValeur('montant'),
								'operationType' => 'D',
								'echeanceDate'  => $dateEcheance,
								'integrationAuto' => $objet->getValeur('integrationAuto')
						);
					}
					if ($args['idCompte'] === $objet->getValeur('virementIdCompteDestinataire')) {
						$tableauEcheances[] = array(
								'idCompte' => $objet->getValeur('virementIdCompteDestinataire'),
								'idEcheance' => $objet->getValeur('idEcheance'),
								'description' => $objet->getValeur('description'),
								'montant' => $objet->getValeur('montant'),
								'operationType' => 'C',
								'echeanceDate'  => $dateEcheance,
								'integrationAuto' => $objet->getValeur('integrationAuto')
						);
					}
				}
			}
		}
	}
	// On va trier notre tableau par date
	if ($tableauEcheances) {
		usort($tableauEcheances, "triTableauDate");
	}
	return $tableauEcheances;
}
/* Cette fonction aura pour but de récupérer toutes les opérations
 * avec une option de mise en forme
 * $args = array (
 * 	'idCompte' = 'l'ID du compte pour lequel nous devons récupérer les opérations',
 *  'estRapproche' = 'Pour récupérer les opérations en fonction de la valeur 1 pour rapproché, -1 pour non rapproché 0 pour toutes
 *  'MEF' = 'type de mise en forme avec valeur possible liste ou tableau
 */
function getListeEcheanceMEF($args) {
	// On va inclure notre classe
	require_once $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myCompta/class/Echeance.php';
	$monEcheance = new Echeance();
	// On récupère la liste de nos opérations
	$listeEcheances = $monEcheance->getListeObjet();
	$definitionEntete = $monEcheance->getDefinition();
	if ($listeEcheances) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/fonctions/myERP.php';
		switch ($args['MEF']) {
			case 'tableau':
				// Nous allons recréer un tableau
				$tableOptions = array();
				foreach ($listeEcheances as $objet){
					if ($args['typeMouvement'] === $objet->getValeur('typeMouvement')){
						$tableDetails = array();
						//------------------------------------
						// Création du tableau d'option
						// Option pour afficher l'opératoin
						$tableDetails[] = array(
								'type' => 'affiche',
								'lien' => 'index.php?module=myCompta&rubrique=Echeance&action=modif&idEcheance=' . $objet->getValeur('idEcheance')
						);
						//------------------------------------
						$tableOptions[] = array(
								'idObjet' => $objet->getValeur('idEcheance'),
								'options' => $tableDetails
						);
						$tableauDonnees[] = $objet;
					}
				}
				// Nous allons constituer notre tableau pour la création du tableau
				$argsTableau = array(
						'enTete' => $monEcheance->getDefinition(),
						'donnees' => $tableauDonnees,
						//'donnees' => $listeEcheances,
						'options' => $tableOptions
				);
				creationTableau($argsTableau);
				break;
			default:
				?><em>Erreur de mise en forme</em><?php
				break;
		}
		
	}
	else {
		?><em>Pas d'opération</em><?php 
	}
}
/* On va créer une fonction qui va afficher le tableau d'échéance
 * sur les pages de détails de compte
 */
function afficheEcheances($tableauEcheancesGenere) {
	if ($tableauEcheancesGenere){
		?>
		<table class="table table-bordered table-striped table-condensed">
		<tr>
			<th>Date</th>
			<th>Bénéficiaire</th>
			<th>Description</th>
			<th>Montant</th>
			<th>Options</th>
		</tr>
		<?php 
		/* On va d'abord vérifier si l'on doit intégrer les échéances automatiquement et
		 * antérieur ou égale à la date du jour
		 */
		foreach ($tableauEcheancesGenere as $echeance) {
			if ($echeance['integrationAuto'] === '1' AND $echeance['echeanceDate'] <= date('Y-m-d')){
				$monEcheance = new Echeance(array('idEcheance' => $echeance['idEcheance']));
				$monEcheance->createMouvement($echeance['echeanceDate']);
			}
			else {
				// On va mettre en forme le montant
				switch ($echeance['operationType']){
					case 'D':
						$classe = 'debit';
						$montant = '- ' . number_format($echeance['montant'], 2, '.', '');
						break;
					case 'C':
						$classe = 'credit';
						$montant = '+ ' . number_format($echeance['montant'], 2, '.', '');
						break;
				}
				// On affiche notre Echeance
				?>
				<tr>
					<td><?php echo $echeance['echeanceDate']; ?></td>
					<td></td>
					<td><?php echo $echeance['description']; ?></td>
					<td class="<?php echo $classe ?>" align="right"><?php echo $montant; ?> €</td>
					<td align=center>
						<a href='<?php echo "index.php?module=myCompta&rubrique=Echeance&action=modif&idEcheance=" . $echeance['idEcheance']; ?>' title="Modifier l'échéance"><span class='glyphicon glyphicon-pencil center'></span></a>
						<a href='<?php echo "index.php?module=myCompta&rubrique=Compte&idCompte=" . $echeance['idCompte'] . "&idEcheance=" . $echeance['idEcheance'] . "&action=createOperation&date=" . $echeance['echeanceDate']; ?>' title="Créer l'opération"><span class='glyphicon glyphicon-plus center'></span></a>
					</td>
				</tr>
				<?php 
			}
		}
		?></table><?php
	}
	else { ?>
		<em>Pas d'échéances</em>
	<?php  }
}
/* +++++++++++++++++++++++
 * Fonctions spécifiques aux prets
 * +++++++++++++++++++++++
 */
function afficheLissage() {
	?>
		<label>Détail du lissage</label><button id=btnPalier>Nouveau Palier</button><br><br>
		<input type=hidden id=nbPalier name=nbPalier value=2>
		<input type=text name=palierMontant1 placeholder="Montant de l'échéance">
		<input type=text name=palierDuree1 placeholder="Durée en mois"><br>
		<input type=text name=palierMontant2 placeholder="Montant de l'échéance">
		<input type=text name=palierDuree2 placeholder="Durée en mois"><br>
		<?php
}
/* +++++++++++++++++++++++
 * Fonctions génériques
 * +++++++++++++++++++++++
 */
/*Fonction pour trier les dates d'un tableau
 * A utiliser avec la fonction usort($nomTableau,triTableauDate)
 */
function triTableauDate( $a, $b ) {
	return strtotime($a['echeanceDate']) - strtotime($b['echeanceDate']);
}


