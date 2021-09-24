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

	if(isset($_GET['score'])){
		$note = $bdd->prepare('INSERT INTO notefilm(score,titre,utilisateur) VALUES(:note,:titre,:utilisateur)');
		$note->execute(array(
				'note'=>$_GET['score'],
				'titre'=>$_GET['titre'],
				'utilisateur'=>$_SESSION['pseudo']));
		$req->closeCursor();
	}
?>