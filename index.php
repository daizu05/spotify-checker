<?php

/************  DuckDuckGo Search by alcoriza05  ***********/

redir();
//header('Content-type: text/plain');

$curl = curl_init(); //$curl is going to be data type curl resource

$search_string = "apk";
if(isset($_GET['q']))
{
  $search_string = $_GET['q'];
}

echo "<title>Searching for \"$search_string\"</title>";

$url = "https://duckduckgo.com/?q=".urlencode($search_string)."&t=h_&ia=about";
$useragent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl);

//preg_match_all("!https://m.media-amazon.com/images/I/[^\s]*?._AC_SX118_SY170_QL70_.jpg!", $result, $matches);
if(!preg_match_all('!<h2 class="result__title">(.*?)</h2>!s',$result, $matches)){
	echo "No result";
} else {
    foreach($matches[1] as $m)
    {
    	echo $m . "<br/>--------------------------------------------------------<br/>";
    }
}

curl_close($curl);

//save_file("result.txt", $result);

function save_file($file,$content)
{
	$open = fopen($file,'ab');
	fwrite($open,$content."\r\n");
	fclose($open);
}

function redir()
{
	if(isset($_GET['uddg']))
	{
		$url = $_GET['uddg'];
		header("Location: $url");
	}
}

?>