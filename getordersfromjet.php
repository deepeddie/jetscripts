<html>
 <head>
  <title>Order list</title>
 </head>
 <body>
 <?php

require_once 'HTTP/Request2.php';

require_once 'AuthAPI.php';
require_once 'TaxonomyAPI.php';
require_once 'ProductAPI.php';
require_once 'OrdersAPI.new.php';
require_once 'ReturnAPI.php';

//$LINE_BREAK = "\r\n";
$LINE_BREAK = "<BR/>";

$authobj = new AuthAPI();
$authinfo = new AuthInfo();
$authinfo = $authobj->GetToken();
$authobj->VerifyToken($authinfo);

$taxobj = new TaxonomyAPI();
$productobj = new ProductAPI();
$returnobj = new ReturnAPI();


function GetReadyOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml1 = "";
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'ready');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml1 = $strhtml1 . "Ready Order IDs : ";
    }
    else {
            $strhtml1 = $strhtml1 . "No New Ready Orders.";
    }
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml1 = $strhtml1 . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "<DIV>";
            //var_dump($oneordernode);
            $strhtml1 = $strhtml1 . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml1 = $strhtml1 . "<DIV>";
                    $strhtml1 = $strhtml1 . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml1 = $strhtml1 . "<a href=" . "/acknowledgeorderitem.php?oid=dc-".$orderid."&oitid=dc-".$oneorderitemnode->{"order_item_id"} . " target=\"_blank\">Acknowledge : </a>";
                    $strhtml1 = $strhtml1 . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "</DIV>";
            }
            $strhtml1 = $strhtml1 . "</DIV>";
    }
    return $strhtml1;
}

function GetAcknowledgedOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml1 = "";
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'acknowledged');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml1 = $strhtml1 . "Acknowledged Order IDs : ";
    }
    else {
            $strhtml1 = $strhtml1 . "No New Acknowledged Orders.";
    }
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml1 = $strhtml1 . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "<DIV>";
            //var_dump($oneordernode);
            $strhtml1 = $strhtml1 . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml1 = $strhtml1 . "<DIV>";
                    $strhtml1 = $strhtml1 . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml1 = $strhtml1 . "<a href=" . "/shipitem.php?oid=dc-".$orderid."&oitid=dc-".$oneorderitemnode->{"order_item_id"} . " target=\"_blank\">Acknowledge : </a>";
                    $strhtml1 = $strhtml1 . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "</DIV>";
            }
            $strhtml1 = $strhtml1 . "</DIV>";
    }
    return $strhtml1;
}

function GetCreatedOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml1 = "";
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'created');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml1 = $strhtml1 . "Created Order IDs : ";
    }
    else {
            $strhtml1 = $strhtml1 . "No New Created Orders.";
    }
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml1 = $strhtml1 . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "<DIV>";
            //var_dump($oneordernode);
            $strhtml1 = $strhtml1 . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml1 = $strhtml1 . "<DIV>";
                    $strhtml1 = $strhtml1 . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml1 = $strhtml1 . "<a href=" . "/shipitem.php?oid=dc-".$orderid."&oitid=dc-".$oneorderitemnode->{"order_item_id"} . " target=\"_blank\">Acknowledge : </a>";
                    $strhtml1 = $strhtml1 . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "</DIV>";
            }
            $strhtml1 = $strhtml1 . "</DIV>";
    }
    return $strhtml1;
}

function GetInProgressOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml1 = "";
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'inprogress');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml1 = $strhtml1 . "InProgress Order IDs : ";
    }
    else {
            $strhtml1 = $strhtml1 . "No New InProgress Orders.";
    }
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml1 = $strhtml1 . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "<DIV>";
            //var_dump($oneordernode);
            $strhtml1 = $strhtml1 . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml1 = $strhtml1 . "<DIV>";
                    $strhtml1 = $strhtml1 . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml1 = $strhtml1 . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "</DIV>";
            }
            $strhtml1 = $strhtml1 . "</DIV>";
    }
    return $strhtml1;
}

function GetCompleteOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml1 = "";
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'complete');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml1 = $strhtml1 . "Complete Order IDs : ";
    }
    else {
            $strhtml1 = $strhtml1 . "No New Complete Orders.";
    }
    $strhtml1 = $strhtml1 . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml1 = $strhtml1 . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "<DIV>";
            //var_dump($oneordernode);
            $strhtml1 = $strhtml1 . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml1 = $strhtml1 . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml1 = $strhtml1 . "<DIV>";
                    $strhtml1 = $strhtml1 . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml1 = $strhtml1 . $LINE_BREAK;
                    $strhtml1 = $strhtml1 . "</DIV>";
            }
            $strhtml1 = $strhtml1 . "</DIV>";
    }
    return $strhtml1;
}

$str = GetReadyOrders();
echo $str;

echo "<HR>";

$str = GetAcknowledgedOrders();
echo $str;

echo "<HR>";

$str = GetCreatedOrders();
echo $str;

echo "<HR>";

$str = GetInProgressOrders();
echo $str;

echo "<HR>";

$str = GetCompleteOrders();
echo $str;

?>
 </body>
</html>