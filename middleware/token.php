<?php

function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}
/**
* get access token from header
* */
$headers = getAuthorizationHeader();
$token = null;

// HEADER: Get the access token from the header
if (!empty($headers)) {
    if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
        $token = $matches[1];
    }
}

if ( $token != md5('hendry_cartrack') ) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this.');     
}
