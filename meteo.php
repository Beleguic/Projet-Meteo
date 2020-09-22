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
$detail = $cook[3];
if($detail == "true"){
	$nbrHeure = ($cook[2]);
}
else{
	$nbrHeure = nbrheureFon($cook[2]);
}
$testVal = substr($ville, 0,22);
if($testVal == "Dernière recherche : "){
	$ville = substr($ville, 22);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//$jsonText = file_get_contents("https://www.prevision-meteo.ch/services/json/$ville");
	$jsonText1 = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$ville.",fr&appid=a995c90c82411b9e3990125c16830e10&units=metric&lang=fr");
	//$jsonText = file_get_contents("Cergy.json");
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$table1 = json_decode($jsonText1,True);
	
if ($table1['cod'] == ""){
    $meteo = false;
}
else{
	$meteo = true;
}


if($meteo == true){

	

	$lon = $table1["coord"]["lon"];
	$lat = $table1["coord"]["lat"];

	$jsonText2 = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?q=".$ville.",fr&appid=a995c90c82411b9e3990125c16830e10&units=metric&lang=fr");
	$table2 = json_decode($jsonText2,True); // meteo pour les 5 prochain jours, toutes les 3 heure (0,3,6,9,12,15,18,21) // Detail

	$jsonText3 = file_get_contents("https://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$lon&appid=a995c90c82411b9e3990125c16830e10&units=metric&lang=fr");
	$table3 = json_decode($jsonText3,True); // meteo par heure sur 48 heures et tendance sur 7 jours. // tendance


	$ville = $table1["name"];
	$HeureLever = date('H:i',$table1["sys"]["sunrise"]); 
	$HeureCoucher = date('H:i',$table1["sys"]["sunset"]);
	$dateCurrent = date('l j F o (d/m/y)',$table1["dt"]);
	$dateHeureCurrent = date('H:i',$table1["dt"]);
	$temperature = temp($table1["main"]["temp"]);
	$tempResentie = temp($table1["main"]["feels_like"]);
	$condition = $table1["weather"]["0"]["description"];
	$condiIMG = $table1["weather"]["0"]["id"];
	$DoN = dayOrNight($table1["dt"],$table1["sys"]["sunrise"],$table1["sys"]["sunset"]);
	$img1 = "./Images/Condition/icon_big/".$condiIMG.$DoN.".png";
	$humiditer = $table1["main"]["humidity"];
	$ventSpeed = temp($table1["wind"]["speed"]);
	$ventDirDeg = $table1["wind"]["deg"];
	$ventDir = dirWind($ventDirDeg);
	$pression = $table1["main"]["pressure"];

	$jour_en = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	$jour_fr = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");

	$mois_en = array("January","February","March","April","May","June","July","August","September","October","November","December");
	$mois_fr = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

	$dateCurrent = str_replace($jour_en, $jour_fr, $dateCurrent);
	$dateCurrent = str_replace($mois_en, $mois_fr, $dateCurrent);


	echo("<div id = 'meteoActuel'>");
		echo("<h1> $ville </h1>");
		echo("<p id='heureRemise'> Émis le $dateCurrent à $dateHeureCurrent depuis https://openweathermap.org</p>");
		echo("<div id='temp-logo'>");
			echo("<div class='infoMeteoActVert' >");
				echo("<p id='temperature'> ".$temperature."°C </p>");
				echo("<p class='info'> $condition </p>");
			echo("</div>");
			echo("<img src='$img1' alt='ERROR'/>");
		echo("</div>");
		echo("<div class='infoMeteoActHori'>");
			echo("<div class='infoMeteoActVert' >");
				echo("<p class='info'> Ressentie </p>");
				echo("<p class='valeur'> ".$tempResentie."°C</p>");
				echo("<p class='info'> Vents </p>");
				echo("<p class='valeur'> $ventSpeed km/h </p>");
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
		echo("<div class='divJourLogoALL'>");
			echo("<div class='divJourLogoHorloge'>");
				echo("<img id='logoHorloge' src='./Images/logo/horloge.png' alt'ERROR' width='30'/>");
			echo("</div>");
			echo("<div class='divJourLogo'>");
				echo("<img id='logoHumidity' src='./Images/logo/Humidity.png' alt'ERROR' width='30'/>");
				echo("<img id='logoVent' src='./Images/logo/Vent.jpg' alt'ERROR'  width='60'/>");
			echo("</div>");
		echo("</div>");
	$xx = 0;
	for ($j=0; $j < 24; $j++) {
		$heure = date('G',$table3["hourly"]["$j"]["dt"]);
		$heure = $heure."H00";
		$haut = $table3["hourly"]["$j"]["temp"];
		$haut2 = intval($haut*10);
		$haut3 = 200-$haut2;
		$bas = 200-$haut3;
		if($heure == 1){
			$xx = 1;
		}
		$DoN = dayOrNight($table3["hourly"]["$j"]["dt"],$table3["daily"]["$xx"]["sunrise"],$table3["daily"]["$xx"]["sunset"]);
		$condiIMG = $table3["hourly"]["$j"]["weather"]["0"]["id"];
		$img3 = "./Images/Condition/icon_big/".$condiIMG.$DoN.".png";
		$Temp = temp($table3["hourly"]["$j"]["temp"]);
		$humi = $table3["hourly"]["$j"]["humidity"];
		$pluie = $table3["hourly"]["$j"]["rain"]["1h"];
		$Vvent = temp($table3["hourly"]["$j"]["wind_speed"]);
		$Dvent = $table3["hourly"]["$j"]["wind_deg"];
		$Dvent = dirWind($Dvent);

		if ($pluie == ""){
			$pluie = 0;
		}

		echo("<div class = 'div_heure'>");
		echo("<h2 class = 'heure_jour' style='margin-bottom: 20px'> $heure </h2>"); 
		echo("<img class = 'icon_heure' src='$img3' alt='ERROR' style='margin-top: ".$haut3."px' width='30'/>");
		echo("<p class = 'temp_heure' style='margin-bottom: ".$bas."px'> $Temp </p>");
		echo("<p class = 'info_complementaire1'> ".$humi."% </p>");
		echo("<p class = 'info_complementaire'> $pluie mm</p>");
		echo("<p class = 'info_complementaire'> $Vvent Km/h </p>");
		echo("<img class='icon_vent' src='./Images/direction/$Dvent.png' alt'ERROR'/>");
		echo("</div>");
		
	}

	echo("</div>");


	if($detail == "true"){
		echo("<div id='divAnnonceMeteo2' >");
			echo("<h2> Tendance pour les 6 prochains jours </h2>");
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
		for ($i=1; $i < 7; $i++) { 
			$day_long = date('l',$table3["daily"]["$i"]["dt"]);
			$tmax = temp($table3["daily"]["$i"]["temp"]["max"]);
			$tmin = temp($table3["daily"]["$i"]["temp"]["min"]);
			$DoN = dayOrNight($table3["daily"]["$i"]["dt"],$table3["daily"]["$i"]["sunrise"],$table3["daily"]["$i"]["sunset"]);
			$condiIMG = $table3["daily"]["$i"]["weather"]["0"]["id"];
			$img2 = "./Images/Condition/icon_big/".$condiIMG.$DoN.".png";

			$jour_en = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
			$jour_fr = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");

			$day_long = str_replace($jour_en, $jour_fr, $day_long);

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
		$hhhh = $nbrJour - 1;
		if($hhhh == 1){
			echo("<h2 id='annonceMeteoJour'> Prévision pour demain</h2>");
		}
		else{
			echo("<h2 id='annonceMeteoJour'> Prévision pour les $hhhh prochains jours </h2>");
		}
		$temps_actuel = date('d');
		for ($l=0; $l < sizeof($table2['list']); $l++) { 
			if ($temps_actuel != date('d',$table2['list']["$l"]['dt'])) {
			    $debut = $l;
			    break;
			}
		}
		for ($i=1; $i < $nbrJour; $i++) { 
			$g = $i*8;
			$jourDate = date('l d.m.Y',$table2["list"]["$g"]["dt"]);

			$jourDate = str_replace($jour_en, $jour_fr, $jourDate);

			echo("<h3 id='MeteoJour'> $jourDate </h3>");
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

			for ($j=0; $j < $nbrHeure; $j++){
				$g = $l + $j;
				$h = date('G',$table2['list']["$g"]['dt']);
				$h = $h."H00";
				$haut = $table2['list']["$g"]['main']["temp"];
				$haut2 = intval($haut*10);
				$haut3 = 200-$haut2;
				$bas = 200-$haut3;
				$DoN = dayOrNight($table2['list']["$g"]['dt'],$table3["daily"]["$i"]["sunrise"],$table3["daily"]["$i"]["sunset"]);
				$lever1 = date('G',$table3["daily"]["$i"]["sunrise"]);
				$coucher1 = date('G',$table3["daily"]["$i"]["sunset"]);
				$lever2 = date('i',$table3["daily"]["$i"]["sunrise"]);
				$coucher2 = date('i',$table3["daily"]["$i"]["sunset"]);
				$leverH = $lever1."H".$lever2;
				$coucherH = $coucher1."H".$coucher2;
				$condiIMG = $table2['list']["$g"]['weather']["0"]["id"];
				$img3 = "./Images/Condition/icon_big/".$condiIMG.$DoN.".png";
				$Temp = temp($table2['list']["$g"]['main']["temp"]);
				$humi = $table2['list']["$g"]['main']["humidity"];
				$pluie = $table2['list']["$g"]['rain']["3h"];
				$Vvent = $table2['list']["$g"]["wind"]["speed"];
				$Dvent = temp($table2['list']["$g"]["wind"]["deg"]);
				$Dvent = dirWind($Dvent);

				if ($pluie == ""){
					$pluie = 0;
				}
				echo("<div class = 'div_heure'>");
				echo("<h2 class = 'heure_jour' style='margin-bottom: 20px' font-size='115%'> $h </h2>"); 
				echo("<img class = 'icon_heure' src='$img3' alt='ERROR' style='margin-top: ".$haut3."px' width='40'/>");
				echo("<p class = 'temp_heure' style='margin-bottom: ".$bas."px'> $Temp </p>");
				echo("<p class = 'info_complementaire1'> ".$humi."% </p>");
				echo("<p class = 'info_complementaire'> $pluie mm</p>");
				echo("<p class = 'info_complementaire'> $Vvent Km/h </p>");
				echo("<img class='icon_vent' src='./Images/direction/$Dvent.png' alt='ERROR'/>");
				echo("</div>");

				$g1 = $g + 1;
				if($table3["daily"]["$i"]["sunrise"] > $table2['list']["$g"]['dt'] && $table2['list']["$g1"]['dt'] > $table3["daily"]["$i"]["sunrise"]){
					echo("<div class = 'div_heure'>");
					echo("<h2 class = 'heure_jour' style='margin-bottom: 20px' font-size='115%'> $leverH </h2>"); 
					echo("<img class = 'icon_heure' src='./Images/Assets/lever.png' alt='ERROR' style='margin-top: ".$haut3."px' width='40'/>");
					echo("</div>");
				}
				elseif($table3["daily"]["$i"]["sunset"] > $table2['list']["$g"]['dt'] && $table2['list']["$g1"]['dt'] > $table3["daily"]["$i"]["sunset"]){
					echo("<div class = 'div_heure'>");
					echo("<h2 class = 'heure_jour' style='margin-bottom: 20px' font-size='115%'> $coucherH </h2>"); 
					echo("<img class = 'icon_heure' src='./Images/Assets/coucher.png' alt='ERROR' style='margin-top: ".$haut3."px' width='40'/>");
					echo("</div>");
				}				
			}
			echo("</div>");
			$l = $l + 8;
		}	
	}
}
else{

	echo("<div id='ErrorMeteo'>");
		echo("<h1> La ville demandée n'est pas disponible actuellement </h1>");
	echo("</div>");
}


function dirWind($degre){

	if ($degree >= 337.5) {
		$degre = "N";
	}elseif ($degre >= 22.5 && $degre < 67.5) {
	    $degre = "NE";
	}elseif ($degre >= 67.5 && $degre < 112.5) {
	    $degre = "E";
	}elseif ($degre >= 112.5 && $degre < 157.5) {
	    $degre = "SE";
	}elseif ($degre >= 157.5 && $degre < 202.5) {
	    $degre = "S";
	}elseif ($degre >= 202.5 && $degre < 247.5) {
	    $degre = "SO";
	}elseif ($degre >= 247.5 && $degre < 292.5) {
	    $degre = "O";
	}elseif ($degre >= 292.5 && $degre < 337.5) {
		$degre = "NO";
	}
	else{
		$degre = "None";
	}
	return $degre;
}

function dayOrNight($tN,$tL,$tC){
	if ($tN >= $tL && $tC > $tN){
		$DoN = "d";
	}
	else{
		$DoN = "n";
	}
	return $DoN;
}

function temp($temp){
	if($temp >= 10){
		if(strlen($temp) > 4){
			$temp = substr($temp,0,-1);
		}
	}
	else{
		if(strlen($temp) > 3){
			$temp = substr($temp,0,-1);
		}
	}
	return $temp;
}

function nbrheureFon($nbrHeure){
	if ($nbrHeure >= 0 && $nbrHeure < 5) {
	    $nbrHeure = 1;
	}elseif ($nbrHeure >= 5 && $nbrHeure < 8) {
	    $nbrHeure = 2;
	}elseif ($nbrHeure >= 8 && $nbrHeure < 11) {
	    $nbrHeure = 3;
	}elseif ($nbrHeure >= 11 && $nbrHeure < 14) {
	    $nbrHeure = 4;
	}elseif ($nbrHeure >= 14 && $nbrHeure < 17) {
	    $nbrHeure = 5;
	}elseif ($nbrHeure >= 17 && $nbrHeure < 20) {
	    $nbrHeure = 6;
	} elseif ($nbrHeure >= 20 && $nbrHeure < 23) {
		$nbrHeure = 7;
	}
	else{
		$nbrHeure = 8;
	}
	return $nbrHeure;
}

/*
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

*/

?>
	<footer>
		
		<p> Site réalisé par Thibault Béléguic dans le cadre du projet "Weather Forecast" pendant le confinement du COVID-19 | 03/2020 </p>
		<p> Université de Cergy-Pontoise / CY Cergy Paris Université - LPI-WS </p>

	</footer>

	<!--cite réaliser part tibo belgeek dent le cadre dû projets "ouitheur forecaste" réaliser durent le confinemant dû COVIDE-19 | 03/2020 Université Sergi-Pont'oise / CY Sergi Parit Université - LPI-WS - Killian.M 26/03/2020 - 16h57m42s - Discord LPI-WS -> Echange -->

</body>
</html>



