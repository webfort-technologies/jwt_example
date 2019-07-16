<?php 
include("config.php");
require __DIR__ . '/vendor/autoload.php';


use \Firebase\JWT\JWT;

/*
foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";
}*/

$allHeaders = getallheaders();
$authorization = $allHeaders['Authorization'];
list($jwt) = sscanf( $authorization, 'Bearer %s');

if($jwt) {

	 try {
            
                $secretKey = base64_decode($config['jwtKey']);
                $token = JWT::decode($jwt, $secretKey, array('HS512'));
               // print_r($token);
                //$asset = base64_encode(file_get_contents('http://thewebfort.com/wp-content/uploads/2016/12/linear_logo.png'));
                /*
                 * return protected asset
                 */
                $asset ="Iloveyou";
                header('Content-type: application/json');
                	echo json_encode([
                    'img'    => $asset
                ]);

            } catch (Exception $e) {
                /*
                 * the token was not able to be decoded.
                 * this is likely because the signature was not able to be verified (tampered token)
                 */
               // print_r($e);
                header('HTTP/1.0 401 Unauthorized');
            }
        } else {
            /*
             * No token was able to be extracted from the authorization header
             */
            header('HTTP/1.0 400 Bad Request');
        }
   




//print_r($jwt);

	 ?>