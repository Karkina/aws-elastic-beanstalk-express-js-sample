
<?php
session_start();
	try
	{

		$bdd=new PDO('mysql:host=localhost:3306;dbname=boutique_mc;charset=utf8', 'root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	if(isset($_GET['id'])){
		$req=$bdd->prepare('SELECT ID,categorie,description,photo,prix FROM articles WHERE ID = :id');
		$req->execute(array(
			"id"=>$_GET['id'])
			);
	
	}
	else{
		echo "error";
	}

	while($row=$req->fetch()){
		$ID[] = $row['ID'];
		$titre[]=$row['categorie'];
		$description[] = $row['description'];
		$prix[]=$row['prix'];
		$photo[]='data:image/png;base64,'.base64_encode($row['photo']);
		/*$i++;*/
	}
	$toto['id'] = $ID;
	$toto['desc'] = $description;
	$toto['categorie'] = $titre;
	$toto['prix'] = $prix;
	$toto['photo'] = $photo;

	echo json_encode($toto);

	
	$req->closeCursor();
?>