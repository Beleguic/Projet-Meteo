<?php
	session_start();


	if (!empty($_POST['pseudo'])) {
		$pseudo = $_POST['pseudo'];  // Adresse mail de connexion
		$deco1 = false;
	}
	else{
		$deco1 = true;
	}
	if (!empty($_POST['motDePasse'])) {
		$mdp = hash('sha256',$_POST['motDePasse']);     // mot de passe de connexion
		$deco2 = false;
	}
	else{
		$deco2 = true;
	}

	if ($deco1 == false && $deco2 == false){

		$fichier = fopen("./info/info.csv", "r");

		$connexion = false;

		while(!feof($fichier)){
			$info = fgets($fichier);
			$info2 = substr($info,0,-2);
			$ligne = explode(";",$info2);
			if($pseudo == $ligne[3]){
				if($mdp == $ligne[4]){
					$connexion = true;
				}
			}
		}	

		if($connexion == true){
			$_SESSION['name'] = $pseudo;
			header('location:index.php');
			exit();
		}
		else{
			$_SESSION=array();
			session_destroy();	
			header("location: connexion.php?ER=true");
			exit();
		}
	}
	else{
		$_SESSION=array();
		session_destroy();	
		header('location:index.php');
		exit();
	}

?>	

