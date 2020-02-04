<?php

function mostraDiv($action){

  $result2[]='<div id="cambioCarrello">';
  switch ($action)
  {
    case 'added':
      $result2[]= 'Articolo aggiunto correttamente';
    break;

    case 'removed':
      $result2[]= 'Articolo rimosso correttamente';
    break;
  }
  $result2[]='</div>';
  return join('',$result2);
}

function usaCarrello()
{
  if(isset($_COOKIE['carrello'])){
    $carrello=$_COOKIE['carrello'];
  }
  else{
    $carrello=null;
  }
  if (!$carrello)
  {
    $result[]='
        <a href="carrello.php" title="Carrello">
        <p>0 prodotti</p>
        </a>';
    return join('',$result);
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

    $result[]='<a href="carrello.php" title="Carrello">
        <p>'.$quanti.' prodotti</p>
        </a>';
    $result[]='<div id="carrellino">';
    $result[] = '<table class="tabella-carrello">';
    $result[]='<thead>
    <tr class="sezioni-tabella">
        <th class="nome">Articoli</th>
        <th class="nome">Modello</th>
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
          <div>

                  ID prodotto: '.$id.' | Marca: '.$marca.'
          </div>
      </td>';
      $result[] = '<td class="prezzo">&euro;'.$prezzo.'</td>';
      $result[] = '<td class="quantita">'.$quantita.'</td>';
      $somma += $prezzo * $quantita;
      $result[] = '</tr>';
    }
    $result[] = '</tbody><tfoot> <tr>
    <td class="totale"> Totale: </td><td></td><td class="prezzo"><b>&euro;'.$somma.'</b></td><td></td></tr></tfoot></table></div>';
mysqli_close($conn);
    return join('',$result);
  }
}

function mostraCarrello()
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "vendita_orologi";
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  if(isset($_COOKIE['carrello'])){
    $carrello=$_COOKIE['carrello'];
  }
  else{
    $carrello=null;
  }
  $somma = 0;
  if ($carrello)
  {
    $prodotti = explode(',',$carrello);
    $acquisti = array();
    foreach ($prodotti as $prodotto)
    {
      $acquisti[$prodotto] = (isset($acquisti[$prodotto])) ? $acquisti[$prodotto] + 1 : 1;
    }
    $result[] = '<form action="funzioni_carrello.php?action=aggiorna" method="post" id="cart">';
    $result[] = '<table id="tabella-carrello-grande" class="tabella-carrello">';
    $result[]='<thead>
    <tr class="sezioni-tabella">
        <th class="nome">Articoli</th>
        <th class="nome">Modello</th>
        <th class="nome">Prezzo</th>
        <th class="nome">Quantità</th>
        <th class="nome">Totale</th>
    </tr></thead>
    <tbody>';

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
          <div>
              <div class="dettagli">
                  ID prodotto: '.$id.' | Marca: '.$marca.'</div>
              <div class="dettagli">
                  <a href="funzioni_carrello.php?action=cancella&id='.$id.'">Elimina articolo</a>
              </div>
          </div>
      </td>';
      $result[] = '<td class="prezzo">&euro;'.$prezzo.'</td>';
      $result[] = '<td><p><input type="number" name="quantita'.$id.'" value="'.$quantita.'" min="1" max="99"></p>';
      $result[] = '<p><button type="submit" class="aggiorna-carrello">Aggiorna il carrello</button></p></td>';
      $result[] = '<td class="prezzo">&euro;'.($prezzo * $quantita).'</td>';
      $somma += $prezzo * $quantita;
      $result[] = '</tr>';
    }

    $result[] = '</tbody><tfoot>';
    $result[] = '<tr class="prodotto"><td></td>';
    $result[] = '<td></td><td class="totale"> Totale: </td><td></td><td class="prezzo"><b>&euro;'.$somma.'</b></td></tr>';
    $result[] = '<tr><td></td><td></td><td></td><td></td><td><input id="acquista-1" type="button" value="Acquista"></td></tr>';
    $result[] = '</tfoot></table></form>';
  }else{
    $result[] = '<table class="tabella-carrello">';
    $result[] = '<tr>';
    $result[] = '<td class="nome">Il carrello è vuoto. Visita il nostro <a href="catalogo.php">catalogo!</a></td>';
    $result[] = '</tr>';
    $result[] = '</table>';
  }
  mysqli_close($conn);
  return join('',$result);
}
?>
