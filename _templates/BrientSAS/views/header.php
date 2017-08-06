<!DOCTYPE html>
<html>	
    <head>
        <meta charset="utf-8" />
        <title>MyERP</title>
        <!-- Utilise CSS -->
        <!-- Utilise CSS -->
        <link href="<?php echo $GLOBALS['root']; ?>_frameworks/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo $GLOBALS['root']; ?>_templates/<?php echo  $_SESSION['template']; ?>/css/style.css" rel="stylesheet">

		<script src="<?php echo $GLOBALS['root']; ?>_frameworks/jquery.js"></script>		
		<script src="<?php echo $GLOBALS['root']; ?>_frameworks/myFrameWork/fonctions/myERP.js"></script>
    </head>

    <body>
		<!--  	MENU PRINCIPAL -->
		<div class="page col-xs-12"> <!-- /!\ LA FERMETURE DE CE <div> SE TROUVE DANS LE FOOTER-->	
	    	<header class="row">   	
		    	<img alt="Logo Brient" src="_templates/<?php echo  $_SESSION['template']; ?>/images/LogoBandeauHeader.png" />
				<div class="col-xs-12" id="menuPrincipal">
					<div class='navbar navbar-default'>
						<div class='container'>
							<div class='navbar-header'>
								<span class='navbar-brand'>MyERP</span>
							</div>
						    <ul class="nav navbar-nav">
						      <li><a href="<?php echo $GLOBALS['root']; ?>index.php"><span class="glyphicon glyphicon-home"></span></a></li>
						      <li><a href="<?php echo $GLOBALS['root']; ?>index.php?module=myContacts">MES CONTACTS</a></li>
						      <li><a href="<?php echo $GLOBALS['root']; ?>index.php?module=myParc">MON PARC</a></li>			      
						      <li><a href="<?php echo $GLOBALS['root']; ?>index.php?module=myCompta">MES COMPTES</a></li>
						      <li><a href="<?php echo $GLOBALS['root']; ?>index.php?module=myAbonnements">MES CONTRATS</a></li>
						      <li><a href="<?php echo $GLOBALS['root']; ?>index.php?module=parametres"><span class="glyphicon glyphicon-cog"></span></a></li>
						      <li><a href="<?php echo $GLOBALS['root']; ?>index.php?module=logout"><span class="glyphicon glyphicon-log-out"></span></a></li>
						    </ul>
					    </div>
				    </div>
			    </div>
			    
	    	</header>
	    	<!--  *************************************** -->
	    </div>