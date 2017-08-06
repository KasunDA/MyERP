/* Cette fonction va nous permettre de créer un champ select à partir de la classe Ville depuis n'importe quelle page
 * Cette fonction JS doit s(utiliser dans le contexte
 * 	1 -> Déclaration du script avant la fonction
 * 		<script src="<?php echo $GLOBALS['root']; ?>_plugins/myContacts/scripts/villes.js"></script>
 * 	2 -> Appel à la fonction en spécifiant les différents paramètres
 * 		getVilleSelect(nomIDChamp,typeMEF,attributName,valName,value,champAffiche,label = null,champDisabled = false,url = false)
 * 
 * Exemple:
 * - Chargement de la liste depuis la saisie depuis une zone ayant un id=codePostal
 * 		getVilleSelect('ville','select','idVille','codePostal',$(this).val(),'libelleVille');
 * - Chargement de la valeur enregistré dans la base avec la 
 */

function getVilleSelect(nomIDChamp,typeMEF,attributName,valName,value,champAffiche,label = null,champDisabled = false,url = false) {
    $("#" + nomIDChamp).load('_frameworks/myFrameWork/scripts/ajax.php',{
		source : 'AJAX',
		fonction: 'getListeObjet',
		plugin: 'myContacts',
		classe: 'Ville',
		miseEnForme: typeMEF,
       	attrName : attributName,
       	valueName : valName,
       	valueSelected : value,
       	label  : label, 
       	disabled: champDisabled,
       	champAffiche: champAffiche,
       	urlAjout: url
    });
}

function reinitialiseVilleListeBase() {
	messageChargement('pageVille','Réinitialisation des villes');
	$('#pageVille').load('_plugins/myContacts/fonctions/importVilles.php');
}