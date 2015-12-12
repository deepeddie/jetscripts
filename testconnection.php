<?php

require_once 'HTTP/Request2.php';

require_once 'AuthAPI.php';
require_once 'TaxonomyAPI.php';
require_once 'ProductAPI.php';
require_once 'OrdersAPI.php';
require_once 'ReturnAPI.php';


$request = new Http_Request2('https://merchant-api.jet.com/api/token/');
$request->setMethod(HTTP_Request2::METHOD_POST);

$headers = array(
   'Content-Type' => 'application/json',
);
$request->setHeader($headers);

$bodyvalue = '{
  "user": "24CB2A75D997F31067D36955FAEAEADC304104BD",
  "pass": "ydQhk8uLlta/BCE/crjyTqiBFxkPiT2V8Ch2l8XErrF0"
}';
$request->setBody($bodyvalue);
$request->setConfig(array(
    'ssl_verify_peer'   => FALSE,
    'ssl_verify_host'   => FALSE
));

try
{
   //var_dump($request);
   $response = $request->send();
   echo 'success' . $response->getBody();
}
catch (HttpException $ex)
{
   echo 'in exception';
   echo $ex;
}




?>
