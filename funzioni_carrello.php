<?php
if(!isset($_COOKIE['carrello'])){
  $carrello=null;
}
else{
  $carrello=$_COOKIE['carrello'];
}



if(isset($_GET['action']))
{
  $action = $_GET['action'];
  switch ($action)
  {
    case 'aggiungi':
    if ($carrello)
    {
      $carrello .= ','.$_GET['id'];
    }else{
      $carrello = $_GET['id'];
    }
    setcookie('carrello', $carrello);
    header('Location: carrello.php?action=added');
    break;

    case 'cancella':
    if ($carrello)
    {
      $prodotti = explode(',',$carrello);
      $acquisto = '';
      foreach ($prodotti as $prodotto)
      {
        if ($_GET['id'] != $prodotto)
        {
          if ($acquisto != '')
          {
            $acquisto .= ','.$prodotto;
          }else{
            $acquisto = $prodotto;
          }
        }
      }
      $carrello = $acquisto;
    }
    setcookie("carrello", "", time()-3600);
    setcookie('carrello', $carrello);
    header('Location: carrello.php?action=removed');
    break;

    case 'aggiorna':
    if ($carrello)
    {
      $acquisto = '';
      foreach ($_POST as $key=>$value)
      {
        if (stristr($key,'quantita'))
        {
          $id = str_replace('quantita','',$key);
          $prodotti = ($acquisto != '') ?
          explode(',',$acquisto) : explode(',',$carrello);
          $acquisto = '';

          foreach ($prodotti as $prodotto)
          {
            if ($id != $prodotto)
            {
              if ($acquisto != '')
              {
                $acquisto .= ','.$prodotto;
              }else{
                $acquisto = $prodotto;
              }
            }
          }

          for ($i=1;$i<=$value;$i++)
          {
            if ($acquisto != '')
            {
              $acquisto .= ','.$id;
            }else{
              $acquisto = $id;
            }
          }
        }
      }
    }
    $carrello = $acquisto;
    setcookie("carrello", "", time()-3600);
    setcookie('carrello', $carrello);
    header('Location: carrello.php');
    break;

  }
}


?>
