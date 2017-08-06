<div class="content <?php echo $tailleContent; ?>">

	<h4><?php echo $monCompte->getValeur('nomBanque'); ?> - <?php echo $monCompte->getValeur('libelleCompte'); ?></h4>
	
	<div class="btmspace-15">
		<div class="two_quarter first">
			<table>
				<tr>
					<td>Echéances à venir</td>
					<td align='right'> €</td>
				</tr>
				<tr>
					<td>Opérations non rapprochées</td>
					<td align='right'><?php echo $monCompte->getValeur('soldeNonRapproche'); ?> €</td>
				</tr>
			</table>
		</div>
		<div class="two_quarter">
			<table>
				<tr>
					<td>Solde rapproché en cours</td>
					<td align='right'><?php echo $monCompte->getValeur('soldeCours'); ?> €</td>
				</tr>
				<tr>
					<td>Solde théorique fin de mois</td>
					<td align='right'><?php echo $monCompte->getValeur('soldeReel'); ?> €</td>
				</tr>
			</table>
		</div>
	</div>
		
	<?php
		// affichage du bandeau d'option
		include ('_optionsAffichageComptes.php');
	?>

	<div id='tableauListe'>
		<?php
			if ($argsPage['nbPage'] > 0) {
				creationTableau($argsPage['tableauDonnees']);
			}
			else { ?>
				<span class='info'>Pas de résultats</span>
		<?php } ?>
	</div>
</div>

<script>
	function affichePageFiltree(dateDebut,dateFin) {
		$('#tableauListe').load('_plugins/myCompta/scripts/myCompta.php',{
				source : 'AJAX',
				fonction: 'getListeObjet',
				plugin: 'myCompta',
				classe: 'Operation',
				miseEnForme: 'tableau',	
				valueSelected : '<?php echo $compteID; ?>',
				dateDebut: dateDebut,
				dateFin: dateFin
        });
	}
	
	$(function() {
		// Fonction qui va affiche le tableau au chargement du programme
		$(document).ready(function() {
			$('#selectionDate').hide();
			$('input[type=radio]').click(function() {
				maDate = new Date();
				typeAff= $('input[type=radio]:checked').attr('value');
				switch (typeAff) {
					case '0':
						$('#selectionDate').show();
						$('#affiche').click(function(e) {
							dateDebut = $('#dateDebut').val();
							dateFin = $('#dateFin').val();
							affichePageFiltree(dateDebut,dateFin);
							e.preventDefault();
						});
						break;
					case '-1':
						$('#selectionDate').hide();
						dateDebut= maDate.getFullYear() + '-' + (maDate.getMonth()) + '-01';
						dateFin= maDate.getFullYear() + '-' + (maDate.getMonth()) + '-' + new Date(maDate.getFullYear(),maDate.getMonth(),0).getDate();
						affichePageFiltree(dateDebut,dateFin);
						break;
					default:
						$('#selectionDate').hide();
						dateDebut= maDate.getFullYear() + '-' + (maDate.getMonth()+1) + '-01';
						dateFin= maDate.getFullYear() + '-' + (maDate.getMonth()+1) + '-' + new Date(maDate.getFullYear(),maDate.getMonth()+1,0).getDate();
						affichePageFiltree(dateDebut,dateFin);
						break;
				}
			});	
		});
	});
</script>
