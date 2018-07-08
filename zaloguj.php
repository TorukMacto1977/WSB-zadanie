<?php

	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: admin.php');
		exit();
	}

	require_once "connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		//polaczenie z baza danych
	$login = $_POST['login'];
	$haslo = $_POST['haslo'];
	
	// obrona przed SQL injection
	$login = htmlentities($login, ENT_QUOTES, "UTF-8" );
	

		if($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
		mysqli_real_escape_string($polaczenie, $login))))
		{	
			//czy dany użytkownik istnieje w bazie
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				//weryfikacja haszowanego hasla
				if(password_verify($haslo, $wiersz['pass']))
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['user'] = $wiersz['user'];
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: panel.php');
				}
				else {
				$_SESSION['blad'] = '<span style="color:red"> Złe dane logowania</span>';
				header('Location: admin.php');
				}
				
			} 
			else {
				$_SESSION['blad'] = '<span style="color:red"> Złe dane logowania</span>';
				header('Location: admin.php');
			}
		}
		
	$polaczenie->close();
	}
		
?>