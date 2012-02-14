<?php
/**
 * Date: 2/13/12
 * Time: 10:27 PM
 **/

require_once('../moveIt/aws/sdk.class.php');

class notify
{
    var $notify_list, $sns;

    function __construct($notify_list='arn:aws:sns:us-east-1:482819455284:1_hour_bucket')
    {
        $this->notify_list=$notify_list;
        $this->sns=  new AmazonSNS();

    }

    function sendNotify($message){
        $response=$this->sns->publish($this->notify_list,$message);
        return $response->isOK();
    }


}
