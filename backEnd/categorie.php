<?try
	{

		$bdd=new PDO('mysql:host=localhost:3306;dbname=boutique_mc;charset=utf8', 'root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}

	$catBDD = $bdd->query("SELECT DISTINCT categorie FROM articles");
	$cat = array();
	$stringCat = '';
	while($row = $catBDD->fetch()){
		$stringCat = $stringCat.'<a href="#galerie"><span class="dropdown-item" data-value="about" onclick="galerie(\''.$row['categorie'].'\')">'.$row['categorie']."</span></a>";
	}
	$cat['catTest'] = $stringCat;
	$catBDD->closeCursor();
	echo json_encode($cat);





?>