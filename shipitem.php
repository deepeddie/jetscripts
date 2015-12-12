<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Ship Item</title>
    <link rel="stylesheet" type="text/css" href="shipform/view.css" media="all">
    <script type="text/javascript" src="shipform/view.js"></script>
    <script type="text/javascript" src="shipform/calendar.js"></script>
</head>

<body id="main_body">
    <?php
    $ispostback = false;
    $strret = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST')
        $ispostback = true;
    ?>
    <?php
        
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    function submitshipmenttojet($oid, $jsondata){
        require_once 'HTTP/Request2.php';

        require_once 'AuthAPI.php';
        require_once 'OrdersAPI.php';

        //$LINE_BREAK = "\r\n";
        $LINE_BREAK = "<BR>";

        $authobj = new AuthAPI();
        $authinfo = new AuthInfo();
        $authinfo = $authobj->GetToken();
        $authobj->VerifyToken($authinfo);

        $orderobj = new OrdersAPI();
        $result = $orderobj->PutOrderShipment($authinfo, $oid, $jsondata);
        $strret = ""; 
        if( strlen($result) > 0) {
            $strret = $strret . "Shipment Error for Order : ".$oid . $LINE_BREAK;
            $strret = $strret . "Error is : ".$result . $LINE_BREAK;
        }
        else {
            $strret = $strret . "Shipment Order Success " . $LINE_BREAK;
        }
        return $strret;
    }
    if($ispostback){
        date_default_timezone_set('America/New_York');
        // define variables and set to empty values
        $oid = test_input($_REQUEST["oid"]);

        $sku = test_input($_POST["element_1"]);
        $qty = test_input($_POST["element_8"]);
        $trackingnumber = test_input($_POST["element_2"]);
        $shipmethod = test_input($_POST["element_7"]);
        $carrier = test_input($_POST["element_5"]);

        $shipdate_1 = test_input($_POST["element_3_1"]);//MM
        $shipdate_2 = test_input($_POST["element_3_2"]);//DD
        $shipdate_3 = test_input($_POST["element_3_3"]);//YYYY
        $shipdate = new DateTime($shipdate_3.'-'.$shipdate_1.'-'.$shipdate_2);
        $shipdate = $shipdate->format(DateTime::ISO8601);

        $deliverydate_1 = test_input($_POST["element_4_1"]);//MM
        $deliverydate_2 = test_input($_POST["element_4_2"]);//DD
        $deliverydate_3 = test_input($_POST["element_4_3"]);//YYYY
        $deliverydate = new DateTime($deliverydate_3.'-'.$deliverydate_1.'-'.$deliverydate_2);
        $deliverydate = $deliverydate->format(DateTime::ISO8601);

        $pickupdate_1 = test_input($_POST["element_6_1"]);//MM
        $pickupdate_2 = test_input($_POST["element_6_2"]);//DD
        $pickupdate_3 = test_input($_POST["element_6_3"]);//YYYY
        $pickupdate = new DateTime($pickupdate_3.'-'.$pickupdate_1.'-'.$pickupdate_2);
        $pickupdate = $pickupdate->format(DateTime::ISO8601);
        
        $filedetails = file_get_contents('shipment_template.json');
        $allshipments = json_decode($filedetails);
        
        $allshipments[0]->{"alt_order_id"} =                                $oid;
        
        $allshipments[0]->{"shipments"}[0]->{"shipment_tracking_number"} =  $trackingnumber;
        $allshipments[0]->{"shipments"}[0]->{"response_shipment_method"} =  $shipmethod;
        $allshipments[0]->{"shipments"}[0]->{"carrier"} =                   $carrier;
        $allshipments[0]->{"shipments"}[0]->{"response_shipment_date"} =    $shipdate;
        $allshipments[0]->{"shipments"}[0]->{"expected_delivery_date"} =    $deliverydate;
        $allshipments[0]->{"shipments"}[0]->{"carrier_pick_up_date"} =      $pickupdate;

        $allshipments[0]->{"shipments"}[0]->{"shipment_items"}[0]->{"shipment_item_id"} =       $trackingnumber;
        $allshipments[0]->{"shipments"}[0]->{"shipment_items"}[0]->{"alt_shipment_item_id"} =   $trackingnumber;
        $allshipments[0]->{"shipments"}[0]->{"shipment_items"}[0]->{"merchant_sku"} =           $sku;
        $allshipments[0]->{"shipments"}[0]->{"shipment_items"}[0]->{"response_shipment_sku_quantity"} = intval($qty);

        $str = json_encode($allshipments, JSON_PRETTY_PRINT);
        
        $strret = submitshipmenttojet($oid, $allshipments);
        
        
    }
    ?>
    
    <img id="top" src="shipform/top.png" alt="">
    <div id="form_container">

        <h1><a>Ship Item</a></h1>
        <form id="form_1081645" class="appnitro" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']."?oid=".$_REQUEST['oid']);?>">
            <div class="form_description">
                <h2>Ship Item</h2>
            </div>
            <ul>
                <li id="li_0">
                    <label class="description" for="element_0">Order ID</label>
                    <div>
                        <input readonly id="element_1" name="element_0" class="element text medium" type="text" maxlength="255" value="<?php echo $_REQUEST['oid']; ?>" />
                    </div>
                </li>
                <li id="li_1">
                    <label class="description" for="element_1">Merchant SKU </label>
                    <div>
                        <input id="element_1" name="element_1" class="element text medium" type="text" maxlength="255" value="" />
                    </div>
                </li>
                <li id="li_8">
                    <label class="description" for="element_8">Quantity </label>
                    <div>
                        <input id="element_8" name="element_8" class="element text medium" type="text" maxlength="255" value="" />
                    </div>
                </li>
                <li id="li_2">
                    <label class="description" for="element_2">Tracking # </label>
                    <div>
                        <input id="element_2" name="element_2" class="element text medium" type="text" maxlength="255" value="" />
                    </div>
                </li>
                <li id="li_7">
                    <label class="description" for="element_7">Shipment Method </label>
                    <div>
                        <input id="element_7" name="element_7" class="element text medium" type="text" maxlength="255" value="" />
                    </div>
                </li>
                <li id="li_5">
                    <label class="description" for="element_5">Carrier </label>
                    <div>
                        <input id="element_5" name="element_5" class="element text medium" type="text" maxlength="255" value="" />
                    </div>
                </li>
                <li id="li_3">
                    <label class="description" for="element_3">Shipment Date </label>
                    <span>
			<input id="element_3_1" name="element_3_1" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_3_1">MM</label>
		</span>
                    <span>
			<input id="element_3_2" name="element_3_2" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_3_2">DD</label>
		</span>
                    <span>
	 		<input id="element_3_3" name="element_3_3" class="element text" size="4" maxlength="4" value="" type="text">
			<label for="element_3_3">YYYY</label>
		</span>

                    <span id="calendar_3">
			<img id="cal_img_3" class="datepicker" src="shipform/calendar.gif" alt="Pick a date.">	
		</span>
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField: "element_3_3",
                            baseField: "element_3",
                            displayArea: "calendar_3",
                            button: "cal_img_3",
                            ifFormat: "%B %e, %Y",
                            onSelect: selectDate
                        });
                    </script>

                </li>
                <li id="li_4">
                    <label class="description" for="element_4">Expected Delivery Date </label>
                    <span>
			<input id="element_4_1" name="element_4_1" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_4_1">MM</label>
		</span>
                    <span>
			<input id="element_4_2" name="element_4_2" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_4_2">DD</label>
		</span>
                    <span>
	 		<input id="element_4_3" name="element_4_3" class="element text" size="4" maxlength="4" value="" type="text">
			<label for="element_4_3">YYYY</label>
		</span>

                    <span id="calendar_4">
			<img id="cal_img_4" class="datepicker" src="shipform/calendar.gif" alt="Pick a date.">	
		</span>
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField: "element_4_3",
                            baseField: "element_4",
                            displayArea: "calendar_4",
                            button: "cal_img_4",
                            ifFormat: "%B %e, %Y",
                            onSelect: selectDate
                        });
                    </script>

                </li>
                <li id="li_6">
                    <label class="description" for="element_6">Carrier Pickup Date </label>
                    <span>
			<input id="element_6_1" name="element_6_1" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_6_1">MM</label>
		</span>
                    <span>
			<input id="element_6_2" name="element_6_2" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_6_2">DD</label>
		</span>
                    <span>
	 		<input id="element_6_3" name="element_6_3" class="element text" size="4" maxlength="4" value="" type="text">
			<label for="element_6_3">YYYY</label>
		</span>

                    <span id="calendar_6">
			<img id="cal_img_6" class="datepicker" src="shipform/calendar.gif" alt="Pick a date.">	
		</span>
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField: "element_6_3",
                            baseField: "element_6",
                            displayArea: "calendar_6",
                            button: "cal_img_6",
                            ifFormat: "%B %e, %Y",
                            onSelect: selectDate
                        });
                    </script>

                </li>
                <li id="li_9" >
                    <label class="description" for="element_9">Result </label>
                    <div>
			<textarea id="element_9" name="element_9" class="element textarea medium" readonly><?php echo $strret; ?></textarea> 
                    </div> 
		</li>
                <li class="buttons">
                    <input type="hidden" name="form_id" value="1081645" />

                    <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
                </li>
            </ul>
        </form>
        <div id="footer">
        </div>
    </div>
    <img id="bottom" src="shipform/bottom.png" alt="">


</body>

</html>