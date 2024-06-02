<?php

require_once '../../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;

$header = apache_request_headers();
// print_r($header);

if($header['Authorization']){
    $token = $header['Authorization'];
    $decode = JWT::decode($token, new Key($jwtSecret,'HS256'));
}
// if(is_object($decode)){
//     echo $decode->email;
// }
foreach ($decode as $j => $k){
    if(is_object($k)){
        foreach ($k as $m => $l){
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo $m;
            echo ": ";
            echo $l;
            echo "<br/>";
            continue;
        }
    }
    echo $j;
    echo ": ";
    echo $k;
    echo "<br/>";
}

// foreach ($decode as $j => $k){
//     echo $j;
//     echo ": ";
//     if(is_object($k)){
//         foreach ($k as $m => $l){
//             echo "&nbsp;&nbsp;&nbsp;&nbsp;";
//             echo $m;
//             echo ": ";
//             echo $l;
//             echo "<br/>";
//             continue;
//         }
//     }
//     echo $k;
//     echo "<br/>";
// }