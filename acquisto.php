<?php
// Start the session
session_start();
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
        <div id="carrellino-titolo"><?php        echo usaCarrello();        ?></div>
      </ul>
    </nav>
  </section>
</header>

<main>
  <header>
    <h2 id="h2">Inserimento dati acquirente</h2>
  </header>
  <?php
  if(isset($_COOKIE['carrello'])){
    $carrello=$_COOKIE['carrello'];
  }
  else{
    $carrello=null;
  }
  if (!$carrello)
  {
    $result[]='<div>

        <p>Carrello vuoto. Non puoi procedere ad acquistare! <a href="catalogo.php" title="Catalogo">Visita il nostro catalogo</a></p>
    </div>';
    echo join('',$result);
  }else{
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
    $result[] = '<table id="tabella-carrello">';
    $result[]='<thead>
    <tr class="sezioni-tabella">
        <th class="nome">Stai acquistando i seguenti articoli</th>
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
    $result[] = '<td class="totale"> Totale: </td><td></td><td class="prezzo"><b>&euro;'.$somma.'</b></td></tr>';
    $result[] = '</tfoot></table></div>';
 $result[]='  <div id="errore"><p>Compila tutti i campi!</p></div><div id="dati" class="forms" style="width: 100%"> <fieldset class="fset" >
   <legend><h2>Inserisci i tuoi dati per la spedizione</h2></legend>

     <label>Nome:
       <input id="ins_nome" type="text" name="nome" required>
     </label>
     <label>Cognome:
       <input id="ins_cognome" type="text" name="cognome" required>
     </label>
     <label>Via e numero civico:
       <input id="ins_via" type="text" name="via" required>
     </label>
     <label>Città
       <input id="ins_citta" type="text" name="citta" required>
     </label>
     <label>CAP:
       <input id="ins_cap" type="text" name="cap" required>
     </label>
     <label>Email:
       <input id="ins_email" type="email" name="email" required>
     </label>
     <label>Telefono:
       <input id="ins_telefono" type="tel" name="phone" required>
     </label>
     <form action="carrello.php"><input id="annulla" type="submit" value="Annulla ordine"></form>
     <input id="ins_submit" type="button" value="Acquista">

 </fieldset></div>';

    echo join('',$result);
  }?>

</main>
<footer>
  <address><a href="contattami.php">Contattaci</a></address>
  <p>Progetto Tecnologie Web 2015/2016 | Martin Ruini - Francesco Dicara - Antonio Pitzus</p>
</footer>
</body>
</html>
</body>

</html>
