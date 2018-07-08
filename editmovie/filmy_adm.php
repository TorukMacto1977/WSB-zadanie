<?php
	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../admin.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Edycja repertuaru</title>
	<link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
<br/><br/><br/><br/><br/>
	<div class="okienko">
	<p> Sala 1 </p>
		<form enctype="multipart/form-data" action="hall1.php" 
				 method="post" >
		<input type="hidden" name="MAX_FILE_SIZE" value="512000" />
		<input type="file" name="obrazek" />
		<input type="submit" value="wyślij" />
		</form>
	</div><br/>
	<div class="okienko">
	<p> Sala 2 </p>
		<form enctype="multipart/form-data" action="hall2.php" 
				 method="post" >
		<input type="hidden" name="MAX_FILE_SIZE" value="512000" />
		<input type="file" name="obrazek" />
		<input type="submit" value="wyślij" />
		</form>
	</div>

	
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>