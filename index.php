<?php

require('code/siteChecker.php');

    $checker= new siteChecker("http://dontbealone.org");
    echo $checker->check();

?>