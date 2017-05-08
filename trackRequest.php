<?php

include_once (dirname(__FILE__).'/lib/Request.php');
include_once (dirname(__FILE__).'/get.php');

/*
 * 0 - Track Ids
 */

$url = trackUrl;
$params = trackParams;

//$xml = new DOMDocument();
//$xmlRoot = $xml->createElement('TrackRequest');
//$xmlRoot->setAttribute('USERID', $userId);

//foreach ($data as $key => $value) {
//    $xmlItem = $xml->createElement('TrackID', ' ');
//    $xmlItem->setAttribute('ID', $value);
//    $xmlRoot->appendChild($xmlItem); 
//}
//$xml->appendChild($xmlRoot);
//var_dump($xml->saveXML());


$xml = '<!--?xml version="1.0" encoding="UTF-8"?--><TrackRequest USERID="'. $userId .'">';
foreach ($data as $value) {
    $xml .= '<TrackID ID="'.$value.'"></TrackID>';
}
$xml .= '</TrackRequest>';

//var_dump($xml);

// request
$request = new Request();
//$results = $request->executeRequest($url, $params . $xml->saveHTML());
$results = $request->executeRequest($url, $params . $xml);

// responses
echo($results);
