# PDF View for the CakePHP Framework
This plugin for the CakePHP Framework allows you to use the dompdf HTML to PDF converter to easily create PDF documents. It's tightly integrated with the CakePHP view renderer.

## Requirements
- [PHP 5+](http://www.php.net)
- [CakePHP 2+](http://www.cakephp.org)
- [dompdf 0.6+](http://code.google.com/p/dompdf)

## Installation
Download the repository and extract the archive to a folder called `cakephp-dompdf-view` in your Plugin folder.

### Vendor Files
Download [dompdf 0.6](http://code.google.com/p/dompdf/downloads/list) and move the content of the archive to `Plugin/cakephp-dompdf-view/Vendor/dompdf`.

### Cache Permissions
A paragraph about changing the permissions on `APP/tmp/dompdf` will eventually go here.

## Usage
Because of the tight integration between this plugin and CakePHP, there's only a few things you have to do to get started.

1. Load the plugin by adding 
`CakePlugin::load('cakephp-dompdf-view', array('bootstrap' => true));` to `APP/Config/bootstrap.php`.
2. Instruct CakePHP to look for the PDF extension by adding `Router::parseExtensions('pdf');` to `APP/Config/routes.php`. If you already use `Router::parseExtensions` in your project, simply add 'pdf' to the list.
3. Finally, make sure that the RequestHandlerComponent is loaded for all controllers by adding `public $components = array('RequestHandler');` to `APP/Controller/AppController.php`.

### Configuration Options
Eventually, I'll add a paragraph here on how to use the config file located in `APP/Plugin/cakephp-dompdf-view/Config/dompdf.php`.

### Layout
You'll need to create the default layout for your PDF documents by creating a file named `default.ctp` in `APP/View/Layouts/pdf`.

### Views
For each action that should return a PDF, simply create a `pdf` folder in the folder where the views for the controller reside and create a file with the name of the action inside the `pdf` folder.

For example, if your controller is named DocumentsController and the action is named view, you need to create the `view.ctp` file in `APP/View/Documents/pdf`.
    
### View Variables
There are a few view variables that you can use to change the behaviour of the view.

- `download` Set to true to set a `Content-Disposition` header. This is ideal for file downloads.
- `name` The filename that will be sent to the user, specified with the extension.
- `paperOrientation` The paper orientation. Must be either 'landscape' or 'portrait'.
- `paperSize` The paper size. Acceptable values include 'letter', 'legal', 'a4', etc. See `CPDF_Adapter::$PAPER_SIZES`.

Example:

    public function view($id)
    {
        // ...
        
        $params = array(
            'download' => false,
            'name' => 'example.pdf',
            'paperOrientation' => 'portrait',
            'paperSize' => 'legal'
        );
        $this->set($params);
    }

### URL
To access any action as a PDF, all you have to do is point your browser to the URL associated with the action in question and add '.pdf' at the end just like you would do for JSON or XML.

For example:

    http://example.com/documents/view/100.pdf