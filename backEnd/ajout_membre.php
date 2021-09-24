<?php
	try
	{
		$bdd=new PDO('mysql:host=localhost:3306;dbname=cinema;charset=utf8','root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	echo "testGood";
	echo $_POST['email'];
	echo $_POST['pseudo'];
	echo $_POST['password'];
	echo $_POST['test_password'];
	if(isset($_POST['email']) && isset($_POST['pseudo'])&&isset($_POST['password'])&&isset($_POST['test_password']))
	{
		echo "test";

		$_POST['email']=htmlspecialchars($_POST['email']);
		$_POST['test_password']=htmlspecialchars($_POST['test_password']);
		$_POST['password']=htmlspecialchars($_POST['password']);
		$_POST['pseudo']=htmlspecialchars($_POST['pseudo']);

		if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])){
		
			header('Location: inscription.php?mailError=true');

		}
		elseif(strcmp($_POST['password'], $_POST['test_password'])!=0)
		{
			header('Location: inscription.php?test_password_error=true');
		}
		else{
		$req=$bdd->prepare('INSERT INTO client(email,date_creation,passwd,pseudo) VALUES (:email,NOW(),:passwd,:pseudo)');
		$req->execute(array(
			'email'=>$_POST['email'],
			'passwd'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
			'pseudo'=>$_POST['pseudo']));
		$req->closeCursor();
		header('Location: ../frontend/indexCinemaTest.php');
		}
	}

?>