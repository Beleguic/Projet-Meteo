<?php

	session_start();	

	if (!empty($_SESSION["name"])) {
		header('location: index.php');
		exit();
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Site Meteo - Thibault Beleguic </title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="reset.css"/>
	<link rel="stylesheet" type="text/css" href="style2.css"/>
</head>
<body>
	<header>
		<div>
			<nav>
				<?php
					echo("<ul>");
					echo("<div class='divHeader'>");
						echo("<div class='divHeaderGauche'>");
							$url = "index.php#";
							echo("<div class='divLogoBack'>");
								echo("<li><a id='imgLogoBack' href='$url'> <img id = 'logoBack' src='./Images/Assets/logoBack.jpg'/> </a></li>");
							echo("</div>");
							echo("<div class='divLogoMaison'>");
								echo("<li><a id='imgLogoMaison' href='index.php#'> <img id = 'logoMaison' src='./Images/Assets/logoMaison.jpg'/> </a></li>");
							echo("</div>");
						echo("</div>");
						echo("<div class='divHeaderDroit'>");
						if (!empty($_SESSION["name"])) {
							echo("<div class='divHeaderBoutonGauche'>");
								echo('<li><a class="headerBoutonGauche" href="compte.php">Compte</a></li>');
							echo("</div>");
							echo("<div class='divHeaderBoutonDroit'>");
								echo('<li><a class="headerBoutonDroit" href="deconnexion.php">Deconnexion</a></li>');
							echo("</div>");
								//$uti = $_COOKIE["name"];
								//echo ("<h1> hola $uti </h1>");
							}
							else{
							echo("<div class='divHeaderBoutonGauche'>");
								echo('<li><a class="headerBoutonGauche" href="inscription.php">Inscription</a></li>');
							echo("</div>");
							echo("<div class='divHeaderBoutonDroit'>");
								echo('<li><a class="headerBoutonDroit" href="connexion.php">Connexion</a></li>');
							echo("</div>");
						}
						echo("</div>");
					echo("</div>");
					echo("</ul>");
					?>
			</nav>
		</div>
	</header>
	<form action="scriptInscription.php" method="post" id="formulaire_inscription">
		<div class = "divInsCon">
			<div class="divRow">
			<h1 id="FormInscriptionText">Inscription</h1>
			</div>
			<div class="divRow">
				<div class="divColone"> 
					<label class="inscripInfo" for="inscrip_nom"> Nom  </label>
					<input id='inscrip_nom' type="text" name="nom" placeholder="Nom">
					<label class="inscripInfo" for="inscrip_prenom"> Prenom </label> 
					<input id='inscrip_prenom' type="text" name="prenom" placeholder="Prenom">
				</div>
				<div class="divColone"> 
					<label class="inscripInfo" for="inscrp_mail"> Telephone </label>
					<input id="inscrp_tel" type="text" name="telephone" placeholder="Telephone">
					<label class="inscripInfo" for="inscrp_pseudo"> Pseudo* </label>
					<input id="inscrp_pseudo" type="text" name="pseudo" placeholder="Pseudo">
					</div>
			</div>
			<div class="divRow">
				<div class="divColone">
					<label class="inscripInfo" for="inscrp_pass1"> Mot de passe** </label>
					<input id="inscrp_pass1" type="password" name="motDePasse" placeholder="Mot De passe">
				</div>
				<div class="divColone">
					<label class="inscripInfo" for="inscrp_pass2"> Confirmation du mot de passe** </label>
					<input id="inscrp_pass2" type="password" name="motDePasse2" placeholder="Mot De passe">
				</div>
			</div>
			<div class="divRow">
				<div class="divColone">
					<input type="button" value="Inscription" onclick="checkIncrip();">
					<p>* 4 caractères minmum</p> 
					<p>** 8 caractères minmum</p>
				</div>
			</div>
			<div class="divColone">
				<p id = "Error;"></p>
				<p id = "ErrorLOGIN"></p>
				<p id = "ErrorLPWD"></p>
				<p id = "ErrorMAIL"></p>
				<p id = "ErrorEPWD"></p>
				<p id = "ErrorSPWD"></p>
			</div> 
		</div>
		<?php
		//class row, colomn
			$errorMAIL = isset($_GET['MAIL']) ? $_GET['MAIL'] : NULL;
			if($errorMAIL == true){
				echo("<p> L'adresse mail est deja utiliser </p>");
			}
			$errorLOG = isset($_GET['LOG']) ? $_GET['LOG'] : NULL;
			if($errorLOG == true){
				echo("<p> Le pseudo est deja utiliser </p>");
			}
		?>
	</form>

	<script type="text/javascript">


		function checkIncrip() {

			let pass1 = document.getElementById('inscrp_pass1').value;
			let pass2 = document.getElementById('inscrp_pass2').value;
			let mail = document.getElementById('inscrp_mail').value;
			let pseudo = document.getElementById('inscrp_pseudo').value;
			let nom = document.getElementById('inscrip_nom').value;
			let prenom = document.getElementById('inscrip_prenom').value;
			let nbrCaracPWD = 8;
			let nbrCaracLOGIN = 4;
			let ErrorMail = document.getElementById('ErrorMail');
			let ErrorEPWD = document.getElementById('ErrorEPWD'); // pwd equivalent
			let ErrorSPWD = document.getElementById('ErrorSPWD'); // synthqx pwd
			let ErrorLPWD = document.getElementById('ErrorLPWD'); // longueur pwd
			let ErrorLOGIN = document.getElementById('ErrorLOGIN'); // longueur Login
			let ErrorPoint = document.getElementById('Error;'); // longueur Login
			
			let ClogL = false;
			let CpwdL = false;
			let Cmail = false;
			let CpwdS = false;
			let CpwdE = false;
			let CPoint = false;
			let psuedoL = pseudo.length;
			let pwdL = pass1.length;


			if(psuedoL < nbrCaracLOGIN){
				ErrorLOGIN.innerHTML = "Le pseudo n'est pas asser long";
				ClogL = false;
			}
			else{
				ErrorLOGIN.innerHTML = "";
				ClogL = true;
			}
			if(pwdL < nbrCaracPWD){
				ErrorLPWD.innerHTML = "Le mot de passe n'est pas asser long";
				CpwdL = false
			}
			else{
				ErrorLPWD.innerHTML = "";
				CpwdL = true;
			}

			if(CpwdL == true && ClogL == true){
				var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				var pwdformat = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)([^;]).*$/;
				if(mail.match(mailformat)){
					ErrorMAIL.innerHTML = "";
					Cmail = true;
				}
				else{
					ErrorMAIL.innerHTML = "Votre mail ne respect pas le format standard";
					Cmail = false;
				}
				if(pass1.match(pwdformat)){
					ErrorSPWD.innerHTML = "";
					CpwdS = true;
				}
				else{
					ErrorSPWD.innerHTML = "Le mot de passe doit contenir au moins 1 Majuscule, 1 Minuscule, 1 chiffre et 1 caracteres specials";
					CpwdS = false;
				}
				if (pass1 === pass2){
					ErrorEPWD.innerHTML = "";
					CpwdE = true;
				}
				else{
					ErrorEPWD.innerHTML = "Les deux mot de passe ne sont pas egaux";
					CpwdE = false;
				}
			}

			if(Cmail == true && CpwdS == true && CpwdE == true){

				var NPPformat = /^[^;]*$/;
				
				if(nom.match(NPPformat)){
					if(prenom.match(NPPformat)){
						if(pseudo.match(NPPformat)){
							if(mail.match(NPPformat)){
								if(pass1.match(NPPformat)){
									CPoint = true
								}
								else{
									CPoint = false
								}
							}
							else{
								CPoint = false
							}
						}
						else{
							CPoint = false
						}
					}
					else{
						CPoint = false
					}
				}
				else{
					CPoint = false
				}

				if(CPoint == false){
					ErrorPoint.innerHTML = "Un des Champs du formulaire contient un \";\" ";
				}
				
			}
				

			if(CPoint == true){
				document.getElementById("formulaire_inscription").submit();
			}
		}
	</script>

	<footer>
		
		<p> Site réalisé par Thibault Béléguic dans le cadre du projet "Weather Forecast" pendant le confinement du COVID-19 | 03/2020 </p>
		<p> Université de Cergy-Pontoise / CY Cergy Paris Université - LPI-WS </p>

	</footer>

	<!--cite réaliser part tibo belgeek dent le cadre dû projets "ouitheur forecaste" réaliser durent le confinemant dû COVIDE-19 | 03/2020 Université Sergi-Pont'oise / CY Sergi Parit Université - LPI-WS - Killian.M 26/03/2020 - 16h57m42s - Discord LPI-WS -> Echange -->


</body>
</html>
