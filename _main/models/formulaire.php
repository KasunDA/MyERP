<?php

if (isset($_POST['fonction'])){
	$GLOBALS['root'] = '../../';
	
	// On vérifie l'initialisation de nos variables
	$type = (isset($_POST['typeOperation'])) ? $_POST['typeOperation'] : null;
	$idSelected = (isset($_POST['idSelected'])) ? $_POST['idSelected'] : null;
	$label = (isset($_POST['label'])) ? $_POST['label'] : null;
	$champValeur = (isset($_POST['champValeur'])) ? $_POST['champValeur'] : null;
	getSelect($_POST['classe'],array('typeOperation' => $type,'idSelected' => $idSelected, 'libelleChamp'  => $label, 'champValeur' => $champValeur));
}

/* Cette fonction aura pour effet de renvoyer un select listant les familles
 * de dépenses/recettes
* en paramètre, nous attendrons la classe ainsi qu'un tableau d'option 
* lié à la classe
*/
function getSelect($classe, $options = null) {
	switch ($classe) {
		case 'personne':
			// On va inclure notre classe
			require_once $GLOBALS['root'] . '_plugins/myContacts/class/Personne.php';
			require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';
			$monObjet = new Personne();
				
			// On va récupérer notre liste de catégorie
			// On vérifie si le type d'opération est défini
			if (isset($options)){
				$idSelected = $options['idSelected'];
				$label = $options['libelleChamp'];
				$champValeur = $options['champValeur'];
			}
			else {
				// On va récupérer tous les comptes
				$idSelected = null;
				$label = 'Personne';
				$champValeur = 'idPersonne';
			}
				
			$listePersonnes = $monObjet->getListeObjet();
				
			$argsSelect =  array(
					'libelleLabel' => $label,
					'donnees' => $listePersonnes,
					'champValeur' => $champValeur,
					'champIDBase' => 'idPersonne',
					'champAffiche' => 'nom',
					'urlAjout' => '',
					'idSelected' => $idSelected,
					'champRupture' => null,
					'disabled' => false
			);
			selectCreate($argsSelect);
			break;
			break;
		default:
			echo "Erreur dans le chargement du SELECT";
			break;
	}
}