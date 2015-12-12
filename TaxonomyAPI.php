<?php

// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
require_once 'HTTP/Request2.php';
//require_once 'TaxonomyInfo.php';

class TaxonomyAPI
{
    
    public function GetAllTaxonomyNodes(AuthInfo $authinfo, $offset)
    {
        $allnodes = $this->GetTaxonomyLinks($authinfo, $offset);
        
        if( $allnodes == null )
            return false;
        
        $allnodeURLs = $allnodes->{'node_urls'};
        foreach($allnodeURLs as $onenodeURL)
        {
            $onenodedetails = explode("/", $onenodeURL);
            $nodeid = $onenodedetails[3];
            $nodeinfo = $this->GetTaxonomyNode($authinfo, $nodeid);
            $nodeattributeinfo = $this->GetTaxonomyNodeAttributes($authinfo, $nodeid);

        }
        return true;
    }
    public function GetTaxonomyLinks(AuthInfo $authinfo, $offset)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        // example request = new Http_Request2('https://merchant-api.jet.com/api/taxonomy/links/v1?offset=4000');
        $request = new Http_Request2('https://merchant-api.jet.com/api/taxonomy/links/v1?offset='.$offset);
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
    public function GetTaxonomyNode(AuthInfo $authinfo, $nodeid)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/taxonomy/nodes/'.$nodeid);
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
           
           //if( stripos($bodyresponse, 'iphone'  ) ){
           //    echo 'found iphone';
           //}
           return $jsonresp;
        }
        catch (HttpException $ex)
        {
           echo 'Exception caught : ' . $ex;
           return null;
        }
    }
    public function GetTaxonomyNodeAttributes(AuthInfo $authinfo, $nodeid)
    {
        $headers = array(
           'Content-Type' => 'application/json',
            'Authorization' => $authinfo->_token_type . ' ' . $authinfo->_id_token,
        );

        $request = new Http_Request2('https://merchant-api.jet.com/api/taxonomy/nodes/'.$nodeid.'/attributes');
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
           
           //if( stripos($bodyresponse, 'iphone'  ) ){
           //    echo 'found iphone';
           //}
           return $jsonresp;
        }
        catch (HttpException $ex)
        {
           echo 'Exception caught : ' . $ex;
           return null;
        }
    }
}
?>
