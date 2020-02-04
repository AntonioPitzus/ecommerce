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
      <div id="carrellino-titolo"><?php echo usaCarrello(); ?></div>
    </nav>
  </section>
  </header>
  <div id="corpo">
    <main id="mainHome">
      <header>
        <h2>Novità</h2>
      </header>
      <section id="nuovoProdotto">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "vendita_orologi";
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $orologio = "SELECT * FROM orologio ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $orologio);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $nome = "<h2 id='titoloNuovoProdotto'>".$row["marca"]."<br/>".$row["modello"]."</h2>";
            $prezzo = "<b>Prezzo: </b>".$row["prezzo"]."€<br/><br/>";
            $desc = "<figcaption id='descrizioneNuovoProdotto'>".$prezzo.$row["descrizione"]."</figcaption></figure>";
            $var = "<figure><img id='imgNuovoProdotto' alt='".$row["marca"]."".$row["modello"]."' src=" .$row["immagine"].  ">";
            $id = "<p id='idNuovoProdotto' hidden>".$row["id"]."</p>";
            $aggiunto = "<div id='risultato'><p>Articolo aggiunto correttamente</p></div>";
            $tasti = "<section id='tasti'><input id='info' type='button' value='Maggiori Informazioni'><input id='homeAggiungi' type='button' value='Aggiungi al carrello'></section>";
            echo $nome.$var.$desc.$id.$aggiunto.$tasti;
            }
         else {
            echo "0 results";
        }
        mysqli_close($conn);
        ?>
      </section>
    </main>

    <section id="prodPiuVenduti">
      <header>
        <h2>Prodotti pi&ugrave; venduti</h2>
      </header>
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "vendita_orologi";
      $conn = mysqli_connect($servername, $username, $password, $dbname);

      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $orologio = "SELECT * FROM orologio ORDER BY venduto DESC LIMIT 9 ";
      $result = mysqli_query($conn, $orologio);

      if (mysqli_num_rows($result) > 0) {
          for($i=0; $i<3; $i++) {
            echo "<div id='row".$i."'>";
            for($j=0; $j<3; $j++){
            $row = mysqli_fetch_assoc($result);
            $var = "<figure id=".$row["id"]." class='gr grHome'>
                    <img src=".$row["immagine"]." alt='".$row["marca"]."".$row["modello"]."'><figCaption><b>".$row["marca"]."</b>:  ".$row["modello"]."</figCaption></figure>";
              echo $var;
            }
            echo "</div>";
          }
      } else {
          echo "0 results";
      }

      mysqli_close($conn);
      ?>

    </section>
  </div>
  <footer>
    <address><a href="contattami.php">Contattaci</a></address>
    <p>Progetto Tecnologie Web 2015/2016 | Martin Ruini - Francesco Dicara - Antonio Pitzus</p>
  </footer>
</body>
</html>
