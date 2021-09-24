
<?php
session_start();
	try
	{

		$bdd=new PDO('mysql:host=localhost:3306;dbname=Cinema;charset=utf8', 'root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	if(isset($_POST['commentaire']) && isset($_SESSION['pseudo']) && isset($_GET['film'])){
		$req=$bdd->prepare('INSERT INTO message(pseudo,dateEnvoie,commentaire,film) VALUES(:pseudo,NOW(),:com,:film)');
		$req->execute(array(
				'pseudo'=>$_SESSION['pseudo'],
				'com'=>$_POST['commentaire'],
				'film'=>$_GET['film']));
		$req->closeCursor();

	}
	else{
		echo "Vous n'êtes pas connecter";
	}

?>