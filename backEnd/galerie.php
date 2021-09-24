<?php
	try
	{

		$bdd=new PDO('mysql:host=localhost:3306;dbname=boutique_mc;charset=utf8', 'root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	$toto = array();
	if(isset($_GET['cat'])){
		$req=$bdd->prepare('SELECT ID,categorie,photo,prix FROM articles WHERE categorie = :cat');
		$req->execute(array(
			"cat"=>$_GET['cat'])
			);
	
	}
	else{
		$req=$bdd->query('SELECT ID,categorie,photo,prix FROM articles');
	}
	/*$i=0;*/
	while($row=$req->fetch()){
		$ID[] = $row['ID'];
		$titre[]=$row['categorie'];
		$prix[]=$row['prix'];
		$photo[]='data:image/png;base64,'.base64_encode($row['photo']);
		/*$i++;*/
	}
	$toto['id'] = $ID;
	$toto['value'] = $titre;
	$toto['prix'] = $prix;
	$toto['photo'] = $photo;

	echo json_encode($toto);

	
	$req->closeCursor();

?>