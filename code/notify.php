<?php
/**
 * Date: 2/13/12
 * Time: 10:27 PM
 * For now, this class relies on the AWS PHP SDK which has to be installed seperately
 **/

require_once('../../../code/moveIt/aws/sdk.class.php');  //link to aws class - not needed if PEAR install is used

class notify
{
    var $notify_list, $sns;
//Is set this to the topic id for my use TODO: move to configuration file
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
