<div class="content three_quarter">
			<article class='row'>
				<div class='col-xs-6'>
					<h4><strong><?php echo $monCompte->getValeur('libelleCompte')? strtoupper($monCompte->getValeur('libelleCompte')): ""; ?></strong></h4>
				</div>
				<div class='col-xs-6'>
					<a href="index.php?module=myCompta&rubrique=Compte&idCompte=<?php echo $monCompte->getValeur('idCompte'); ?>&action=ajout">
						<button type="button" class="btn btn-success"><span class='glyphicon glyphicon-plus'></span> OPERATION</button>
					</a>
					<a href="index.php?module=myCompta&rubrique=Compte&idCompte=<?php echo $monCompte->getValeur('idCompte'); ?>&action=virement">
						<button type="button" class="btn btn-success"><span class='glyphicon glyphicon-plus'></span> VIREMENT INTERNE</button>
					</a>
				</div>
			</article>
			
			<article class="pull-right">
				<div class='col-xs-12'>
					<strong>Solde Rapproché</strong>
					<span class='<?php ($monCompte->getValeur('soldeCours') >= '0' ?  'credit' : 'debit'); ?>'><?php echo $monCompte->getValeur('soldeCours'); ?> €</span>
				</div>			
			</article>
	
			<article class='col-sm-12'>
				<div><strong>Liste des échéances</strong></div>
				<div id="echeances"></div>				
			</article>
			
			<article class='col-sm-12'>
				<div><strong>Opérations non rapprochées</strong></div>
				<div id="nonRapprochees"></div>					
			</article>
	
			<hr>
			<article class='col-sm-12'>
				<div><strong>Liste des opérations : </strong></div>
				<div id="rapprochees"></div>		
			</article>
</div>


<script>
function afficheEcheances() {
	messageChargement('echeances','Chargement des Echéances');
	messageChargement('nonRapprochees','Chargement des opérations non rapprochées');
	$('#echeances').load('_plugins/myCompta/scripts/myCompta.php',
			{	source : 'AJAX',
				fonction: 'echeances',
				idCompte: <?php echo $monCompte->getValeur('idCompte')?>,
				MEF: 'tableau',
				dateDebut: 'null',
				dateFin: '<?php echo date('Y-m-t', strtotime(date('Y-m-d'))); ?>'
			},afficheOperationNonRapprochees);
};

function afficheOperationNonRapprochees() {
	$('#nonRapprochees').load('_plugins/myCompta/scripts/myCompta.php',
			{	source : 'AJAX',
				fonction: 'operation',
				idCompte: <?php echo $monCompte->getValeur('idCompte')?>,
				estRapproche: '-1',
				MEF: 'tableau'	
			});
};


function afficheOperationRapprochees() {
	messageChargement('rapprochees','Chargement des opérations rapprochées');
	$('#rapprochees').load('_plugins/myCompta/scripts/myCompta.php',
		{	source : 'AJAX',
			fonction: 'operation',
			idCompte: <?php echo $monCompte->getValeur('idCompte')?>,
			estRapproche: '1',
			MEF: 'tableau'			
		});
};


$(function() {
	// Fonction qui va affiche le tableau au chargement du programme
	$(document).ready(function() {
		afficheEcheances();
		afficheOperationRapprochees();
		//afficheOperationNonRapprochees();
		
	});

    $("a#createEcheance").click(function(event){
        //do whatever you want
        event.preventDefault(); // This is for preventing the default behavior of links
        $("a#createEcheance").click();
      });	
});
</script>
