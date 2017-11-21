# Piwik analytic and statistic plugin for Contao 4

[![Version](https://img.shields.io/packagist/v/agoat/contao-piwikanalytics.svg?style=flat-square)](http://packagist.org/packages/agoat/contao-piwikanalytics)
[![License](https://img.shields.io/packagist/l/agoat/contao-piwikanalytics.svg?style=flat-square)](http://packagist.org/packages/agoat/contao-piwikanalytics)
[![Downloads](https://img.shields.io/packagist/dt/agoat/contao-piwikanalytics.svg?style=flat-square)](http://packagist.org/packages/agoat/contao-piwikanalytics)

## About
Add **piwik** statistics easily to your contao website. Simply activate piwik tracking on the root page and set the required parameters.

For more information about [Piwik] visit their web page.

[Piwik]: https://piwik.org/

## Requirements
Piwik is a 'Open Analytics Platform'. The tracking will be saved outside of contao.

A public available Piwik installation is needed (Self-hosted or Cloud-hosted doesn't matter).

## Install
### Contao manager
Search for the package and install it
```bash
agoat/contao-autoprefixer
```

### Managed edition
Add the package
```bash
# Using the composer
composer require agoat/contao-piwikanalytics
```
Registration and configuration is done by the manager-plugin automatically.

### Standard edition
Add the package
```bash
# Using the composer
composer require agoat/contao-piwikanalytics
```
Register the bundle in the AppKernel
```php
# app/AppKernel.php
class AppKernel
{
    // ...
    public function registerBundles()
    {
        $bundles = [
            // ...
            // after Contao\CoreBundle\ContaoCoreBundle
            new Agoat\PiwikAnalyticsBundle\AgoatPiwikAnalyticsBundle(),
        ];
    }
}
```
