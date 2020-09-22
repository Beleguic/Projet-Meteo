<?php

	function checkPassword($oldPassword,$id){
		$oldPassword = hash('sha256', $oldPassword);

		$fichier = fopen('./info/info.csv', 'r');

		while (!feof($fichier)){
			$line = fgets($fichier);
			$password = explode(';', $line);
			$name = rtrim($password[3]);
			$password = rtrim($password[4]);
			if ($oldPassword == $password && $id == $name){
				return true;
			}
		}
		return false;
	}

	function checkMail($mail,$id){
		$fichier = fopen('./info/info.csv', 'r');

		while (!feof($fichier)){
			$line = fgets($fichier);
			$checkmail = explode(';', $line);
			$name = rtrim($checkmail[3]);
			$checkmail = rtrim($checkmail[2]);
			if ($mail == $checkmail && $id == $name){
				return true;
			}
		}
		return false;
	}

	function changePassword($new,$mail){
		$passwd = hash('sha256', $new);

		$id = $_SESSION['name'];

		$fichier = fopen('./info/info.csv', 'r');

		$newFichier = array();

		while ($line = fgets($fichier)){
			$line = explode(';', $line);

			if ($id == $line[3] && $mail == $line[2]){
				$chaine = $line[0] . ";" . $line[1] . ";" . $mail . ";" . $id . ";" . rtrim($passwd) . ";";
				array_push($newFichier, $chaine);
			}
			else{
				$chaine = rtrim($line[0]) . ";" . rtrim($line[1]) . ";" . rtrim($line[2]) . ";" . rtrim($line[3]) . ";" . rtrim($line[4]) . ";";
				array_push($newFichier, $chaine);
			}

		}
		fclose($fichier);
		$fichier = fopen('./info/info.csv', 'w');
		for ($k = 0; $k < sizeof($newFichier); $k++){
			fputs($fichier, $newFichier[$k] . "\n");
		}
		fclose($fichier);
		header("Location: compte.php");
	}



	$id = $_SESSION['name'];
	$mail = checkMail($_POST['mail'],$id);
	$pwd = checkPassword($_POST['oldPwd'],$id);
	
	if (!($mail)){
			header('Location: compte.php?error=2');
		}
	else{
		if (!($pwd)){
			header('Location: compte.php?error=1');
			}
		else{
			changePassword($_POST['newPwd1'],$_POST['mail']);
		}
	}

?>

</body>
</html>