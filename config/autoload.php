<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'MCupic',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Src
	'MCupic\HeadlineExtended' => 'system/modules/mcupic_elements/src/elements/HeadlineExtended.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_headline_extended' => 'system/modules/mcupic_elements/templates',
));
