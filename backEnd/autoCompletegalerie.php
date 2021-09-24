<?php
if(isset($_GET["term"]))
{
	try
	{

		$bdd=new PDO('mysql:host=localhost:3306;dbname=Cinema;charset=utf8', 'root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	
	$reqFilm=$bdd->query("SELECT id,titre,photo FROM films WHERE titre LIKE'%".$_GET["term"]."%'");
	$output = array();

	while($row=$reqFilm->fetch()){
			$temp_array = array();
	   		$temp_array['titre'] = $row['titre'];
	   		$temp_array['photo'] = '<img src="'.$row['photo'].'" width="70" />';
	   		$output[] = $temp_array;	
	   	}
	$reqFilm->closeCursor();

	$reqActeur=$bdd->query("SELECT DISTINCT name,photo FROM acteurs WHERE name LIKE'%".$_GET["term"]."%'");
	if($reqActeur->rowCount()>0){
	while($row=$reqActeur->fetch()){
			$temp_array = array();
	   		$temp_array['titre'] = $row['name'];
	   		$temp_array['photo'] = '<img src="data:image/jpeg;base64,'.base64_encode($row['photo']).'"width="70" />';
	   		$output[] = $temp_array;	
	   	}
	}
	$reqActeur->closeCursor();

	$reqReal=$bdd->query("SELECT name,photo FROM realisateur WHERE name LIKE'%".$_GET["term"]."%'");
	if($reqReal->rowCount()>0){
		while($row=$reqReal->fetch()){
			$temp_array = array();
	   		$temp_array['titre'] = $row['name'];
	   		$temp_array['photo'] = '<img src="'.$row['photo'].'" width="70" />';
	   		$output[] = $temp_array;	
	   	}
	    }
	
	echo json_encode($output);
}
?>
