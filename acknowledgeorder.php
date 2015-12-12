<?php

require_once 'HTTP/Request2.php';

require_once 'AuthAPI.php';
require_once 'TaxonomyAPI.php';
require_once 'ProductAPI.php';
require_once 'OrdersAPI.new.php';
require_once 'ReturnAPI.php';

$LINE_BREAK = "\r\n";//"<BR>"

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



$filedetails = file_get_contents('acknowledge.json');
$allorders = json_decode($filedetails);
foreach($allorders as $oneorder) {    
    $id = $oneorder->{'alt_order_id'};
    unset($oneorder->{'alt_order_id'});

    $result = $orderobj->PutOrderStatus($authinfo, $id, $oneorder);
    if( strlen($result) > 0) {
        echo "Put Order Error : ".$id.".  Error is : ".$result . $LINE_BREAK;
    }
    else {
        echo "Put Order Success for sku : ".$id . $LINE_BREAK;
    }
}



// $result = '';

// $allorderids = $orderobj->PutOrderStatus($authinfo);

// echo $LINE_BREAK.$LINE_BREAK;
// if(count($allorderids) > 0) {
// 	echo "Ready Order IDs : ";
// }
// else {
// 	echo "No New Ready Orders.";
// }
// foreach($allorderids as $oneorderid) {
// 	echo $LINE_BREAK;
// 	echo "OrderId : " . $oneorderid . $LINE_BREAK;
// }



?>
