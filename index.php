<?php
require_once('includes/core.php');

/*  This try catch will eventually be removed and moved to global exception handler. */
try {
    $controller = stController::getInstance();
    $controller->dispatch();
    $dBug->o($controller);
} catch (Exception $e) {
    $dBug->o($controller);
    echo 'Caught exception: ',  $e->getMessage(), "\n";  
}
?>