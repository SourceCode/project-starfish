<?php 
require_once('../includes/core.php');

function testException($var)
{
    if ($var != 2)
    {
     throw new stException('This is a test exception');   
    }
}


try {
    testException(50);  
} catch(Exception $e) 
{
    echo 'Succesful Catch: ' .$e->getMessage() . '<br />';
} 

echo 'We have thrown a silent exception that is in the logs.';
throw new stException('This was a test of an unhandled exception');
