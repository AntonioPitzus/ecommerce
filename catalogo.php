<?php session_start();
  require('stampa_carrello.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
<title>Progetto Tecnologie Web</title>
<link rel="stylesheet" href="../orologio/themes.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="../orologio/script.js" type="text/javascript"></script>
  <meta charset="utf-8">
  <script>
  $(function(){
  if(location.hash.match(/#ricerca/)){
    $("#searchResult").css("display", "block");
  }
  else{
    $("#searchResult").css("display", "none");
  }
  });
</script>
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
<section id="sezioneRicerca">
<img id="searchImage" src="risorse/search.jpg" alt="Icona lente d' ingrandimento">
<form id="searchForm" method="post">
<label>Ricerca<input id="search_value" type="text" name="search_value" size="30" maxlength="30" placeholder="Marca, modello, descrizione.." autocomplete="off" required></label>
<input id="searchSubmit" type="submit" name="SEARCH" value="search">
</form>
</section>
<div id="corpo">
  <header id="headerCat">
    <h2>Catalogo</h2>
  </header>
<div id="filtro">
  <section id="sezioneFiltro">
    <form id="formFiltro" method="post">
      <section>
      <fieldset>
      <legend>Ordina per prezzo:</legend>
                <label><input id="prezzoCrescente" name="opzione" type="radio" value="prezzoCrescente">Crescente<br></label>
                <label><input id="prezzoDecrescente" name="opzione" type="radio" value="prezzoDecrescente">Decrescente<br></label>
      </fieldset><br>
      <fieldset>
    <legend>Ordina per data:</legend>
            <label><input id="dataRecente" name="opzione" type="radio" value="idHigh">Dal piu recente<br></label>
            <label><input id="dataVecchio" name="opzione" type="radio" value="idLow">Dal piu vecchio</label>
      </fieldset>
    </section><br>
    <section>
      <fieldset>
      <legend>Seleziona sesso:</legend>
      <label><input id="maschio" name="sesso" type="radio" value="uomo">Maschio<br></label>
      <label><input id="femmina" name="sesso" type="radio" value="donna">Femmina<br></label>
      </fieldset>
    </section><br>
    <section>
      <fieldset>
      <legend>Seleziona prezzo:</legend>
      Min <label><input id="min" name="min" type="text" value="" size="5" maxlength="5"> €<br></label>
      Max <label><input id="max" name="max" type="text" value="" size="5" maxlength="5"> €</label>
      </fieldset>
    </section><br>
      <input id="submitForm" name="submit" type="submit" value="Ordina">
        <input id="default" type="button" name="default" value="Default">
  </form>
  </section>
</div>
<div id="searchResult">
  <input id="closeSearch" type="button" value="Chiudi">
<?php
  $mysqli_db = new mysqli('localhost', 'root', '', 'vendita_orologi');
  if (!empty($_POST['SEARCH']) && !empty($_POST['search_value'])) {
     $e = $_POST['search_value'];
     $query = 'SELECT * FROM orologio WHERE ' .
             "marca LIKE '%$e%' OR " .
             "modello LIKE '%$e%' OR " .
             "descrizione LIKE '%$e%' ";

     $query_result = $mysqli_db->query($query);
     $count = $query_result->num_rows;

     if($count == 0){
       echo "<h1>Nessun risultato trovato</h1>";
     }
     else if($count == 1){
       echo "<h1 class='altro'>Trovato ".$count." risultato</h1>";
     }
     else{
          echo "<h1 class='altro'>Trovati ".$count." risultati</h1>";
     }

     $count = 0;
     $rownum=0;
     $flag = 0;
     while ($row = mysqli_fetch_array($query_result)) {
       $flag = 1;
       if($count==0){
         echo "<div class='row'>";
       }
       echo "<figure class='gr figCat'><img alt='".$row["marca"]."".$row["modello"]."' src=".$row["immagine"]." alt=''><figCaption><b>".$row["marca"]."</b>:  "
             .$row["modello"]."</figCaption><p class='prezzo' hidden>".$row["prezzo"]."</p><p class='descr' hidden>".$row["descrizione"]."</p>
             <p class='id' hidden>".$row["id"]."</p></figure>";
       $count++;
       if($count==3){
         echo "</div>";
         $rownum++;
         $count = 0;
       }
     }
     if($flag && $count > 0 && $count < 3){
       echo "</div>";
     }

     $mysqli_db->close();
  }
?>
  </div>
  <div id="risultato"><p>Articolo aggiunto correttamente</p></div>
  <main id="mainCat">
    <section id="detailSec">
    <input id="detailCarrello" type="button" value="Aggiungi al carrello">
        <input id="closeDetail" type="button" value="Chiudi">
        <h3 id="titoloDettaglio">Titolo</h3>
    <figure id="detail">
      <img src="" alt="alt">
      <figcaption></figcaption>
    </figure>
    <p id="detailId" hidden></p>
  </section>
  </main>
<div id="corpoCatalogo">
  <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "vendita_orologi";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $per_page = 12;
    $start = 0;

    if(!isset($_GET['page'])){

        $page = 1;
    }
    else{
      $page = $_GET['page'];
    }

    if($page <= 1){
        $start = 0;
    }
    else{
      $start = $page * $per_page - $per_page;
    }

  $_SESSION["min"]=0;
  $_SESSION["max"]=1000000;
  if (empty($_POST['SEARCH']) && empty($_POST['search_value'])) {

    if($_SERVER["REQUEST_METHOD"] == "POST"){

     if(isset($_POST["opzione"])){
        $_SESSION["options"] = $_POST["opzione"];
      }
      else{
        $_POST["opzione"] = "default";
        $_SESSION["options"] = $_POST["opzione"];
      }
      if(isset($_POST["min"]) && !empty($_POST["min"])){
          $_SESSION["min"] = $_POST["min"];
          $min =  $_SESSION["min"];
      }
     else{
        $_POST["min"] = 0;
        $_SESSION["min"] = $_POST["min"];

      }
      if(isset($_POST["max"]) && !empty($_POST["max"])){
          $_SESSION["max"] = $_POST["max"];
          $max =  $_SESSION["max"];
      }
     else{
        $_POST["max"] = 1000000;
        $_SESSION["max"] = $_POST["max"];

      }
      if(isset($_POST["sesso"])){
        $_SESSION["sesso"] = $_POST["sesso"];
      }
      else{
        $_POST["sesso"] = "default";
        $_SESSION["sesso"] = $_POST["sesso"];
      }
      echo '<script>$(function(){$("#searchResult").hide();});</script>';
    }
  }
  $min =  $_SESSION["min"];
  $max =  $_SESSION["max"];
       $sql = "SELECT * FROM orologio WHERE prezzo >= $min && prezzo <= $max";

    if(isset($_SESSION["sesso"])){
    switch($_SESSION["sesso"]){
      case 'uomo':
        $sql = "SELECT * FROM orologio WHERE prezzo >= $min && prezzo <= $max && genere = 'uomo'";
        $sql2 = $sql." LIMIT $start, $per_page";

      break;

      case 'donna':
      $sql = "SELECT * FROM orologio WHERE prezzo >= $min && prezzo <= $max && genere = 'donna'";
      $sql2 = $sql." LIMIT $start, $per_page";
      break;

      default:
      $sql2 = $sql." LIMIT $start, $per_page";
      break;
    }
  }else{
    $sql2 = $sql." LIMIT $start, $per_page";
    $selected = "default";
  }


  if(isset($_SESSION["options"])){
    switch($_SESSION["options"]){
      case 'prezzoCrescente':
        $sql2 = $sql." ORDER BY prezzo ASC LIMIT $start, $per_page";
      break;

      case 'prezzoDecrescente':
        $sql2 = $sql." ORDER BY prezzo DESC LIMIT $start, $per_page";
      break;

        case 'idHigh':
          $sql2 = $sql." ORDER BY id DESC LIMIT $start, $per_page";
        break;

        case 'idLow':
          $sql2 = $sql." ORDER BY id ASC LIMIT $start, $per_page";
        break;

        default:
          $sql2 = $sql." LIMIT $start, $per_page";
        break;
      }
    }
  else{
    $sql2 = $sql." LIMIT $start, $per_page";
    $selected = "default";
  }

    $num_rows = mysqli_num_rows(mysqli_query($conn, $sql));
    $num_pages = ceil($num_rows / $per_page);
    $result = mysqli_query($conn, $sql2);

    $count = 0;
    $rownum=0;
    while($row = mysqli_fetch_array($result)){
      if($count==0){
        echo "<div class='row'>";
      }
      echo "<figure class='gr figCat'><img alt='".$row["marca"]."".$row["modello"]."' src=".$row["immagine"]."><figCaption><b>".$row["marca"]."</b>: "
            .$row["modello"]."</figCaption><p class='prezzo' hidden>".$row["prezzo"]."</p><p class='descr' hidden>".$row["descrizione"]."</p>
            <p class='id' hidden>".$row["id"]."</p></figure>";
      $count++;
      if($count==4){
        echo "</div>";
        $rownum++;
        $count = 0;
      }
      if($rownum==3){
        $rownum = 0;
      }
    }


    if($num_pages == 1){}
    else{
      $prev = $page - 1;
      $next = $page + 1;
      echo "<hr>";

      if($prev > 0){
        echo " <a class='altro' href='?page=$prev'> prev </a> ";
      }

      for($i = 1; $i <= $num_pages; $i++){
        echo "<a class='pagine' href='?page=$i'> $i </a> ";
      }

      if($next <= $num_pages){
        echo " <a class='altro' href='?page=$next'> next </a>";
      }
    }
    mysqli_close($conn);
  ?>
</div>
</div>
<footer>
  <address><a href="contattami.php">Contattaci</a></address>
  <p>Progetto Tecnologie Web 2015/2016 | Martin Ruini - Francesco Dicara - Antonio Pitzus</p>
</footer>
</body>
</html>
