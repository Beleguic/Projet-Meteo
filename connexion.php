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
	<form action="scriptConnexion.php" method="post" id="formulaire_connexion">
		<div class="divInsCon">
			<div class="divRow">
				<h1 id="FormConnexionText">Connexion</h1>
			</div>
			<div class="divRow">
				<div class="divColone"> 
					<label class="inscripInfo" for="co_LOGIN"> Pseudo </label>
					<input id = "co_LOGIN" type="text" name="pseudo" placeholder="Pseudo">
					<label class="inscripInfo" for="co_LOGIN"> Mot de passe </label>
					<input id = "co_MDP" type="password" name="motDePasse" placeholder="Mot De passe">
				</div>
			</div>
			<div class="divRow">
				<div class="divColone">
					<input type="button" value="Connexion" onclick="checkCo();">
				</div>
			</div>
			<div class="divColone">
				<p id="ErrorLONG"></p>
				<?php
					$error = isset($_GET['ER']) ? $_GET['ER'] : NULL;
					if($error == true){
						echo("<p> le pseudo et/ou le mot de passe est incorrect </p>");
					}
				?>
			</div>
		</div>
	</form>

	<script>
		function checkCo() {
		
			let pass = document.getElementById('co_MDP').value;
			let pseudo = document.getElementById('co_LOGIN').value;
			let nbrCarac = 1;
			let ErrorLONG = document.getElementById('ErrorLONG'); // longueur champ
			long1 = pass.length;
			long2 = pseudo.length;
			
			
			if(long1 >= nbrCarac && long2 >= nbrCarac){
				document.getElementById("formulaire_connexion").submit();
			}
			else{
				ErrorLONG.innerHTML = "Veuiller renseigner les information dans les champs";
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