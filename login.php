<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>MyERP</title>
        
        <!-- Utilise CSS -->
        <link href="_frameworks/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="_templates/default/css/style.css" rel="stylesheet">
		<link href="_templates/default/css/framework.css" rel="stylesheet">

		<script src="_frameworks/jquery.js"></script>
		<script src="_frameworks/myFrameWork/scripts/_myERP.js"></script>
    </head>
	<body class='fondEcran'>
		<div class='col-sm-12'>
		
			<div class='login col-xs-offset-2 col-xs-8 col-md-offset-4 col-md-4 '>
				<div class='btmspace-30'>
					<h1>Bienvenue sur MyERP</h1>
					<!--  <img src="_templates/default/images/logo.png"> -->
				</div>
				<form class='formulaire' method=post action='index.php'>
					<div class='group btmspace-15'>
						<div class='one-line'>
							<div class='two_quarter first btmspace-15'>
								<label for='user'><span class='glyphicon glyphicon-user' ></span> Utiliseur</label>
							</div>
							<div class='two_quarter'>
								<input class='form-control controlForm-username' type=text id='user' name='user' required />
							</div>
						</div>							
						<div class='one-line'>
							<div class='two_quarter first '>
								<label for='form-control pass'><span class='glyphicon glyphicon-lock' ></span> Mot de passe</label>
							</div>
							<div class='two_quarter'>
								<input class='form-control controlForm-pass' type=password id='pass' name='password' required />
							</div>
						</div>
					</div>
					<div class='group'>				
						<input class='btn btn-primary pull-right' type=submit name='login' value='Connexion' />
					</div>
				</form>
			</div>
		</div>
		<?php 
			if (isset($_GET['error'])) {
				switch ((int)(htmlspecialchars($_GET['error']))) {
					case '1': 
						$msgErreur = 'Utilisateur/Mot de passe erroné';
						break;
					case '2':
						$msgErreur = "Votre compte est désactivé";
						
						break;
					case '3':
						$msgErreur = "Vous n'êtes pas autorisé à accéder au site";
						break;
					default :
						$msgErreur = "Connexion impossible";
						break;
				}
				?>
				<script src="_frameworks/jquery.js"></script>
				<script>
					$(function() {
						// Au chargement de la page, on affiche les paramètres de profil
						$(document).ready(function() {
							alert("<?php echo $msgErreur; ?>");
						});	
					});
				</script>
				<?php 
			}
		?>
	<script>
		$(function() {
			$(document).ready(function() {
				// On active le controle des formulaires
				controleFormulaire();
			});
		});
	</script>
	</body>
</html>
