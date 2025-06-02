<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>admin leht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body>
  <?php
	//echo password_hash('admin', PASSWORD_DEFAULT);
	session_start();
	if (isset($_SESSION['tuvastamine'])) {
	  header('Location: admin.php');
	  exit();
	  }
	  include("config.php");


	  	if (!empty($_POST['login']) && !empty($_POST['pass'])) {
			$login = $_POST['login'];
			$pass = $_POST['pass'];
			
		

		$paring = "SELECT * FROM users";
	  	$saada_paring = mysqli_query($yhendus, $paring);
	  	$rida = mysqli_fetch_assoc($saada_paring);
	  	$s = $rida["password"];
			var_dump (password_verify($pass, $s ));

		if ($login == 'admin' && password_verify($pass, $s )) {
			echo "tere admin";
			$_SESSION['tuvastamine'] = 'mida';
			header('Location: admin.php');
			exit();
		}
		else{
			echo"vale kasutaja nimi";
		}
	}

?>
<h1>Login</h1>
<form action="" method="post">
	Login: <input type="text" name="login"><br>
	Password: <input type="password" name="pass"><br>
	<input type="submit" value="Logi sisse">
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>