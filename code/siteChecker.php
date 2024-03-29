<?php
/**
 * https://github.com/tagroup/Is-My-Server-Running
 * Date: 2/7/12
 * Time: 6:06 PM
 */
require_once('notify.php');
class siteChecker
{
    var $siteURL, $pageData, $pageInfo;
    var $httpCodes = array();


    function __construct($sURL= '')
    {

        if($sURL=='')
        {
            //TODO: throw error

        }
        else
        {
            //TODO: add check to clean up inputed url
            $this->siteURL=$sURL;
        }
        $this->httpErrorsLoad();
    }

    function check()
    {
        $this->getSiteInfo();
        if($this->isOK())
        {
            echo "Site is running!";
        }
        else
        {
            //TODO: make not hack
            $message=$this->siteURL . " is down.  " .$this->returnCodePretty();
            $notify= new notify();
            echo $notify->sendNotify($message);
        }
    }
    function returnCodePretty()
    {
        if($this->httpCodes[$this->pageInfo['http_code']]!='')
        {

            return $this->httpCodes[$this->pageInfo['http_code']];
        }
        else
        {
            //TODO: some error occurred handle it
            return "No error code found.";
        }
    }
    private function getSiteInfo()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->siteURL);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        $this->pageData = curl_exec($ch);
        $this->pageInfo= curl_getinfo($ch);
        curl_close($ch);
    }
    function isOK($codes = array(200, 201, 202,203, 204, 205, 206))
    {
        if (is_array($codes))
        {
            return in_array($this->pageInfo['http_code'], $codes);
        }

        return $this->pageInfo['http_code'] === $codes;
    }
    function httpErrorsLoad()
    {
        //hidden here so I do not have to look at it.
        //source: http://consense-project.com/2011/05/http-error-codes-as-php-array/
        $httpErrorCodes = array();
        $httpErrorCodes['100'] = 'Continue - Only a part of the request has been received by the server, but as long as it has not been rejected, the client should continue with the request';
        $httpErrorCodes['101'] = 'Switching Protocols - The server switches protocol ';
        $httpErrorCodes['200'] = 'OK - The request is OK';
        $httpErrorCodes['201'] = 'Created - The request is complete, and a new resource is created ';
        $httpErrorCodes['202'] = 'Accepted - The request is accepted for processing, but the processing is not complete';
        $httpErrorCodes['203'] = 'Non-authoritative Information';
        $httpErrorCodes['204'] = 'No Content';
        $httpErrorCodes['205'] = 'Reset Content';
        $httpErrorCodes['206'] = 'Partial Content';
        $httpErrorCodes['300'] = 'Multiple Choices - A link list. The user can select a link and go to that location. Maximum five addresses';
        $httpErrorCodes['301'] = 'Moved Permanently - The requested page has moved to a new url';
        $httpErrorCodes['302'] = 'Found - The requested page has moved temporarily to a new url';
        $httpErrorCodes['303'] = 'See Other - The requested page can be found under a different url';
        $httpErrorCodes['304'] = 'Not Modified';
        $httpErrorCodes['305'] = 'Use Proxy';
        $httpErrorCodes['306'] = 'Unused - This code was used in a previous version. It is no longer used, but the code is reserved';
        $httpErrorCodes['307'] = 'Temporary Redirect - The requested page has moved temporarily to a new url';
        $httpErrorCodes['400'] = 'Bad Request - The server did not understand the request';
        $httpErrorCodes['401'] = 'Unauthorized - The requested page needs a username and a password';
        $httpErrorCodes['402'] = 'Payment Required - You can not use this code yet';
        $httpErrorCodes['403'] = 'Forbidden - Access is forbidden to the requested page';
        $httpErrorCodes['404'] = 'Not Found - The server can not find the requested page';
        $httpErrorCodes['405'] = 'Method Not Allowed - The method specified in the request is not allowed';
        $httpErrorCodes['406'] = ' Not Acceptable - The server can only generate a response that is not accepted by the client';
        $httpErrorCodes['407'] = 'Proxy Authentication Required - You must authenticate with a proxy server before this request can be served';
        $httpErrorCodes['408'] = 'Request Timeout - The request took longer than the server was prepared to wait';
        $httpErrorCodes['409'] = 'Conflict - The request could not be completed because of a conflict';
        $httpErrorCodes['410'] = 'Gone - The requested page is no longer available';
        $httpErrorCodes['411'] = 'Length Required - The "Content-Length" is not defined. The server will not accept the request without it';
        $httpErrorCodes['412'] = 'Precondition Failed - The precondition given in the request evaluated to false by the server';
        $httpErrorCodes['413'] = 'Request Entity Too Large - The server will not accept the request, because the request entity is too large';
        $httpErrorCodes['414'] = 'Request-url Too Long - The server will not accept the request, because the url is too long. Occurs when you convert a "post" request to a "get" request with a long query information';
        $httpErrorCodes['415'] = 'Unsupported Media Type - The server will not accept the request, because the media type is not supported';
        $httpErrorCodes['416'] = 'Requested Range not satisfiable';
        $httpErrorCodes['417'] = 'Expectation Failed';
        $httpErrorCodes['500'] = 'Internal Server Error - The request was not completed. The server met an unexpected condition';
        $httpErrorCodes['501'] = 'Not Implemented - The request was not completed. The server did not support the functionality required';
        $httpErrorCodes['502'] = 'Bad Gateway - The request was not completed. The server received an invalid response from the upstream server';
        $httpErrorCodes['503'] = 'Service Unavailable - The request was not completed. The server is temporarily overloading or down';
        $httpErrorCodes['504'] = 'Gateway Timeout - The gateway has timed out';
        $httpErrorCodes['505'] = 'HTTP Version Not Supported - The server does not support the "http protocol" version';
        $this->httpCodes=$httpErrorCodes;

    }
}
