<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version 002-testLogging.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category tests
 */


/**
 * Used to make sure exception handling is working correctly
 */
 
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