<?php

if(!isset($_COOKIE['carrello'])){
  $carrello=null;
}
else{
  $carrello=$_COOKIE['carrello'];
}

if ($carrello)
{
  $carrello .= ','.$_POST['id'];
}else{
  $carrello = $_POST['id'];
}
setcookie('carrello', $carrello);
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
      <div>
              ID prodotto: '.$id.' | Marca: '.$marca.'</div>
  </td>';
  $result[] = '<td class="prezzo">&euro;'.$prezzo.'</td>';
  $result[] = '<td class="quantita">'.$quantita.'</td>';
  $somma += $prezzo * $quantita;
  $result[] = '</tr>';
}
$result[] = '</tbody><tfoot> <tr>
<td class="totale"> Totale: </td><td></td><td class="prezzo"><b>&euro;'.$somma.'</b></td></tr></tfoot></table></div>';
mysqli_close($conn);
$stampa=join('',$result);

echo $stampa;
?>
