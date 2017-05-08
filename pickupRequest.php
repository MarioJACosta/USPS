<?php

include_once (dirname(__FILE__) . '/lib/Request.php');
include_once (dirname(__FILE__) . '/lib/WriteXML.php');
include_once (dirname(__FILE__) . '/get.php');

/*
 * 0 - Type (pickup, schedule, cancel, change, inquiry)
 * 1 - FirmName
 * 2 - SuiteOrApt
 * 3 - Address2
 * 4 - Urbanization
 * 5 - State
 * 6 - City
 * 7 - ZIP5
 * 8 - ZIP4
 * 9 - Date
 * 10 - FirstName
 * 11 - LastName
 * 12 - Phone
 * 13 - Extension
 * 14 - ServiceType
 * 15 - Count
 * 16 - EstimatedWeight
 * 17 - PackageLocation
 * 18 - SpecialInstructions
 * 19 - EmailAddress
 * 20 - ConfirmationNumber
 * 21 - ServiceType (accepts different values than the 14)
 */

$url = pickupUrl;
$params = pickupParams;

$root = array(
    'pickup' => 'CarrierPickupAvailabilityRequest',
    'schedule' => 'CarrierPickupScheduleRequest',
    'cancel' => 'CarrierPickupCancelRequest',
    'change' => 'CarrierPickupChangeRequest',
    'inquiry' => 'CarrierPickupInquiryRequest'
);

$pickup = array(
    'FirmName' => $data[1],
    'SuiteOrApt' => $data[2],
    'Address2' => $data[3],
    'Urbanization' => $data[4],
    'State' => $data[5],
    'City' => $data[6],
    'ZIP5' => $data[7],
    'ZIP4' => $data[8],
    'Date' => $data[9]
);

switch ($data[0]) {
    case 'schedule':
        $pickupSchedule = array(
            'FirstName' => $data[10],
            'LastName' => $data[11],
            'Phone' => $data[12],
            'Extension' => $data[13],
            'Package' => array(
                'ServiceType' => $data[14],
                'Count' => $data[15]
            ),
            'EstimatedWeight' => $data[16],
            'PackageLocation' => $data[17],
            'SpecialInstructions' => $data[18],
            'EmailAddress' => $data[19]
        );
        unset($pickup['Date']);
        $pickup = array_merge($pickupSchedule, $pickup);
        $params = pickupSchedule;
        break;

    case 'cancel':
        $pickupCancel = array('ConfirmationNumber' => $data[20]);
        unset($pickup['Date']);
        $pickup = array_merge($pickup, $pickupCancel);
        $params = pickupCancel;
        break;

    case 'change':
        $pickupChange = array(
            'FirstName' => $data[10],
            'LastName' => $data[11],
            'Phone' => $data[12],
            'Extension' => $data[13],
            'Package' => array(
                'ServiceType' => $data[21],
                'Count' => $data[15]
            ),
            'EstimatedWeight' => $data[16],
            'PackageLocation' => $data[17],
            'SpecialInstructions' => $data[18],
            'EmailAddress' => $data[19],
            'ConfirmationNumber' => $data[20]
        );
        unset($pickup['Date']);
        $pickup = array_merge($pickupChange, $pickup);
        $params = pickupChange;
        break;

    case 'inquiry':
        $pickupInquiry = array('ConfirmationNumber' => $data[20]);
        unset($pickup['Date']);
        $pickup = array_merge($pickup, $pickupInquiry);
        $params = pickupInquiry;
        break;
}

// writing xml
$xml = new WriteXML();
$xmlNodes = $xml->writeToFile($pickup, $root[$data[0]]);

// add userId to the request
$xmlRoot = $xmlNodes->getElementsByTagName($root[$data[0]])->item(0);
$xmlRoot->setAttribute('USERID', $userId);

//var_dump($xmlNodes->saveHTML());

// make the request
$request = new Request();
$result = $request->executeRequest($url, $params . $xmlNodes->saveHTML());

// response
echo($result);
