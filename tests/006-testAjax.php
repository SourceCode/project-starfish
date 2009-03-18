<?php
  /**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version 006-testAjax.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category tests
 */


/**
 * Used to make sure the basics of ajax transactions / library are working
 */
 
require_once('../includes/core.php');
$yuiControls = stYui::getInstance();


$yuiControls->addPackage('XHR');
$includeList = $yuiControls->genIncludes();

?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Retrieving a Yahoo! Weather RSS Feed</title>

<style type="text/css">
/*margin and padding on body element
  can introduce errors in determining
  element position and are not recommended;
  we turn them off as a foundation for YUI
  CSS treatments. */
body {
    margin:0;
    padding:0;
}
</style>
<?php echo $includeList; ?>
</head>
<body class=" yui-skin-sam">
<h1>Retrieving a Yahoo! Weather RSS Feed</h1>
<div class="exampleIntro">
    <p>This example demonstrates how to use the <a href="http://developer.yahoo.com/yui/connection/">Connection Manager</a> and a PHP proxy &mdash; to work around XMLHttpRequest's same-domain policy &mdash; to retrieve an XML document from <code>http://xml.weather.yahoo.com/forecastrss</code>.</p>

<p>To try out the example, fill in your five-digit US zip code, or Location ID.</p>            
</div>
<form id="wForm">
<fieldset>
    <label>Zip Code or Location ID</label> <input type="text" name="zip" value="94089">
    <p>Please enter a U.S. Zip Code or a location ID to get the current temperature.  The default is Zip Code 94089 for Sunnyvale, California; its location ID is: USCA1116.</p>
</fieldset>
<div id="weatherModule"></div>
<input type="button" value="Get Weather RSS" onClick="getModule()">
</form>
<script>
var div = document.getElementById('weatherModule');
var oForm = document.getElementById('wForm');

function successHandler(o){

    var root = o.responseXML.documentElement;
    var oTitle = root.getElementsByTagName('description')[0].firstChild.nodeValue;
    var oDateTime = root.getElementsByTagName('lastBuildDate')[0].firstChild.nodeValue;
    var descriptionNode = root.getElementsByTagName('description')[1].firstChild.nodeValue;

    div.innerHTML = "<p>" + oTitle + "</p>" + "<p>" + oDateTime + "</p>" + descriptionNode;

}

function failureHandler(o){

    div.innerHTML = o.status + " " + o.statusText;
}

function getModule(){
    var iZip = oForm.elements['zip'].value;
    var entryPoint = 'content/006-ajaxTest.php';
    var queryString = encodeURI('?p=' + iZip);
    var sUrl = entryPoint + queryString;

    YAHOO.log("Submitting request; zip code: " + iZip, "info", "example");

    var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, { success:successHandler, failure:failureHandler });
}

</script>
</body>
</html>