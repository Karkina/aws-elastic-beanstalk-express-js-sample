<?php 
	session_start();
	if(isset($_POST['pseudoCo'])&& isset($_POST['passwdCo']))
	{
		$pseudo = htmlspecialchars($_POST['pseudoCo']);
		$passwd = htmlspecialchars($_POST['passwdCo']);

		try
		{
			$bdd=new PDO('mysql:host=localhost:3306;dbname=cinema;charset=utf8','root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		$reponse=$bdd->prepare('SELECT id, passwd as test_passwd FROM client WHERE pseudo=?');
		$reponse->execute(array($pseudo));
		$rep=$reponse->fetch();
		if(!$rep){
			echo "<script>alert(\"Mauvaise connexion a la BDD\")</script>";	
		}
		elseif(password_verify($passwd, $rep['test_passwd']))
		{
			echo "<script>alert(\"C'est good\")</script>";
			setcookie('pseudo',$pseudo,time()+24*3600,null,null,false,true);
			setcookie('pass_hache',$rep['test_passwd'],time()+24*3600,null,null,false,true);
       		$_SESSION['id'] = $rep['id'];
       		$_SESSION['pseudo'] = $pseudo;
       		echo 'Vous êtes connecté !'.$pseudo;
       		header('Location:../frontEnd/galerie.html');
       		
		}
		else{
			echo "<script>alert(\"Mauvais pseudo ou mot de passe\")</script>";
		}
	}


	if(isset($_POST['email']) && isset($_POST['pseudo'])&&isset($_POST['password'])&&isset($_POST['test_password']))
	{
		try
		{
			$bdd=new PDO('mysql:host=localhost:3306;dbname=cinema;charset=utf8','root', 'root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
		}
	catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}

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
		header('Location: ../frontend/insc.php');
		}
	}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <link rel="stylesheet" href="css/insc.css">
</head>
<body>
    	
    <div class="container">
       <div class="login-box">
            <div class="title">se connecter</div>
            <form  method="POST">
	            <div class="input">
	                <input type="text" id="login-user" placeholder="Veuillez entrer votre nom d'utilisateur" value="<?php if(isset($_COOKIE['pseudo']))echo $_COOKIE['pseudo']?>" name="pseudoCo">
	            </div>
	            <div class="input">
	                <input type="password" id="login-password" placeholder="Veuillez entrer votre mot de passe" value="<?if(isset($_COOKIE['pass_hache']))echo $_COOKIE['pass_hache']?>" name="passwdCo">
	            </div>
	            <input type="submit" value="connexion" class="btn login_btn">
	            <!-- <div type="submit" class="btn login-btn">
	                <span>connecte</span>
	            </div> -->
            </form>
            <div class="change-box login-change">
                <div class="change-btn toSign">
                    <span>s'inscrire</span>
                </div>
            </div>

       </div>

       <div class="sign-box">
            <div class="title">s'inscrire</div>
            <form method="POST">

            <div class="input">
                <input type="text" id="sign-user" placeholder="Saisir un nom d'utilisateur" name="pseudo">
            </div>

            <div class="input">
                <input type="email" id="sign-email" placeholder="Saisir email" name="email">
            </div>

            <div class="input">
                <input type="password" id="sign-password" placeholder="Saisir votre mot de passe" name="password">
            </div>

             <div class="input">
                <input type="password" id="verify-password" placeholder="Saisir votre mot de passe" name="test_password">
            </div>

            <input type="submit" value="connexion" class="btn login_btn">

           <!--  <div class="btn sign-btn">
                <span>je m'inscris</span>
            </div> -->
            </form>
            <div class="change-box sign-change">
                <div class="change-btn toLogin">
                    <span>se connecter</span>
                </div>
            </div>
       </div>
    </div>
</body>


<script src="js/insc.js"></script>
 <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</html>