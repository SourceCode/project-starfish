<?php
  /**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version 008-testAjax-yuiTooltipFactory.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category tests
 */


/**
 * Test the YUI Tooltip Factory (Uses YUI Simple Generator)
 */
 
require_once('../includes/core.php');
$stFilePath = stFilepath::getInstance();

require_once($stFilePath->ajaxController . '/yui/obj.yui.php'); 
require_once($stFilePath->ajaxController . '/yui/obj.tooltips.php');

//get YUI library instance
$yuiControls = stYui::getInstance();

//get instance of dialog factory
$yuiTooltip = stTooltipFactory::getInstance();

//create tooltips
$yuiTooltip->create('testtip1', 'This is test tooltip1', 'tooltip1')->render(); 
$yuiTooltip->create('testtip2', 'This is test tooltip2', 'tooltip2')->render();
$yuiTooltip->create('testtip3', 'This is test tooltip3', 'tooltip3')->render();

//generate includes
$includeList = $yuiControls->genIncludes(); 
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Test YUI Tooltip Factory</title>
<?php echo $includeList; ?>
<script>

<?php echo $yuiTooltip->paint(); ?> 

function init()
{  

} 

YAHOO.util.Event.onDOMReady(init);
</script>
</head>
<body class=" yui-skin-sam">
YUI Tooltip Factory<br /><br />
<input type="button" value="Show Tooltip 1" name="tooltip1" id="tooltip1">
<br /><br />
<a href="#" id="tooltip2">This is a link</a><br /><br />
<p id="tooltip3">This is a paragraph.</p> 
</body>
</html>