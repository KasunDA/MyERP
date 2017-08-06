

<div class="group btmspace-15 optionsAffiche">
	<div id="affichage" class="three_quarter first one-line">
		<label><strong>Relevé: </strong></label>
		<label class="radio-inline"> mois en cours </label>
		<input type=radio name=afficheDate value='1' CHECKED>
		<label class="radio-inline"> mois dernier </label>
		<input type=radio name=afficheDate value='-1'>
		<label class="radio-inline"> personnalisé </label>
		<input type=radio name=afficheDate value='0'>

	</div>
	<div class=" one_quarter one-line">
		<a href=<?php echo $argsPage['urlAjout']; ?>>
		<button type="button" class="btn btn-success pull-right"><span class='glyphicon glyphicon-plus'></span> NOUVEAU</button>
		</a>
	</div>
	<div id='selectionDate' class='three_quarter one-line'>
		<input type=text placeholder="Début (jj-mm-aaaa)" id='dateDebut'>
		<input type=text placeholder="Fin (jj-mm-aaaa)" id='dateFin'>
		<input type=submit value='Afficher' id='affiche'>
	</div>
</div>

