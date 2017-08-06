<div class='corps col-sm-9'>
	<div class="container-fluid">
		<h1>Gestion des Prêts</h1>
		<!-- Affichage de la partie contenu -->
		<section>
			<article>
				<a href=index.php?module=myCompta&rubrique=Pret&action=ajout>
					<button type="button" class="btn btn-success"><span class='glyphicon glyphicon-plus'></span> AJOUTER UN CREDIT</button>
				</a>
			</article>
			<article class='tab-responsive'>
				<?php
				creationTableau($argsTableau);
				?>
			</article>
		</section>
	</div>
</div>