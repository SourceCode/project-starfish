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

require_once($stFilePath->ajaxController . '/obj.windows.php');

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

function init()
{  
        
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