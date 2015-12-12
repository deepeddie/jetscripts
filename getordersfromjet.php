<html>
 <head>
  <title>Order Dashboard</title>
 </head>
 <body>
 <?php
 
require_once 'HTTP/Request2.php';

require_once 'AuthAPI.php';
require_once 'TaxonomyAPI.php';
require_once 'ProductAPI.php';
require_once 'OrdersAPI.php';
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
    
    $strhtml = "";
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'ready');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml = $strhtml . "Ready Order IDs : ";
    }
    else {
            $strhtml = $strhtml . "No New Ready Orders.";
    }
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml = $strhtml . $LINE_BREAK;
            $strhtml = $strhtml . "<DIV>";
            //var_dump($oneordernode);
            $strhtml = $strhtml . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml = $strhtml . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml = $strhtml . "<DIV>";
                    $strhtml = $strhtml . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml = $strhtml . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml = $strhtml . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml = $strhtml . "<a href=" . "/acknowledgeorderitem.php?oid=".$orderid."&oitid=".$oneorderitemnode->{"order_item_id"} . " target=\"_blank\">Acknowledge : </a>";
                    $strhtml = $strhtml . $LINE_BREAK;
                    $strhtml = $strhtml . "</DIV>";
            }
            $strhtml = $strhtml . "</DIV>";
    }
    return $strhtml;
}

function GetAcknowledgedOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml = "";
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'acknowledged');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml = $strhtml . "Acknowledged Order IDs : ";
    }
    else {
            $strhtml = $strhtml . "No New Acknowledged Orders.";
    }
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml = $strhtml . $LINE_BREAK;
            $strhtml = $strhtml . "<DIV>";
            //var_dump($oneordernode);
            $strhtml = $strhtml . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml = $strhtml . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml = $strhtml . "<DIV>";
                    $strhtml = $strhtml . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml = $strhtml . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml = $strhtml . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml = $strhtml . "<a href=" . "/shipitem.php?oid=".$orderid."&oitid=".$oneorderitemnode->{"order_item_id"} . " target=\"_blank\">Ship : </a>";
                    $strhtml = $strhtml . $LINE_BREAK;
                    $strhtml = $strhtml . "</DIV>";
            }
            $strhtml = $strhtml . "</DIV>";
    }
    return $strhtml;
}

function GetCreatedOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml = "";
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'created');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml = $strhtml . "Created Order IDs : ";
    }
    else {
            $strhtml = $strhtml . "No New Created Orders.";
    }
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml = $strhtml . $LINE_BREAK;
            $strhtml = $strhtml . "<DIV>";
            //var_dump($oneordernode);
            $strhtml = $strhtml . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml = $strhtml . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml = $strhtml . "<DIV>";
                    $strhtml = $strhtml . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml = $strhtml . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml = $strhtml . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml = $strhtml . $LINE_BREAK;
                    $strhtml = $strhtml . "</DIV>";
            }
            $strhtml = $strhtml . "</DIV>";
    }
    return $strhtml;
}

function GetInProgressOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml = "";
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'inprogress');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml = $strhtml . "InProgress Order IDs : ";
    }
    else {
            $strhtml = $strhtml . "No New InProgress Orders.";
    }
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml = $strhtml . $LINE_BREAK;
            $strhtml = $strhtml . "<DIV>";
            //var_dump($oneordernode);
            $strhtml = $strhtml . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml = $strhtml . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml = $strhtml . "<DIV>";
                    $strhtml = $strhtml . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml = $strhtml . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml = $strhtml . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml = $strhtml . $LINE_BREAK;
                    $strhtml = $strhtml . "</DIV>";
            }
            $strhtml = $strhtml . "</DIV>";
    }
    return $strhtml;
}

function GetCompleteOrders() {

    global $authinfo;
    global $LINE_BREAK;
    
    $strhtml = "";
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,'complete');
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    if(count($allordernodes) > 0) {
            $strhtml = $strhtml . "Complete Order IDs : ";
    }
    else {
            $strhtml = $strhtml . "No New Complete Orders.";
    }
    $strhtml = $strhtml . $LINE_BREAK.$LINE_BREAK;
    foreach($allordernodes as $orderid => $oneordernode) {
            $strhtml = $strhtml . $LINE_BREAK;
            $strhtml = $strhtml . "<DIV>";
            //var_dump($oneordernode);
            $strhtml = $strhtml . "OrderId : " . $orderid . $LINE_BREAK;
            $strhtml = $strhtml . "Order place date : " . $oneordernode->{"order_placed_date"} . $LINE_BREAK;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $strhtml = $strhtml . "<DIV>";
                    $strhtml = $strhtml . "order_item_id : " . $oneorderitemnode->{"order_item_id"} . $LINE_BREAK;
                    $strhtml = $strhtml . "merchant_sku : " . $oneorderitemnode->{"merchant_sku"} . $LINE_BREAK;
                    $strhtml = $strhtml . "quanitity : " . $oneorderitemnode->{"request_order_quantity"} . $LINE_BREAK;

                    $strhtml = $strhtml . $LINE_BREAK;
                    $strhtml = $strhtml . "</DIV>";
            }
            $strhtml = $strhtml . "</DIV>";
    }
    return $strhtml;
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