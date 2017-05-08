<?php

include_once (dirname(__FILE__) . '/lib/Request.php');
include_once (dirname(__FILE__) . '/lib/WriteXML.php');
include_once (dirname(__FILE__) . '/get.php');

/*
 * 0 - MailClass
 * 1 - OriginZIP
 * 2 - DestinationZIP
 * 3 - AcceptDate
 * 4 - AcceptTime
 * 5 - NonExpeditedDetail
 * 6 - NonExpeditedOriginType
 * 7 - NonExpeditedDestType
 */

$url = sdcUrl;
$params = sdcParams;
$root = 'SDCGetLocationsRequest';

$sdc = array(
    'MailClass' => $data[0],
    'OriginZIP' => $data[1],
    'DestinationZIP' => $data[2],
    'AcceptDate' => $data[3],
    'AcceptTime' => $data[4],
    'NonExpeditedDetail' => $data[5],
    'NonExpeditedOriginType' => $data[6],
    'NonExpeditedDestType' => $data[7],
);

// writing xml
$xml = new WriteXML();
$xmlNodes = $xml->writeToFile($sdc, $root);

// add userId to the request
$xmlRoot = $xmlNodes->getElementsByTagName($root)->item(0);
$xmlRoot->setAttribute('USERID', $userId);

//var_dump($xmlNodes->saveHTML());

// make the request
$request = new Request();
$result = $request->executeRequest($url, $params . $xmlNodes->saveHTML());

// response
echo($result);
