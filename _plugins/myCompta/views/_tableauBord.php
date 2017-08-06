<div class="two_quarter first"> 
	<div id="menuAside">
			<?php 
			include_once $GLOBALS['root'] . '_plugins/myCompta/viewModels/widgets.php';
			listeCompte(true); ?>
	</div>
</div>

<div class="content two_quarter"> 
	<div id='comments'>
		<?php listeEcheances(); ?>
	</div>
</div>
