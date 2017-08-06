<div class='content three_quarter'>
	<h6><strong>GESTION DES UTILISATEURS</strong></h6>
	<?php
		// affichage du bandeau d'option
		// include ($_GLOBALS['root'] . '_frameworks/myFrameWork/views/optionsAffichage.php');
	?>
	<div class='group'>
		<hr>
		<a href='index.php?module=parametres&rubrique=User&action=nouveau'><button id='btnAjoutUserForm' class='btn btn-success pull-right'>Nouveau <span class='fa fa-plus-circle'></span></button></a>
		<div id='tableauListe'>
			<?php
				//if ($argsPage['nbPage'] > 0) {
					creationTableau($tableauDonnees);
				//}
				//else { ?>
					<span class='info'>Pas de résultats</span>
			<?php //} ?>
		</div>
	</div>
</div>	
<script>
$(function() {
	$(document).ready(function() {
		// On va gérer le controle de la suppression via un avertissement
		alertSupprimeObjet();
	}
}
</script>		