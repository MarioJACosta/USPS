<?php

include_once (dirname(__FILE__).'/lib/Request.php');
include_once (dirname(__FILE__).'/lib/WriteXML.php');
include_once (dirname(__FILE__).'/get.php');

/*
 * First value is the revision
 * The other indices in $data represent a package each obeying the below list
 * 0 - Pounds
 * 1 - Ounces
 * 2 - Machinable
 * 3 - MailType
 * 4 - GXG 
 * 5 - ValueOfContents
 * 6 - Country
 * 7 - Container
 * 8 - Size
 * 9 - Width
 * 10 - Length
 * 11 - Height
 * 12 - Girth
 * 13 - OriginZip
 * 14 - CommercialFlag
 * 15 - CommercialPlusFlag
 * 16 - ExtraServices
 * 17 - AcceptanceDateTime
 * 18 - DestinationPostalCode
 * 19 - Content
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
$nPackages = count($data);

// need change for more than one package
for ($i = 1; $i < $nPackages; $i++) {
    $package = explode('~', $data[$i]);
    $gxg = explode('^', $package[4]);
    $contents = explode('^', $data[19]);
    $packages[$i] = array(
        //'Package'.$i => array(
        'Pounds' => $package[0],
        'Ounces' => $package[1],
        'Machinable' => $package[2],
        'MailType' => $package[3],
        'GXG' => array(
            'POBoxFlag' => $gxg[0],
            'GiftFlag'  => $gxg[1]
        ),
        'ValueOfContents' => $package[5],
        'Country' => $package[6],
        'Container' => $package[7],
        'Size' => $package[8],
        'Width' => $package[9],
        'Length' => $package[10],
        'Height' => $package[11],
        'Girth' => $package[12],
        'OriginZip' => $package[13],
        'CommercialFlag' => $package[14],
        'CommercialPlusFlag' => $package[15],
        'ExtraServices' => array(
            'ExtraService' => $package[16]
        ),
        'AcceptanceDateTime' => $package[17],
        'DestinationPostalCode' => $package[18],
        'Content' => array(
            'ContentType' => $contents[0],
            'ContentDescription' => $contents[1]
        )
    );

    // if Content is null usps returns null
    // its easier to unset Content
    if ($gxg[0] == '') {
        unset($packages[$i]['GXG']);
    }
    if ($contents[0] == '') {
        unset($packages[$i]['Content']);
    }
    
    // make sure values are not repeated
    unset($package);
    unset($contents);
}

//var_dump($packages);

// get the indices to change the indice name
$keys = array_keys($packages);
foreach ($keys as $key => $value) {
    $keys[$key] = 'Package' . $value;
}
$packages = array_combine($keys, $packages);
$nodes = array_merge($values, $packages);

// values to make the request
$url = intRateUrl;
$params = intRateParams;
$root = 'IntlRateV2Request';

// writing xml
$xml = new WriteXML();
$xmlNodes = $xml->writeToFile($nodes, $root);

// add userId to the request
$xmlRoot = $xmlNodes->getElementsByTagName($root)->item(0);
$xmlRoot->setAttribute('USERID', $userId);

// add ids to the addresses
for ($i = 1; $i < $nPackages; $i++) {
    $items = $xmlNodes->getElementsByTagName('Package' . $i);
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