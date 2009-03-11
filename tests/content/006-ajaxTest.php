<?php
  //Within a PHP block:

// Since the result is an XML document, the Content-type
// header must be set to "text/xml" for the data to be
// treated as XML and to populate responseXML.
header("Content-Type:text/xml");

// $url is the resource path of the Y! Weather RSS
// with the appended querystring of zip code/location id.
$url = 'http://xml.weather.yahoo.com/forecastrss?'.getenv('QUERY_STRING');

// This function initializes CURL, sets the necessary CURL
// options, executes the request and returns the results.
function getResource($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
}

// Call getResource to make the request.
$feed = getResource($url);

// Return the results.
echo $feed;
?>
