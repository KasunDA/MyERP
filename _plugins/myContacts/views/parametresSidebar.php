<?php if ($_SESSION[$nomPlugin] >= 5) { ?>
	<div class="sidebar one_quarter first">
		<!-- Affichage du menu aside -->
		<aside>
			<div id="menuAside">
				<h6>Paramètres</h6>
				<ul>
					<li><a href="index.php?module=myContacts&rubrique=Parametres&referentiel=Ville">VILLES</a>
					<li><a href="index.php?module=myContacts&rubrique=Parametres&referentiel=Adresse">ADRESSES</a>
				</ul>
				<hr>
				<div class='center'>
					<a href="index.php?module=myContacts&rubrique=Parametres&referentiel=Update"><button class='btn btn-succes'>MISE A JOUR</button></a>
				</div>	
			</div>
		</aside>
	</div>
<?php } ?>