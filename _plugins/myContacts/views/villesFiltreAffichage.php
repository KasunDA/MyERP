<div class="group btmspace-15 optionsAffiche">
	<div id="affichage">
		<div class='two_quarter first'>
			<h6>Affichage :</h6>
				<div class='two_quarter fisrt'>
					<label class="form-control">Eléments/page</label>
				</div>
				<div class='one_quarter'>
					<select id='nbElementsPage' class="form-control">
						<option value='10'>10</option>
						<option value='50'>50</option>
						<option value='100'>100</option>
						<option value='200'>200</option>
					</select>
				</div>
		</div>
		<div class='two_quarter'>
			<?php if (isset($argsPage['champRecherche'])) { ?>
			<h6>Recherche : </h6>

				<div class='group one-line'>
					<div class='two_quarter first btmspace-15'>
						<select id='nomCle' class="form-control">
							<?php foreach ($argsPage['champRecherche'] as $cle  => $champ) { 
								if ($champ['afficheOn']) {?>
									<option value=<?php echo $cle; ?>><?php echo $champ['libelleAffiche']; ?></option>
								<?php }	
							} ?>
						</select>
					</div>
					<div class='two_quarter'>
						<input  id='valeurCle' class='controlForm-recherche form-control' type=text placeHolder='Mots-clé...'>
					</div>
				</div>
				<div class='one-line'>
					<button id="champRecherche" type="button" class="btn bn-warning pull-right">Rechercher <span class='fa fa-search'></span></button>
				</div>
			<?php } ?>
		</div>
	</div>	
</div>

