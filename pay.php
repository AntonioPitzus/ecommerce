<?php

    $result=' <fieldset class="fset">
      <legend>Inserisci i dati della carta di credito</legend>
  			<div id="creditcardform" class="inserimento">
  				    	<div style="padding-bottom: 15px"><label>	<input type="text" id="creditcard" name="creditcard" pattern="[0-9]{21}" placeholder="Numero di carta di credito" style="width: 40%"/></label></div>
  					    <div style="padding-bottom: 15px"><label><input type="number" id="cardmonth" name="cardmonth" placeholder="MM"  min="1" max="12" style="width: 10%"/></label>
  							<label><input type="number" id="cardyear" name="cardyear" placeholder="YY"  min="16" max="30" style="width: 10%"/></label>
                <label><input type="number" id="cardsecurecode" name="cardsecurecode"  placeholder="Secure Code" min="0" max="999" style="width: 15%"/></label></div>
  							<div style="padding-bottom: 15px"><label><input type="text" value="" id="cardnameon" name="cardnameon" placeholder="Nome e cognome possessore carta" style="width: 40%"/></label></div>

  						<input id="confirm" type="button" value="Conferma dati e paga" >
              <a href="carrello.php"><input id="annulla" type="button" value="Annulla ordine"></a>
  			</div>
      </fieldset>';
      echo $result;
?>
