<?php

// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
require_once 'HTTP/Request2.php';
//require_once 'OrdersInfo.php';

class OrdersAPI
{
    public function GetAllOrdersNodes(AuthInfo $authinfo, $status)
    {
        $retval = array();
        $allnodes = $this->GetOrdersLinks($authinfo,$status);
        //var_dump($allnodes);
        $allnodeURLs = $allnodes->{'order_urls'};
        $i = 0;
        foreach($allnodeURLs as $onenodeURL) {
            $onenodeURLElements = explode("/", $onenodeURL);
            $orderid = $onenodeURLElements[3];
            $orderinfo = $this->GetOrdersNode($authinfo, $orderid);

            $json_obj = json_encode($orderinfo,JSON_PRETTY_PRINT);
            //file_put_contents("orderinfo.json", $json_obj);
            //$strtempl = "{ \"orderid\":%s, \"order_item_id\":%s }";
            //$ordertuple = sprintf($strtempl, $orderid, $orderinfo->{"order_items"}[0]->{"order_item_id"});
            

            $retval[$orderid] = $orderinfo;
            $i++;
        }
        return $retval;
    }
    
    public function GetOrdersLinks(AuthInfo $authinfo, $status)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/orders/'.$status);
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setHeader($headers);

        $request->setBody("");
	      $request->setConfig(array(
    		          'ssl_verify_peer'   => FALSE,
    		          'ssl_verify_host'   => FALSE
		    ));
        try
        {
           $response = $request->send();

           //echo $response->getBody();
           $bodyresponse = $response->getBody();
           $jsonresp = json_decode($bodyresponse);
           
           return $jsonresp;
        }
        catch (HttpException $ex)
        {
           echo $ex;
           return '{}';
        }
    }
    
    public function GetOrdersNode(AuthInfo $authinfo , $id)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );
                        ///orders/withoutShipmentDetail/{id}
        $request = new Http_Request2('https://merchant-api.jet.com/api/orders/withoutShipmentDetail/'.$id);
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setHeader($headers);

        $request->setBody("");
        $request->setConfig(array(
                'ssl_verify_peer'   => FALSE,
                'ssl_verify_host'   => FALSE
                ));
        try
        {
           $response = $request->send();

           //echo $response->getBody();
           $bodyresponse = $response->getBody();
           $jsonresp = json_decode($bodyresponse);
           
           return $jsonresp;
        }
        catch (HttpException $ex)
        {
           echo $ex;
           return null;
        }
    }

    public function AcknowledgeOrder(AuthInfo $authinfo, $id, $orderdetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/orders/'.$id.'/acknowledge');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = json_encode($orderdetails);
        
        $request->setBody($bodycontent);
        $request->setConfig(array(
                'ssl_verify_peer'   => FALSE,
                'ssl_verify_host'   => FALSE
                ));
        try
        {
           $response = $request->send();

           //echo $response->getBody();
           $bodyresponse = $response->getBody();
           $jsonresp = $bodyresponse;
           
           return $jsonresp;
        }
        catch (HttpException $ex)
        {
           echo $ex;
           return null;
        }
    }

    public function PutOrderShipment(AuthInfo $authinfo, $id, $orderdetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/orders/'.$id.'/shipped');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

   
        $bodycontent = json_encode($orderdetails);
        $request->setBody($bodycontent);
        $request->setConfig(array(
                'ssl_verify_peer'   => FALSE,
                'ssl_verify_host'   => FALSE
                ));
        try
        {
           $response = $request->send();

           
           $bodyresponse = $response->getBody();
           $jsonresp = $bodyresponse;
           
           return $jsonresp;
        }
        catch (HttpException $ex)
        {
           echo $ex;
           return null;
        }
    }

    public function GetOrderCancelled(AuthInfo $authinfo)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/orders/directedCancel');
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setHeader($headers);

        $request->setBody("");
        $request->setConfig(array(
                'ssl_verify_peer'   => FALSE,
                'ssl_verify_host'   => FALSE
                ));
        try
        {
           $response = $request->send();

           echo $response->getBody();
           $bodyresponse = $response->getBody();
           $jsonresp = json_decode($bodyresponse);
           
           return $jsonresp;
        }
        catch (HttpException $ex)
        {
           echo $ex;
           return '{}';
        }
    }
}
?>
