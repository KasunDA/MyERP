<div class="content">
	<!-- Affichage de la partie contenu -->
	<form method=post action='index.php?module=myCompta&rubrique=Pret'>
		<div>
			<?php echo ($monObjet->getValeur('idPret')) ? '<input type=hidden name="idPret" value=' . $monObjet->getValeur('idPret') . '>':"";?>
		</div>

		<div class='one-line pull-right'>
			<label>Archivé </label>
			<input type='checkbox' name='onArchive'	<?php echo ($monObjet->getValeur('onArchive')) ? 'CHECKED' :"";?>>
		</div>

		<div class='one-line'>
			<label>Type d'emprumt</label>
			<select name='typeEmprunt' class="form-control">
				<option value="immo" <?php echo ($monObjet->getValeur('typeEmprunt') === 'immo') ? "SELECTED" :"";?>>Immobilier</option>
				<option value="conso" <?php echo ($monObjet->getValeur('typeEmprunt') === 'conso') ? "SELECTED" :"";?>>Consommation</option>
			</select>
		</div>					

		<div id="compte" class='one-line'></div>

		<div class='one-line'>
			<label>Libellé Prêt</label>
			<input type=text name=libelle class="form-control" value="<?php echo ($monObjet->getValeur('libelle')) ? $monObjet->getValeur('libelle') :"";?>">
		</div>
		
		<div class='one-line'>
			<label>Somme empruntée</label>
			<input type=text name=montantEmprunt class="form-control" value="<?php echo ($monObjet->getValeur('montantEmprunt')) ? $monObjet->getValeur('montantEmprunt') :"";?>">		
		</div>

		<div class='one-line'>
			<label>Montant assurance</label>
			<input type=text name=montantAssurance class="form-control" value="<?php echo ($monObjet->getValeur('montantAssurance')) ? $monObjet->getValeur('montantAssurance') :"";?>">
		</div>

		<div class='one-line'>
			<label>Taux de base</label>
			<input type=text name=tauxBase class="form-control" value="<?php echo ($monObjet->getValeur('tauxBase')) ? $monObjet->getValeur('tauxBase') :"";?>">
			<label>TEAG</label>
			<input type=text name=TEAG class="form-control" value="<?php echo ($monObjet->getValeur('TEAG')) ? $monObjet->getValeur('TEAG') :"";?>">
		</div>
		
		<div class='one-line'>					
			<label>Date Signature</label>
			<input type=date name=dateSignature class="form-control" value="<?php echo ($monObjet->getValeur('dateSignature')) ? $monObjet->getValeur('dateSignature') :"";?>">					
			<label>Date 1ere Echéance</label>
			<input type=date name=date1erEcheance class="form-control" value="<?php echo ($monObjet->getValeur('date1erEcheance')) ? $monObjet->getValeur('date1erEcheance') :"";?>">
		</div>
		
		<div class='one-line'>	
			<label>Durée (en mois)</label>
			<input type=text name=dureePret class="form-control" value="<?php echo ($monObjet->getValeur('dureePret')) ? $monObjet->getValeur('dureePret') :"";?>">
		</div>
		
		<div class='one-line'>
			<input type='submit' name='enreg' value=<?php echo ($monObjet->getValeur('idPret')) ? 'Modifier':'Ajouter';?> class="btn">
		</div>
	</form>
</div>

<script src="_plugins/myCompta/scripts/myCompta.js"></script>
<script>

/* On va créer une fonction qui va permettre d'ajouter une palier
 * supplémentaire
 *   Attention: Ne pas confondre palier et renégociation qui nécessite un changement de taux donc
 *     un changement complet du tableau d'amortissement !!!  
 */
function nouveauPalier(){
	$('#btnPalier').click(function(event) {
		// On annule toute action suite au click
		event.preventDefault(); 

		// On va incrémenter notre valeur cachée pour connaitre le nombre de palier
		nbPalier = $('#nbPalier').val();
		nbPalier++;
		$('#nbPalier').val(nbPalier);

		// On ajoute une ligne de détail
		$('#zoneLissage').append('<input type=text name=palierMontant' + nbPalier + ' placeholder="Montant de l\'échéance">');
		$('#zoneLissage').append('<input type=text name=palierDuree' + nbPalier + '  placeholder="Durée en mois"><br>');
	
		// Comme expliqué par un banquier, au dela de 4 palier, cela devient une usine à gaz donc... on ne le gère pas
		if (nbPalier == '4') {
			$('#btnPalier').attr('disabled',true);
		}
	});
}

// Cette fonction va afficher la partie lissage
function codeLissageHTML() {
	$('#zoneLissage').html('<img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif">');
	$('#zoneLissage').load('_plugins/myCompta/scripts/myCompta.php',
		{	fonction: 'lissage'
		},nouveauPalier);
};

$(function() {
	
	// Fonction qui va affiche le tableau au chargement du programme
	$(document).ready(function() {
		//On charge la zone compte
		idSelected = <?php echo ($monObjet->getValeur('idCompte')) ? "'" . $monObjet->getValeur('idCompte') . "'" : 'null'; ?>;
		$('#compte').load('_frameworks/myFrameWork/scripts/ajax.php',{
			source : 'AJAX',
			fonction: 'getListeObjet',
			plugin: 'myCompta',
			classe: 'Compte',
			miseEnForme: 'select',	
			label  : 'Compte',
			attrName : 'idCompte',
			valueName : 'idCompte',
			valueSelected : idSelected,
			disabled: false,
			champAffiche: 'libelleCompte',
			urlAjout: false
        });

		if (<?php //echo $monObjet->getValeur('nbPalier'); ?>'2' >= '2'){
			codeLissageHTML();
		}
	});

	$('#lissage').change(function() {
		codeLissageHTML();
	});
})
</script>