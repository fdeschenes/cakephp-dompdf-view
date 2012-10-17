<?php

/**
 * 
 * 
 * @copyright Copyright 2012 Francois Deschenes (http://francoisdeschenes.com)
 * @since CakePHP(tm) v 2.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// For a list available settings, please see the `dompdf_config.custom.inc.php` file located in the root of your dompdf installation. Please camel case the options and drop the DOMPDF_ prefix.
$config['dompdf'] = array(
	'enablePhp' => false,
	'enableRemote' => true,
	'dpi' => 72,
	'tempDir' => CACHE . 'dompdf'
);