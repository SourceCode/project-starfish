<?php
require_once('../../includes/core.php');
require_once($stLoad->get('html', 'core'));
require_once($stLoad->get('smartfields', 'core'));

$smartFields = new stSmartFields();

if ($_POST['action'] == 'renderClass') {
	
} else {
	//load default form view
	$tableSQL = "SHOW TABLES FROM " . stConfig::$dbDatabase;
	$result = mysql_query($tableSQL, $stSQL->dbCon) or die("SQL ERROR");
	
	while($tmpValue = mysql_fetch_assoc($result)) {
		foreach($tmpValue as $id => $value) {
			$tableList[$value] = $value;
		} //end foreach
	} //end while
	
	$tableSelect = $smartFields->gen('select', 'table_name', 0, 'areaID2', 0, 0, $tableList);
	

}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Starfish Object Compiler</title>
<link href="resources/objectCompiler.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<form name="tableCompiler" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div id="tableOptions">
			<div class="tableOptionRow"><h1>Table and Compiler Options</h1></div>
			<div class="tableOptionRow">
				<label for="table_name">Table Name</label><br />
				<?php echo $tableSelect; ?><br /><br />
			</div>
			<div class="tableOptionRow">
				<label for="table_class">Class Name</label><br />
				<input type="input" name="class_name" id="class_name" size="24"/><br />
				<span>* Name of class to be generated</span><br /><br />
			</div>
			<div class="tableOptionRow">
				<label for="table_fieldproperties">Render Fields to Object Properties</label><br />
				<input name="table_fieldproperties" id="table_fieldproperties" type="checkbox" value="" />
				<span> Enabled</span><br /><br />
			</div>
			<div class="tableOptionRow">
				<label for="table_acid">Generate Database Scaffolding </label>
				<br />
				<input name="table_acid" id="table_acid" type="checkbox" value="" />
				<span> Enabled</span><br /><br />
			</div>		
			<div class="tableOptionRow">
				<label for="table_validators">Generate Validators</label><br />
				<input name="table_validators" type="radio" id="table_validators" value="1" checked="checked" />
				<span> Placeholders Only</span><br />
				<input name="table_validators" type="radio" id="table_validators" value="1" />
				<span> Assume Validation Based on Field Settings</span><br />
			</div>	
			<div class="tableCenterRow">
				<br />
				<button name="submit" id="submit" type="submit" value="Compile" class="submitButton">Compile Table to Object</button>
			</div>
		</div>
	</form>
</body>
</html>
