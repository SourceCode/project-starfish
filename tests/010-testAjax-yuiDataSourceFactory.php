<?php
  /**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version 010-testAjax-yuiDataSourceFactory.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category tests
 */


/**
 * Test the YUI DataSource Factory (Uses YUI Simple Generator)
 */
 
require_once('../includes/core.php');
$stFilePath = stFilepath::getInstance();

require_once($stFilePath->ajaxController . '/yui/obj.yui.php'); 
require_once($stFilePath->ajaxController . '/yui/obj.datasource.php');

//get YUI library instance
$yuiControls = stYui::getInstance();

//get instance of dialog factory
$stDataSource = stDataSourceFactory::getInstance();

$dataArray1 = 'YAHOO.dataSourceFactory.testData1 = [
    "Alabama",
    "Alaska",
    "Arizona",
    "Arkansas",
    "California",
    "Colorado",
    "Connecticut",
    "Delaware",
    "Florida"
];';


$dataArray1Schema = '{fields:["name"]}';

//create tooltips
$result = $stDataSource->create('source1', 'YAHOO.dataSourceFactory.testData1', 'LocalDataSource')->setSchema($dataArray1Schema, 'TYPE_JSARRAY')->render();
if ($result === true) echo 'Data Source 1 rendered';

//generate includes
$includeList = $yuiControls->genIncludes(); 
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Test YUI DataSource Factory</title>
<?php echo $includeList; ?>
<script>

<?php echo $stDataSource->paint(); ?> 



YAHOO.dataSourceFactory.testData1 = [
    "Alabama",
    "Alaska",
    "Arizona",
    "Arkansas",
    "California",
    "Colorado",
    "Connecticut",
    "Delaware",
    "Florida"
];

function init()
{  

} 

YAHOO.util.Event.onDOMReady(init);
</script>
</head>
<body class=" yui-skin-sam">
YUI DataSource Factory<br /><br />



</body>
</html>