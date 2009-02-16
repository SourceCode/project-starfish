<?php
require_once('../../includes/core.php');

require_once($stLoad->get('xml', 'core'));


$xmlFile = 'http://www.webcredible.co.uk/user-friendly-resources/usability.rss';

$xmlObject = new stXML();
$xmlObject->openXMLFile($xmlFile);

$dBug->o($xmlObject);
?>