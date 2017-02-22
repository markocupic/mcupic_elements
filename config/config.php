<?php
/**
* Content elements
*/

// ServiceLinks require FontAwesome v4.7.0
define('SERVICE_LINK_FONTAWESOME_VERSION', '4.7.0');

// !important notice
// Get the icons.yml file from https://github.com/FortAwesome/Font-Awesome/blob/master/src/icons.yml
// and save it to the yml-folder


// Content Elements
array_insert($GLOBALS['TL_CTE'], 2, array('ce_serviceLink' => array('serviceLink' => 'MCupic\ServiceLink')));
$GLOBALS['TL_CTE']['texts']['headlineExtended'] = 'MCupic\HeadlineExtended';
