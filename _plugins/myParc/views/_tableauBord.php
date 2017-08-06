<div id='tableauBord'>
	<div class="container-fluid">
		<!-- Affichage de la partie contenu -->
		<?php 
		// On va utiliser notre fonction php pour ajouter une tuile
		require_once $GLOBALS['root'] . '_frameworks/myFrameWork/fonctions/myERP.php';
		setTuile("Matériels","Gestion du matériel","index.php?module=myParc&rubrique=materiel","materiel_48x48.png");
		setTuile("Logiciels","Gestion des Logiciels","index.php?module=myParc&rubrique=logiciel","logiciel_48x48.png");
		setTuile("Mise à Jour","Mise à jour de la base","index.php?module=myParc&rubrique=update","update_48x48.png","pull-right");
		setTuile("Référentiel","Gestion du référentiel","index.php?module=myParc&rubrique=referentiel","liste_48x48.png","pull-right");
		?>
	</div>
</div>