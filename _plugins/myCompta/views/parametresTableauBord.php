<div class="content three_quarter">
	<h4><strong>OPTIONS GENERALES</strong></h4>
	<hr>
	<h6>Accès plugin</h6>
	<div class='one-line'>
		<div class='one_quarter'><label>Personne</label></div>
		<span id='personne'></span>
	</div>
	<hr>
	<h6>Informations Plugin</h6>
	<p><strong>Nom :</strong> MyCompta</p>
	<p><strong>Développeur :</strong> Cédric DESMARES</p>
	<p><strong>Version :</strong>  1.0</p>
	<p><strong>Description :</strong> Ce plugin a pour but de gérer vos comptes bancaires au quotidien et ainsi prévoir votre budget en fonction de vos crédits et échéances à venir</p>
	<p><strong>Dépendance :</strong> </p>
	<table>
		<tr>
			<th>Plugin</th>
			<th>Version</th>
		</tr>
		<tr>
			<td>MyContacts</td>
			<td>1.0</td>
		</tr>
	</table>
	
	<hr>
	<h6>Mises à jour</h6>
	Votre base est à jour
	<!-- <button>BASE DE DONNEES</button> -->
</div>

<script src="<?php echo $GLOBALS['root'] .'_plugins/myCompta/scripts/myCompta.js'; ?>"></script>
<script>
$(function() {
	
	// Fonction qui va affiche le tableau au chargement du programme
	$(document).ready(function() {
		selectMyCompta ('Compte','compte','6')
	});
})
</script>