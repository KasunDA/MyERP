<?php

function creationTableau($args){ ?>
	 <div class='btmspace-15 one-line row'>
		<div class="">
			<?php 
				// Gestion de la zone Page 
				/*if ($args['nbPage'] > '1') { ?>
				<table>
					<tr>
						<td width='55'>Pages</td>
						<td align=center>
						<?php 
							if ($args['nbPage']> 15) { ?>
							<a href='#page=1' class='numPage' id='1'><span class='fa fa-angle-double-left'></span></a> 
						<?php  }
						if ($args['optionFiltre']['nbPageListeStop'] > 15) { ?>
							<a id='pagesPrecedentes' href='#'  class='numPage' ><span class='fa fa-angle-left'></span></a>
						<?php }
						for ($i = 1; $i <= ($args['nbPage'] > 15 ? '15': $args['nbPage']) ; $i++) {
								echo ($i > 1 ? " - ": " ");
								echo "<a id='" . $i . "' href='#page=" . $i . "' class='numPage'>" . $i . "</a>";
							}
							if ($args['nbPage'] > 15) { ?>
								<a id='pagesSuivantes' href='#' class='numPage'><span class='fa fa-angle-right'></span></a>
						<?php
							}
							if ($args['nbPage'] > 15) { ?>
								<a id='" + nbPage + "' href='#page=" . + nbPage + . "' class='numPage'> <span class='fa fa-angle-double-right'></span></a>
						<?php } ?>
						</td>
					</tr>
				</table>
			<?php }*/ ?>
		</div>
		<div class="">
			<?php
				// Gestion du bouton Nouveau
			if  ($args['niveauDroitAjout'] > 0 && $args['niveauDroitAjout'] <= $args['niveauAcces']) {?>
				<a href='<?php echo $args['urlAjout']; ?>' class='pull-right'>
					<button type="button" class="btn btn-success"><span class='fa fa-plus'></span> NOUVEAU</button>
				</a>
			<?php } ?>
		</div>
	</div>
	<?php 
	if ($args['donnees']) {
		if (isset($args['rupture']) AND $args['rupture'] !== null) {
			$idRupture = '';
			foreach ($args['donnees'] as $objet) {
				if ($idRupture !== $objet->getValeur($args['rupture']['cleRupture'])) {
					$idRupture = $objet->getValeur($args['rupture']['cleRupture']);
					
					?>
					<h6><?php echo $objet->getValeur($args['rupture']['libelleRupture']); ?></h6>
					<table class="table table-bordered table-striped table-condensed">
					<tr>
						<?php
						// On va préparer notre en-tête de tableau
						foreach ($args['enTete'] as $tabEnTete) { ?>
							<th class='center' <?php echo ($tabEnTete['afficheOn'])? "" : "hidden"; ?>><?php echo $tabEnTete['libelleAffiche']; ?></th>				
						<?php } 
						if (isset($args['options'])) { ?><th class='center'>Options</th> <?php }; ?>
					</tr>				
					<?php 
						foreach ($args['donnees'] as $objet) {
							if ($objet->getValeur($args['rupture']['cleRupture']) === $idRupture) {
									?><tr><?php
					/* On va parcourir notre tableau d'enTête pour être raccord
					 * avec les enTêtes
					 */
					foreach ($args['enTete'] as $cle => $tabEnTete) {
						// On va analyser chaque entrée pour afficher la particularité si besoin
						afficheChampTableau($objet,$tabEnTete,$cle);
					}
						if (isset($args['options'])) { ?>
							<td class='center'><?php 
							// 	On affiche les options
								setOption(isset($args['options']) ? $args['options'] : null,$objet->getValeur($objet->getValeur('nomID')));
						 	?></td><?php }?>							 	
					 	</tr><?php
						}
					}
					?>
					</table>
					<?php
				}
			}
		}
		else {
			?>
			<table class="table table-bordered table-striped table-condensed">
			<tr>
				<?php
				// On va préparer notre en-tête de tableau
				foreach ($args['enTete'] as $tabEnTete) { ?>
					<th class='center' <?php echo ($tabEnTete['afficheOn'])? "" : "hidden"; ?>><?php echo $tabEnTete['libelleAffiche']; ?></th>				
				<?php } ?>
				<?php if (isset($args['options'])) { ?><th class='center'>Options</th> <?php }; ?>
			</tr>
			<?php 
				if ($args['donnees']) {
					foreach ($args['donnees'] as $objet) {
						?><tr><?php 
						/* On va parcourir notre tableau d'enTête pour être raccord
						 * avec les enTêtes
						 */
						foreach ($args['enTete'] as $cle => $tabEnTete) {
							// On va analyser chaque entrée pour afficher la particularité si besoin
							afficheChampTableau($objet,$tabEnTete,$cle);
						}
							if (isset($args['options'])) { ?>
								<td class='center' width='120px'><?php 
								// 	On affiche les options
									setOption(isset($args['options']) ? $args['options'] : null,$objet->getValeur($objet->getValeur('nomID')));
							 	?></td><?php }?>							 	
						 	</tr><?php
					}
				}
			?>
			</table>
			<?php
		}
	}
	else { ?>
		<div><strong>Pas de résultats</strong></div>
	<?php }
}

/* Fonction qui va créer les liens ainsi que les icones à afficher dans les options des tableaux
 * en paramètre, nous allons demander un tableau d'option suivant la norme
 * $argsTableau = array(
 * 		'idObjet' => 'id de l'objet pour lequel s'applique les options',
 'options' => array(
 'type' => 'Type de ligne pour définir notre option',
 'lien' => 'Lien vers lequel pointe l'option'
 )
 * )
 * ainsi qu'un deuxième paramètre qui sera l'ID de l'objet (pour lier les options au bon objet)
 */
function setOption($tableauOptions,$idObjet) {
	if ($tableauOptions) {
		if (isset($_SESSION[$tableauOptions['type']['plugin']])) {
			$niveauAcces = $_SESSION[$tableauOptions['type']['plugin']];
		}
		else {
			$niveauAcces = $_SESSION['niveauAccesGeneral'];
		}
			
		foreach ($tableauOptions['type']['droits'] as $option){
			switch ($option['option']){
				case 'affiche':
					if (getNiveauDroit($tableauOptions['type']['droits'], 'affiche') <= $niveauAcces) {
						?> <a href='<?php echo $tableauOptions['lien'] . '&action=affiche&id=' . $idObjet; ?>' title="Afficher"><span class="fa fa-search center"></span></a><?php
					}
					break;
				case 'modif':
					if (getNiveauDroit($tableauOptions['type']['droits'], 'modif') <= $niveauAcces) {
						?> <a href='<?php echo $tableauOptions['lien'] . '&action=modif&id=' . $idObjet; ?>' title="Modifier"><span class='fa fa-pencil-square-o center'></span></a><?php
					}
					break;
				case 'supprime':
					if (getNiveauDroit($tableauOptions['type']['droits'], 'supprime') <= $niveauAcces) {
						?> <a href='<?php echo $tableauOptions['lien'] . '&action=supprime&id=' . $idObjet; ?>' id='supprime' title="Supprimer"><span class='fa fa-trash-o center'></span></a><?php
					}
					break;
			default:
				break;
			}
		}
	}
}


/* Cette fonction va nous permettre de récupérer le niveau de droit
 * donné pour une action en fonction de la définition issu du viewModels
 * de la classe dans la variable $droitsOptions
 */
function getNiveauDroit ($tableauNiveauDroit, $optionTest) {
	foreach ($tableauNiveauDroit as $droit){
		$niveau = 0;
		if ($droit['option'] === $optionTest) {
			$niveau = $droit['niveauAcces'];
			break;
		}
	}
	return $niveau;
}



function getNombrePage ($nbObjet,$nbObjetAffiche) {
	$nbPage = $nbObjet % ($nbObjetAffiche);
	if ($nbPage != 0) {
		$nbPage = (int)($nbObjet / ($nbObjetAffiche)) + 1;
	}
	else {
		$nbPage = $nbObjet / ($nbObjetAffiche);
	}
	return $nbPage;
}

/* Fonction que va nous permettre de mettre en forme les valeurs
 * affichées en fonction de leur type
 */
function afficheChampTableau ($objet,$tabEntete,$cle) {
	// On définit ici nos variables à utiliser dans la fonction
	$classe = '';
	// On ne va traiter l'objet que si le champ est à afficher
	if ($tabEntete['afficheOn']){
		// Si nous sommes dans le cas d'une date, on la remet en forme pour l'affichage
		if ($tabEntete['typeChamp'] === 'date') {
			$objet->setValeur($cle,baseToFormDate($objet->getValeur($cle)));
		}
		// On va ensuite vérifier si une particularité au niveau du champ est demandée
		switch ($tabEntete['particulariteChamp']) {
			case 'url':
				if ($objet->getValeur($cle) !== '') {
					$champAffiche = "<a href='" .$objet->getValeur($cle) . "' alt='" .$objet->getValeur($cle) . "' target='_blank'><span class='fa fa-globe'></span></a>";
				}
				else {
					$champAffiche = '';
				}
				break;
			case 'mail':
				if ($objet->getValeur($cle) !== '') {
					$champAffiche = "<a href='mailto:" .$objet->getValeur($cle) . "'><span class='fa fa-envelope'></span></a>";
				}
				else {
					$champAffiche = '';
				}
				break;
			case 'monetaire':
				switch ($objet->getValeur($objet->getValeur('typeMontantChampNom'))){
					case 'D':
						$classe = 'debit';
						$montant = '- ' . number_format($objet->getValeur($cle), 2, '.', '');
						break;
					case 'C':
						$classe = 'credit';
						$montant = '+ ' . number_format($objet->getValeur($cle), 2, '.', '');
						break;
					default:
						$classe = '';
						$montant = number_format($objet->getValeur($cle), 2, '.', '');
						break;
				};
				break;
			default:
				$classe = '';
				$champAffiche = $objet->getValeur($cle);
				break;
		}
		if ($tabEntete['particulariteClasse']) {
			foreach ($tabEntete['particulariteClasse'] as $particulariteClasse) {
				if ($classe === ''){
					$classe = $particulariteClasse;
				}
					
				else {
					$classe = $classe .' ' . $particulariteClasse;
				}
				
			}
		}
		
		?>
			<td <?php echo ($classe !== '' ? "class='" . $classe . "'" : "")?>><?php echo $champAffiche; ?></td>
		<?php
	}
}

function setTableLigneDefinition($libelleAffiche,$afficheOn,$typeChamp,$align = null, $particularite = null) {
	return array (
			'libelleAffiche' => $libelleAffiche,
			'afficheOn' => $afficheOn,
			'typeChamp' => $typeChamp,
			'particulariteChamp' => $align,
			'particulariteClasse' => $particularite
	);
}