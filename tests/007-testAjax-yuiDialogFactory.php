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
$yuiControls->addPackage('logger');

//get instance of dialog factory
$yuiDialog = stDialogFactory::getInstance();
$yuiDialog->create('Is this a working Test?', 'testDialog1', 'testCallbackFunc')->modify('width', '450px')->render();

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

function showDialog()
{
    YAHOO.factory.testDialog1.show(); 
}

function init()
{
    var oElement = document.getElementById("showDialog");
    YAHOO.util.Event.addListener(oElement, "click", showDialog);    
} 



YAHOO.util.Event.onDOMReady(init);
</script>
</head>
<body class=" yui-skin-sam">
YUI Dialog Factory
<input type="button" value="Show Dialog" name="showDialog" id="showDialog">
</body>
</html>