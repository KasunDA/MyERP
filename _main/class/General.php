<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/_frameworks/myFrameWork/class/MyERP.php';

// On va définir notre classe
class General extends MyERP
{
	// Définition des variables correspondant à notre table dans la base
	protected $id;
	protected $titre;
	protected $sousTitre;
	protected $info1;
	protected $stInfo1;
	protected $info2;
	protected $stInfo2;
	protected $telContact;
	protected $mailContact;
	protected $footer;
	
	public function getClasseDefinition() {
		$this->nomTable = "_general";
		$this->nomID = "id";
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
				'id' =>  $this->baseDefinition('int',true,true,true,true),
				'titre' => $this->baseDefinition('varchar(30)',false,false,false,false),
				'sousTitre' =>  $this->baseDefinition('varchar(30)',false,false,false,false),
				'info1' =>  $this->baseDefinition('varchar(30)',false,false,false,false),
				'stInfo1' =>  $this->baseDefinition('varchar(30)',false,false,false,false),
				'info2' =>  $this->baseDefinition('varchar(30)',false,false,false,false),
				'stInfo2' =>  $this->baseDefinition('varchar(30)',false,false,false,false),
				'telContact' =>  $this->baseDefinition('varchar(30)',false,false,false,false,'telSupport'),
				'mailContact' =>  $this->baseDefinition('varchar(100)',false,false,false,false,'mailSupport'),
				'footer' =>  $this->baseDefinition('varchar(255)',false,false,false,false),
		);
		return  $baseDefinition;
	}

}

