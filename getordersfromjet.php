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

$result = '';

$allordernodes = $orderobj->GetAllOrdersNodes($authinfo);
$json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
//var_dump($json_str);

echo $LINE_BREAK.$LINE_BREAK;
if(count($allordernodes) > 0) {
	echo "Ready Order IDs : ";
}
else {
	echo "No New Ready Orders.";
}
foreach($allordernodes as $orderid => $oneordernode) {
	echo $LINE_BREAK;
	//var_dump($oneordernode);
	echo "OrderId : " . $orderid . $LINE_BREAK;
	foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
		echo "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
		echo "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
		echo "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;
	}
	echo "order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
}



?>
