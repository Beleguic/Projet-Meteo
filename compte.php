<?php
	session_start();

	if(empty($_SESSION['name'])){
		header('Location: index.php#');
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title> Site Meteo - Thibault Beleguic </title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="reset.css"/>
	<link rel="stylesheet" type="text/css" href="style2.css"/>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
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
	<div id = "HeuRefreshStat">
		<?php

			$jsonText = file_get_contents("./info/Stat.json");
			$table = json_decode($jsonText,True);

			$dateH = date(" G:i:s ");
			$dateD = date(" l j F o (d/m/y) ");
			$dateF = date(" P - e");

			$jour_en = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
			$jour_fr = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");

			$mois_en = array("January","February","March","April","May","June","July","August","September","October","November","December");
			$mois_fr = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

			$dateD = str_replace($jour_en, $jour_fr, $dateD);
			$dateD = str_replace($mois_en, $mois_fr, $dateD);

			echo("<span id = 'NbrVisiteur'> dernier refresh des Statistique le $dateD </br> à $dateH GMT $dateF </span>");
		?>
	</div>
	<div id = "divGeneralStat">

		<div id = "divStatGauche">
			<div id = "DivMyChart1">
				<canvas id="myChart" width="600"> </canvas>
			</div>
			<div id = "DivMyChart2">
				<canvas id="myChart2" width="600"> </canvas>
			</div>
		</div>
		<div id = "divStatDroite">	
			<div id='StatRegion'>
				<canvas id="myChart3" width="600"> </canvas>
			</div>
			<div id="infoStat">
				<div class = "divinfoStat">
					<?php
						$nbrVisiteur = $table["Connexion"]["Total"];
						echo("<span id = 'NbrVisiteur'> Nombre de visiteurs : $nbrVisiteur </span>");
					?>
				</div>
				<div class = "divinfoStat">
					<?php
						$nbrCompte = file("./info/info.csv");
						$nbrCompte = count($nbrCompte);
						$nbrCompte = $nbrCompte-1; // pour la ligne du dessous vide
						echo("<span id = 'NbrCompte'> Nombre de comptes : $nbrCompte </span>");
					?>
				</div>
				<div class = "divinfoStat">
					<?php
						$NbrSearchMeteo = $table["MeteoMois"]["Total"];
						echo("<span id = 'NbrSearchMeteo'> Nombre de recherches météo : $NbrSearchMeteo </span>");
					?>
				</div>
			</div>
			<form action="changePWD.php" method="post" id="formChangePwd">
				<div class = "divChangePwd">
					<h1 id="infoChangePwd"> Changer le mot de passe </h1>
					<div class="divRow2">
						<div class="divColone"> 
							<label class="inscripInfo" for="inscrip_nom"> Adresse Mail </label>
							<input id="change_mail" type="text" name="mail" placeholder="Adresse Mail"/>
							<label class="inscripInfo" for="inscrip_nom"> Ancien mot de passe </label>
							<input id="change_passOld" type="password" name="oldPwd" placeholder="Ancien mot de passe"/>
						</div>
						<div class="divColone"> 
							<label class="inscripInfo" for="inscrip_nom"> Nouveau mot de passe* </label>
							<input id="change_pass1" type="password" name="newPwd1" placeholder="Nouveau mot de passe"/>
							<label class="inscripInfo" for="inscrip_nom"> Confirmation du nouveau mot de passe* </label>
							<input id="change_pass2" type="password" name="newPwd2" placeholder="Confirmation du nouveau mot de passe"/>
						</div>
					</div>
					<div class="divRow2">
						<div class="divColone">
							<input type="button" value="Changer le mot de passe" onclick="checkNewPwd();"/>
							<p>* 8 caractères minmum</p>
						</div>
					</div>
					<div class="divColone">
						<p id = "ErrorLPWD"></p>
						<p id = "ErrorMAIL"></p>
						<p id = "ErrorEPWD"></p>
						<p id = "ErrorSPWD"></p>
						<?php
							$error = isset($_GET['error']) ? $_GET['error'] : NULL;
							if($error == 1){
								echo("<p> l'ancien mot de passe n'est pas bon ! </p>");
							}
							if($error == 2){
								echo("<p> le mail n'est pas bon ! </p>");
							}

						?> 
					</div>
				</div>
			</form>
		</div>
	</div>

	<footer>
		
		<p> Site réalisé par Thibault Béléguic dans le cadre du projet "Weather Forecast" pendant le confinement du COVID-19 | 03/2020 </p>
		<p> Université de Cergy-Pontoise / CY Cergy Paris Université - LPI-WS </p>

	</footer>

	<script>

		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
		    type: 'line',
		    data: {
		        labels: ['0h','1h','2h','3h','4h','5h','6h','7h','8h','9h','10h','11h','12h','13h','14h','15h','16h','17h','18h','19h','20h','21h','22h','23h'],
		        datasets: [{
		            label: 'Visiteurs', backgroundColor:'rgba(255, 99, 132, 0.5)',borderColor:'rgba(255, 99, 132)',borderWidth: 2,
		            data: [	<?php
				    	$t = ",";
				    	for ($i = 0; $i <= 23; $i++) {
				    		$f = $table["Connexion"]["$i"];			
							echo("$f ");
							echo("$t ");
				    	}
					?>],
		        }]
		    },
		    options: {
                title: {
                	display: true,
                    text: "Nombre de visites par heure"
           		}
		    }
		});

				
		var ctx = document.getElementById('myChart2').getContext('2d');
		var myChart2 = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
		        datasets: [{
		            label: 'Visiteurs par mois', 
		            data: [	<?php
				    	$t = ",";
				    	for ($y = 1; $y < 13; $y++) {
				    		if($y < 10){
				    			$y = "0".$y; 
				    		}
				    		$f = $table["MeteoMois"]["$y"];			
							echo("$f ");
							echo("$t ");
				    	}
					?>],
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)',
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
	            	],
	            	borderColor: [
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
	           		],
	           		borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero: true
		                }
		            }]
		        },   
		        title: {
                	display: true,
                    text: "Nombre de requête meteo par mois"
           		}
		    }
		});




		var ctx = document.getElementById('myChart3').getContext('2d');

		var chart = new Chart(ctx, {
    // Le type de graphique que l'on souhaite
	    type: 'pie',

	    // Les différentes données du graphique
	    data: {
	        labels: ['île de france', 'Centre-Val de Loire', 'Bourgogne-Franche-Compté','Normandie','Hauts-de-France','Grand Est','Pays de la Loire','Bretagne','Nouvelle-Aquitaine','Occitanie','Auvergne-Rhône-Alpes','Provence-Alpes-Côte d\'Azur','Corse'],
	        datasets: [{
	            label: 'PIE Viste Regions',
	            backgroundColor: ['#B49C27','#327915','#6488F5','#CD4AE2','#7C5EB3','#82776D','#08004C','#109D46','#8D667A','#FF83FA','#C4BB6E','#7B8694','#80DBF5'],
	            borderColor: 'rgb(255, 255, 255)',
	            data: [<?php 
	            	$t = ",";
			    	for ($y = 11; $y < 95; $y = $y + $suiv) {
			    		if($y == 11){
			    			$suiv = 13; 
			    		}
			    		if($y == 27 || $y == 52 || $y == 75 || $y == 93){
			    			$suiv = 1;
			    		}
			    		if($y == 44 || $y == 76){
			    			$suiv = 8;
			    		}
			    		if($y == 24){
			    			$suiv = 3; 
			    		}
			    		if($y == 28){
			    			$suiv = 4; 
			    		}
			    		if($y == 84){
			    			$suiv = 9; 
			    		}
			    		if($y == 32){
			    			$suiv = 12; 
			    		}
			    		if($y == 53){
			    			$suiv = 22; 
			    		}
			    		$f = $table["Region"]["$y"];			
						echo("$f ");
						echo("$t ");
			    	}
	            	?>]
	        }]
	    },

	    // Configuration options go here
	    options: {
	    	cutoutPercentage: 0,
	    	title: {
	    		display: true,
	    		text: "Nombre de visites par régions"
	    	}
	    }
		});

		
		function checkNewPwd() {
			
			let oldPwd = document.getElementById('change_passOld').value;
			let newPwd1 = document.getElementById('change_pass1').value;
			let newPwd2 = document.getElementById('change_pass2').value;
			let mail = document.getElementById('change_mail').value;
			let nbrCaracPWD = 8;
			let ErrorEPWD = document.getElementById('ErrorEPWD'); // pwd equivalent
			let ErrorSPWD = document.getElementById('ErrorSPWD'); // synthqx pwd
			let ErrorLPWD = document.getElementById('ErrorLPWD'); // longueur pwd
			let ErrorMail = document.getElementById('ErrorMail'); // synthax mail
			let LnewPwd1 = newPwd1.length;
			let CpwdL = false;
			let Cmail = false;
			let CpwdS = false;
			let CpwdE = false;

			if(LnewPwd1 < nbrCaracPWD){
				ErrorLPWD.innerHTML = "Le nouveau mot de passe n'est pas asser long";
				CpwdL = false
			}
			else{
				ErrorLPWD.innerHTML = "";
				CpwdL = true;
			}

			if(CpwdL == true){
				var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				var pwdformat = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
				if(mail.match(mailformat)){
					ErrorMAIL.innerHTML = "";
					Cmail = true;
				}
				else{
					ErrorMAIL.innerHTML = "Votre mail ne respect pas le format standard";
					Cmail = false;
				}
				if(newPwd1.match(pwdformat)){
					ErrorSPWD.innerHTML = "";
					CpwdS = true;
				}
				else{
					ErrorSPWD.innerHTML = "Le nouveau mot de passe doit contenir au moins 1 Majuscule, 1 Minuscule, 1 chiffre et 1 caracteres specials";
					CpwdS = false;
				}
				if (newPwd1 === newPwd2){
					ErrorEPWD.innerHTML = "";
					CpwdE = true;
				}
				else{
					ErrorEPWD.innerHTML = "Les deux mot de passe ne sont pas egaux";
					CpwdE = false;
				}
			}
			if(Cmail == true && CpwdS == true && CpwdE == true){
				document.getElementById("formChangePwd").submit();
			}
		}

	</script>

	<!--cite réaliser part tibo belgeek dent le cadre dû projets "ouitheur forecaste" réaliser durent le confinemant dû COVIDE-19 | 03/2020 Université Sergi-Pont'oise / CY Sergi Parit Université - LPI-WS - Killian.M 26/03/2020 - 16h57m42s - Discord LPI-WS -> Echange -->


</body>
</html>