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
//$request->setAdapter('curl');
try
{
   //var_dump($request);
   $response = $request->send();
}
catch (HttpException $ex)
{
   echo 'in exception';
   echo $ex;
}



$authobj = new AuthAPI();
$authinfo = $authobj->GetToken();
//var_dump($authinfo);
$authobj->VerifyToken($authinfo);

$taxobj = new TaxonomyAPI();
$productobj = new ProductAPI();
$orderobj = new OrdersAPI();
$returnobj = new ReturnAPI();

$currdir = getcwd();
$exportdir = $currdir.'/../var/export';
$prodinfofilename = $exportdir . '/jet-prodinfo.json';
$prodconfigurablefilename = $exportdir . '/jet-prodconfigurable.json';
$prodpricefilename = $exportdir . '/jet-prodprice.json';
$prodinventoryfilename = $exportdir . '/jet-prodinventory.json';

echo "<BR><BR>";
echo "Simple Product info file : " . $prodinfofilename . "<BR>";
echo "Configurable Product info file : ". $prodconfigurablefilename . "<BR>";
echo "Product Price info file : " . $prodpricefilename . "<BR>";
echo "Product Inventory info file : " . $prodinventoryfilename . "<BR>";

$result = '';

$filedetails = file_get_contents($prodinfofilename);
$allproducts = json_decode($filedetails);
foreach($allproducts as $oneproduct) {    
    $sku =   $oneproduct->{'jet_retail_sku'};

    //$result = $productobj->PutSKU($authinfo, $sku, $oneproduct);
    if( strlen($result) > 0) {
        echo "PutSKU Error for sku : ".$sku.".  Error is : ".$result . "<BR>";
    }
    else {
        echo "PutSKU Success for sku : ".$sku . "<BR>";
    }
}

$filedetails = file_get_contents($prodconfigurablefilename);
$allproducts = json_decode($filedetails);
foreach($allproducts as $oneproduct) {    
    $sku = $oneproduct->{'jet_retail_sku'};
    unset($oneproduct->{'jet_retail_sku'});

    //$result = $productobj->PutRelationshipproduct($authinfo, $sku, $oneproduct);
    if( strlen($result) > 0) {
        echo "Put configurable  Error for sku : ".$sku.".  Error is : ".$result . "<BR>";
    }
    else {
        echo "Put configurable Success for sku : ".$sku . "<BR>";
    }
}

$filedetails = file_get_contents($prodpricefilename);
$allproducts = json_decode($filedetails);
foreach($allproducts as $oneproduct) {    
    $sku = $oneproduct->{'jet_retail_sku'};
    unset($oneproduct->{'jet_retail_sku'});

    //$result = $productobj->PutPrice($authinfo, $sku, $oneproduct);
    if( strlen($result) > 0) {
        echo "PutPrice Error for sku : ".$sku.".  Error is : ".$result . "<BR>";
    }
    else {
        echo "PutPrice Success for sku : ".$sku . "<BR>";
    }
}

$filedetails = file_get_contents($prodinventoryfilename);
$allproducts = json_decode($filedetails);
foreach($allproducts as $oneproduct) {    
    $sku = $oneproduct->{'jet_retail_sku'};
    unset($oneproduct->{'jet_retail_sku'});

    //$result = $productobj->PutInventory($authinfo, $sku, $oneproduct);
    if( strlen($result) > 0) {
        echo "PutInventory Error for sku : ".$sku.".  Error is : ".$result . "<BR>";
    }
    else {
        echo "PutInventory Success for sku : ".$sku . "<BR>";
    }
}

?>
