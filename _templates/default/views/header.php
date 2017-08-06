<!DOCTYPE html>
	<!--
	Template Name: Dodmond
	Author: <a href="http://www.os-templates.com/">OS Templates</a>
	Author URI: http://www.os-templates.com/
	Licence: Free to use under our free template licence terms
	Licence URI: http://www.os-templates.com/template-terms
	-->
	<html lang="FR">
	<head>
		<title>MyERP</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link href="<?php echo '/_templates/' .  $_SESSION['template']; ?>/css/layout.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo '/_templates/' .  $_SESSION['template']; ?>/css/style.css" rel="stylesheet" type="text/css" media="all">

		<!-- JAVASCRIPTS -->
		<script src="<?php echo '/_templates/' .  $_SESSION['template']; ?>/js/jquery.min.js"></script>
		<script src="/_frameworks/myFrameWork/scripts/_myERP.js"></script>

	</head>

	<body id="top">
		<div class="wrapper row0">
		  <div id="topbar" class="hoc clear"> 
		    <div class="fl_left">
		      <ul>
		      	<?php if (isset($_SESSION) AND isset($_SESSION['id']) AND $_SESSION['id'] > 0) { ?>
		        	<li>
		        		<?php if ($mesVariablesAffichage->getValeur('telContact')) { ?>
		        			<i class="fa fa-phone"></i> 
		        		<?php }; 
		        			echo $mesVariablesAffichage->getValeur('telContact'); ?>
		        	</li>
		        	<li>
		        		<?php if ($mesVariablesAffichage->getValeur('mailContact')) { ?>
									<i class="fa fa-envelope-o"></i>
									<a href="mailto:<?php echo $mesVariablesAffichage->getValeur('mailContact'); ?>"> 
								 	<?php	echo $mesVariablesAffichage->getValeur('mailContact'); ?></a>
								<?php }; ?>
		        	</li>
		        <?php } ?>
		      </ul>
		    </div>
		    <div class="fl_right">
		      <ul>
		        <li><a href="index.php"><i class="fa fa-lg fa-home"></i></a></li>
		        <li><a href="index.php?module=logout">Déconnexion</a></li>
		      </ul>
		    </div>
		  </div>
		</div>
		
		<div class="wrapper row1">
		  <header id="header" class="hoc clear"> 
			    <div id="logo" class="fl_left">
			      <h1><a href="index.html"><?php echo $mesVariablesAffichage->getValeur('titre'); ?></a></h1>
			      <p><?php echo $mesVariablesAffichage->getValeur('sousTitre'); ?></p>
			    </div>
			    <div id="quickinfo" class="fl_right">
			      <ul class="nospace inline">
			        <li><strong><?php echo $mesVariablesAffichage->getValeur('info1'); ?></strong><br>
			          <?php echo $mesVariablesAffichage->getValeur('stInfo1'); ?></li>
			        <li><strong><?php echo $mesVariablesAffichage->getValeur('info2'); ?></strong><br>
			          <?php echo $mesVariablesAffichage->getValeur('stInfo2'); ?></li>
			      </ul>
			    </div>
		  </header>

		  <nav id="mainav" class="hoc clear"> 
		    <ul class="clear">
		      <li class="active"><a href="index.php"><i class="fa fa-lg fa-home"></i></a></li>
				<?php 
				/* On va définir ici notre menu principal à partir des plugins de manière dynamique */
				$tableauMenu = getListeMenu();
				if ($tableauMenu) {
					foreach ($tableauMenu as $menu) {
						?>
						<li><a href="<?php echo $menu['url']; ?>" <?php if ($menu['sousMenu']) { echo "class='drop'"; } ?>><?php echo $menu['libelle']; ?></a>
						<?php  
							if($menu['sousMenu']) { ?>
								<ul>
									<?php foreach ($menu['sousMenu'] as $sousMenu) { ?>
										<li><a href="<?php echo $sousMenu['url']; ?>"><?php echo $sousMenu['libelle']; ?></a></li>
									<?php } ?>
								</ul>
							<?php }
						}
						?></li><?php 
					}
				?>
		      <li><a href="index.php?module=parametres"><span class='fa fa-cogs'></span></a></li>
		    </ul>
		  </nav>
		</div>
		
		<div class="wrapper bgded overlay" style="background-image:url('<?php echo '/_templates/' .  $_SESSION['template']; ?>/images/demo/backgrounds/01.png');">
	 		<section id="breadcrumb" class="hoc clear">
	 			<?php
	 			/* On ne va afficher le sous menu que si nous sommes dans une rubrique */
	 			$listePlugin = listeDossiers(array('dossier'=>'plugins'));
	 			foreach ($listePlugin as $plugin) {
	 				if (isset($_GET['module']) && $_GET['module'] === $plugin) {
	 					/*On va définir ici notre sous menu sous forme de tuile */
	 					if ($tableauMenu) {
	 						foreach ($tableauMenu as $menu) {
	 							// On vérifie que nous sommes bien dans le bon plugin et que l'on doit afficher les tuiles
	 							if ($menu['plugin'] === $_GET['module'] && ($menu['afficheTuile'])) {
		 							if($menu['sousMenu']) {
					 					foreach ($menu['sousMenu'] as $sousMenu) {?>
											<div class='tuile <?php echo (isset($sousMenu['pull-right']) && ($sousMenu['pull-right'])? 'pull-right' : ''); ?>'>
												<a class="tile" title="<?php echo $sousMenu['alt']; ?>" href="<?php echo $sousMenu['url']; ?>">
												<h1><?php echo $sousMenu['libelle']; ?></h1>
												<img src="_templates/<?php  echo $_SESSION['template'];?>/images/<?php echo $sousMenu['logo']; ?>" alt="<?php echo $sousMenu['alt']; ?>">
												</a>
											</div>		 					
						 				<?php }
					 				}
	 							}
				 			}
				 		}
	 				}
	 			} ?>
	 		</section>
		</div>
		
	<!-- On ouvre la mise en forme de notre page et sera fermé dans le footer -->	
		<div class="wrapper row3">
		  <main class="hoc container clear"> 