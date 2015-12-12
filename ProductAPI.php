<?php

// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
require_once 'HTTP/Request2.php';

class ProductAPI
{

    public function GetAllSKUDetails(AuthInfo $authinfo)
    {
        $allskus = $this->GetAllSKUs($authinfo);
        
        $allskuURLs = $allskus->{'sku_urls'};
        foreach($allskuURLs as $oneskuURL)
        {
            $oneskudetails = explode("/", $oneskuURL);
            $sku = $oneskudetails[1];
            $skuinfo = $this->GetSKU($authinfo, $sku);
            $this->GetSKUPrice($authinfo, $sku);
            $this->GetSKUInventory($authinfo, $sku);
        }
    }
    public function GetAllSKUs(AuthInfo $authinfo)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus');
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
    public function GetSKU(AuthInfo $authinfo, $sku)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku);
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
           return null;
        }
    }
    public function GetSKUPrice(AuthInfo $authinfo, $sku)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku.'/price');
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
           return null;
        }
    }
    public function GetSKUInventory(AuthInfo $authinfo, $sku)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku.'/inventory');
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
           return null;
        }
    }

    public function PutSKU(AuthInfo $authinfo, $sku, $proddetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku);
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = json_encode($proddetails);
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
    public function PutPrice(AuthInfo $authinfo, $sku, $proddetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku.'/price');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = json_encode($proddetails);
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

    public function PutInventory(AuthInfo $authinfo, $sku, $proddetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku.'/inventory');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = json_encode($proddetails);
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
    
    /* by madhu */
    public function PutRelationshipproduct(AuthInfo $authinfo, $sku, $proddetails)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku.'/Relationship');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = json_encode($proddetails);
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
    
    public function ArchiveSKU(AuthInfo $authinfo, $sku)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku.'/status/true');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = "";
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

    public function ResurrectSKU(AuthInfo $authinfo, $sku)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku.'/status/false');
        $request->setMethod(HTTP_Request2::METHOD_PUT);
        $request->setHeader($headers);

        $bodycontent = "";
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

    
    public function DeleteSKU(AuthInfo $authinfo, $sku , $oneprod)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/merchant-skus/'.$sku .'/image');
        $request->setMethod(HTTP_Request2::METHOD_DELETE);
        $request->setHeader($headers);

        $bodycontent = "";
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
