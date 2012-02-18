<?php

require('code/siteChecker.php');

    $checker= new siteChecker("http://dontbealone.org/");
    //$checker= new siteChecker("http://timmahahhahsad.com");
    echo $checker->check();

?>