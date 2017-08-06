<fieldset class=''>
	<div id="compte"></div>
</fieldset>	
			
<fieldset>
	<div id="compteEmetteur"></div>
	<div id="compteDestinataire"></div>
</fieldset>
			
<fieldset>
	<label for='description'>Description </label>
	<input type='text' name='description' id='description' <?php echo ($maClasse->getValeur('description')) ? 'value="' . $maClasse->getValeur('description') . '"' :"Transfert de fonds";?> class="form-control">
	<label for='montant'>Montant </label>
	<input type='text' name='montant' id='montant' <?php echo ($maClasse->getValeur('montant')) ? 'value=' . $maClasse->getValeur('montant') :"";?> class="form-control">
</fieldset>