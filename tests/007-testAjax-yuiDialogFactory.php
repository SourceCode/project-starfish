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
    YAHOO.factory.testDialog1.show();
    console.log('called');
    console.log(YAHOO.factory.testDialog1);
    //alert('This test is working');   
}

function init()
{
    console.log('test');  
    var oElement = document.getElementById("showDialog");
    YAHOO.util.Event.addListener(oElement, "click", testCallbackFunc);    
}

 /*
var loader = new YAHOO.util.YUILoader();
loader.insert({
    require: ['fonts','dragdrop','logger'],
    base: '../../build/',

    onSuccess: function(loader) {
            YAHOO.util.Event.addListener(YAHOO.util.Dom.get("loglink"), "click", function(e) {
                YAHOO.util.Event.stopEvent(e);
                YAHOO.log("This is a simple log message.");
            });

            // Put a LogReader on your page
            this.myLogReader = new YAHOO.widget.LogReader();
    }
});  */



YAHOO.util.Event.onDOMReady(init);
</script>
</head>
<body class=" yui-skin-sam">
YUI Dialog Factory
<input type="button" value="Show Dialog" name="showDialog" id="showDialog">
</body>
</html>