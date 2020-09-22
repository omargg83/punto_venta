<?php
	require_once("db_.php");
?>

	<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Datos Empresa</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>
				<li class='' is='li-link' des='a_datosemp/lista' dix='trabajo'><i class='fas fa-list-ul'></i>Lista</button>
			</ul>
	  </div>
	</nav>
<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>
