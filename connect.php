<?php
require_once 'header.php';
header("Content-Type: text/html; charset=windows-1250");
$content = "";


function pull_from_ares($ico,$conn){


	$url_ico = "http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=";
	$url_obch_jm = "http://wwwinfo.mfcr.cz/cgi-bin/ares/ares_es.cgi?obch_jm=";
	
	$data=simplexml_load_file($url_ico.$ico);
	$space=$data->getDocNamespaces();

	$odpovedi=$data->children($space['are']);

	foreach ($odpovedi as $odpoved)
	{
	$elementy=$odpoved->children($space['D']);
	if($elementy->E->EK!="1"){
		$IC=$elementy->VBAS->ICO;
		$DIC=$elementy->VBAS->DIC;
		$NAZEV=$elementy->VBAS->OF;
		$VZNIK=$elementy->VBAS->DV;
		$ADRESA=$elementy->VBAS->AD->UC;
		$MESTO=$elementy->VBAS->AD->PB;

		$NAZEV = mb_convert_encoding($NAZEV, "ISO-8859-2");
		$ADRESA = mb_convert_encoding($ADRESA, "ISO-8859-2");
		$MESTO = mb_convert_encoding($MESTO, "ISO-8859-2");
		vypis($IC,$DIC,$NAZEV,$VZNIK,$ADRESA,$MESTO);

   $retval = mysqli_query($conn,"INSERT INTO firmy (ico,dic,nazev,vznik,adresa,mesto)
      VALUES ('$IC','$DIC','$NAZEV','$VZNIK','$ADRESA','$MESTO')");
	  
	   if(! $retval ){
            die();
        }

	}
	else{
		header("Location: index.php?ico=".$ico."&err=1");
	}

	}
}

function pull_from_database($ico,$conn){
$query= "SELECT * FROM `firmy` WHERE ico=$ico";

	if ($result = mysqli_query($conn, $query)) {
		$row = mysqli_fetch_assoc($result);
		$IC=$row["ico"];
		$DIC=$row["dic"];
		$NAZEV=$row["nazev"];
		$VZNIK=$row["vznik"];
		$ADRESA=$row["adresa"];
		$MESTO=$row["mesto"];
		vypis($IC,$DIC,$NAZEV,$VZNIK,$ADRESA,$MESTO);
}

}

function vypis($IC,$DIC,$NAZEV,$VZNIK,$ADRESA,$MESTO){
 echo"
    <table class='striped'>
    <tr><td>Ièo:</td><td>".$IC."</td>
    <tr><td>Diè:</td><td>".$DIC."</td>
    <tr><td>Firma:</td><td>".$NAZEV."</td>
    <tr><td>Datum založení:</td><td>".$VZNIK."</td>
    <tr><td>Adresa:</td><td>".$ADRESA.", ".$MESTO."</td>
	</table>
    ";	
}

// function push_to_database($pull_a,$conn){
// 	foreach ($pull_a as $value) {
// 		$IC=$value[0];
// 		$DIC=$value[1];
// 		$NAZEV=$value[2];
// 		$VZNIK=$value[3];
// 		$ADRESA=$value[4];
// 		$MESTO=$value[5];
// 	}
// 	   $retval = mysqli_query($conn,"INSERT INTO firmy (ico,dic,nazev,vznik,adresa,mesto)
//       VALUES ('$IC','$DIC','$NAZEV','$VZNIK','$ADRESA','$MESTO')");
	  
// 	   if(! $retval ){
//             die();
//         }
//  ?>
// <script type="text/javascript">
// Materialize.toast('Data byla vložena do databáze.', 3000, 'rounded');

// </script>
// <?php
//  return array($IC,$DIC,$NAZEV,$VZNIK,$ADRESA,$MESTO);
// }


//-------------------------------------------------------------------------------------

if (isset($_POST["action"])) {
	$ico=$_POST["ico"];
	$obch_jm=$_POST["firma"];

	$conn = mysqli_connect("localhost","root","","my_ares");
	if (!$conn) {      
        die('Could not connect: ' . mysqli_error());
    }

$query= "SELECT DATEDIFF((CURRENT_TIMESTAMP),(SELECT datum FROM `firmy` WHERE ico=$ico)) AS days";

 	if ($result = mysqli_query($conn, $query)) { 
	
        while (($row = mysqli_fetch_assoc($result))!=0) {
            if($row["days"] < 31){
               pull_from_database($ico,$conn);
            }
            else{
            	$pull_a=pull_from_ares($ico,$conn);

            	//push_to_database($pull_a,$conn);
            }
        }
        mysqli_free_result($result);
    }


    mysqli_close($conn);
}


?>


