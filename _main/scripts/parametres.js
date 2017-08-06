//Fonction pour afficher les personnes sous forme de SELECT
function affichePersonne(champNom = null ,idSelected = null,nomZone = null, libelleChamp = null) {
	$('#' + nomZone).html('<img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif">');
	$('#' + nomZone).load('_plugins/myContacts/models/formulaire.php',
		{	fonction: 'getSelect',
			classe: 'Personne',
			champValeur : champNom,
			idSelected : idSelected,
			label : libelleChamp
		});
}


//Fonctions pour masquer le formulaire de saisie utilisateur
function masqueFormulaire() {
	$('#userFormulaire').hide();
	// On surveille les clics sur les options du tableau
	lienAction();
	
	// On surveille les clics sur la mise à jour de le base

	
	// On surveille l'action sur le bouton nouvel utilisateur
    $('#btnAjoutUserForm').click(function() {
    	effaceFormulaire('userFormulaire');
    	$('#param').load('_main/viewModels/parametres.php',
    			{	affiche: 'user',
    				userAction: 'modif',
    				id : ''
    			},afficheFormulaire);	
    });
}

//Fonctions pour afficher le formulaire de saisie utilisateur
function afficheFormulaire() {
	$('#userFormulaire').show();
	// On va charger le select pour le lien avec la classe Personne
	affichePersonne('idPersonne' ,null,'personne','Lien Personne')
	// On surveille les clics sur les options du tableau
	lienAction();

	// On surveille l'action sur le bouton nouvel utilisateur
    $('#btnAjoutUserForm').click(function() {
    	effaceFormulaire('userFormulaire');
    	$('#param').load('_main/viewModels/parametres.php',
    			{	affiche: 'user',
    				userAction: 'modif',
    				id : ''
    			},afficheFormulaire);	
    });
	// On surveille si une action de modification/ajout est en cours
    $('#userEnreg').click(function() {
    	// On va récupérer nos variables issues du formulaire
    	idUser = $('#idUser').attr("value");
    	utilisateur = $('#utilisateur').val();
    	acces = $('#acces option:selected').val();
    	pass = $.md5($('#pass').val());
    	idPersonne = $('#idPersonne option:selected').val();
    	// On va effectuer l'action sur l'utilisateur
    	messageChargement('param','Chargement des paramètres');
    	$('#param').load('_main/viewModels/parametres.php',
    			{	affiche: 'user',
    				userAction: 'enreg',
    				id : idUser,
    				utilisateur : utilisateur,
    				pass: pass,
    				acces : acces,
    				idPersonne : idPersonne
    			},masqueFormulaire);	
    });
}

// Fonction pour surveiller les options du tableau
function lienAction() {
	$("a.userAction").click(function(event){
        event.preventDefault();
        // On récupère l'id en cours
        var regExp = /idUser=([^)]+)/;
        var resultat = regExp.exec($(this).attr('href'));
       	idUser = resultat[1];
	
    	// On va effectuer l'action sur l'utilisateur
    	messageChargement('param','Chargement des paramètres');

    	if ($(this).attr('id') == 'modif'){
        	$('#param').load('_main/viewModels/parametres.php',
        			{	affiche: 'user',
        				userAction: $(this).attr("id"),
        				id : idUser
        			},afficheFormulaire);	
    	}
    	else {
        	$('#param').load('_main/viewModels/parametres.php',
        			{	affiche: 'user',
        				userAction: $(this).attr("id"),
        				id : idUser
        			},masqueFormulaire);	
    	}
	});
	
	$('#majBase').click(function(event) {
		event.preventDefault();
		alert('ok');
	});
}