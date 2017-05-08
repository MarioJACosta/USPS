<?php

include_once (dirname(__FILE__) . '/lib/Request.php');
include_once (dirname(__FILE__) . '/lib/WriteXML.php');
include_once (dirname(__FILE__) . '/get.php');

/*
 * First value is the revision
 * The other parameters in $data represent a package each obeying the list below
 * 0 - Number of packages
 * 1 - Service
 * 2 - FirstClassMailType
 * 3 - ZipOrigination
 * 4 - ZipDestination
 * 5 - Pounds
 * 6 - Ounces
 * 7 - Container
 * 8 - Size
 * 9 - Width
 * 10 - Length
 * 11 - Height
 * 12 - Girth
 * 13 - Value
 * 14 - AmountToCollect
 * 15 - SpecialServices
 * 16 - Content
 * 17 - GroundOnly
 * 18 - SortBy
 * 19 - Machinable
 * 20 - ReturnLocations
 * 21 - ReturnServiceInfo
 * 22 - DropOffTime
 * 23 - ShipDate
 */

// package ids
$ids = array(
    1 => '1ST',
    2 => '2ND',
    3 => '3RD',
    21 => '21ST',
    22 => '22ND',
    23 => '23RD'
);

$values = array('Revision' => $data[0]);
$data[0] = count($data);

// need change for more than one package
for ($i = 1; $i < $data[0]; $i++) {
    $indice = $i * 23;
    $packages[$i] = array(
        'Service' => $data[0 + $indice],
        'FirstClassMailType' => $data[1 + $indice],
        'ZipOrigination' => $data[2 + $indice],
        'ZipDestination' => $data[3 + $indice],
        'Pounds' => $data[4 + $indice],
        'Ounces' => $data[5 + $indice],
        'Container' => $data[6 + $indice],
        'Size' => $data[7 + $indice],
        'Width' => $data[8 + $indice],
        'Length' => $data[9 + $indice],
        'Height' => $data[10 + $indice],
        'Girth' => $data[11 + $indice],
        'Value' => $data[12 + $indice],
        'AmountToCollect' => $data[13 + $indice],
        'SpecialServices' => array(
            'SpecialService' => $data[14 + $indice]
        ),
        'Content' => array(
            'ContentType' => $data[15 + $indice],
            'ContentDescription' => $data[16 + $indice]
        ),
        'GroundOnly' => $data[17 + $indice],
        'SortBy' => $data[18 + $indice],
        'Machinable' => $data[19 + $indice],
        'ReturnLocations' => $data[20 + $indice],
        'ReturnServiceInfo' => $data[21 + $indice],
        'DropOffTime' => $data[22 + $indice],
        'ShipDate' => $data[23 + $indice]
    );

    // if Content is null usps returns null
    // its easier to unset Content
    if ($data[15] == '') {
        unset($packages[$i]['Content']);
    }
}

// get the indices to change the indice name
$keys = array_keys($packages);
foreach ($keys as $key => $value) {
    $keys[$key] = 'Package' . $value;
}
$packages = array_combine($keys, $packages);
$nodes = array_merge($values, $packages);

// values to make the request
$url = domRateUrl;
$params = domRateParams;
$root = 'RateV4Request';

// writing xml
$xml = new WriteXML();
$xmlNodes = $xml->writeToFile($nodes, $root);

// add userId to the request
$xmlRoot = $xmlNodes->getElementsByTagName($root)->item(0);
$xmlRoot->setAttribute('USERID', $userId);

//var_dump($xmlNodes->saveHTML());
// add ids to the addresses
for ($i = 1; $i < $data[0]; $i++) {
    $items = $xmlNodes->getElementsByTagName('Package' . $i);
//    var_dump($items);
    if ($items instanceof DOMNodeList) {
        foreach ($items as $item) {
            if ($i < 4 || $i > 20 && $i < 24) {
                $item->setAttribute('ID', $ids[$i]);
            } else {
                $item->setAttribute('ID', $i . 'TH');
            }
            $xml->changeNodeName($item, 'Package');
        }
    }
}

//var_dump($xmlNodes->saveHTML());

$request = new Request();
$results = $request->executeRequest($url, $params . $xmlNodes->saveHTML());

echo ($results);
