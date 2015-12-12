<?php

require_once 'HTTP/Request2.php';

require_once 'AuthAPI.php';
require_once 'TaxonomyAPI.php';
require_once 'ProductAPI.php';
require_once 'OrdersAPI.php';
require_once 'ReturnAPI.php';

//$LINE_BREAK = "\r\n";
$LINE_BREAK = "<BR>";

$authobj = new AuthAPI();
$authinfo = new AuthInfo();
$authinfo = $authobj->GetToken();
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



echo $LINE_BREAK.$LINE_BREAK;

$oid = $_GET["oid"];
$oitid = $_GET["oitid"];

$filedetails = file_get_contents('acknowledge_template.json');
$allorders = json_decode($filedetails);
$allorders[0]->{"order_items"}[0]->{"order_item_id"} = $oitid;

$result = $orderobj->AcknowledgeOrder($authinfo, $oid, $allorders[0]);
if( strlen($result) > 0) {
    echo "Acknowledge Error for Order : ".$oid.". Order Item : " . $oitid .$LINE_BREAK;
    echo "Error is : ".$result . $LINE_BREAK;
}
else {
    echo "Acknowledge Order Success " . $LINE_BREAK;
}

?>
