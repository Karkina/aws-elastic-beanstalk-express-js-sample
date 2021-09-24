
<?php session_start();
   try
  {

    $bdd=new PDO('mysql:host=localhost:3306;dbname=Cinema;charset=utf8', 'root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  
  }
  catch(Exception $e)
  {
    die('Erreur : '.$e->getMessage());
  }

  if(isset($_SESSION['pseudo'])){
    $req = $bdd->prepare('SELECT * FROM client WHERE pseudo=:pseudo');
    $req->execute(array(
      'pseudo'=>$_SESSION['pseudo']));
    $row = $req->fetch();
    $email = $row['email'];
    $date = $row['date_creation'];

    if(isset($_GET['supprimerCompte'])){
    $req = $bdd->prepare('DELETE FROM client WHERE pseudo=:pseudo');
    $req->execute(array(
      'pseudo'=>$_SESSION['pseudo']));
    session_destroy();
    header('Location:../frontEnd/galerie.html');

    }
  }


  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>espace personnel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet"  href="../frontEnd/css/profil.css">
</head>
<body>
<div class="wrapper">
 <div class="book">
 <div class="book__cover">
   <div class="header-image"><div class="overlay"></div></div>
   <div class="title-wrap">
     <h1 class="pseudo"><?if(isset($_SESSION['pseudo'])): echo strtoupper($_SESSION['pseudo']); endif;?> </h1>
   </div>
   <p class="book__cover-exerpt">
      
      Mail:<? echo $email;?> <br>
      <a href="../frontEnd/index.html">Changer de planète</a> <br>
      <a href="?supprimerCompte=oui"> Se désinscrire </a>  <br>
      Films de type préféré:
    </p>
    <p class="book__cover-exerpt">
        <div  align="center">
            action <input type="checkbox" name="prf" checked/><br />
	        animation <input type="checkbox" name="prf" /><br />
	        aventure <input type="checkbox" name="prf" /><br />
	        comédie<input type="checkbox" name="prf"  /><br />
            drame <input type="checkbox" name="prf"  /><br />
            fantastique <input type="checkbox" name="prf"  /><br />
            musical <input type="checkbox" name="prf"  /><br />
            thriller <input type="checkbox" name="prf"  /><br />
        </div>

    </p>
   <div class="book__content">
     
   </div>
  </div>
 </div>
</div>
  
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
 "use strict";

 $('.book').on('click', function () {
   $(this).toggleClass('book--expanded');
 });
    
</script>
</body>
</html>