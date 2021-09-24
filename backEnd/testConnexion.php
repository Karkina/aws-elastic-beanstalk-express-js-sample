<?php
/*Permet de tester si une personne est connecter*/
	session_start();
	if(isset($_SESSION['pseudo'])){

		$var['pseudo'] = $_SESSION['pseudo'];
		$var['connecter'] = true;
	}
	else
	{
		$var['connecter'] = false;
	}

	echo json_encode($var);
 ?>