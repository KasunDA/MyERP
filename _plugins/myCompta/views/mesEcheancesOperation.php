<div class="content three_quarter">
<fieldset class=''>
	<div id="compte"></div>
</fieldset>	

<fieldset>
	<label for='type'>Type d'opération </label>
		<input type='radio' name='operationType' value='D' CHECKED> Débit
		<input type='radio' name='operationType' value='C' <?php echo ($maClasse->getValeur('operationType') === 'C') ? 'CHECKED' :'';?>> Crédit
		<div id='operationMode' class='pull-right'></div>
		
	<div id="categorie"></div>
</fieldset>

<fieldset>
	<label for='typeTiers'>Tiers </label>
	<span class='pull-right'>Carnet d'adresses <input type='checkbox' name='typeTiers' value='D' <?php echo ($maClasse->getValeur('operationSourceBeneficiaire') === 'CA') ? 'CHECKED' :'';?> disabled></span>
	<div id="tiers">
		<input type=text placeholder='Nom du bénéficiaire' name='operationBeneficiaire' <?php echo ($maClasse->getValeur('operationBeneficiaire')) ? 'value="' . $maClasse->getValeur('operationBeneficiaire') . '"' :"";?> class="form-control" >
	</div>
	<label for='description'>Description </label>
	<input type='text' name='description' id='description' <?php echo ($maClasse->getValeur('description')) ? 'value="' . $maClasse->getValeur('description') . '"' :"";?> class="form-control">
</fieldset>

<fieldset>
	<div class='pull-right'>
		<label> Ventilé </label>
		<input type='checkbox' name='estVentile' id='ventilation' <?php echo ($maClasse->getValeur('operationEstVentile')) ? 'CHECKED' :"";?> disabled>
	</div>
	<div class='pull-right'>
		<label>Montant fixe </label>
		<input type='checkbox' name='montantFixe' id='ventilation' <?php echo ($maClasse->getValeur('montantFixe')) ? 'CHECKED' :"";?> disabled>
	</div>
	<label for='montant'>Montant </label>
	<input type='text' name='montant' id='montant' <?php echo ($maClasse->getValeur('montant')) ? 'value="' . $maClasse->getValeur('montant') .'"' :"";?> class="form-control">
</fieldset>

<fieldset id="zoneVentilation">
	<strong>Ventilation</strong> <button class='btn btn-warning'>+</button>
	<span class='pull-right'>Montant à ventiler <input type="text" disabled></span>
	<table style="width: 100%;">
		<tr>
			<th style="width: 80%;">Categorie</th>
			<th style="width: 20%;">Montant</th>
		</tr>
		<tr>
			<td><input style="width: 100%;" type="text"></td>
			<td><input style="width: 100%;" type="text"></td>
		</tr>
	</table>
</fieldset>
	