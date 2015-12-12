<?php

// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
require_once 'HTTP/Request2.php';
//require_once 'OrdersInfo.php';

class OrdersAPI
{
    public function GetAllOrdersNodes(AuthInfo $authinfo)
    {
        $retval = array();
        $allnodes = $this->GetOrdersLinks($authinfo);
        //var_dump($allnodes);
        $allnodeURLs = $allnodes->{'order_urls'};
        $i = 0;
        foreach($allnodeURLs as $onenodeURL) {
            $onenodeURLElements = explode("/", $onenodeURL);
            $orderid = $onenodeURLElements[3];
            $orderinfo = $this->GetOrdersNode($authinfo, $orderid);
            //var_dump($orderid);
            ///echo "status = " . strtolower($orderinfo->{"status"});

            // not needed - $json_obj = json_encode($orderinfo);
            $retval[$i] = $orderid;
            $i++;
        }
        return $retval;
    }
    public function GetOrdersLinks(AuthInfo $authinfo)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/orders/ready');
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
    
    
    public function GetOrder(AuthInfo $authinfo , $id)
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
    public function PutOrderStatus(AuthInfo $authinfo, $id, $orderdetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/orders/'.$id.'/acknowledge');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

     //   $orderinfo = $this->GetOrdersNode($authinfo, $id);
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