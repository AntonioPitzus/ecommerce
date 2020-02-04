$(function(){

  $("#intestazione > h1").hover(function(){
    $(this).css("color", "#dddddd");
  },
  function(){
    $(this).css("color", "#aaaaaa");
  });

  $("#intestazione > h1").click(function(){
    location.assign("home.php");
  });

  $(".gr > img").hover(function(){
    $(this).fadeTo(90,0.8);
  },
  function(){
    $(this).fadeTo(90,1);
  });

  $(".grHome > img, #imgNuovoProdotto, #info").click(function(){
    if($(this).attr("id") == "imgNuovoProdotto" || $(this).attr("id") == "info"){
      $id = $("#idNuovoProdotto").html();
    }
    else{
      $id = $(this).parent().attr("id");
    }
    location.assign("http://localhost/orologio/catalogo.php#showDetail"+$id);
  });


  $("#logout").click(function(){
  cname="loggedIn";
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0){
          document.cookie = "loggedIn=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        }
        window.location.assign("http://localhost/orologio/login.php")
  }
});

$(".figCat > img").click(function(){
  //$("#mainCat").css("display", "block");
  $("#mainCat").slideDown(300);
  $("#detail > img").attr("src", $(this).attr("src"));
  $asd = $(this).next().html();
  $("#detailSec > h3").html($asd);

  $asd = "<b>Prezzo:</b> " + $(this).siblings(".prezzo").html() + "€<br/><br/>" + $(this).siblings(".descr").html();
  $("#detail > figcaption").html($asd);
  $("#detailId").html($(this).siblings(".id").html());

  $('html, body').animate({
        scrollTop: $("#mainCat").offset().top
    }, 300);

});

$("#closeDetail").click(function(){
  //  location.assign("catalogo.php");
  $("#mainCat").slideUp(300);
  location.hash = "";
});


$("#detailCarrello").click(function(){
  var id = $("#detailId").html();
  $.ajax({
          type: "POST",
          url: "addAjax.php",
          data: "id=" + id,
          dataType: "html",
          success: function(msg) {
            $("#carrellino-titolo").html(msg);
            $("#risultato").css("display", "inline-block");
            $("#risultato").fadeOut(4000);
          }
          });
});

$("#homeAggiungi").click(function(){
  var id = $("#idNuovoProdotto").html();
  $.ajax({
          type: "POST",
          url: "addAjax.php",
          data: "id=" + id,
          dataType: "html",
          success: function(msg) {
            $("#carrellino-titolo").html(msg);
            $("#risultato").css("display", "inline-block");
            $("#risultato").fadeOut(4000);
          }
          });
});

$("#searchSubmit").click(function(){
   location.hash = "ricerca";
});

$(".fig > img").click(function(){
  $("#mainCat").css("display", "block");
  $("#detail > img").attr("src", $(this).attr("src"));
  $asd = $(this).next().html();
  $("#detail > p").html($asd);
  $asd = $(this).siblings("p").html();
  $("#detail > figcaption").html($asd);
  $('html, body').animate({
        scrollTop: $("#mainCat").offset().top
    }, 300);
});

$("#closeSearch").click(function(){
  $("#searchResult").css("display", "none");
});
/*carrello*/
var sPageURL = decodeURIComponent(window.location.search.substring(1)),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;
for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === 'action') {
        sParameterName[1] === undefined ? true : sParameterName[1];
        if(sParameterName[1] === 'added'){
          $("#cambioCarrello").css("border-color", "#00ff00");
          $("#cambioCarrello").css("background-color", "#00C000")
        }
        if(sParameterName[1] === 'removed'){
          $("#cambioCarrello").css("border-color", "#ff0000");
          $("#cambioCarrello").css("background-color", "#C00000")
        }
    }
}
$("#cambioCarrello").fadeOut(6000);

$("#carrellino-titolo").hover(function(){
$(this).css("background", "url(risorse/cart2.png) no-repeat");
$("#carrellino-titolo > a").css("color", "white");
$(this).css("background-color", "black");
$(this).fadeTo(90,1);
//
$("#carrellino").show();
},
function(){
$(this).css("background", "url(risorse/cart.png) no-repeat");
$(this).css("background-color", "white");
$("#carrellino-titolo > a").css("color", "black");
$(this).fadeTo(90,1);
//$(".carrellino").css("display", "none");
$("#carrellino").hide();
});

// acquisto
$("#acquista-1").click(function(){
  $("#tabella-carrello-grande").css("display", "none");
  $("#div-tabella-carrello").css("display", "block");
  $("#dati").css("display", "block");
  $("#h2").html("Inserimento dati");
});

$("#acquista-button").click(function(){
  if($("#ins_nome")[0].checkValidity()){
    var nome = $("#ins_nome").val();
  }else{
    var nome = "";
  }
  if($("#ins_cognome")[0].checkValidity()){
    var cognome = $("#ins_cognome").val();
  }else{
    var cognome = "";
  }
  if($("#ins_via")[0].checkValidity()){
    var via = $("#ins_via").val();
  }else{
    var via = "";
  }
  if($("#ins_citta")[0].checkValidity()){
    var citta = $("#ins_citta").val();
  }else{
    var citta = "";
  }
  if($("#ins_cap")[0].checkValidity()){
    var cap = $("#ins_cap").val();
  }else{
    var cap = "";
  }
  if($("#ins_email")[0].checkValidity()){
    var email = $("#ins_email").val();
  }else{
    var email = "";
  }
  if($("#ins_telefono")[0].checkValidity()){
    var telefono = $("#ins_telefono").val();
  }else{
    var telefono = "";
  }
  if(nome!="" && cognome!="" && via!="" && citta!="" && cap!="" && email!="" && telefono!=""){
    $.ajax({
            type: "POST",
            url: "riepilogo.php",
            data: "nome=" + nome + "&cognome=" + cognome + "&via="+via+"&citta="+citta+"&cap="+cap+"&email="+email+"&telefono="+telefono,
            dataType: "html",
            success: function(msg) {
              $("#errore").css("display", "none");
              $("#dati").html(msg);
              $("#h2").html("Riepilogo");
              $("#pagamento").click(function(){
                $.ajax({
                        type: "GET",
                        url: "pay.php",
                        data: "",
                        dataType: "html",
                        success: function(msg) {
                          $("#errore").css("display", "none");
                          $("#dati").html(msg);
                          $("#h2").html("Inserimento dati carta di credito");
                          $("#confirm").click(function(){
                            if($("#creditcard")[0].checkValidity()){
                              var creditcard = $("#creditcard").val();
                            }else{
                              var creditcard = "";
                            }
                            if($("#cardmonth")[0].checkValidity()){
                              var cardmonth = $("#cardmonth").val();
                            }else{
                              var cardmonth = "";
                            }
                            if($("#cardyear")[0].checkValidity()){
                              var cardyear = $("#cardyear").val();
                            }else{
                              var cardyear = "";
                            }
                            if($("#cardsecurecode")[0].checkValidity()){
                              var cardsecurecode = $("#cardsecurecode").val();
                            }else{
                              var cardsecurecode = "";
                            }
                            if($("#cardnameon")[0].checkValidity()){
                              var cardnameon = $("#cardnameon").val();
                            }else{
                              var cardnameon = "";
                            }
                            if(creditcard!="" && cardmonth!="" && cardyear!="" && cardsecurecode!="" && cardnameon!=""){
                              $.ajax({
                                      type: "GET",
                                      url: "confirm.php",
                                      data: "",
                                      dataType: "html",
                                      success: function(msg) {
                                        $("#errore").css("display", "none");
                                        $("#div-tabella-carrello").css("display", "none");
                                        $("#carrellino-titolo").css("display", "none");
                                        $("#dati").html(msg);
                                        $("#h2").html("Acquisto avvenuto con successo!");
                                      }
                                      });
                            }
                            else{
                              $("#errore").css("display", "block");
                            }
                          });
                        }
                        });

              });
            }
            });
  }
  else{
    $("#errore").css("display", "block");
  }

});

$("#sezioneRicerca").hover(function(){
  $("#searchForm").css("display", "block");
},
function(){
  $("#searchForm").css("display", "none");
});

$("#default").click(function(){
    $.ajax({
            type: "POST",
            url: "default.php",
            data: "",
            dataType: "html",
            success: function(msg) {
              $(function(){location.assign('catalogo.php')});
            }
            });
  });

});

/*funzioni catalogo
*/

$(document).ready(function(){
  if(location.hash.match(/#showDetail/)){
    $("#mainCat").css("display", "block");
    $op = location.hash.match(/[0-9]/g);
    $i = 0;
    $str = "";
    while($op[$i]){
      $str = $str + $op[$i];
      $i++;
    }
    $.post('phpscript.php', "id= " + $str, function (response) {
      $("#mainCat").append(response);
      $("#mainCat").css("display", "block");
      $("#detail > img").attr("src", $("#qSrc").html());
      $("#detailSec > h3").html("<b>" + $("#qMarca").html() + "</b>: " + $("#qModello").html());
      $("#detail > figcaption").html("<b>Prezzo:</b> " + $("#qPrezzo").html() + "€<br/><br/>" + $("#qDesc").html());
      $("#detailId").html($str);
      $('html, body').animate({
        scrollTop: $("#mainCat").offset().top
      }, 100);
    });
  }


  $num = location.search.match(/[0-9]/g);
  if($num){
    $(".pagine[href='?page="+ $num +"']").css("text-decoration", "underline");
  }
  else{
    $num = 1;
    $(".pagine[href='?page="+ $num +"']").css("text-decoration", "underline");
  }
});
