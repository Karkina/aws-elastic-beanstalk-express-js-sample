
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

	if(isset($_GET['imageVal'])){
		$index=$_GET['imageVal'];
		$req=$bdd->prepare('SELECT * FROM films WHERE id=:imageIndex');
		$req->execute(array(
				'imageIndex'=>$index));

	}
	if(isset($_GET['url']) ||isset($_GET['titre'])){

		if(isset($_GET['url'])){
			$url=$_GET['url'];
			$req=$bdd->prepare('SELECT * FROM films WHERE photo=:urlImage');
			$req->execute(array(
					'urlImage'=>$url));
		}

		else{

			$titre_test=$_GET['titre'];
			$req=$bdd->prepare('SELECT * FROM films WHERE titre=:titreImage');
			$req->execute(array(
				'titreImage'=>$titre_test));
		}
		if($req->rowCount()>0){
			$row=$req->fetch();
			$titre = $row['titre'];
			$com = $bdd->prepare('SELECT * FROM message WHERE film=:titre ORDER BY dateEnvoie DESC LIMIT 5');
			$com->execute(array(
			'titre'=>$titre));

			/*Creation des commentaires*/
			$lesCommentaire = "";
			while($rowCom = $com->fetch()){
					$commentaire =$rowCom['dateEnvoie']." <b>".strtoupper($rowCom['pseudo'])." : </b>".$rowCom['commentaire']. "<br> <br>";
					$lesCommentaire = $lesCommentaire . $commentaire;
			}
			$com->closeCursor();
			$row['com'] = $lesCommentaire;
			//Connection
			if(isset($_SESSION['pseudo'])){
				$row['connecter'] ="true";
			}
			else{
				$row['connecter'] ="false";
			}


			$note = $bdd->prepare('SELECT AVG(score) as moyenne, titre FROM notefilm WHERE titre=:titre');
			$note->execute(array(
				'titre'=>$titre));
			while($rowNote = $note->fetch()){
			 		$row['note']=$rowNote['moyenne'];
		    }
		    $note->closeCursor();
		}
			else{

				$reqActeur = $bdd->prepare('SELECT DISTINCT name,titre,nationalité as pays,a.photo as photoActeur,b.photo as photoFilm FROM acteurs a JOIN films AS b ON a.title = b.titre WHERE name =:acteur');
				$reqActeur->execute(array(
					'acteur'=>$titre_test));
				if($reqActeur->rowCount()>0){
				$row['acteur'] ="true";
				$i=0;
				while($rowActeur = $reqActeur->fetch()){
					$test['name']= $rowActeur['name'];
					$test['nationalite'] = $rowActeur['pays'];
					$test['titreFilm'] = $rowActeur['titre'];
					$test['photoFilm'] = $rowActeur['photoFilm'];
					$test['photoTest'] = 'data:image/jpeg;base64,'.base64_encode($rowActeur['photoActeur']);
					$row[$i] = $test;
					$i+=1;
				}
				}
				else{
					$reqActeur = $bdd->prepare('SELECT * FROM realisateur WHERE name=:acteur');
					$reqActeur = $bdd->prepare('SELECT DISTINCT name,titre,nationalité as pays,a.photo as photoReal,b.photo as photoFilm FROM realisateur a JOIN films AS b ON a.name = b.realisateur WHERE name =:acteur');
					$reqActeur->execute(array(
					'acteur'=>$titre_test));
					if($reqActeur->rowCount()>0){
						$row['real'] ="true";
						$i=0;
						while($rowActeur = $reqActeur->fetch()){
							$test['name']= $rowActeur['name'];
							$test['nationalite'] = $rowActeur['pays'];
							$test['titreFilm'] = $rowActeur['titre'];
							$test['photoFilm'] = $rowActeur['photoFilm'];
							$test['photoTest'] = $rowActeur['photoReal'];
							$row[$i] = $test;
							$i+=1;
						}
					}
				
				/*print_r($row);*/
				}
			}

			//print_r($row);
			echo json_encode($row);
		}

	/*if(isset($_GET['titre'])){

		while($row=$req->fetch()){
			$titre = $row['titre'];
			$com = $bdd->prepare('SELECT * FROM message WHERE film=:titre ORDER BY dateEnvoie DESC LIMIT 5');
			$com->execute(array(
			'titre'=>$_GET['titre']));
			$lesCommentaire = "";
			while($rowCom = $com->fetch()){
					$commentaire =$rowCom['dateEnvoie']." <b>".strtoupper($rowCom['pseudo'])." : </b>".$rowCom['commentaire']. "<br> <br>";
					$lesCommentaire = $lesCommentaire . $commentaire;
			}
			$com->closeCursor();
			$row['com'] = $lesCommentaire;
			echo json_encode($row);
			}
	}*/

	if(!isset($_GET['url']) && !isset($_GET['titre'])){
	while($row=$req->fetch()){
			$req->closeCursor();
			echo json_encode($row);
		}	
	}
	
?>