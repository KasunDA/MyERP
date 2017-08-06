<?php 

function createTableauNominatif ($cheminFichier) {
	$monfichier = fopen($cheminFichier, 'r+');
	$tab = array();
	if ($monfichier){
		$contenu_fichier = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/_plugins/myContacts/referentiels/villes.csv');
		$nombre_ligne_fichier = substr_count( $contenu_fichier, "\n" );
		
		$i = 1;
		
		while (($buffer = fgets($monfichier,4096)) !== false) {
			if ($i === 1) {
				$entete = explode(";", $buffer);
			}
			if ($i > 1) {
				$ligneTableau = array();
				$ligne = explode(';', $buffer);
				for ($index = 0 ; $index < count($entete); $index++) {
					$ligneTableau[rtrim($entete[$index])] = rtrim($ligne[$index]);
				}
				$tab[] = $ligneTableau;
			}
			$i++;
		}
	}

	fclose($monfichier);
	return $tab;
}