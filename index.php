<?php

require('code/siteChecker.php');

    $checker= new siteChecker("http://dontbealone.org/notfound.php");
    //$checker= new siteChecker("http://timmahahhahsad.com");
    echo $checker->check();

?>