<?php

//NOTE: PHP_VERSION_ID was introduced in 5.2.7
if ( !defined('PHP_VERSION_ID') || (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION < 3))
    exit("PHP version 5.3.7 or greater is required for this site to run.");

require_once '../config/local-config.php';

define('DB_NAME', (empty(DB_PREFIX) ? '' : DB_PREFIX . '_') . DB_SHORTNAME); 
