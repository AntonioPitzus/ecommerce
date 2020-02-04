<!DOCTYPE html>
<html lang="it">
<head>
  <title>Progetto Tecnologie Web</title>
  <link rel="stylesheet" href="themes.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="script.js" type="text/javascript"></script>
  <meta charset="utf-8">
  <script>
  $(function(){
    $("#welcome").html("Benvenuto, " + $("#currentUser").html());
  });
  </script>
</head>
<body>
  <header id="intestazione">
    <h1> Orologi online </h1>
    <section id="barraNav">
    <section id="sectionAdmin">
      <p id="welcome"></p>
      <input id="logout" type="button" value="logOut">
    </section>
    <nav>
      <ul id="links">
        <li> <a href="home.php">Home</a> </li>
        <li> <a href="catalogo.php">Catalogo</a> </li>
        <li> <a href="carrello.php">Carrello</a> </li>
        <li> <a href="login.php">Login</a> </li>
        <li> <a href="contattami.php">Contattami</a> </li>
      </ul>
    </nav>
  </section>
  </header>
  <main id="loginMain">
    <header><h2 id="loginHeader">Login</h2></header>
    <section id="login">
    <h3>Immetti i tuoi dati:</h3>
    <form class="inserimento forms" name="submitlogin" method="post">
      <label id="user"><b>Username</b>
      <input type="text" name="user" placeholder="username..." required>
    </label>
    <label id="password"><b>Password</b>
      <input type="password" name="pass" placeholder="password..." required>
    </label>
    <p id="err_login" hidden>Username o password errati</p>
    <input id="access" type="submit" value="Login">
    </form>


</section>
<section id="ins_compl">
  <p>Prodotto Inserito correttamente</p>
</section>
<section id="adminMain" hidden>
  <section id="inserimentoProdotto">
    <form class="inserimento forms" method="post">
    <label>Marca:
      <input id="ins_marca" type="text" name="marca" placeholder="marca.." required>
    </label>
    <label>Nome modello:
      <input id="ins_modello" type="text" name="modello" placeholder="modello.." required>
    </label>
    <label>Prezzo:
      <input id="ins_prezzo" type="number" name="prezzo" placeholder="prezzo.." required>
    </label>
    <label>Anno Produzione:
      <input id="ins_anno_prod" type="number" name="anno" placeholder="anno.." required>
    </label>
    <label>Genere:
      <select id="ins_genere" name="genere">
         <option value="uomo">Uomo</option>
         <option value="donna">Donna</option>
        </select>
    </label>
    <label>Descrizione:
      <textarea id="ins_desc" name="descr" placeholder="descrizione.." required></textarea>
    </label>
    <label>Immagine:
      <input id="ins_img" type="file" name="immagine" required>
    </label>
    <input id="ins_submit" type="submit" value="Inserisci">
  </form>
</section>
</section>
  </main>
  <footer>
    <address><a href="contattami.php">Contattaci</a></address>
    <p>Progetto Tecnologie Web 2015/2016 | Martin Ruini - Francesco Dicara - Antonio Pitzus</p>
  </footer>
</body>
<?php
if(isset($_COOKIE["loggedIn"])){
  echo '<script>$(function(){$("#login").hide();$("#adminMain,#sectionAdmin").show();});</script>';
  echo "<p id='currentUser' hidden>".$_COOKIE['loggedIn']."</p>";
  echo "<script>$('#loginHeader').html('Inserisci prodotto')</script>";
}else{
  echo "<script>$('#loginHeader').html('Login')</script>";
}

$trov=0;

  if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_COOKIE["loggedIn"])){
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "vendita_orologi";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $admin = "SELECT * FROM amministratore WHERE username = '$user' AND password = '$pass' ";

    $result = mysqli_query($conn, $admin);

    if (mysqli_num_rows($result) > 0) {
        $trov=1;
        setcookie("loggedIn", $user);
    } else {
        echo '<script>$(function(){$("#err_login").slideDown();$("#err_login").fadeTo(5000,0.01);$("#err_login").slideUp(250)});</script>';
    }
    mysqli_close($conn);

    if($trov == 1){
      header('location: http://localhost/orologio/login.php');
  }
  }else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_COOKIE["loggedIn"])){

    $marca = $_POST['marca'];
    $modello = $_POST['modello'];
    $prezzo = $_POST['prezzo'];
    $anno = $_POST['anno'];
    $descr = $_POST['descr'];
    $genere = $_POST['genere'];
    $immagine = "/orologio/risorse/".$_POST['immagine'];


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "vendita_orologi";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $orologio = "INSERT INTO orologio (marca, modello, prezzo, descrizione, immagine, anno_produzione, venduto, genere)
                 VALUES ('$marca', '$modello', '$prezzo', '$descr', '$immagine', '$anno', 0, '$genere')";


    if (mysqli_query($conn, $orologio)) {
      echo "New record created successfully";
    }
    else {
      echo "Error: ". "<br>" . mysqli_error($conn);
    }

    echo '<script>$(function(){$("#ins_compl").show().fadeOut(2000);});</script>';

    mysqli_close($conn);
  }

?>

</html>
