<div class='col-sm-9'>
	<div class="container-fluid">
		<!-- Affichage de la partie contenu -->
		<section>
			<article class='row'>
				<div class='col-xs-6'>
					<h4><strong>GESTION DES ECHEANCES</strong></h4>
				</div>
				<div class='col-xs-6'>
					<a href="index.php?module=myCompta&rubrique=Echeance&action=ajout">
						<button type="button" class="btn btn-success pull-right"><span class='glyphicon glyphicon-plus'></span> ECHEANCE</button>
					</a>
					<a href="index.php?module=myCompta&rubrique=Echeance&action=operation">
						<button type="button" class="btn btn-success pull-right"><span class='glyphicon glyphicon-plus'></span> OPERATION RECCURENTE</button>
					</a>
					
				</div>
			</article>
	
			<article class='col-sm-12'>
				<div><strong>Opérations</strong></div>
				<div id="operation"></div>				
			</article>
			
			<article class='col-sm-12'>
				<div><strong>Virements Internes</strong></div>
				<div id="virement"></div>					
			</article>
			
		</section>
	</div>
</div>

<script>
//Fonction générique pour afficher le tableau en fonction des filtres sur cette page

$(function() {
	// Fonction qui va affiche le tableau au chargement du programme
	$(document).ready(function() {
		$('#operation').html('<img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif">');
		$('#operation').load('_plugins/myCompta/scripts/myCompta.php',
				{	fonction: 'echeanceSynthese',
					typeMouvement : 'O',
					MEF: 'tableau',
					dateDebut: '2017-01-01',
					dateFin: '2017-02-28'
				});	

		$('#virement').html('<img src="http://www.mediaforma.com/sdz/jquery/ajax-loader.gif">');
		$('#virement').load('_plugins/myCompta/scripts/myCompta.php',
				{	fonction: 'echeanceSynthese',
					typeMouvement : 'V',
					MEF: 'tableau',
					dateDebut: '2017-01-01',
					dateFin: '2017-02-28'
				});	
	});
});
</script>
