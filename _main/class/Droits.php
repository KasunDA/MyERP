<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class Droits extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $idDroit;
	protected $idUser;
	protected $plugin;
	protected $typeAcces;
	
	public function getClasseDefinition() {
		$this->nomTable = "_usersDroits";
		$this->nomID = "idDroit";
		$this->suiviModification = false;
	}
	
	public function getBaseDefinition() {
		/* Le tableau d'en-tete sera construit de la même façon pour toutes les classes
		 * $nomChamp => nom du champ dans la table,
		 * $typeChamp => le type de champ dans la table,
		 * $lienBase => booleen pour savoir si le champ est dans la table,
		 * $afficheTableau => booleen pour savoir si on affiche dans le tableau,
		 * $nomAffiche => nom du label dans un tableau
		 */
		$baseDefinition = array(
				'idDroit' =>  $this->baseDefinition('int',true,true,true,true),
				'idUser' => $this->baseDefinition('int',false,false,false,false),
				'plugin' =>  $this->baseDefinition('varchar(20)',false,false,false,false),
				'typeAcces' =>  $this->baseDefinition('int',false,false,false,false)
		);
		return  $baseDefinition;
	}
}

