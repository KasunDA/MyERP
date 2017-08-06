<?php 
/* ---------------------------------------------------------------------------------
 * ---------------------------------------------------------------------------------
 	Objectif:
 	---------
 	Le but de ce fichier est de traiter toutes les fonctions qui seront potentiellement
 	accessible depuis notre site. Chaque fonction sera présenté dans le descriptif ci-dessous
 	avec la procédure pour l'utiliser
 	Il est possible de rajouter une fonction spécifique, mais il faut le faire directement
 	dans un fichier à mettre dans le dossier fonctions du plugin.
 	Les fichiers annexes seront inclus dans ce fichier qui sera le seul a être déclaré
 	dans notre index.php afin d'en faciliter la gestion et des scinder les fonctions
 	par type. Pour chaque fichier joint, une liste de fonctions présentes dans ce fichier
 	sera faite.
 	
 	++++++++++++++++++++++++++++++++++++++++++++++++++++++
 	------------------------------------------------------
 	Liste des fonctions par fichier
 	------------------------------------------------------
 	++++++++++++++++++++++++++++++++++++++++++++++++++++++
 	tableauObjets.php
 		creationTableau($args)
 		setTableLigneDefinition($libelleAffiche,$afficheOn,$typeChamp,$align = null, $particularite = null)	
 		getNombrePage ($nbObjet,$nbObjetAffiche)
 		afficheChampTableau ($objet,$tabEntete,$cle)
 	
 	
 	------------------------------------------------------
 	++++++++++++++++++++++++++++++++++++++++++++++++++++++
 	
 	
 	
 	------------------------------------------------------
 	--- tableauObjets.php --- DETAILS
 	------------------------------------------------------
 	creationTableau($args)
			 	---------------------
				Objectif
					Le but de cette fonction est de créer un tableau de manière générique
					afin d'uniformiser l'affichage, mais également à partir d'une liste d'objets
					et de certains arguments, de gagner un temps précieux dans la construction 
					des tableaux
				---------------------
				Descriptif paramètres
					$args = array(
						'enTete' => array définissant les entetes du tableau de manière générale, il est défini
							depuis la classe via la fonction $monObjet->getTableEnTeteDefinition(). Peut être null
							pour ne pas afficher d'en-tete
						'donnees' => array contenant  nos objets mis en forme de manière spécifique,
						'options' => (!$afficheOption ? null : array (
									'idObjet' => $monObjet->getValeur('nomID'),
									'type' => $droitsOptions,
									'lien' => 'index.php?module=' . $lienPlugin. '&rubrique=' . $nomClasse
							)),
						'nbPage' => Définit le nombre de page du tableau en cours donc peut varier selon les options. il est
							possible d'utiliser la fonction getNombrePage().
						'niveauDroitAjout' => Niveau du droit pour l'accès à l'ajout du formulaire. On l'obtient via la fonction
							getNiveauDroit()
						'urlAjout' => URL pointant vers le formulaire de saisie de l'objet,
					)
				Prototype
						creationTableau(array(
							'enTete' => '' // Obligatoire, null possible
							'donnees' => '', // Obligatoire, null possible
							'rupture' => array(
								'cleRupture' => '',
								'libelleRupture' => ''
								),
							'options' => array (	
										'idObjet' => '',
										'type' => '',
										'lien' => ''
								),
							'nbPage' => '' // Obligatoire, null possible
							'niveauDroitAjout' => '' // Obligatoire
							'urlAjout' => '' // Obligatoire
						));
				+++++++++++++++++++++++++++++++++++++++++


	setTableLigneDefinition($libelleAffiche,$afficheOn,$typeChamp,$particulariteChamps = null, $particulariteClasse = null)
				---------------------
				Objectif
					Le but de cette fonction est de créer un tableau qui utilisé dans notre classe objet, permet
				de définir une ligne à afficher(ou pas) et qui sera utiliser dans la fonction creationTableau($args)
				---------------------
				Descriptif paramètres
					$libelleAffiche => Libellé qui sera affiché dans l'entête du tableau
					$afficheOn => boolen permettant de masquer la colonne
					$typeChamp => type de champ affiché (date, int, etc.)
					$particulariteChamp = Si on veut une mise en forme particulière (mail / www / monetaire) 
					$particulariteClasse = Si on veut mettre une particularité de classe (center pull-right etc.)
				---------------------
				Prototype
					setTableLigneDefinition($libelleAffiche,$afficheOn,$typeChamp,$align = null, $particularite = null)
				+++++++++++++++++++++++++++++++++++++++++


	getNombrePage ($nbObjet,$nbObjetAffiche)
				---------------------
				Objectif
					Le but de cette fonction est de renvoyer le nombre de page à afficher dans notre tableau en
				fonction du nombre d'objets dans la liste
				---------------------
				Descriptif paramètres
					$nbObjet => Nombre d'objet contenu dans la liste 
					$nbObjetAffiche => Nombre d'objet à afficher sur une page dans le tableau
				---------------------
				Prototype
					getNombrePage ($nbObjet,$nbObjetAffiche)
				+++++++++++++++++++++++++++++++++++++++++
				
				
	afficheChampTableau ($objet,$tabEntete,$cle)
				---------------------
				Objectif
					Le but de cette fonction est de renvoyer le nombre de page à afficher dans notre tableau en
				fonction du nombre d'objets dans la liste
				---------------------
				Descriptif paramètres
					$nbObjet => Nombre d'objet contenu dans la liste 
					$nbObjetAffiche => Nombre d'objet à afficher sur une page dans le tableau
				---------------------
				Prototype
					getNombrePage ($nbObjet,$nbObjetAffiche)
				+++++++++++++++++++++++++++++++++++++++++
* ---------------------------------------------------------------------------------
* ---------------------------------------------------------------------------------
*/

// Inclusion de nos fichiers de fonctions
include ('tableauObjets.php');
include ('fichiersCSV.php');


/* ---------------------------------------------------------------------------------------------------------------------
 * ---------------------------------------------------------------------------------------------------------------------
 *		FONCTIONS SPECIFIQUES A L'ECHANGE DE DONNEES AVEC LA BASE DE DONNEES
 * ---------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------- */
/* Cette fonction a pour but de générer la classe correspondant
 * au formulaire en cours d'ajout. L'idée est de faire ici un second
 * controle ainsi qu'une traduction de certains champs (date/checkboc, etc.)
 */
function setDataForm($classe, $idObjet = null){
	if (isset($_POST['enreg'])) {
		/* Afin d'éviter de devoir tout se retaper, nous allons
		 * céer un tableau avec toutes les variables $_POST
		 */
		$maClasse = new $classe(array('idObjet' => $idObjet));

		/* On va récupérer la définition des champs pour enregistrer
		 *  dans la base le bon format
		 */
		$listeDefinition = $maClasse->getBaseDefinition();

		foreach ($_POST as $cle => $valeur) {
			/* On va vérifier pour chaque définition si une conversion
			 * est nécessaire
			 */
			foreach ($listeDefinition as $cleDefinition => $definition) {
				if ($cleDefinition === $cle) {
					switch ($definition['typeChamp']){
						case 'date':
							$maClasse->setValeur($cle,formToBaseDate($valeur));
							break;
						case 'Double' :
							$maClasse->setValeur($cle,formToBaseDouble($valeur));
							break;
						case 'int' :
							$maClasse->setValeur($cle,formToBaseInt($valeur));
							break;
						case 'tinyint':
							$maClasse->setValeur($cle,formToBaseCheckBox($valeur));
							break;
						default:
							$maClasse->setValeur($cle,$valeur);
							break;
					}
				}
			}
		}
		// Nous allons enregistrer l'objet dans la base et retourner l'ID
		return $maClasse->setObjet();
	}
}

/* Cette fonction a pour but de récupérer un paramètre général dans la liste
 * Celle-ci pourra être compléter au fur et à mesure de l'évolution du programme
 */
function recupereParametre ($param) {
	switch ($param){
		case 'idCompteDefaut':
			$maConnexion = ouvreConnexion();
			$requete = $maConnexion->query("SELECT " . $param . " FROM _param");
			$parametre = $requete->fetch();
			break;
		default:
			$parametre = null;
			break;
	}
	return $parametre;
}

// Manupilation des checkbox
function formToBaseCheckBox($valeur = null) {
	if (($valeur) AND ($valeur === 'on'))
		return 1;
		else
			return null;
}

// Manupilation des Int
function formToBaseInt($valeur = null) {
	if (($valeur) AND ($valeur != ''))
		return $valeur;
	else
	return null;
}

// Manupilation des dates
function formToBaseDate($valeur = null) {
	if ($valeur){
		return date("Y-m-d", strtotime($valeur));
	}
	else {
		return null;
	}
}
function baseToFormDate($valeur = null) {
	if ($valeur) {
		return date("d-m-Y", strtotime($valeur));
	}
	else {
		return null;
	}
}

// On met un . pour les doubles
function formToBaseDouble($valeur = null) {
	if ($valeur){
		return number_format($valeur, 2,'.','');
	}
	else {
		return null;
	}
}

/*function recupArgsTableau($nomClasse,$nomID,$URL,$rupture,$idObjet = null) {
	$monObjet = new $nomClasse($idObjet);
	$listeObjet = $monObjet->getListeObjet();
	// Nous allons créer un tableau d'options
	$tableOptions = array();
	foreach ($listeObjet as $objet){
		$tableDetails = array();
		//------------------------------------
		// Création du tableau d'option
		// Option pour afficher l'opératoin
		$tableDetails[] = array(
				'type' => 'affiche',
				'lien' => $URL . '&' . $nomID . '=' . $objet->getValeur($nomID)
		);
		//------------------------------------
		$tableOptions[] = array(
				'idObjet' => $objet->getValeur($nomID),
				'options' => $tableDetails
		);
	}
	$argsTableau = array(
			'enTete' => $monObjet->getDefinition(),
			'donnees' => $listeObjet,
			'options' => $tableOptions,
			'rupture' => $rupture
	);
	return $argsTableau;
}*/

/* ---------------------------------------------------------------------------------------------------------------------
 * ---------------------------------------------------------------------------------------------------------------------
 *		FONCTIONS DE MISE EN FORME SPECIFIQUES AUX FORMULAIRES
 * ---------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------- */

/* Fonction pour créer le champ select à partir d'un classe
 * En argument, nous utilisons un tableau suivant la norme suivante
 * array(
 * 'libelleLabel' => le nom du libellé à afficher,
 * 'donnees' => 'tableau d'objet',
 * 'attrName' => 'nom du champID qui servira en valeur à envoyer',
 * 'champAffiche' => 'nom du champ qui sera affiche dans les options',
 * 'urlAjout' => 'URL pour créer une nouvelle entrée,
 * 'idSelected' => 'valeur du champ si sélectionner sinon mettre à null',
 * 'champRupture' => 'champ qui va nous servir de rupture pour filtrer le champ',
 * 'disabled' => 'boolean pour savoir si on affiche un champ non modifiable',
 */
function selectObjetCreate($args){
	if (isset($args['libelleLabel']) && $args['libelleLabel'] !== '') { ?>
		<label><?php echo $args['libelleLabel']; ?></label>
	<?php
	}
		// On va afficher le bouton d'ajout si nous avons une url 
		if (isset($args['urlAjout']) AND $args['urlAjout'] != '') { ?><a href='<?php echo $args['urlAjout']; ?>'><span class='glyphicon glyphicon-plus pull-right'> AJOUTER</span></a>
	<?php } ?>

	<select name='<?php echo $args['attrName']; ?>' id='<?php echo $args['attrName']; ?>' <?php  echo ($args['disabled'] === 'true' ? 'DISABLED=disabled' : ''); ?>>
		<?php
		$rupture = "";
		foreach ($args['donnees'] as $objet) {	
				// On va vérifier si une rupture est demandée
				if ($args['champRupture']){
					if ($rupture !== $objet->getValeur($args['champRupture'])) {
						// On vérifie si c'est notre premier boucle
						if ($rupture !== "") {
							?>
								</optgroup>
								<optgroup label="<?php echo strtoupper($objet->getValeur($args['champRupture'])); ?>">
							<?php 
						}
						else {
							?>
								<optgroup label="<?php echo strtoupper($objet->getValeur($args['champRupture'])); ?>">
							<?php
						}
						$rupture = $objet->getValeur($args['champRupture']);
					}
				} ?>
				
				<option value="<?php echo $objet->getValeur($objet->getValeur('nomID')); ?>" 
					<?php if ($args['idSelected']) echo ($objet->getValeur($args['champIDBase']) === $args['idSelected']) ? "SELECTED" : ""; ?>
				>
					<?php
					// On va permettre l'envoi d'un array pour afficher plusieurs valeurs de l'objet si besoin
					if (is_array($args['champAffiche'])) {
						foreach ($args['champAffiche'] as $valeur) {
							echo $objet->getValeur($valeur) . ' ';
						}
					}
					else {			
						echo $objet->getValeur($args['champAffiche']); 
					}?>
				</option> 
	<?php }?>
	</select> <?php 
}

// On va créer une fonction pour créer un champs select à partir de valeurs envoyés
function selectVariablesCreate($args) {
	?>
	<select class="form-control" name="<?php echo $args['champCle']; ?>" id="<?php echo $args['champCle']; ?>">
	<?php 
	foreach ($args['listeChoix'] as $valeur) {
	?>
		<option value="<?php echo $valeur['valeur']?>" <?php echo ($valeur['valeur'] === $args['champSelected']) ? "SELECTED" : ""; ?>><?php echo $valeur['valeurAffiche'];?></option>
	<?php } ?>
	</select>
	<?php 	
}

/* Fonction qui va lister les dossiers
 * 
 */
function listeDossiers($args){
	switch ($args['dossier']) {
		case 'templates':
			$listeBrute = scandir($_SERVER['DOCUMENT_ROOT'] . '/_templates/');
			$listeDossiers = filtreDossier($listeBrute);
			break;
		case 'plugins':
			$listeBrute = scandir($_SERVER['DOCUMENT_ROOT'] . '/_plugins/');
			$listeDossiers = filtreDossier($listeBrute);
			break;
		case 'classe':
			$listeBrute = scandir($_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $args['plugin'] . '/class/');
			$listeDossiers = filtreDossier($listeBrute);
			break;
		default:
			break;
	}
	return $listeDossiers;
}
function filtreDossier($listeBrute) {
	// boucler tant que quelque chose est trouve
	$listeFiltre = array(); 
	foreach ($listeBrute as $entree) { 
		// affiche le nom et le type si ce n'est pas un element du systeme
		if( $entree != '.' && $entree != '..' && $entree != '__exemple__') {
			$listeFiltre[] = $entree;
		}
	}
	return $listeFiltre;
}

/* Fonction qui va créer un tableau associant une valeur
 * à la valeur à afficher pour les champs SELECT
 */
function setArraySelectListe($valeur,$valeurAffiche) {
	return array(
			'valeur' => $valeur,
			'valeurAffiche' => $valeurAffiche
	);
}

/* ---------------------------------------------------------------------------------------------------------------------
 * ---------------------------------------------------------------------------------------------------------------------
 *		FONCTIONS DIVERSES
 * ---------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------- */
/* Fonction qui va nous permettre de constuire un tableau de données
 * qui sera utilisé par le template pour afficher les menus.
 * il ira chercher dans chaque dossier de plugins le fichier définition afin de retourner l'affiche
 * ainsi que les droits autorisés.
 * Les droits eux seront dans la variable $_SESSION
 * Pour simplifier le template, on va gérer les droits dans cette fonction
 */
function getListeMenu() {
	$listePlugin = listeDossiers(array('dossier' => 'plugins'));
	foreach ($listePlugin as $plugin) {
		// on va récupérer la définition de notre menu
		require_once ( $_SERVER['DOCUMENT_ROOT'] . '/_plugins/' . $plugin . '/_definitions.php');
		$definitionMenu = $plugin('getMenu');
	
		// On vérifie que l'on doit affiche le plugin dans le menu
		if ($definitionMenu) {
			// on vérifie si la personne est autorisée à accéder au menu
			if (isset($_SESSION[$plugin]) && $_SESSION[$plugin] >= $definitionMenu['niveauAcces']) {
				//on va vérifier la présence de notre sous menu
				if($definitionMenu['sousMenu']) {
					/* Comme le menu, on va vérifier que pour chaque sous-menu
					 * l'utilsateur y a accès (ex: paramètres)
					 */
					$listeSousMenuFiltree = array();
					//$listeSousMenu = null;
					$listeSousMenu  = $plugin('getSousMenu');
					foreach ($listeSousMenu as $sousMenu) {
						if ($_SESSION[$plugin] >= $sousMenu['niveauAcces']) {
							$listeSousMenuFiltree[] = $sousMenu;
						}
					}
					$definitionMenu['sousMenu'] = $listeSousMenuFiltree;
				}
				// On ajoute la définition de notre menu
				$tableauMenu[] = $definitionMenu;
			}
		}
	}
	
	// on renvoie un null si aucun menu n'a été trouvé
	if (isset($tableauMenu)) {
		return $tableauMenu;
	}
	else {
		return null;
	}
}



function setTuile($titre,$description,$lien,$nomImage,$classe = null) { ?>
	<div class='tuile<?php echo (isset($classe) ? ' ' .$classe : ''); ?>'>
		<a class="tile" title="<?php echo $description; ?>" href="<?php echo $lien; ?>">
			<h1><?php echo $titre; ?></h1>
			<img src="_templates/<?php  echo $_SESSION['template'];?>/images/<?php echo $nomImage; ?>" alt="<?php echo $description; ?>">
			<p><?php echo $description; ?></p>
		</a>
	</div>
<?php }
