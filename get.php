<?php

// fix for mac
date_default_timezone_set('UTC');

// configuration file with the urls
include_once (dirname(__FILE__) . '/config.php');
include_once (dirname(__FILE__) . '/lib/Request.php');

//$data = explode('|', filter_input(INPUT_GET, 'data'));
//$userId = filter_input(INPUT_GET, 'userId');

$userId = userId;
//$data = explode('|', addressValues);
$data = explode('|', trackValues);
//$data = explode('|', domRateValues);
//$data = explode('|', intRateValues);
//$data = explode('|', labelValues);
//$data = explode('|', pickupValues);
//$data = explode('|', sdcValues);
//$data = explode('|', dmssValues);