<?php

// On va définir notre classe
class Osiris
{
	// Définition des variables correspondant à notre table dans la base
	protected $idAdresse;
	protected $numVoie;
	protected $indRepetition;
	protected $libelleVoie;
	protected $complementVoie;
	protected $onArchive;

	/* Information sur notre base mais ne devant pas figurer dans
	 * notre tableau de définitions
	 */
	protected $nomTable = "refAdresses";
	protected $nomID = "idAdresse";
	protected $champTriDefaut = "numVoie";
	protected $ordreTriDefaut = "ASC";

}
?>
