<?php

include_once (dirname(__FILE__) . '/lib/Request.php');
include_once (dirname(__FILE__) . '/lib/WriteXML.php');
include_once (dirname(__FILE__) . '/get.php');

/*
 * 0 - Type (delivery, signature, priority)
 * 1 - Option
 * 2 - Revision
 * 3 - ImageParameter
 * 4 - PackageNumber
 * 5 - TotalPackages
 * 6 - FromName
 * 7 - FromFirm
 * 8 - FromAddress1
 * 9 - FromAddress2
 * 10 - FromCity
 * 11 - FromState
 * 12 - FromZip5
 * 13 - FromZip4
 * 14 - ToName
 * 15 - ToFirm
 * 16 - ToAddress1
 * 17 - ToAddress2
 * 18 - ToCity
 * 19 - ToState
 * 20 - ToZip5
 * 21 - ToZip4
 * 22 - ToPOBoxFlag
 * 23 - ToContactPreference
 * 24 - ToContactMessaging
 * 25 - ToContactEMail
 * 26 - WeightInOunces
 * 27 - ServiceType
 * 28 - InsuredAmount
 * 29 - WaiverOfSignature
 * 30 - SeparateReceiptPage
 * 31 - POZipCode
 * 32 - ImageType
 * 33 - LabelDate
 * 34 - CustomerRefNo
 * 35 - AddressServiceRequested
 * 36 - SenderName
 * 37 - SenderEMail
 * 38 - RecipientName
 * 39 - RecipientEMail
 * 40 - AllowNonCleansedDestAddr
 * 41 - HoldForManifest
 * 42 - Container
 * 43 - Size
 * 44 - Width
 * 45 - Length
 * 46 - Height
 * 47 - Girth
 * 48 - Machinable
 * 49 - CommercialPrice
 * 50 - ExtraService
 * 51 - CarrierRelease
 * 52 - ReturnCommitments
 * 53 - GroundOnly
 * 54 - ContentType
 * 55 - ContentDescription
 * 56 - MeterVendorID
 * 57 - MeterSerialNumber
 * 58 - MeterModelID
 * 59 - RateCategory
 * 60 - IndiciumCreationRecordDate
 * 61 - IBI
 * 
 * Following values are for shipping to/from Military and Diplomatic (APO/FPO/DPO) and US Possessions, Territories and Freely Associated States (PTFAS)
 * 62 - Description
 * 63 - Quantity
 * 64 - Value
 * 65 - NetPounds
 * 66 - NetOunces
 * 67 - HSTariffNumber
 * 68 - CountryofOrigin
 * 69 - FromPhone
 * 70 - SenderMID
 * 71 - ToPhone
 * 72 - CustomsContentType
 * 73 - ContentComments
 * 74 - RestrictionType
 * 75 - RestrictionComments
 * 76 - AESITN
 * 77 - ImportersReference
 * 78 - ImportersContact
 * 79 - ExportersReference
 * 80 - ExportersContact
 * 81 - InvoiceNumber
 * 82 - LicenseNumber
 * 83 - CertificateNumber
 * 84 - NonDeliveryOption
 * 85 - AltReturnAddress1
 * 86 - AltReturnAddress2
 * 87 - AltReturnAddress3
 * 88 - AltReturnAddress4
 * 89 - AltReturnAddress5
 * 90 - AltReturnAddress6
 * 91 - AltReturnCountry
 * 
 * Following values to ExpressMailLabelRequest
 * 92 - FromFirstName
 * 93 - FromLastName
 * 94 - ToFirstName
 * 95 - ToLastName
 * 96 - SundayHolidayDelivery
 * 97 - NoWeekend
 * 98 - FacilityType
 * 99 - LabelTime
 * 100 - NineDigitRoutingZip
 * 101 - ContentType
 * 102 - ContentDescriptor
 */

//var_dump($data);

// info to validate the address
$url = labelUrl;
$params = labelParams;

$root = array(
    'delivery' => 'DeliveryConfirmationV4.0Request',
    'signature' => 'SignatureConfirmationV4.0Request',
    'priority' => 'ExpressMailLabelRequest',
);

// need change for more than one package
$label = array(
    'Option' => $data[1],
    'Revision' => $data[2],
    'ImageParameters' => array(
        'ImageParameter' => $data[3],
        'LabelSequence' => array(
            'PackageNumber' => $data[4],
            'TotalPackages' => $data[5]
        ),
    ),
    'FromName' => $data[6],
    'FromFirm' => $data[7],
    'FromAddress1' => $data[8],
    'FromAddress2' => $data[9],
    'FromCity' => $data[10],
    'FromState' => $data[11],
    'FromZip5' => $data[12],
    'FromZip4' => $data[13],
    'ToName' => $data[14],
    'ToFirm' => $data[15],
    'ToAddress1' => $data[16],
    'ToAddress1' => $data[17],
    'ToCity' => $data[18],
    'ToState' => $data[19],
    'ToZip5' => $data[20],
    'ToZip5' => $data[21],
    'ToPOBoxFlag' => $data[22],
    'ToContactPreference' => $data[23],
    'ToContactMessaging' => $data[24],
    'ToContactEMail' => $data[25],
    'WeightInOunces' => $data[26],
    'ServiceType' => $data[27],
    'InsuredAmount' => $data[28],
    'WaiverOfSignature' => $data[29],
    'SeparateReceiptPage' => $data[30],
    'POZipCode' => $data[31],
    'ImageType' => $data[32],
    'LabelDate' => $data[33],
    'CustomerRefNo' => $data[34],
    'AddressServiceRequested' => $data[35],
    'SenderName' => $data[36],
    'SenderEMail' => $data[37],
    'RecipientName' => $data[38],
    'RecipientEMail' => $data[39],
    'AllowNonCleansedDestAddr' => $data[40],
    'HoldForManifest' => $data[41],
    'Container' => $data[42],
    'Size' => $data[43],
    'Width' => $data[44],
    'Length' => $data[45],
    'Height' => $data[46],
    'Girth' => $data[47],
    'Machinable' => $data[48],
    'CommercialPrice' => $data[49],
    'ExtraServices' => array(
        'ExtraService' => $data[50],
    ),
    'CarrierRelease' => $data[51],
    'ReturnCommitments' => $data[52],
    'GroundOnly' => $data[53],
    'Content' => array(
        'ContentType' => $data[54],
        'ContentDescription' => $data[55],
    ),
    'MeterData' => array(
        'MeterVendorID' => $data[56],
        'MeterSerialNumber' => $data[57],
        'MeterModelID' => $data[58],
        'RateCategory' => $data[59],
        'IndiciumCreationRecordDate' => $data[60],
        'IBI' => $data[61]
    ),
);

if (isset($data[62])) {
    $labelM = array('ShippingContents' => array(
            'ItemDetail' => array(
                'Description' => $data[62],
                'Quantity' => $data[63],
                'Value' => $data[64],
                'NetPounds' => $data[65],
                'NetOunces' => $data[66],
                'HSTariffNumber' => $data[67],
                'CountryofOrigin' => $data[68],
            ),
        ),
        'FromPhone' => $data[69],
        'SenderMID' => $data[70],
        'ToPhone' => $data[71],
        'CustomsContentType' => $data[72],
        'ContentComments' => $data[73],
        'RestrictionType' => $data[74],
        'RestrictionComments' => $data[75],
        'AESITN' => $data[76],
        'ImportersReference' => $data[77],
        'ImportersContact' => $data[78],
        'ExportersReference' => $data[79],
        'ExportersContact' => $data[80],
        'InvoiceNumber' => $data[81],
        'LicenseNumber' => $data[82],
        'CertificateNumber' => $data[83],
        'NonDeliveryOption' => $data[84],
        'AltReturnAddress1' => $data[85],
        'AltReturnAddress2' => $data[86],
        'AltReturnAddress3' => $data[87],
        'AltReturnAddress4' => $data[88],
        'AltReturnAddress5' => $data[89],
        'AltReturnAddress6' => $data[90],
        'AltReturnCountry' => $data[91]
    );

    $label = array_merge($label, $labelM);

    // according to docs
    if ($data[27] !== 'Priority') {
        unset($label['ImportersReference']);
        unset($label['ImportersContact']);
        unset($label['ExportersReference']);
        unset($label['ExportersContact']);
        unset($label['InvoiceNumber']);
        unset($label['LicenseNumber']);
        unset($label['CertificateNumber']);
    }
}

switch ($data[0]) {
    case 'delivery':
        $params = labelParams;
        break;

    case 'signature':
        $params = labelSignature;
        unset($label['CarrierRelease']);
        break;

    case 'priority':
        $params = labelPriority;
        unset($label['FromName']);
        unset($label['ToName']);
        unset($label['ServiceType']);
        unset($label['AllowNonCleansedDestAddr']);
        unset($label['AddressServiceRequested']);
        unset($label['Machinable']);
        unset($label['GroundOnly']);
        unset($label['Content']);
        unset($label['MeterData']);

        $labelP = array(
            'FromFirstName' => $data[92],
            'FromLastName' => $data[93],
            'ToFirstName' => $data[94],
            'ToLastName' => $data[95],
            'SundayHolidayDelivery' => $data[96],
            'StandardizeAddress' => $data[40],
            'NoWeekend' => $data[97],
            'FacilityType' => $data[98],
            'LabelTime' => $data[99],
            'NineDigitRoutingZip' => $data[100],
            'Content' => array(
                'ContentType' => $data[101],
                'ContentDescriptor' => $data[102],
            ),
        );

        $label = array_merge($label, $labelP);

        if (!isset($data[99])) {
            unset($label['FacilityType']);
        }

        break;
}

// writing xml
$xml = new WriteXML();
$xmlNodes = $xml->writeToFile($label, $root[$data[0]]);

// add userId to the request
$xmlRoot = $xmlNodes->getElementsByTagName($root[$data[0]])->item(0);
$xmlRoot->setAttribute('USERID', $userId);

//var_dump($xmlNodes->saveHTML());

// make the request
$request = new Request();
$result = $request->executeRequest($url, $params . $xmlNodes->saveHTML());

// response
echo '<br><br>response<br><br>';
echo($result);
