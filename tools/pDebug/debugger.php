<?php
require_once('../../includes/core.php');
require_once('resources/obj.pdebug.php');
require_once($stLoad->get('template', 'core'));

$templateControls = new stTemplate();


$pDebug = new pDebug();

$testString = 'Test Value';

$pDebug->printValue($testString);

$testBool = true;
$pDebug->printValue($testBool);

$testArray = array('orange', 'red', 'blue');
$pDebug->printValue($testArray);

$testObj = new stdClass();
$testObj->testVal = 123;
$testObj->testVal2 = 2123;
$pDebug->printValue($testObj);

#$dBug->o($pDebug);


// FIX OBJECT PROPERTY AND METHOD LISTERS + MORE!
function templateClassType($varType)
{
	if (strpos($varType, 'object')) {
		return 'objectRow';
	} else {
		return $varType . 'Row';
	}
}

//render debugger rows with template object
try {
	$debugTheme = $templateControls->loadTemplate($stFile->root . '/tools/pDebug/resources/theme.debugger.php');
	$templateControls->set($debugTheme['debugger']['row']);
	
	foreach($pDebug->debugRows as $rowData) {
		$rowData['rowClass'] = templateClassType($rowData['varType']);
		$tmpRow = $templateControls->matchObject($rowData);
		$rowStack .= $tmpRow;
	} //end foreach
	
} catch (Exception $e) {
	echo '! Template Failure !';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>pDebug Beta</title>
<link href="resources/debugger.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<table width="100%" border="0" cellspacing="1" cellpadding="4" id="pDebug">
	  <tr>
		<td colspan="5" class="pdg_header"><h1>pDebug Beta</h1></td>
	  </tr>
	  <tr>
		<td width="38" height="20" align="center" valign="middle"><img src="resources/next.png" alt="arrow" width="16" height="16" /></td>
		<td width="351"><h3>Data Set</h3></td>
		<td width="113"><h3>Variable Name</h3></td>
		<td width="113"><h3>Variable Type</h3></td>
		<td width="233"><h3>Details</h3></td>
	  </tr>
	  
	  <? echo $rowStack; ?>
	  	  
	</table>
</body>
</html>