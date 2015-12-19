 <?php
 
require_once 'HTTP/Request2.php';

require_once 'AuthAPI.php';
require_once 'TaxonomyAPI.php';
require_once 'ProductAPI.php';
require_once 'OrdersAPI.php';
require_once 'ReturnAPI.php';

//$DELIM = "\r\n";
$DELIM = ",";
$MULTIVAL_DELIM = ";";
$NEW_LINE = "\n";

$authobj = new AuthAPI();
$authinfo = new AuthInfo();
$authinfo = $authobj->GetToken();
$authobj->VerifyToken($authinfo);

$taxobj = new TaxonomyAPI();
$productobj = new ProductAPI();
$returnobj = new ReturnAPI();


function Convert2Date($datestr){
    if(empty($datestr))
        return "";
    date_default_timezone_set('America/New_York');
    $dt = new DateTime($datestr);
    return $dt->format('Y-m-d');
}

function SafeGetProperty($obj, $property){
    if (property_exists($obj, $property))
        return SafeGetValue($obj->{$property});
    return "";
}
function SafeGetValue($val){
    if (isset($val))
        return $val;
    return "";
}

function GetAllOrders($status) {

    global $authinfo;

    $orderobj = new OrdersAPI();
    $allordernodes = $orderobj->GetAllOrdersNodes($authinfo,$status);
    $json_str = json_encode($allordernodes,JSON_PRETTY_PRINT);
    //var_dump($json_str);
}

function GetCompleteOrdersCSV($allcompletedorders) {

    global $authinfo;
    global $DELIM;
    global $MULTIVAL_DELIM;
    global $NEW_LINE;
    

    $orderobj = new OrdersAPI();
    $allcompletedorders = $orderobj->GetAllOrdersNodes($authinfo,'complete');
    $json_str = json_encode($allcompletedorders,JSON_PRETTY_PRINT);
    //var_dump($json_str);

    $csvline = "";

    {
            $csvline = $csvline . "\"OrderId\"" . $DELIM;
            $csvline = $csvline . "\"Order Status\""  . $DELIM;
            $csvline = $csvline . "\"Order Placed date\""  . $DELIM;
            $csvline = $csvline . "\"Order Ready date\""  . $DELIM;
            $csvline = $csvline . "\"Order Acknowledge date\""  . $DELIM;
            $csvline = $csvline . "\"Request Ship By\""  . $DELIM;
            $csvline = $csvline . "\"Request Delivery By\""  . $DELIM;
            {
                    $csvline = $csvline . "\"Order_item_id\""  . $DELIM;
                    $csvline = $csvline . "\"Merchant_sku\""  . $DELIM;
                    $csvline = $csvline . "\"Quanitity\""  . $DELIM;
            }
            $csvline = $csvline . "\"Order item base price\""  . $DELIM;
            $csvline = $csvline . "\"Reference Order id\""  . $DELIM;

            $csvline = $csvline . "\"Shipping To Name\""  . $DELIM;
            $csvline = $csvline . "\"Shipping To PhoneNumber\""  . $DELIM;
            $csvline = $csvline . "\"Shipping To Address 1\""  . $DELIM;
            $csvline = $csvline . "\"Shipping To Address 2\""  . $DELIM;
            $csvline = $csvline . "\"Shipping To City\""  . $DELIM;
            $csvline = $csvline . "\"Shipping To State\""  . $DELIM;
            $csvline = $csvline . "\"Shipping To Zipcode\""  . $DELIM;

            $csvline = $csvline . "\"Shipment Tracking Number\""  . $DELIM;

            $csvline = $csvline . $NEW_LINE;

    }
    foreach($allcompletedorders as $orderid => $oneordernode) {
            $csvline = $csvline .  $orderid . $DELIM;
            $csvline = $csvline .  "\"" .$oneordernode->{"status"} . "\"" . $DELIM;
            $csvline = $csvline .  "\"" .Convert2Date($oneordernode->{"order_placed_date"}) . "\"" .$DELIM;
            $csvline = $csvline .  "\"" .Convert2Date($oneordernode->{"order_ready_date"}) . "\"" .$DELIM;
            $csvline = $csvline .  "\"" .Convert2Date($oneordernode->{"order_acknowledge_date"}) . "\"" .$DELIM;
            $csvline = $csvline .  "\"" .Convert2Date($oneordernode->{"order_detail"}->{"request_ship_by"}) . "\"" .$DELIM;
            $csvline = $csvline .  "\"" .Convert2Date($oneordernode->{"order_detail"}->{"request_delivery_by"}) . "\"" .$DELIM;
            foreach($oneordernode->{"order_items"} as $oneorderitemnode) {
                    $csvline = $csvline . "\"" .$oneorderitemnode->{"order_item_id"} . "\"" .$DELIM;
                    $csvline = $csvline . "\"" .$oneorderitemnode->{"merchant_sku"} . "\"" .$DELIM;
                    $csvline = $csvline . "\"" .$oneorderitemnode->{"request_order_quantity"} . "\"" .$DELIM;
            }
            $csvline = $csvline . "\"" .$oneordernode->{"order_totals"}->{"item_price"}->{"base_price"} . "\"" .$DELIM;
            $csvline = $csvline . "\"" .$oneordernode->{"reference_order_id"} . "\"" .$DELIM;

            $csvline = $csvline . "\"" .$oneordernode->{"shipping_to"}->{"recipient"}->{"name"} . "\"" .$DELIM;
            $csvline = $csvline . "\"" .$oneordernode->{"shipping_to"}->{"recipient"}->{"phone_number"} . "\"" .$DELIM;
            $csvline = $csvline . "\"" .$oneordernode->{"shipping_to"}->{"address"}->{"address1"} . "\"" .$DELIM;
            $csvline = $csvline . "\"" .$oneordernode->{"shipping_to"}->{"address"}->{"address2"} . "\"" .$DELIM;
            $csvline = $csvline . "\"" .$oneordernode->{"shipping_to"}->{"address"}->{"city"} . "\"" .$DELIM;
            $csvline = $csvline . "\"" .$oneordernode->{"shipping_to"}->{"address"}->{"state"} . "\"" .$DELIM;
            $csvline = $csvline . "\"" .$oneordernode->{"shipping_to"}->{"address"}->{"zip_code"} . "\"" .$DELIM;

            $shipmentline = "";
            foreach($oneordernode->{"shipments"} as $oneordershipmentnode) {
                    //var_dump($oneordershipmentnode);
                    $shipmentline = $shipmentline . SafeGetProperty($oneordershipmentnode, "shipment_tracking_number") . $MULTIVAL_DELIM;
            }
            $csvline = $csvline . "\"" .$shipmentline . "\"" .$DELIM;

            $csvline = $csvline . $NEW_LINE;

    }
    return $csvline;

}

$allcompletedorders = GetAllOrders('complete');
$retstr = GetCompleteOrdersCSV($allcompletedorders);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.'allorders.csv'.'";');
header("Pragma: no-cache");
header("Expires: 0");

// open the "output" stream
// see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
$f = fopen('php://output', 'w');
fwrite($f, $retstr);


?>