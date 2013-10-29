Html2PdfServiceBundle
=====================

[![Build Status](https://travis-ci.org/carlescliment/Html2PdfServiceBundle.png)](https://travis-ci.org/carlescliment/Html2PdfServiceBundle)

This is a Symfony 2 client for the [Html2Pdf REST Service](https://github.com/carlescliment/html2pdf-service).


## Installation

Include the bundle in your composer.json file.

```
    "require": {
        ...
        "carlescliment/html2pdf-bundle": "dev-master"
    }
```

Modify your AppKernel:


```php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new carlescliment\Html2PdfServiceBundle\carlesclimentHtml2PdfServiceBundle(),
        );
```


Set the bundle configuration in your `config.yml`:

```yaml
parameters:
    html2pdf.host: http://html2pdf.mydomain.com
    html2pdf.port: 80
```


Execute `php composer.phar update carlescliment/html2pdf-bundle`



## Usage

From your controller, render the template and pass it to the service:


```php
class SampleController extends Controller
{
    public function toPdfAction()
    {
        $view = $this->renderView('YourBundle:Sample:toPdf.html.twig');
        $bridge = $this->get('html2pdf.bridge');
        return $bridge->getFromHtml($view, 'document_name');
    }
}
```



## TO-DO
* Port setting is currently being ignored
* Allow passing document settings to the service.

