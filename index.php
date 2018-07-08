<?php
	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: admin.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Panel administracyjny kina</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
	<div class="powitanie">
	<?php
		echo "<p><h2>Witaj ".$_SESSION['user'].'! </h2>[<a href="logout.php">Wyloguj się!</a>]</p>' ;
	?>
	</div>	
	<div class="rejestracja">
			<a href="rejestacja.php">Rejestracja nowego pracownika</a>
	</div>
	<br/><br/><br/>
	<div id="nav">
		<ul>
		  <li><a href="editmovie/filmy_adm.php" target="blank">Edycja repertuaru</a></li>
		  <li>Edycja sal 1</li>
		  <li>Edycja sal 2</li>
		  <li>Edycja widzów</li>
		</ul>
	</div>
	<div id="container">
	test
	</div>
	<div style="clear: both;"></div>
	
		
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>