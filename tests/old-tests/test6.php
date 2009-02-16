<?php
require_once('../../includes/core.php');

require_once($stLoad->get('proxy', 'core'));

$testProxy = new stProxy('http://example.com');

$loadResult = $testProxy->proxyExecute();

if ($loadResult === true) {
	echo "<h1>Loaded</h1><br />";
	$dBug->o($testProxy);
} else {
	echo "<h1>Error</h1><br />";
}

?>