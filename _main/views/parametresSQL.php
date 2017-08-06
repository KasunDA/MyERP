<div class='content three_quarter'>
	<h6><strong>PARAMETRES DU SITE</strong></h6>

	<div class='group'>
		<h6>Paramètres SQL</h6>
		<hr>
		<form method="post" action=''>
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>TYPE DE SERVEUR</label>
				</div>
				<div class='three_quarter'>
					<select name=typeBase DISABLED>
						<option value='mysql' <?php echo ($maConfig['typeBase'] === 'mysql' ? 'SELECTED' : ''); ?>>MySQL
						<option value='oracle' <?php echo ($maConfig['typeBase'] === 'oracle' ? 'SELECTED' : ''); ?>>Oracle
						<option value='mssql' <?php echo ($maConfig['typeBase'] === 'mssql' ? 'SELECTED' : ''); ?>>MS-SQL
						<option value='nosql' <?php echo ($maConfig['typeBase'] === 'nosql' ? 'SELECTED' : ''); ?>>NoSQL
						<option value='sybase' <?php echo ($maConfig['typeBase'] === 'sybase' ? 'SELECTED' : ''); ?>>Sybase
					</select>
				</div>
			</div>
				
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Adresse du serveur</label>
				</div>
				<div class='three_quarter'>
					<input type='text' name='adress' value=<?php echo ($maConfig['address'] ? $maConfig['address']: ''); ?> DISABLED>
				</div>
			</div>
				
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Port</label>
				</div>
				<div class='three_quarter'>
					<input type='text' name='port' id='port' value=<?php echo ($maConfig['port'] ? $maConfig['port']: ''); ?> DISABLED>
				</div>
			</div>				

			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Nom de la base</label>
				</div>
				<div class='three_quarter'>
					<input type='text' name='baseName' id='baseName' value=<?php echo ($maConfig['baseName'] ? $maConfig['baseName']: ''); ?> DISABLED>
				</div>
			</div>
				
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Utilisateur</label>
				</div>
				<div class='three_quarter'>
					<input type='text' name='username' id='username' value=<?php echo ($maConfig['username'] ? $maConfig['username']: ''); ?> DISABLED>
				</div>
			</div>				
				
			<div class='one-line'>
				<div class='one_quarter first'>
					<label>Mot de Passe</label>
				</div>
				<div class='three_quarter'>
					<input type='password' name='password' id='password' value=<?php echo ($maConfig['password'] ? $maConfig['password']: ''); ?> DISABLED>
				</div>
			</div>				

			<div class='one-line'>
				<div class='two_quarter'>
					<button type=submit name='generalEnreg' value='Valider' class='btn btn-success pull-right' DISABLED>Valider</button>
				</div>
			</div>
		</form>
	</div>
	<hr>
	<div class='group'>
		<div class='one-line'>
			<div class='two_quarter first'>
			<button id=majBase class='btn btn-danger'>Mise à jour de la base</button>
			</div>
		</div>
	</div>
</div>
