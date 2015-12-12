<?php

// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
require_once 'HTTP/Request2.php';
require_once 'AuthInfo.php';

class AuthAPI
{
    
    public function GetToken()
    {
        $headers = array(
           'Content-Type' => 'application/json',
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/token/');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setHeader($headers);

        $bodyvalue = '{
          "user": "24CB2A75D997F31067D36955FAEAEADC304104BD",
          "pass": "ydQhk8uLlta/BCE/crjyTqiBFxkPiT2V8Ch2l8XErrF0"
        }';

        $request->setBody($bodyvalue);
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
           
           $authinfo = new AuthInfo();
           $authinfo->_id_token = $jsonresp->{'id_token'};
           $authinfo->_token_type = $jsonresp->{'token_type'};
           $authinfo->_expires_on = $jsonresp->{'expires_on'};
           
           return $authinfo;
        }
        catch (HttpException $ex)
        {
           echo $ex;
           return null;
        }
    }
    public function VerifyToken(AuthInfo $authinfo)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/authcheck/');
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
           //$jsonresp = json_decode($bodyresponse);
           
           return true;
        }
        catch (HttpException $ex)
        {
           echo $ex;
           return false;
        }
    }
}
?>
