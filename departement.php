<?php

	session_start();


	$dep = $_GET["depcode"];
	$jsonText = file_get_contents("./info/Stat.json");
	$table = json_decode($jsonText,True);
	$table["Departement"]["$dep"] += 1 ; // +=
	$jsonTextEncode = json_encode($table);
	$fichier = fopen("./info/Stat.json", "w");
	fputs($fichier,$jsonTextEncode);
	fclose($fichier);


	if(isset($_COOKIE['pref'])){
		$cookie = $_COOKIE['pref'];
		$cookie = explode("/", $cookie);
		$CookieVilleInfo = "Dernière recherche : ".$cookie[0];
		$CookieVille = $cookie[0];
		$CookieNbrJour = $cookie[1];
		$CookieNbrHeure = $cookie[2];
		$CookieFreqHeure = $cookie[3];
		$CookieCkeckBox = $cookie[4];
	}	
	else{
		$CookieVille = "---Selectionner une ville---";
		$CookieNbrJour = 2;
		$CookieNbrHeure = 12;
		$CookieFreqHeure = 1;
		$CookieCkeckBox = true;
	}

?>


<!DOCTYPE html>
<html>
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
					$dep = $_GET["depcode"];
					$fichier = fopen("./info/departments.csv", "r");
					while(!feof($fichier)){
						$ligne = fgetcsv($fichier,1024);
						if($ligne[2] == $dep){
							$nomDep = $ligne[3];
							$reg = $ligne[1];
							break;
						}
					}
					echo("<ul>");
					echo("<div class='divHeader'>");
						echo("<div class='divHeaderGauche'>");
							$url = "Region.php?code=$reg";
							echo("<div class='divLogoBack'>");
								echo("<li><a id='imgLogoBack' href='$url'> <img id = 'logoBack' alt='ERROR' src='./Images/Assets/logoBack.jpg'/> </a></li>");
							echo("</div>");
							echo("<div class='divLogoMaison'>");
								echo("<li><a id='imgLogoMaison' href='index.php#'> <img id = 'logoMaison' alt='ERROR' src='./Images/Assets/logoMaison.jpg'/> </a></li>");
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
<?php

// regioncode=53&depcode=29

	echo ("<div id='divDep'>");
		echo("<h1 id='nomDep'> $nomDep </h1>");
	echo ("</div>");
	echo ("<div id='divDep'>");
		echo ("<div id='divInfoDep'>");
			echo("<img id='mapdep' src='./Images/Departement/$dep.jpg' alt='ERROR'/>");
		echo ("</div>");
		echo ("<div id='divInfoDep'>");
			$fichier = fopen("./info/cities.csv", "r");
			echo("<h2 id='titreDep'> Sélectionnez votre commune pour afficher la météo </h2>");
			echo("<form id='formulaireMeteo' action='meteo.php' method='GET'>");
			echo("<select id='ville_select' name='ville' size='1' onchange='changeDivForm1()'>");
				echo("<option class = 'form_ville'> ---Selectionner une ville--- </option>");
				if(isset($_COOKIE['pref'])){
					echo("<option class = 'form_ville'> $CookieVilleInfo </option>");
				}
			$dep = $_GET["depcode"];
			$nomVilleAvant = "";
			while(!feof($fichier)){
				$ligne = fgetcsv($fichier,1024);
				if($ligne[1] == $dep){
					if($nomVilleAvant != $ligne[4]){
						echo("<option class = 'form_ville'> $ligne[4] </option>");
						$nomVilleAvant = $ligne[4];
					}
				}	
			}

			echo("</select>");
			echo("<div id='parmForm1'>");
				echo("<input type='checkbox' id='detailCheckBox' name='detail' onchange='changeDivForm2();' checked=''/>");
			  	echo("<label for='detail'>Afficher seulement les tendances des 6 prochains jours ?</label>");
			  	
			  	echo("<p id = 'chckboxtest'></p>"); 
			  echo("<input type='text' name='dep' value='$dep' id='hidden'/>");
			  	echo("<div id='parmForm2'>");
			  		echo("<div class='divInfoSlider'>");
					  	echo ("<p>Prévision météo pour&nbsp</p>");
					  	echo ("<p id='slider1'> </p>");
					  	echo ("<p>&nbspjours </p>");
					echo("</div>");
					echo ("<div class='slidecontainer'>");
					  	echo ("<input type='range' min='1' max='4' value='$CookieNbrJour' class='slider' id='myRange1'/>");
					echo ("</div>");
					echo("<div class='divInfoSlider'>");
						echo ("<p>Prévision météo jusqu'a&nbsp</p>");
						echo ("<p id='slider2'> </p>");
						echo ("<p>&nbspheures chaque jour </p>");
					echo("</div>");
					echo ("<div class='slidecontainer'>");
					  	echo ("<input type='range' min='2' max='24' value='$CookieNbrHeure' class='slider' id='myRange2'/>");
					echo ("</div>");
					/*echo("<div class='divInfoSlider'>");
						echo ("<p>Prévision météo toutes les </p>");
						echo ("<p id='slider3'> </p>");
						echo ("<p> heure</p>");
					echo("</div>");
					echo ("<div class='slidecontainer'>");
					  	echo ("<input type='range' min='1' max='4' value='$CookieFreqHeure' class='slider' id='myRange3'/>");
					echo ("</div>");*/
				echo("</div>");
				echo("<p id='infoMeteo'> </p>");
				echo("<input type='button' value='Valider' onclick='checkMeteo();'/>");
				echo("</div>");
			echo("</form>");
		echo("</div>");
	echo ("</div>");

	?>
<script>

	var slider1 = document.getElementById("myRange1");
	var output1 = document.getElementById("slider1");
	output1.innerHTML = slider1.value;

	slider1.oninput = function() {
	  output1.innerHTML = this.value;
	}

	var slider2 = document.getElementById("myRange2");
	var output2 = document.getElementById("slider2");
	output2.innerHTML = slider2.value;

	slider2.oninput = function() {
	  output2.innerHTML = this.value;
	}
/*
	var slider3 = document.getElementById("myRange3");
	var output3 = document.getElementById("slider3");
	output3.innerHTML = slider3.value;

	slider3.oninput = function() {
	  output3.innerHTML = this.value;
	}
*/

	function changeDivForm1(){
		var villecheck = document.getElementById('ville_select').value;
		var otherText1 = document.querySelector('div[id="parmForm1"]');
		if(villecheck == "---Selectionner une ville---"){
			otherText1.style.visibility = "hidden";
		}
		else{
			otherText1.style.visibility = "visible";
		}
	}

	function changeDivForm2(){
		var otherCheckbox = document.getElementById('detailCheckBox').checked;
		var otherText2 = document.querySelector('div[id="parmForm2"]');
		if(otherCheckbox == true){
			otherText2.style.visibility = "hidden";
		}
		else{
			otherText2.style.visibility = "visible";
		}
	}



	function checkMeteo(){

		let ville = document.getElementById('ville_select').value;
		let box = document.getElementById('detailCheckBox').checked;
		let nbrJour = document.getElementById('myRange1').value;
		let nbrHeure = document.getElementById('myRange2').value;
//		let ecartHeure = document.getElementById('myRange3').value;
		console.log(slider1);
		console.log(slider2);
//		console.log(slider3);
		let regex = /(Dernière recherche : )+/;


		if(ville.match(regex)){
			ville = "<?php echo("$CookieVille"); ?>";
		}


		if(box == true){
			nbrJour = 4;
			//nbrHeure = -1;
			//ecartHeure = -1;
		}
		else{
			if(nbrJour < 1){
				nbrJour = 1;
			}
			if(nbrJour > 4){
				nbrJour = 4;
			}
			if(nbrHeure < 1){
				nbrHeure = 1;
			}
			if(nbrHeure > 24){
				nbrHeure = 24;
			}
		}
		cook = "".concat(ville,"/",nbrJour,"/",nbrHeure,"/",box,"/");
		//cook = "".concat(ville,"/",nbrJour,"/",nbrHeure,"/",ecartHeure,"/",box,"/");

		document.cookie = "pref="+cook;
		//let url = "meteo.php?ville=";
		//url = url + ville;
		//document.location.href = url
		console.log("test");
		document.getElementById("formulaireMeteo").submit();
		
	}

</script>
	<footer>
		
		<p> Site réalisé par Thibault Béléguic dans le cadre du projet "Weather Forecast" pendant le confinement du COVID-19 | 03/2020 </p>
		<p> Université de Cergy-Pontoise / CY Cergy Paris Université - LPI-WS </p>
	</footer>

	<!--cite réaliser part tibo belgeek dent le cadre dû projets "ouitheur forecaste" réaliser durent le confinemant dû COVIDE-19 | 03/2020 Université Sergi-Pont'oise / CY Sergi Parit Université - LPI-WS - Killian.M 26/03/2020 - 16h57m42s - Discord LPI-WS -> Echange -->

</body>
</html>