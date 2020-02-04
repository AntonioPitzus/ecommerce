<?php
session_start();
require('stampa_carrello.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <title>Progetto Tecnologie Web</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="script.js" type="text/javascript"></script>
  <link rel="stylesheet" href="themes.css"/>
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
  <div id="corpo">
    <main>
      <header>
        <h2 id="h2">Carrello</h2>
      </header>
      <section id="carrello">
        <?php
        if(isset($_GET['action']))
        {
          $action = $_GET['action'];
          echo mostraDiv($action);
        }
        ?>

        <?php
        echo mostraCarrello();
        ?>
      </section>
      <?php
      if(isset($_COOKIE['carrello'])){
        $carrello=$_COOKIE['carrello'];
      }
      else{
        $carrello=null;
      }
      if($carrello){

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "vendita_orologi";
      $conn = mysqli_connect($servername, $username, $password, $dbname);

      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      $prodotti = explode(',',$carrello);
      $quanti = count($prodotti);
      $acquisti = array();
      foreach ($prodotti as $prodotto)
      {
        $acquisti[$prodotto] = (isset($acquisti[$prodotto])) ? $acquisti[$prodotto] + 1 : 1;
      }
      $result[]='<div id="div-tabella-carrello">';
      $result[] = '<table id="tabella-carrello" class="tabella-carrello">';
      $result[]='<thead>
      <tr class="sezioni-tabella">
          <th class="nome">I tuoi articoli</th>
          <th class="nome">&nbsp;</th>
          <th class="nome">Prezzo</th>
          <th class="nome">Qta</th>
      </tr></thead>
      <tbody>';
      $somma = 0;
      foreach ($acquisti as $id=>$quantita)
      {
        $orologio = 'SELECT * FROM orologio WHERE id = '.$id;
        $res = mysqli_query($conn, $orologio);
        $f = mysqli_fetch_assoc($res);
        extract($f);
        $result[] = '<tr class="prodotto">';
        $result[]='<td class="image-cell">
                <img src="'.$immagine.'" width="85" height="85" alt="'.$modello.'"/>
                </td>';
        $result[] = '<td><h2>'.$modello.'</h2>
            <div class="dettagli">
                    ID prodotto: '.$id.' | Marca: '.$marca.'
            </div>
        </td>';
        $result[] = '<td class="prezzo">&euro;'.$prezzo.' </td>';
        $result[] = '<td class="quantita">'.$quantita.'</td>';
        $somma += $prezzo * $quantita;
        $result[] = '</tr>';
      }
      $result[] = '</tbody><tfoot>';
      $result[] = '<tr>';
      $result[] = '<td></td><td class="totale"> Totale: </td><td class="prezzo"><b>&euro;'.$somma.'</b></td><td></td></tr>';
      $result[] = '</tfoot></table></div>';
   $result[]=' <div id="errore"><p>Compila correttamente tutti i campi!</p></div><div id="dati" class="forms" > <fieldset class="campi-acquisto" >
     <legend>Inserisci i tuoi dati per la spedizione</legend>

       <div style="padding-bottom: 15px"><label>
         <input id="ins_nome" type="text" name="nome" placeholder="Nome" >
         </label>
         <label>
         <input id="ins_cognome" type="text" name="cognome" placeholder="Cognome" >
       </label></div>
       <div style="padding-bottom: 15px"><label>
         <input id="ins_via" type="text" name="via" placeholder="Via, piazza.. e numero civico" >
         </label>
         <label>
         <input id="ins_citta" type="text" name="citta" placeholder="Città" >
         </label>
         <label>
         <input id="ins_cap" type="text" name="cap" placeholder="CAP"  pattern="[0-9]{5}" >
       </label></div>
       <div style="padding-bottom: 15px"><label>
         <input id="ins_email" type="email" name="email" placeholder="Email" >
         </label>
         <label>
         <input id="ins_telefono" type="text" name="phone" placeholder="Numero di telefono" pattern="[0-9]{10}" >
       </label></div>
       <a href="carrello.php"><input id="annulla" type="button" value="Annulla ordine"></a>
       <input id="acquista-button" type="button" value="Acquista">

   </fieldset></div> ';

      echo join('',$result);
    }
      ?>
    </main>
  </div>
  <footer>
    <address><a href="contattami.php">Contattaci</a></address>
    <p>Progetto Tecnologie Web 2015/2016 | Martin Ruini - Francesco Dicara - Antonio Pitzus</p>
  </footer>
</body>
</html>
