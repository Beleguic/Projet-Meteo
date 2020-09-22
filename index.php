<?php
	session_start();
		if (!empty($_SESSION["name"])) {
			$uti = $_SESSION["name"];
		}
		else{
			$_SESSION=array();
			session_destroy();	
		}

		date_default_timezone_set('Europe/Paris');
		$date = date('G');
		$jsonText = file_get_contents("./info/Stat.json");
		$table = json_decode($jsonText,True);
		$table["Connexion"]["$date"] += 1 ; // +=
		$table["Connexion"]["Total"] += 1 ; // +=
		$jsonTextEncode = json_encode($table);
		$fichier = fopen("./info/Stat.json", "w");
		fputs($fichier,$jsonTextEncode);
		fclose($fichier);


?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Site Meteo - Thibault Beleguic </title>
	<link rel="stylesheet" type="text/css" href="reset.css"/>
	<link rel="stylesheet" type="text/css" href="style2.css"/>
	<meta charset="utf-8"/>
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
	<div id="infoCarteFrance">
		<h1 id="nomReg"> Sélectionnez votre région </h1>
	</div>
	<div id='divCarteFrance'>
		<map name="france-region">
			<area shape="poly" coords="825,628,789,628,740,685,740,782,825,782" href="Region.php?code=94" alt="Error"/>
			<!-- Corse  -->

			<area shape="poly" coords="555,655,591,610,578,583,608,585,628,600,643,589,625,574,665,536,679,535,671,521,673,513,695,512,718,544,715,575,761,591,753,623,691,677,626,674" href="Region.php?code=93" alt="Error"/>
			<!-- Provence Alpes Cote d'azur  -->

			<area shape="poly" coords="552,654,545,647,509,671,500,671,479,700,479,740,416,743,384,724,333,704,328,717,287,717,272,704,294,666,287,643,279,640,281,615,335,608,360,579,385,525,419,530,429,560,447,557,462,533,475,558,486,537,500,531,506,545,522,543,540,585,556,590,572,586,588,610,575,634,568,635,565,644" href="Region.php?code=76" alt="Error"/>
			<!-- Occitanie  -->

			<area shape="poly" coords="268,704,182,656,202,635,231,480,236,410,271,405,254,355,304,341,321,362,340,361,370,409,433,407,453,443,439,454,446,491,437,490,421,526,382,522,334,603,280,612,275,640,287,649,286,672" href="Region.php?code=75" alt="Error"/>
			<!-- Nouvelle Aquitaine  -->

			<area shape="poly" coords="430,554,426,531,440,496,450,496,450,465,446,457,456,446,454,424,439,410,438,401,456,398,456,387,459,382,478,376,487,386,506,388,513,382,519,397,532,404,532,427,557,429,561,418,575,418,578,428,585,427,592,402,604,400,622,418,647,420,658,406,696,404,714,441,722,495,672,511,668,522,678,525,677,532,663,533,626,565,623,577,638,585,640,592,630,597,612,589,610,580,544,580,525,539,502,528,483,532,476,552,464,530,446,552" href="Region.php?code=84" alt="Error"/>
			<!-- Auverge-Rhone-Alpes  -->

			<area shape="poly" coords="393,195,385,206,358,213,364,233,354,244,355,254,354,279,320,308,311,341,323,355,343,354,373,407,434,403,451,395,451,385,481,372,468,294,478,290,482,275,475,260,446,262,448,255,433,247,419,249,397,216" href="Region.php?code=24" alt="Error"/>
			<!-- Centre-Val de Loire  -->

			<area shape="poly" coords="644,416,709,322,698,321,714,306,705,289,653,270,613,307,589,299,591,285,569,271,567,277,530,278,503,242,481,243,477,256,486,272,480,291,471,294,476,311,483,376,513,376,537,399,536,422,556,424,558,414,578,413,592,395,608,395,624,415" href="Region.php?code=27" alt="Error"/>
			<!-- Bourgogne-Franche-Comte  -->

			<area shape="poly" coords="513,187,506,205,510,220,503,239,532,274,581,267,592,295,612,303,629,295,611,302,629,294,654,265,710,287,718,309,732,311,739,300,767,182,685,169,671,147,614,142,579,117,580,107,575,104,580,89,576,88,571,102,562,107,548,107,534,153,515,158" href="Region.php?code=44" alt="Error"/>
			<!-- Grand Est  -->

			<area shape="poly" coords="405,170,393,183,400,206,418,234,420,245,431,241,445,245,451,256,471,257,478,251,478,240,500,238,499,226,506,219,501,219,499,201,485,185,457,182,433,175" href="Region.php?code=11" alt="Error"/>
			<!-- ile-De-France  -->

			<area shape="poly" coords="392,93,409,110,409,168,483,177,503,198,513,187,515,159,534,154,545,109,539,80,509,62,485,39,452,12,403,28" href="Region.php?code=32" alt="Error"/>
			<!-- Hauts-de-France  -->

			<area shape="poly" coords="223,213,228,224,239,218,266,226,295,219,307,234,327,228,331,242,351,252,352,240,360,235,360,226,354,220,354,211,383,205,391,182,399,178,408,120,388,98,323,126,318,141,319,151,300,160,248,152,239,125,207,120,219,158" href="Region.php?code=28" alt="Error"/>
			<!-- Normandie  -->

			<area shape="poly" coords="160,320,164,310,185,305,188,293,222,282,234,286,243,270,249,268,250,227,270,230,294,223,304,238,313,239,322,231,329,243,350,256,351,277,321,302,306,338,250,351,267,405,228,409,197,391,180,360" href="Region.php?code=52" alt="Error"/>
			<!-- Pays de la Loire  -->

			<area shape="poly" coords="247,224,246,265,240,266,233,282,222,278,190,287,166,305,143,300,74,263,60,268,40,247,40,205,84,196,133,187,156,219,174,206,219,213,229,229,237,221" href="Region.php?code=53" alt="Error"/>
			<!-- Bretagne  -->

		</map>
		<img class="map_france" usemap="#france-region" src="./Images/carte_region.jpg" alt="france region test" />
	</div>
	<footer>
		
		<p> Site réalisé par Thibault Béléguic dans le cadre du projet "Weather Forecast" pendant le confinement du COVID-19 | 03/2020 </p>
		<p> Université de Cergy-Pontoise / CY Cergy Paris Université - LPI-WS </p>

	</footer>

	<!--cite réaliser part tibo belgeek dent le cadre dû projets "ouitheur forecaste" réaliser durent le confinemant dû COVIDE-19 | 03/2020 Université Sergi-Pont'oise / CY Sergi Parit Université - LPI-WS - Killian.M 26/03/2020 - 16h57m42s - Discord LPI-WS -> Echange -->

</body>
</html>