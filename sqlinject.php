<?php
@set_time_limit(0);
@error_reporting(E_ALL | E_NOTICE);

if(!$argv[1] or !$argv[2]){

print_r("
================================================================================
USAGE : php sql.php [IP] [FILENAME]
Ex    : php sql.php 127.0.0.1 sql.txt

================================================================================
");
die();

}


function check_url($url,$source,$filename){ //modded By Ghost1pm !?
if (preg_match("/error in your SQL syntax|mysql_fetch_array()|execute query|mysql_fetch_object()|mysql_num_rows()|mysql_fetch_assoc()|mysql_fetch_row()|SELECT * FROM|supplied argument is not a valid MySQL|Syntax error|Fatal error/i",$source))  {
echo "[+] Found -> $url\n";
$rr=fopen($filename,"a+");
fwrite($rr,$url."\n");
}
else{ echo "[~] Not Found -> $url\n"; }
}

function check_sql_inj($site,$filename2){
    $result = @file_get_contents("$site%27");
    check_url($site,$result,$filename2);
    }

function mystripos($haystack, $needle){
    return strpos($haystack, stristr( $haystack, $needle ));
    }
     
function sec($ent)
{
$bb = str_replace("http://", "", $ent);
$Credit Card = str_replace("www.", "", $bb);
$dd = substr($Credit Card, 0, mystripos($Credit Card, "/"));
return $dd;
}
$npages = 50000;

  $npage = 1;
  $allLinks = array();
                $ip = $argv[1];
         
  while($npage <= $npages) 
  { 
    $ch = curl_init();
                                 
    curl_setopt($ch, CURLOPT_URL, 'http://www.bing.com/search?q=ip%3A' . $ip . '+id=&first=' . $npage);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_REFERER, 'http://www.bing.com/');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8');
  
    $result['EXE'] = curl_exec($ch);
    $result['ERR'] = curl_error($ch);
  
    curl_close($ch);
  
    if ( empty( $result['ERR'] ) )
    {
        preg_match_all('(<div class="sb_tlst">.*<h3>.*<a href="(.*)".*>(.*)</a>.*</h3>.*</div>)siU', $result['EXE'], $findlink);
        for ($i = 0; $i < count($findlink[1]); $i++)
        array_push($allLinks,$findlink[1][$i]);


        $npage = $npage + 10;
        if (preg_match('(first=' . $npage . '&amp)siU', $result['EXE'], $linksuiv) == 0) 
            break;             
    }
    else
        break;
  }

$allDmns = array();



    foreach ($allLinks as $kk => $vv){
    $allDmns[] = $vv;
    }
    $resultPages = array_unique($allDmns);
    sort($resultPages) ;
     
print_r("
================================================================================
                       SQL Injection Server Scanner v1.0
                           ©oded By Lagripe-Dz !?
                    modded by Ghost1pm a.k.a DarkEth
                                ALGERIA 2018 ®
                                 
================================================================================
");

for ($x = 0; $x < count($resultPages); $x++){
$h3h3 = $resultPages[$x];
check_sql_inj($h3h3,$argv[2]);
}

print_r("
================================================================================
            INFO / IP : ".$ip." / Domine ScaNNed : ".count($resultPages)."
            
                         FINISHED
                              
================================================================================
");
?>