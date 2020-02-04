<?php
// Start the session
session_start();

$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$via=$_POST['via'];
$citta=$_POST['citta'];
$cap=$_POST['cap'];
$email=$_POST['email'];
$telefono=$_POST['telefono'];

  $_SESSION["acquisto_orologi"] = $nome.','.$cognome.','.$via.','.$citta.','.$cap.','.$email.','.$telefono;

      $result = '<table style="width:100%"><thead>
      <tr class="sezioni-tabella" >
          <th class="nome">Gli articoli verranno spediti a</th>
          <th class="nome">&nbsp;</th>
      </tr></thead><tbody><tr class="prodotto">
<td><h2>'.$nome.'  '.$cognome.'</h2>
          <div>
              <div>
                  email: '.$email.' | telefono: '.$telefono.'</div>
          </div>
      </td>
<td class="prezzo">Indirizzo: '.$via.' | Città: '.$citta.' | CAP: '.$cap.'</td>
</tr>
  </tbody><tfoot>
<tr>
<td> </td><td><a href="carrello.php"><input id="annulla" type="button" value="Annulla ordine"></a><input id="pagamento" type="button" value="Procedi al pagamento"></td></tr>
</tfoot></table>';


    echo $result;
?>
