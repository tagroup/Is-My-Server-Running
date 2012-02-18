<?php
/**
 * Date: 2/16/12
 * Time: 11:56 PM
 * Description: checks to see if rss feed changes - sends an alert  - you must have writeable permissions in the cache directory
 **/
require_once('../code/notify.php');

//this has to run once to get the cache
$cached_file= file_get_contents('cache/raspberry.cache');
$temp_file=file_get_contents('http://www.raspberrypi.com/rss.php?type=atom');
//extra step over sha1_file but we can look at file
$new_file=sha1($temp_file);
file_put_contents('cache/raspberry.cache',$new_file);

if($cached_file==$new_file)
{
    echo 'Nothing Changed' , "\n";

}
else
{
    echo 'Everything is different', "\n";
    $message="http://raspberrypi.com has been updated.";
    $notify= new notify();
    echo $notify->sendNotify($message);

}
