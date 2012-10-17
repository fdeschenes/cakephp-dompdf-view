<?php

/**
 * 
 * 
 * @copyright Copyright 2012 Francois Deschenes (http://francoisdeschenes.com)
 * @since CakePHP(tm) v 2.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('PdfView', 'Dompdf.View');
if (version_compare(Configure::version(), '2.1.1', '<')) {
    App::load('PdfView');
}

try {
    Configure::load('dompdf');
} catch(Exception $e) {
    Configure::load('Dompdf.dompdf');
}