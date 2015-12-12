<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?php 
// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
require_once 'HTTP/Request2.php';

class ReturnAPI
{

public function GetAllReturnOrder(AuthInfo $authinfo)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/returns/created');
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
    
    
    public function GetOneReurnOrder(AuthInfo $authinfo , $id)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/returns/state/'.$id);
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
    
    
    
     public function PutOrdestatus(AuthInfo $authinfo, $id , $ordeerdetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/returns/'.$id.'/acknowledge');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = json_encode($ordeerdetails);
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
    
    public function PutOrderComplete(AuthInfo $authinfo, $id , $ordeerdetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/returns/'.$id.'/complete');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = json_encode($ordeerdetails);
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
    
    
}
?>
