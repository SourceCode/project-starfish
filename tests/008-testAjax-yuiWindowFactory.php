<?php
  /**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version 008-testAjax-yuiWindowFactory.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category tests
 */


/**
 * Test the YUI Window Factory (Uses YUI Simple Generator)
 */
 
require_once('../includes/core.php');
$stFilePath = stFilepath::getInstance();

require_once($stFilePath->ajaxController . '/yui/obj.windows.php');

//get YUI library instance
$yuiControls = stYui::getInstance();

//get instance of dialog factory
$yuiDialog = stWindowFactory::getInstance();

$yuiDialog->create('window1', 'test window 1', 'test window 1', 'test window 1')->modify('draggable', true)->render();
$yuiDialog->create('window2', 'test', 'test window 2', 'test')->render();
$yuiDialog->create('window3', 'test', 'test window 3', 'test')->modify('width', '800px')->modify('draggable', true)->render();

//generate includes
$includeList = $yuiControls->genIncludes();

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Test YUI Window Factory</title>
<?php echo $includeList; ?>
<script>

<?php echo $yuiDialog->paint(); ?> 

function init()
{  
    YAHOO.util.Event.addListener("showWindow1", "click", YAHOO.windowFactory.window1.show, YAHOO.windowFactory.window1, true);
    YAHOO.util.Event.addListener("showWindow2", "click", YAHOO.windowFactory.window2.show, YAHOO.windowFactory.window2, true);
    YAHOO.util.Event.addListener("showWindow3", "click", YAHOO.windowFactory.window3.show, YAHOO.windowFactory.window3, true);  
} 

YAHOO.util.Event.onDOMReady(init);
</script>
</head>
<body class=" yui-skin-sam">
YUI Window Factory
<input type="button" value="Show Window1" name="showWindow1" id="showWindow1">
<input type="button" value="Show Window2" name="showWindow2" id="showWindow2">
<input type="button" value="Show Window3" name="showWindow3" id="showWindow3"> 
</body>
</html>