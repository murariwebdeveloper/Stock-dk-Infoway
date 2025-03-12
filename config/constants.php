<?php

/*const SITE_NAME = 'My Laravel Application';
const ADMIN_EMAIL = 'admin@example.com';*/

if (!defined('SUCCESS')) {
    define('SUCCESS', 'SUCCESS');
}

if (!defined('ERROR')) {
    define('ERROR', 'ERROR');
}

if (!defined('LEFT')) {
    define('LEFT', 'Left');
}

if (!defined('RIGHT')) {
    define('RIGHT', 'Right');
}

//status
if (!defined('ACTIVE')) {
    define('ACTIVE', 'Active');
}
if (!defined('INACTIVE')) {
    define('INACTIVE', 'Inactive');
}

if (!defined('ACTIVE_CODE')) {
    define('ACTIVE_CODE', 1);
}

if (!defined('INACTIVE_CODE')) {
    define('INACTIVE_CODE', 0);
}

if (!defined('STATUS_LIST')) {
    define('STATUS_LIST',[['code' => ACTIVE_CODE, 'name' => ACTIVE],['code' => INACTIVE_CODE, 'name' => INACTIVE]]);
}

// Availability

if (!defined('AVAILABLE')) {
    define('AVAILABLE', 'Available');
}

if (!defined('UNAVAILABLE')) {
    define('UNAVAILABLE', 'Unavailable');
}

if (!defined('SOLD_OUT')) {
    define('SOLD_OUT', 'Sold Out');
}

if (!defined('AVAILABLE_CODE')) {
    define('AVAILABLE_CODE', 1);
}

if (!defined('UNAVAILABLE_CODE')) {
    define('UNAVAILABLE_CODE', -1);
}

if (!defined('SOLD_OUT_CODE')) {
    define('SOLD_OUT_CODE', 0);
}

// Availability
if (!defined('AVAILABILITY_LIST')) {
    define('AVAILABILITY_LIST',[['code' => AVAILABLE_CODE, 'name' => AVAILABLE],['code' => SOLD_OUT_CODE, 'name' => SOLD_OUT]]);
}




?>
