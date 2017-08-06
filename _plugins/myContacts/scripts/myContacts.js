function getSelect (classe,args) {
	erreur = false;
	switch (classe) {
		case 'Personne':
			varChampRupture= typeof args.champRupture !== 'undefined' ? args.champRupture : null;
			varChampAffiche = typeof args.champAffiche !== 'undefined' ? args.label : ['nom','prenom'];
			varAttrName= typeof args.attrName !== 'undefined' ? args.attrName : 'idPersonne';
			varValueName= typeof args.valueName !== 'undefined' ? args.valueName : 'idPersonne';
			break;
		default:
			alert('Erreur dans la récupération du select - Classe introuvable');
			erreur = true;
			break;
	}

	if (erreur !== true) {
		$('#' + args.nomChamp).load('_frameworks/myFrameWork/scripts/ajax.php',{
				source : 'AJAX',
				fonction: 'getListeObjet',
				plugin: 'myContacts',
				classe: classe,
				miseEnForme: 'select',	
				label  : typeof args.label !== 'undefined' ? args.label : null,
				attrName : varAttrName,
				valueName : varValueName,
				valueSelected : args.idSelect,
				disabled: false,
				champAffiche: varChampAffiche,
				champRupture: varChampRupture,
				urlAjout: false
		});
	}
}


