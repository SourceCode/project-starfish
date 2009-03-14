<?php
  /**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version 005-testEvents.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category tests
 */


/**
 * Test the YUI Dialog Generator (Uses YUI Simple Generator)
 */
 
require_once('../includes/core.php');
$stFilePath = stFilepath::getInstance();

require_once($stFilePath->ajaxController . '/obj.dialogs.php');

//get YUI library instance
$yuiControls = stYui::getInstance();
$yuiControls->addPackage('button');

//get instance of dialog factory
$yuiDialog = stDialogFactory::getInstance();
$yuiDialog->create('Is this a working Test?', 'testDialog1', 'testCallbackFunc')->modify('width', '450px')->render();
$yuiDialog->create('Is this a working Also?', 'testDialog2', 'testCallbackFunc')->render();
$yuiDialog->create('Is this a working cause its cool?', 'testDialog3', 'testCallbackFunc')->modify('width', '550px')->modify('draggable', 'true')->render();

//generate includes
$includeList = $yuiControls->genIncludes();
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Test YUI Dialog Factory</title>
<?php echo $includeList; ?>
<script>

<?php echo $yuiDialog->paint(); ?> 

function testCallbackFunc()
{
    alert('callback called!');  
}

function showDialog1()
{
    YAHOO.factory.testDialog1.show(); 
}

function showDialog2()
{
    YAHOO.factory.testDialog2.show(); 
}

function showDialog3()
{
    YAHOO.factory.testDialog3.show(); 
}

function init()
{
    var oElement = document.getElementById("showDialog1");
    YAHOO.util.Event.addListener(oElement, "click", showDialog1);
    
 var oElement = document.getElementById("showDialog2");
    YAHOO.util.Event.addListener(oElement, "click", showDialog2);  
 
 var oElement = document.getElementById("showDialog3");
    YAHOO.util.Event.addListener(oElement, "click", showDialog3);    
        
} 

YAHOO.util.Event.onDOMReady(init);
</script>
</head>
<body class=" yui-skin-sam">
YUI Dialog Factory
<input type="button" value="Show Dialog1" name="showDialog1" id="showDialog1">
<input type="button" value="Show Dialog2" name="showDialog2" id="showDialog2">
<input type="button" value="Show Dialog3" name="showDialog3" id="showDialog3"> 
</body>
</html>