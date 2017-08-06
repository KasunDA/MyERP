<?php

//	if (VerifAccess($_SESSION['id'])) {
?>    	
   	<!-- Affichage du menu aside -->
  	<?php include '_default/Views/annuaireMenu.php'; ?>
    
    <!-- Affichage de la partie contenu -->
    <section class="col-sm-9">
	   	<article>
	   		<?php 
    		// On va afficher le contenu en fonction du menu aside
			if (isset($_GET['option'])){
				switch (htmlSpecialChars($_GET['option'])) {
					case 'personnes': 
						include ('_default/ViewModels/personnes.php');
						break;
					case 'societes':
						include ('_default/ViewModels/societes.php');
						break;
					case 'sites':
						include ('_default/ViewModels/sites.php');
						break;
					case 'collaborateurs':
						include ('_default/ViewModels/collaborateurs.php');
						break;
					default: 
						include ('_templates/' . $_SESSION['template'] . '/Views/hacking.php');					
						break;
					}
				}
			else {
				include ('_default/Views/annuaireHome.php');
			}
			?>
	    	</article>
    	</section>

<?php 				    
/*	}
	else {
		// Pas de validation de session donc renvoi vers la page prévue à cet effet
		include ('_templates/BrientSAS/php/unAuthorize.php');
	}*/
	