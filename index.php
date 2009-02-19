<?php
require_once('includes/core.php');

/*  This try catch will eventually be removed and moved to global exception handler. */
try {
    $controller = stController::getInstance();
    $controller->dispatch();
    stLogFile::systemLog('this is a log test');
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";  
}
?>