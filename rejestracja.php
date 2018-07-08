<?php
	session_start();
	
	if (isset($_POST['email'])) 
	{
		//udana walidacja - tak
		$wszystko_OK=true;
		
		//sprawdzenie	nicka
		$nick = $_POST['nick'];
			
		//sprawdzenie dł nicka
		if((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESION['e_nick']="Nick musi posiadać od 3 do 20 znaków";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESION['e_nick']="Nick może się sładać tylko z liter i cyfr (bez polskich znaków)";
		}
		// sprawdzenie poprawności adresu email
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($email!=$emailB))
		{
			$wszystko_OK=false;
			$_SESION['e_email']="Podaj poprawny adres email";
		}			
		
		//sprawdzenie poprawności hasła
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków";
		}
		
		if($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESION['e_haslo']="Podane hasła nie są identyczne";
		}
		
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//akceptacja regulaminu
		if(!isset($_POST['regulamin']))
			{
				$wszystko_OK=false;
				$_SESION['e_regulamin']="Zaakceptuj regulamin";
			}
		//weryfikacja captcha
		$secret = "6Lc3zGIUAAAAAGtIYu5F2U27_TW13hnIvjXwGhj_";
		
		$check = file_get_contents('https://google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($check);
		
		if($odpowiedz->success==false)
			{
				$wszystko_OK=false;
				$_SESION['e_bot']="Potwierdź że nie jesteś botem";
			}
		require_once "connect.php";
		
		//mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0)
			{
				throw new Exeption(mysqli_connect_errno());
			}
			else
			{
				//czy użytkownik już istnieje
			//	$rezultat = $polaczenie->querry("SELECT id FROM uzytkownicy WHERE email= '$email'");
			//	if(!$rezultat) throw new Exeption($polaczenie->error);
				
			//	$ile_takich_maili = $rezultat->num_rows;
			//	if($ile_takich_maili>0)
			//	{
			//		{
			//		$wszystko_OK=false;
			//		$_SESION['e_email']="Istnieje już konto do tego adresu e-mail!";
			//		}
			//	}
				
				$polaczenie->close();
			}
		}
		catch(Exeption $e)
		{
			echo '<span style="color:red;" Błąd serwera</span>';
			//echo '<br/> Informacja o błędzie: '.$e;
		}
		
		
		if($wszystko_OK==true)
		{
			//Dodawanie gracza
			echo "Udana walidacja"; exit();
		}
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Rejestracja</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>
		.error
		{
			color: red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	
	</style>
	
</head>

<body>

	<form method="post">
	
		Nickname: <br/> <input type="text" name="nick" /><br/>
		<?php
			if (isset($_SESION['e_nick']))
			{
				echo '<div class="error">'.$_SESION['e_nick'].'</div>';
				unset($_SESION['e_nick']);
			}
		?>
		E-mail: <br/> <input type="text" name="email" /><br/>
		<?php
			if (isset($_SESION['e_email']))
			{
				echo '<div class="error">'.$_SESION['e_email'].'</div>';
				unset($_SESION['e_email']);
			}
		?>
		Twoje hasło: <br/> <input type="pasword" name="haslo1" /><br/>
		<?php
			if (isset($_SESION['e_haslo']))
			{
				echo '<div class="error">'.$_SESION['e_haslo'].'</div>';
				unset($_SESION['e_haslo']);
			}
		?>
		
		Powtórz hasło: <br/> <input type="pasword" name="haslo2" /><br/><br/>
		<label>
		<input type="checkbox" name="regulamin" />Akceptuję regulamin
		</label>
		<?php
			if (isset($_SESION['e_regulamin']))
			{
				echo '<div class="error">'.$_SESION['e_regulamin'].'</div>';
				unset($_SESION['e_regulamin']);
			}
		?>
		<div class="g-recaptcha" data-sitekey="6Lc3zGIUAAAAACLr_rXXdPqgozgV8HLL4Dvktagi"></div>
				<?php
			if (isset($_SESION['e_bot']))
			{
				echo '<div class="error">'.$_SESION['e_bot'].'</div>';
				unset($_SESION['e_bot']);
			}
		?>
		
		<br/>
		<input type="submit" value="Zarejestruj się" />
	
	</form>
	<br/><br/>
	<a class="nav-link" href="../views/index.hjs">Powrót do strony głównej</a>
	
</body>
</html>