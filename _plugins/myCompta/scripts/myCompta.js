
//Fonction spécifique pour afficher la catégorie sous forme de SELECT
function selectCategorie(plugin, classe, nameChamp = null, idSelected = null,nomZone = null, libelleChamp = null,typeOperation=null){
	$('#'+nomZone).html('<img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif">');
	$('#'+nomZone).load('_plugins/'+plugin+'/scripts/'+plugin+'.php',
			{	fonction: 'listeDeroulante',
				classe: classe,
				champValeur : nameChamp,
				idSelected : idSelected,
				label : libelleChamp,
				typeOperation : typeOperation,
			});
	if (this.value = 'C') {
		$('#credit').show();
		$('#debit').hide();
	}
	else {
		$('#credit').hide();
		$('#debit').show();
	}	
}

//Fonction gérant la zone de ventilation
function afficheZoneVentilation() {
	$('#zoneVentilation').append('<hr />');
}


function afficheModeOperation(typeOperation,nomZone,Selected,numCheque = null) {
	$('#'+nomZone).html('');
	if (typeOperation == 'C') {
		if (modeSelected == 'VI') {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='VI' CHECKED> Virement ");
		}
		else {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='VI'> Virement ");
		}
		if (modeSelected == 'DE') {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='DE' CHECKED> Dépot (Espèces/Chèques) ");
		}else {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='DE'> Dépot (Espèces/Chèques) ");
		}
	}
	else {
		if (modeSelected == 'CB') {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='CB' CHECKED> Carte Bancaire ");
		}
		else {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='CB'> Carte Bancaire ");
		}
		if (modeSelected == 'RE') {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='RE' CHECKED> Retrait ");
		}
		else {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='RE'> Retrait ");
		}
		if (modeSelected == 'PR') {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='PR' CHECKED> Prélèvement ");
		}
		else {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='PR'> Prélèvement ");	
		}
		if (modeSelected == 'VI') {		
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='VI' CHECKED> Virement ");
		}
		else {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='VI'> Virement ");
		}
		if (modeSelected == 'CH') {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='CH' CHECKED> Chèque ");
		}
		else {
			$('#'+nomZone).append("<input type='radio' name='" + nomZone + "' value='CH'> Chèque ");
		}

	}
}

function selectMyCompta (classe,args) {
	erreur = false;
	switch (classe) {
		case 'Compte':
			varChampRupture= typeof args.champRupture !== 'undefined' ? args.champRupture : 'nomBanque';
			varChampAffiche = typeof args.champAffiche !== 'undefined' ? args.label : 'libelleCompte';
			varAttrName= typeof args.attrName !== 'undefined' ? args.attrName : 'idCompte';
			varValueName= typeof args.valueName !== 'undefined' ? args.valueName : 'idCompte';
			break;
		case 'Banque':
			varChampRupture= typeof args.champRupture !== 'undefined' ? args.champRupture : null;
			varChampAffiche = typeof args.champAffiche !== 'undefined' ? args.label : 'nomBanque';
			varAttrName= typeof args.attrName !== 'undefined' ? args.attrName : 'idBanque';
			varValueName= typeof args.valueName !== 'undefined' ? args.valueName : 'idBanque';
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
				plugin: 'myCompta',
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
