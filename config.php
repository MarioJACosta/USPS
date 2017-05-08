<?php

// USER CREDENTIALS
define('userId', '');

// URLS
define('addressUrl', 'http://production.shippingapis.com/ShippingAPI.dll');
define('dmssUrl', 'http://production.shippingapis.com/ShippingAPI.dll');
define('labelUrl', 'https://secure.shippingapis.com/ShippingAPI.dll');
define('trackUrl', 'http://stg-production.shippingapis.com/ShippingAPI.dll');
define('intRateUrl', 'http://production.shippingapis.com/ShippingAPI.dll');
define('domRateUrl', 'http://production.shippingapis.com/ShippingAPI.dll');
define('pickupUrl', 'https://secure.shippingapis.com/ShippingAPI.dll');
define('sdcUrl', 'http://production.shippingapis.com/ShippingAPI.dll ');

// PARAMS
define('addressParams', 'API=Verify&XML=');
define('dmssParams', '?API=PriorityMail&XML=');
define('dmssPacakage', '?API=StandardB &XML=');
define('dmssFirst', '?API=FirstClassMail &XML=');
define('dmssExpress', '?API=ExpressMailCommitment &XML=');
define('labelParams', '?API=DelivConfirmCertifyV4&XML=');
define('labelSignature', '?API=SignatureConfirmationCertifyV4&XML=');
define('labelPriority', '?API=ExpressMailLabelCertify&XML=');
define('trackParams', 'API=TrackV2&XML=');
define('domRateParams', 'API=RateV4&XML=');
define('intRateParams', '?API=IntlRateV2&XML=');
define('pickupParams', '?API=CarrierPickupAvailability&XML=');
define('pickupSchedule', '?API=CarrierPickupSchedule&XML=');
define('pickupCancel', '?API=CarrierPickupCancel&XML=');
define('pickupChange', '?API=CarrierPickupChange &XML=');
define('pickupInquiry', '?API=CarrierPickupInquiry &XML=');
define('sdcParams', '?API=SDCGetLocations&XML=');

// DELETE IN PRODUCTION
define('addressValues', ''); 
define('dmssValues', ''); 
define('labelValues', ''); 
define('trackValues', '');
define('domRateValues', '');
define('intRateValues', '');
define('pickupValues', '');
define('sdcValues', '');