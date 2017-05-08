<?php

include_once (dirname(__FILE__).'/lib/Request.php');
include_once (dirname(__FILE__).'/lib/WriteXML.php');
include_once (dirname(__FILE__).'/get.php');

/*
 * 0 - Number of addresses to validate
 * 1 - Firm Name
 * 2 - Address1(apartment or suite number, if applicable)
 * 3 - Address2 (Street address)
 * 4 - City
 * 5 - State
 * 6 - Urbanization
 * 7 - Zip5
 * 8 - Zip4
 */

$header = array(
    'IncludeOptionalElements' => 'true',
    'ReturnCarrierRoute' => 'true');

for ($i = 0; $i < $data[0]; $i++) {
    $indice = $i * 8;                       // adds the number of parameters for each address
    $addresses[$i] = array(
        'FirmName' => $data[1 + $indice],
        'Address1' => $data[2 + $indice],
        'Address2' => $data[3 + $indice],
        'City' => $data[4 + $indice],
        'State' => $data[5 + $indice],
        'Urbanization' => $data[6 + $indice],
        'Zip5' => $data[7 + $indice],
        'Zip4' => $data[8 + $indice]
    );
}

// get the indices to change the node name
$keys = array_keys($addresses);
foreach ($keys as $key => $value) {
    $keys[$key] = 'Addresses' . $value;
}
$addresses = array_combine($keys, $addresses);
$nodes = array_merge($header, $addresses);

// info to validate the address
$url = addressUrl;
$params = addressParams;
$root = 'AddressValidateRequest';

// creating xml
$xml = new WriteXML();
$xmlNodes = $xml->writeToFile($nodes, $root);

// add userId to the node
$xmlRoot = $xmlNodes->getElementsByTagName($root)->item(0);
$xmlRoot->setAttribute('USERID', $userId);

// add ids to the addresses
for ($i = 0; $i < $data[0]; $i++) {
    $items = $xmlNodes->getElementsByTagName('Addresses' . $i);
    if ($items instanceof DOMNodeList) {
        foreach ($items as $item) {
            $item->setAttribute('ID', $i);
            $xml->changeNodeName($item, 'Address');
        }
    }
}

//echo '<pre>';
//var_dump($xmlNodes->saveHTML());

// make the request
$request = new Request();
$result = $request->executeRequest($url, $params . $xmlNodes->saveHTML());

// response
echo($result);
