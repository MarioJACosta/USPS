<?php

include_once (dirname(__FILE__) . '/lib/Request.php');
include_once (dirname(__FILE__) . '/lib/WriteXML.php');
include_once (dirname(__FILE__) . '/get.php');

/* 
 * This service offers diferent kind of requests. 
 * The only diference is the first node of the request, that is defined by the first parameter.
 * 
 * 0 - Type - mail, package, first, express
 * 1 - OriginZip
 * 2 - DestinationZip
 * 3 - DestinationType
 * 4 - Date
 * 5 - DropOffTime
 * 6 - ReturnDates
 * 7 - PMGuarantee
 */

$url = pmssUrl;

// This array is used to create the first node of each request
$root = array(
    'mail' => 'PriorityMailRequest',
    'package' => 'StandardBlRequest',
    'first' => 'FirstClassMailRequest',
    'express' => 'ExpressMailCommitmentRequest'
);

$pmss = array(
    'OriginZip' => $data[1],
    'DestinationZip' => $data[2],
    'DestinationType' => $data[3]
);

switch ($data[0]) {
    case 'mail':
        $params = dmssParams;
        break;

    case 'package':
        $params = dmssPacakage;
        break;

    case 'first':
        $params = dmssFirst;
        break;

    case 'express':
        $params = dmssExpress;

        $pmssExpress = array(
            'Date' => $data[4],
            'DropOffTime' => $data[5],
            'ReturnDates' => $data[6],
            'PMGuarantee' => $data[7]
        );

        unset($pmss['DestinationType']);

        $pmss = array_merge($pmss, $pmssExpress);
        break;
}

// writing xml
$xml = new WriteXML();
$xmlNodes = $xml->writeToFile($pmss, $root[$data[0]]);

// add userId to the request
$xmlRoot = $xmlNodes->getElementsByTagName($root[$data[0]])->item(0);
$xmlRoot->setAttribute('USERID', $userId);

var_dump($xmlNodes->saveHTML());

$request = new Request();
$results = $request->executeRequest($url, $params . $xmlNodes->saveHTML());

echo ($results);