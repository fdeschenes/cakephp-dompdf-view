<?php

/**
 * 
 * 
 * @copyright Copyright 2012 Francois Deschenes (http://francoisdeschenes.com)
 * @since CakePHP(tm) v 2.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Configure', 'Core');
App::uses('View', 'View');

/**
 * Dompdf View provides a custom view implementation for creating PDF documents using dompdf (http://code.google.com/p/dompdf).
 * 
 * Unlike other views, DompdfView uses several viewVars that have special meaning:
 * 
 * - `download` Set to true to set a `Content-Disposition` header. This is ideal for file downloads.
 * - `name` The filename that will be sent to the user, specified with the extension.
 * - `paperOrientation` The paper orientation. Must be either 'landscape' or 'portrait'.
 * - `paperSize` The paper size. Acceptable values include 'letter', 'legal', 'a4', etc. See `CPDF_Adapter::$PAPER_SIZES`.
 * 
 * ### Usage
 * 
 * {{{
 * class ExampleController extends AppController
 * {
 *     public function view()
 *     {
 *         $this->viewClass = 'Dompdf';
 *         $params = array(
 *             'download' => false,
 *             'name' => 'example.pdf',
 *             'paperOrientation' => 'portrait',
 *             'paperSize' => 'legal'
 *         );
 *         $this->set($params);
 *     }
 * }
 * }}}
 */
class PdfView extends View
{
	public $subDir = 'pdf';
	
	public function __construct($controller)
	{
		parent::__construct($controller);
		
		$config = Configure::read('Dompdf');
		foreach ($config as $key => $value) {
			$key = 'DOMPDF_' . strtoupper(Inflector::underscore($key));
			if (!defined($key)) {
				define($key, $value);
			}
		}
		
		App::import('Vendor', 'cakephp-dompdf-view.DOMPDF', true, array(), 'dompdf' . DS . 'dompdf_config.inc.php');
	}
	
    public function render($view = null, $layout = null)
    {
    	ob_start();
    	if (defined('DOMPDF_TEMP_DIR')) {
    		$dir = new SplFileInfo(DOMPDF_TEMP_DIR);
    		if (!$dir->isDir() || $dir->isWritable()) {
    			trigger_error(__('%s is not writable', DOMPDF_TEMP_DIR), E_USER_WARNING);
    		}
    	}
    	$errors = ob_get_contents();
    	ob_end_clean();
    	
    	$download = false;
    	$name = pathinfo($this->here, PATHINFO_BASENAME);
    	$paperOrientation = 'portrait';
    	$paperSize = 'letter';
    	
        extract($this->viewVars, EXTR_IF_EXISTS);
        
        $dompdf = new DOMPDF();
        $dompdf->load_html($errors . parent::render($view, $layout), Configure::read('App.encoding'));
        $dompdf->set_protocol('');
        $dompdf->set_protocol(WWW_ROOT);
        $dompdf->set_base_path('/');
        $dompdf->set_paper($paperSize, $paperOrientation);
        $dompdf->render();
        $dompdf->stream($name, array('Attachment' => $download));
    }
}