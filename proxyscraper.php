<?php


/**
 * Free PHP script for scraping proxies from HideMyAss
 * Works from console too with php get_proxies.php
 * It will create a file named proxies.txt where will save proxies
 * It parses all pages with proxies from HideMyAss
 */


$baselink 	= "http://hidemyass.com/proxy-list";
$result 	= xg($baselink);


preg_match('#<div class="pagination">(.*?)</div#msi', $result['result'], $pagination);
preg_match_all('#<li>.*?</li>#msi', $pagination[1], $pages);


$proxies = array();
$ff = fopen("proxies.txt", "a+");
for($i=1;$i<=count($pages[0])+1;$i++) {
	
	$link = $baselink . "/" . $i;
	$result = xg($link);
	preg_match('#<table id="listtable".*?</thead.*?>(.*?)</table#msi', $result['result'], $content);


	$rows = explode("<tr", $content[1]);
	array_shift($rows);


	foreach($rows as $key => $row) {
		$cols = explode("<td", $row);
		array_shift($cols);
		preg_match('#<style>(.*?)</style>#msi', $cols[1], $styles);
		preg_match_all('#\.(.*?){display:.*?(.*?)}#msi', $styles[1], $style);


		$classes = array();
		for($j=0;$j<count($style[1]);$j++) {
			$classes[$style[1][$j]] = $style[2][$j];
		}


		$cols[1] = preg_replace('#>.*?<style>.*?</style>#msi', '', $cols[1]);
		$cols[1] = preg_replace('#<(div|span) style="display:none">.*?</(div|span)>#', '', $cols[1]);
		foreach($classes as $class => $value) {
			if($value == "none") {
				$cols[1] = preg_replace('#<(div|span) class="'.$class.'">.*?</(div|span)>#', '', $cols[1]);
			}
		}
		$proxy_ip   = strip_tags(preg_replace('#\s+#msi', '', $cols[1]));
		$proxy_port = strip_tags(preg_replace('#>|\s+#msi', '', $cols[2]));


		$proxies[] = $proxy_ip.':'.$proxy_port;
		fwrite($ff, $proxy_ip.':'.$proxy_port."\r");
	}
}
fclose($ff);


function xg($url, $show_header = 0)
{


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HEADER, $show_header);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
	$result['result'] = curl_exec($ch);
	$result['info']   = curl_getinfo($ch);
	return $result;
}


var_dump($proxies);


?>
 
 Thanks Thanks x 3
Jun 6, 2014
 jazzc
jazzc
Moderator
Staff Member Moderator Jr. VIP
You may want to change this
fwrite($ff, $proxy_ip.':'.$proxy_port."\r");
to this 
fwrite($ff, $proxy_ip.':'.$proxy_port.PHP_EOL);
:)
 
Jun 8, 2014
 vebxperts
vebxperts
Elite Member
Awesome share OP :)

Here is a little input for further decorating the output (line by line):

After following line: 
$proxies = array();
Add this line:
unlink("proxies.txt"); //removing already saved proxies list, from server.
