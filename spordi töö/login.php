<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<style>
   .btn-color{
  background-color: #0e1c36;
  color: #fff;
  
}

.profile-image-pic{
  height: 200px;
  width: 200px;
  object-fit: cover;
}



.cardbody-color{
  background-color: #ebf2fa;
}

a{
  text-decoration: none;
}

</style>  
</head>
  <body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
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
        <h2 class="text-center text-dark mt-5">Login sisse</h2>
        <div class="card my-5">
          <form class="card-body cardbody-color p-lg-5" method="post">
            <div class="mb-3">
              <input type="text" class="form-control" name="login" aria-describedby="emailHelp"
                placeholder="Kasutaja">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" name="pass" placeholder="Parool">
            </div>
            <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100">Login</button></div>
            <div class="form-group d-md-flex">
                <div class="w-50">
                    <label class="checkbox-wrap checkbox-primary">Mäleta mind
                        <input type="checkbox" checked name="remember">
                        <span class="checkmark"></span>
                    </label>
                </div>
	            </div>
          </form>
        </div>

      </div>
    </div>
  </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>