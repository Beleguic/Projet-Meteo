<?php
	$liste = array('nom','prenom','adresseMail','pseudo','motDePasse');
	$sortie = true;
	for ($i=0; $i < sizeof($liste) && $sortie = TRUE; $i++){ 
		if (!isset($_POST[$liste[$i]]) || $_POST[$liste[$i]] == ""){
			$sortie = false;
		}
	}

	$fichier = fopen("./info/info.csv", "r");

	while(!feof($fichier)){
		$info = fgets($fichier);
		$info2 = substr($info,0,-2);
		$ligne = explode(";",$info2);
		if($_POST['adresseMail'] == $ligne[2]){
			$sortie = false;
			$IncMail = true;
		}
		else{
			$IncMail = false;
		}
		if($_POST['pseudo'] == $ligne[3]){
			$sortie = false;
			$IncLOG = true;
		}
		else{
			$IncLOG = false;
		}
	}	


	if($sortie == true){
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$email = $_POST['adresseMail'];
		$pseudo = $_POST['pseudo'];
		$mdp = hash('sha256',$_POST['motDePasse']);
		$fichier = fopen("./info/info.csv", "a");
		fputs($fichier, $nom . ";");
		fputs($fichier, $prenom . ";");
		fputs($fichier, $email . ";");
		fputs($fichier, $pseudo . ";");
		fputs($fichier, $mdp . ";");
		fputs($fichier, "\n");
		fclose($fichier);
		header('location: index.php');
		exit();
	}
	else{
		if ($IncLOG == true && $IncMail == true) {
		header("location: inscription.php?MAIL=true&LOG=true");
		exit();
		}
		if ($IncLOG == true && $IncMail == false) {
		header("location: inscription.php?LOG=true");
		exit();	
		}
		if ($IncLOG == false && $IncMail == true) {
		header("location: inscription.php?MAIL=true");
		exit();
		}
	}

?>
