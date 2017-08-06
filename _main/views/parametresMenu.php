<div class="sidebar one_quarter first">
	<!-- Affichage du menu aside -->
	<aside>
		<div id="menuAside">
			<h4>PARAMETRES</h4>
			<ul>
				<li><a href="index.php?module=parametres&rubrique=Profil">MON PROFIL</a>
				<?php
				if ($_SESSION['niveauAccesGeneral']=== '9') {
				?>
					<hr>
					<li><a href="index.php?module=parametres&rubrique=General">GENERAL</a>
					<li><a href="index.php?module=parametres&rubrique=User">UTILISATEURS</a>
					<li><a href="index.php?module=parametres&rubrique=SQL">BASE DE DONNEES</a>
				<?php 
					}
				?>
			</ul>

		</div>
	</aside>
</div>