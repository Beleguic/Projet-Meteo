<?php
	
		session_start();

		date_default_timezone_set('Europe/Paris');
		$date = date('m');
		$jsonText = file_get_contents("./info/Stat.json");
		$table = json_decode($jsonText,True);
		$table["MeteoMois"]["$date"] += 1 ; // +=
		$table["MeteoMois"]["Total"] += 1 ; // +=
		$jsonTextEncode = json_encode($table);
		$fichier = fopen("./info/Stat.json", "w");
		fputs($fichier,$jsonTextEncode);
		fclose($fichier);

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
						$dep = $_GET['dep'];
							$url = "departement.php?depcode=$dep";
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

<?php
$ville = $_GET['ville'];
$dep = $_GET['dep'];
$cook = $_COOKIE['pref'];
$cook = explode('/', $cook);
$nbrJour = $cook[1] + 1;
$nbrHeure = $cook[2];
$ecartHeure = $cook[3];
$detail = $cook[4];

$testVal = substr($ville, 0,22);
if($testVal == "Dernière recherche : "){
	$ville = substr($ville, 22);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//$jsonText = file_get_contents("https://www.prevision-meteo.ch/services/json/$ville");
	$jsonText = file_get_contents("Cergy.json");
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$table = json_decode($jsonText,True);

if (empty($table['errors'])) {
    $meteo = true;

}
else{
	
	$ville2 = $ville;
	$ville2 = $ville2."-".$dep;
	$jsonText = file_get_contents("https://www.prevision-meteo.ch/services/json/$ville2");
	$table = json_decode($jsonText,True);
    if (empty($table['errors'])) {
   		$meteo = true;
	}
	else{
		$meteo = false;
	}
}


if($meteo == true){

	

	$ville = $table["city_info"]["name"];
	$HeureLever = $table["city_info"]["sunrise"]; 
	$HeureCoucher = $table["city_info"]["sunset"];
	$jour = $table["fcst_day_0"]["day_long"];
	$date = $table["current_condition"]["date"]; 
	$heur = $table["current_condition"]["hour"];
	$heure = str_replace(":", "H", $heur);
	$temperature = $table["current_condition"]["tmp"];
	$condition = $table["current_condition"]["condition"];
	$condiIMG = $condition;
	$confiIMG = changeletter($condiIMG);
	$img1 = "./Images/Condition/icon_big/".$confiIMG."-big".".png";
	$humiditer = $table["current_condition"]["humidity"];
	$ventSpeed = $table["current_condition"]["wnd_spd"];
	$ventRafale = $table["current_condition"]["wnd_gust"];
	$ventDir = $table["current_condition"]["wnd_dir"];
	$pression = $table["current_condition"]["pressure"];

	echo("<div id = 'meteoActuel'>");
		echo("<h1> $ville </h1>");
		echo("<p id='heureRemise'> Émis le $jour $date à $heure depuis prevision-meteo.ch</p>");
		echo("<div id='temp-logo'>");
			echo("<div class='infoMeteoActVert' >");
				echo("<p id='temperature'> ".$temperature."°C </p>");
				echo("<p class='info'> $condition </p>");
			echo("</div>");
			echo("<img src='$img1' alt='ERROR'/>");
		echo("</div>");
		echo("<div class='infoMeteoActHori'>");
			echo("<div class='infoMeteoActVert' >");
				echo("<p class='info'> Vents </p>");
				echo("<p class='valeur'> $ventSpeed km/h </p>");
				echo("<p class='info'> Rafales </p>");
				echo("<p class='valeur'> $ventRafale km/h </p>");
			echo("</div>");
			echo("<div class='infoMeteoActVert' >");
				echo("<p class='info'> Direction du vent </p>");
				echo("<img id='imgDirAct' src='./Images/direction/".$ventDir."-big.png' width='100' alt'ERROR'/>");
			echo("</div>");
			echo("<div class='infoMeteoActVert' >");
				echo("<p class='info'> Humidité </p>");
				echo("<p class='valeur'> ".$humiditer."% </p>");
				echo("<p class='info'> Pression </p>");
				echo("<p class='valeur'> ".$pression."hPa </p>");
			echo("</div>");
			echo("<div class='infoMeteoActVert'>");
				echo("<p class='info'> Lever du soleil </p>");
				echo("<p class='valeur'> $HeureLever </p>");
				echo("<p class='info'> Coucher du soleil </p>");
				echo("<p class='valeur'> $HeureCoucher </p>");
			echo("</div>");
		echo("</div>");
	echo("</div>");

	echo("<div id='divAnnonceMeteo1'>");
		echo("<h2> Météo pour les prochaines 24 heures </h2>");
	echo("</div>");
	echo("<div class = 'div_jour'>");
	if($heure < "10H00"){
		$heure = substr($heure,-4,4);
	}
	$heureNow = date('G');
	$heurSuiv = substr($heure,0,-3);
	if ($heureNow != $heurSuiv){
		$heurSuiv = $heurSuiv -1;
		if($heurSuiv < 0){
			$heurSuiv = 23;
		}
	} 
	$jo = 0;
		echo("<div class='divJourLogoALL'>");
			echo("<div class='divJourLogoHorloge'>");
				echo("<img id='logoHorloge' src='./Images/logo/horloge.png' alt'ERROR' width='30'/>");
			echo("</div>");
			echo("<div class='divJourLogo'>");
				echo("<img id='logoHumidity' src='./Images/logo/Humidity.png' alt'ERROR' width='30'/>");
				echo("<img id='logoVent' src='./Images/logo/Vent.jpg' alt'ERROR'  width='60'/>");
			echo("</div>");
		echo("</div>");
	for ($j=0; $j < 24; $j++) {
		$h = $heurSuiv . "H00";
		$heurSuiv = $heurSuiv + 1;
		$CONDITION = $table["fcst_day_$jo"]["hourly_data"]["$h"]["CONDITION"];
		$haut = $table["fcst_day_$jo"]["hourly_data"]["$h"]["TMP2m"];
		$haut2 = intval($haut*10);
		$haut3 = 200-$haut2;
		$bas = 200-$haut3;
		$condiIMG = $table["fcst_day_$jo"]["hourly_data"]["$h"]["CONDITION"];
		$confiIMG = changeletter($condiIMG);
		$img3 = "./Images/Condition/icon/".$confiIMG.".png";
		$Temp = $table["fcst_day_$jo"]["hourly_data"]["$h"]["TMP2m"];
		$humi = $table["fcst_day_$jo"]["hourly_data"]["$h"]["RH2m"];
		$pluie = $table["fcst_day_$jo"]["hourly_data"]["$h"]["APCPsfc"];
		$Vvent = $table["fcst_day_$jo"]["hourly_data"]["$h"]["WNDSPD10m"];
		$Dvent = $table["fcst_day_$jo"]["hourly_data"]["$h"]["WNDDIRCARD10"];
		if($heurSuiv > 23){
			$heurSuiv = 0;
			$jo = 1;
		}


		echo("<div class = 'div_heure'>");
		echo("<h2 class = 'heure_jour'> $h </h2>"); 
		//echo("<p = class = 'condi_heure'> $CONDITION </p>");
		echo("<img class = 'icon_heure' src='$img3' alt='ERROR' style='margin-top: ".$haut3."px' width='30'/>");
		echo("<p class = 'temp_heure' style='margin-bottom: ".$bas."px'> $Temp </p>");
		echo("<p class = 'info_complementaire1'> ".$humi."% </p>");
		echo("<p class = 'info_complementaire'> $pluie mm</p>");
		echo("<p class = 'info_complementaire'> $Vvent Km/h </p>");
		echo("<img class='icon_vent' src='./Images/direction/$Dvent.png' alt'ERROR'/>");
		echo("</div>");
		
	}

	echo("</div>");


	if($detail == true && $nbrHeure == "-1" && $ecartHeure == "-1"){
		echo("<div id='divAnnonceMeteo2' >");
			echo("<h2> Tendance pour les 3 prochains jours </h2>");
		echo("</div>");
		echo("<div class='MeteoTendance'>");
			echo("<div id='varInterneTendance' class='InterneTendance'>");
				echo("<div class='tendanceObejct' >");
					echo("<p class='infoTendance'> Jour </p>");
				echo("</div>");
				echo("<div class='tendanceObejct'>");
					echo("<p class='infoTendance'> Condition </p>");
				echo("</div>");
				echo("<div class='tendanceObejct'>");
					echo("<p class='infoTendance'> T-Max </p>");
				echo("</div>");
				echo("<div class='tendanceObejct'>");
					echo("<p class='infoTendance'> T-Min </p>");
				echo("</div>");
			echo("</div>");
		for ($i=1; $i < $nbrJour; $i++) { 
			$date = $table["fcst_day_$i"]["date"];
			$day_long = $table["fcst_day_$i"]["day_long"];
			$tmax = $table["fcst_day_$i"]["tmax"];
			$tmin = $table["fcst_day_$i"]["tmin"];
			$condiIMG = $table["fcst_day_$i"]["condition"];
			$confiIMG = changeletter($condiIMG);
			$img2 = "./Images/Condition/icon_big/$confiIMG"."-big".".png";

			echo("<div class='InterneTendance'>");
				echo ("<div class='tendanceObejct' >");
				echo("<p> $day_long </p>");
				echo ("</div>");
				echo ("<div class='tendanceObejct'>");
				echo("<img src='$img2' alt='ERROR'/>");
				echo ("</div>");
				echo ("<div class='tendanceObejct'>");
				echo("<p> ".$tmax."°C</p>");
				echo ("</div>");
				echo ("<div class='tendanceObejct'>");
				echo("<p> ".$tmin."°C</p>");
				echo ("</div>");
				
			echo("</div>");
		}
		echo("</div>");
	}
			
		
	else{
		$hhhh = $nbrJour-1;
		echo("<h2 id='annonceMeteoJour'> Prévision pour les $hhhh prochains jours </h2>");
		for ($i=1; $i < $nbrJour; $i++) { 
			$jour = $table["fcst_day_$i"]["day_long"];
			$date = $table["fcst_day_$i"]["date"];
			echo("<h3 id='MeteoJour'> $jour $date </h3>");
			echo("<div class = 'div_jour'>");
				echo("<div class='divJourLogoALL'>");
					echo("<div class='divJourLogoHorloge'>");
						echo("<img id='logoHorloge' src='./Images/logo/horloge.png' alt'ERROR' width='30'/>");
					echo("</div>");
					echo("<div class='divJourLogo'>");
						echo("<img id='logoHumidity' src='./Images/logo/Humidity.png' alt'ERROR' width='30'/>");
						echo("<img id='logoVent' src='./Images/logo/Vent.jpg' alt'ERROR'  width='60'/>");
					echo("</div>");
				echo("</div>");
			for ($j=0; $j < $nbrHeure; $j = $j + $ecartHeure) {
				$h = $j . "H00";
				$CONDITION = $table["fcst_day_$i"]["hourly_data"]["$h"]["CONDITION"];
				$haut = $table["fcst_day_$i"]["hourly_data"]["$h"]["TMP2m"];
				$haut2 = intval($haut*10);
				$haut3 = 200-$haut2;
				$bas = 200-$haut3;
				$condiIMG = $table["fcst_day_$i"]["hourly_data"]["$h"]["CONDITION"];
				$confiIMG = changeletter($condiIMG);
				$img3 = "./Images/Condition/icon/$confiIMG".".png";
				$Temp = $table["fcst_day_$i"]["hourly_data"]["$h"]["TMP2m"];
				$humi = $table["fcst_day_$i"]["hourly_data"]["$h"]["RH2m"];
				$pluie = $table["fcst_day_$i"]["hourly_data"]["$h"]["APCPsfc"];
				$Vvent = $table["fcst_day_$i"]["hourly_data"]["$h"]["WNDSPD10m"];
				$Dvent = $table["fcst_day_$i"]["hourly_data"]["$h"]["WNDDIRCARD10"];

				echo("<div class = 'div_heure'>");
				echo("<h2 class = 'heure_jour'> $h </h2>"); 
				echo("<img class = 'icon_heure' src='$img3' alt='ERROR' style='margin-top: ".$haut3."px' width='30'/>");
				echo("<p class = 'temp_heure' style='margin-bottom: ".$bas."px'> $Temp </p>");
				echo("<p class = 'info_complementaire1'> ".$humi."% </p>");
				echo("<p class = 'info_complementaire'> $pluie mm</p>");
				echo("<p class = 'info_complementaire'> $Vvent Km/h </p>");
				echo("<img class='icon_vent' src='./Images/direction/$Dvent.png' alt'ERROR'/>");
				echo("</div>");
				
			}
			echo("</div>");
		}	
	}
}
else{

	echo("<div id='ErrorMeteo'>");
		echo("<h1> La ville demandée n'est pas disponible actuellement </h1>");
	echo("</div>");
}

function changeletter($condition){

	$condition = strtolower($condition);
	$vowels = array("é", "è", "ê");
	$condition = str_replace($vowels,"e",$condition);
	$condition = str_replace(" ","-",$condition);

	return $condition;
}

?>
	<footer>
		
		<p> Site réalisé par Thibault Béléguic dans le cadre du projet "Weather Forecast" pendant le confinement du COVID-19 | 03/2020 </p>
		<p> Université de Cergy-Pontoise / CY Cergy Paris Université - LPI-WS </p>

	</footer>

	<!--cite réaliser part tibo belgeek dent le cadre dû projets "ouitheur forecaste" réaliser durent le confinemant dû COVIDE-19 | 03/2020 Université Sergi-Pont'oise / CY Sergi Parit Université - LPI-WS - Killian.M 26/03/2020 - 16h57m42s - Discord LPI-WS -> Echange -->

</body>
</html>

