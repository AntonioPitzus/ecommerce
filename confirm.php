<?php

session_start();

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "vendita_orologi";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  $carrello=$_COOKIE['carrello'];
  $prodotti = explode(',',$carrello);
  $quanti = count($prodotti);
  $acquisti = array();
  foreach ($prodotti as $prodotto)
  {
    $acquisti[$prodotto] = (isset($acquisti[$prodotto])) ? $acquisti[$prodotto] + 1 : 1;
  }
  $somma = 0;
  foreach ($acquisti as $id=>$quantita)
  {
    $orologio = 'SELECT * FROM orologio WHERE id = '.$id;
    $res = mysqli_query($conn, $orologio);
    $f = mysqli_fetch_assoc($res);
    extract($f);
    $somma += $prezzo * $quantita;
    $new=$venduto+$quantita;
    $orologio2 = 'UPDATE orologio SET venduto='.$new.' WHERE id = '.$id;
    mysqli_query($conn, $orologio2);
  }

  $sessione=$_SESSION["acquisto_orologi"];
  $dati = explode(',',$sessione);
  $nome=$dati[0];
  $cognome=$dati[1];
  $via=$dati[2];
  $citta=$dati[3];
  $CAP=$dati[4];
  $email=$dati[5];
  $telefono=$dati[6];
  $ordine = "INSERT INTO ordine (id_acquistati, spesa_totale, nome, cognome, via, citta, CAP, email, telefono)
               VALUES ('$carrello', '$somma', '". addslashes($nome) ."', '". addslashes($cognome) ."', '". addslashes($via) ."', '". addslashes($citta) ."', '$CAP', '$email', '$telefono')";


  if (mysqli_query($conn, $ordine)) {
    $result=' Pagamento avvenuto con successo. Grazie per il tuo acquisto!';
  }
  else {
    echo "Error: ". "<br>" . mysqli_error($conn);
  }
 setcookie("carrello", "", time()-3600);
 mysqli_close($conn);


   echo $result;

?>
