<div class='content three_quarter'>
	<h6><strong>PERSONNALISATION DU SITE</strong></h6>

	<div class='group'>
		<hr>
		<form method="post" action='index.php?module=parametres&rubrique=General'>
			<input type='hidden' name='formulaire'>
			<input type='hidden' name='id' value='<?php echo $monObjet->getValeur('id'); ?>'>
			<div class='group'>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Titre du site</label>
					</div> 
					<div class='three_quarter'>
						<input type=text name='titre' value='<?php echo (($monObjet->getValeur('titre')) ? $monObjet->getValeur('titre'): 'Your CORPORATION'); ?>'>
					</div>
				</div>
					
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Sous-Titre du site</label>
					</div>
					<div class='three_quarter'>
						<input type=text name='sousTitre' value='<?php echo (($monObjet->getValeur('sousTitre')) ? $monObjet->getValeur('sousTitre'): 'myerp'); ?>'>
					</div>
				</div>
			</div>
			<hr>
			<div class='group'>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Téléphone contact</label>
					</div>
					<div class='three_quarter'>
						<input type=text name='telContact' value='<?php echo (($monObjet->getValeur('telContact')) ? $monObjet->getValeur('telContact'): '(+33) 01.23.45.67.89'); ?>'>
					</div>
				</div>
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Email contact</label>
					</div>
					<div class='three_quarter'>
						<input type=text name='mailContact' value='<?php echo (($monObjet->getValeur('mailContact')) ? $monObjet->getValeur('mailContact'): 'john.doe@myCorporation.net'); ?>'>
					</div>
				</div>
			</div>
			<hr>
			<div class='group'>		
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Titre info 1</label>
					</div>
					<div class='three_quarter'>
						<input type=text name='info1' value='<?php echo (($monObjet->getValeur('info1')) ? $monObjet->getValeur('info1'): 'Info1'); ?>'>
					</div>
				</div>	
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Sous-Titre info 1</label>
					</div>
					<div class='three_quarter'>
						<input type=text name='stInfo1' value='<?php echo (($monObjet->getValeur('stInfo1')) ? $monObjet->getValeur('stInfo1'): 'sous-titre Info1'); ?>'>
					</div>
				</div>
				
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Titre info 2</label>
					</div>
					<div class='three_quarter'>
						<input type=text name='info2' value='<?php echo (($monObjet->getValeur('info2')) ? $monObjet->getValeur('info2'): 'Info2'); ?>'>
					</div>
				</div>
				
				<div class='one-line'>
					<div class='one_quarter first'>
						<label>Sous-Titre info 2</label>
					</div>
					<div class='three_quarter'>
						<input type=text name='stInfo2' value='<?php echo (($monObjet->getValeur('stInfo2')) ? $monObjet->getValeur('stInfo2'): 'sous-titre Info2'); ?>'>
					</div>
				</div>
			</div>
			<hr>
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Information footer</label>
				</div>
				<div class='three_quarter'>
					<input type=text name='footer' value='<?php echo (($monObjet->getValeur('footer')) ? $monObjet->getValeur('footer'): 'Copyright &copy; 2016 - All Rights Reserved - My Corporation'); ?>'>
				</div>
			</div>

			<div class='one-line'>
				<div class='two_quarter'>
					<button type=submit name='enreg' value='Valider' class='btn btn-success pull-right'>Valider</button>
				</div>
			</div>
		</form>
	</div>
</div>
