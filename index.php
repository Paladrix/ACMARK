<!DOCTYPE html>

<?php

  $error=0;
  $err_ico="";
  if (isset ($_GET["err"])) {
  if ($_GET['err']=='1') {
  $err_ico=$_GET['ico'];
  $error=1;
  }

}
require_once 'header.php';
header("Content-Type: text/html; charset=windows-1250"); 
  ?>

<html>

<head>
   
    <title></title>
</head>
<body>
  <div class="row">
    <form class="col s12" method="POST" action="connect.php" onsubmit="return Validate()" name="vForm">
      <div class="row">
        <div class="input-field col s12 m4 l2 offset-s0 offset-m4 offset-l5">
          <input  class="validate" type="text" name="ico">
          <div id="ico_error" class="val_error"></div>
          <label for="ico">IÈO</label>
        </div>
      </div>
      <div class="row">
         <div class="input-field col s12 m4 l2 offset-s0 offset-m4 offset-l5">
          <input id="firma" type="text" class="validate" name="firma">
          <div id="firm_error" class="val_error"></div>
          <label for="firma">Firma</label>
        </div>
      </div>
      <div class="row">
        <button id="butt" class="btn waves-effect waves-light col s12 m4 l2 offset-s0 offset-m4 offset-l5" type="submit" name="action">
        <i class="material-icons">odeslat</i>
        </button>
      </div>
    </form>
  </div>

 
<!-- add javascript here -->
<script type="text/javascript">
    // GETTING ALL INPUT TEXT FIELDS
    var ico = document.forms["vForm"]["ico"];
    var firma = document.forms["vForm"]["firma"];
    var frame = document.getElementById("toast");
 
 function testICO()
{
	var tmp = ico.value;
    var a = 0;
    var b = tmp.split('');
    if(tmp.length != 8) return false;
    
    var c = 0;
    for(var i = 0; i < 7; i++){
        a += (parseInt(b[i]) * (8 - i));
    }
    a = a % 11;
    c = 11 - a;
    c = c % 10;
    if(parseInt(b[ 7]) != c){
    	return false;
    }

  return true;

}

window.onload=function(){
  if(<?php print_r($error) ?>){
  ico.value=<?php print_r($err_ico); ?>"";
  ico.style.borderBottom = "1px solid red";
  ico.style.boxShadow = "0 1px 0 0 #8B0000";
    Materialize.toast('Záznam nenalezen.', 3000, 'rounded');
      ico.focus();
}
}




  function Validate(){
  	if(ico.value == ""){
      ico.style.borderBottom = "1px solid red";
      ico.style.boxShadow = "0 1px 0 0 #8B0000";
      		Materialize.toast('Prosím, vyplòte IÈO.', 3000, 'rounded');
            ico.focus();
            return false;
        }
    if(isNaN(ico.value)){
      ico.style.borderBottom = "1px solid red";
      ico.style.boxShadow = "0 1px 0 0 #8B0000";
            Materialize.toast('Zadejte platné IÈO.', 3000, 'rounded');
            ico.focus();
            return false;
        }

    if(testICO() == false){
      ico.style.borderBottom = "1px solid red";
      ico.style.boxShadow = "0 1px 0 0 #8B0000";
            Materialize.toast('Zadejte platné IÈO.', 3000, 'rounded');
            ico.focus();
            return false;
    	}
    if(testICO() == true && firma.value == ""){
      ico.style.borderBottom = "1px solid green";
      ico.style.boxShadow = "0 1px 0 0 green";
      firma.style.borderBottom = "1px solid red";
      firma.style.boxShadow = "0 1px 0 0 #8B0000";
      Materialize.toast('Prosím, vyplòte název firmy.', 3000, 'rounded');
      return false;
    }
    	
    if(firma.value == ""){
      firma.style.borderBottom = "1px solid red";
      firma.style.boxShadow = "0 1px 0 0 #8B0000";
            Materialize.toast('Prosím, vyplòte název firmy.', 3000, 'rounded');
            firma.focus();
            return false;
        }
 
    }
 
</script>
</body>
</html>