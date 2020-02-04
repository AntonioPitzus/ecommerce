<?php
require('stampa_carrello.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <title>Progetto Tecnologie Web</title>
  <link rel="stylesheet" href="themes.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="script.js" type="text/javascript"></script>
  <meta charset="utf-8">
</head>
<body>
  <header id="intestazione">
    <h1> Orologi online </h1>
    <section id="barraNav">
    <nav>
      <ul id="links">
        <li> <a href="home.php">Home</a> </li>
        <li> <a href="catalogo.php">Catalogo</a> </li>
        <li> <a href="carrello.php">Carrello</a> </li>
        <li> <a href="login.php">Login</a> </li>
        <li> <a href="contattami.php">Contattami</a> </li>
      </ul>
      <div id="carrellino-titolo"><?php        echo usaCarrello();        ?></div>
    </nav>
  </section>
  </header>
    <main id="mainHome">
      <header>
        <h2>Contattami</h2>
      </header>
      <section id="contattami" class="forms">
        <fieldset class="fset">
          <legend>Inserisci i tuoi dati e un commento</legend>
      <form class="inserimento" method="post">
        <div style="padding-bottom: 15px"><label>
          <input id="ins_nome" type="text" name="nome" placeholder="Nome" required>
        </label>
        <label>
          <input id="ins_email" type="email" name="email" placeholder="Email" required>
        </label></div>
        <div style="padding-bottom: 15px"><label>
          <textarea id="ins_commento" name="commento" placeholder="Inserisci il tuo commento" style="width: 60%; height: 150px; resize:none" required></textarea>
        </label></div>
        <input id="ins_submit" type="submit" value="Invia">
      </form>
    </fieldset>
    </section>
  </main>
  <footer>
    <address><a href="contattami.php">Contattaci</a></address>
    <p>Progetto Tecnologie Web 2015/2016 | Martin Ruini - Francesco Dicara - Antonio Pitzus</p>
  </footer>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $commento = $_POST['commento'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "vendita_orologi";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $orologio = "INSERT INTO commenti (nome, email, commento)
               VALUES ('$nome', '$email', '$commento')";


  if (mysqli_query($conn, $orologio)) {

  }
  else {
    echo "Error: ". "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
}
?>
</html>
