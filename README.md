# Matomo analytic and statistic plugin for Contao 4

[![Version](https://img.shields.io/packagist/v/agoat/contao-piwikanalytics.svg?style=flat-square)](http://packagist.org/packages/agoat/contao-piwikanalytics)
[![License](https://img.shields.io/packagist/l/agoat/contao-piwikanalytics.svg?style=flat-square)](http://packagist.org/packages/agoat/contao-piwikanalytics)
[![Downloads](https://img.shields.io/packagist/dt/agoat/contao-piwikanalytics.svg?style=flat-square)](http://packagist.org/packages/agoat/contao-piwikanalytics)

#### Now compatible with Contao 4.6 !!

## About
Add **Matomo** statistics easily to your contao website. Simply activate piwik tracking on the root page and set the required parameters.

For more information about [Matomo] visit their web page.

[Matomo]: https://matomo.org/

## Attention
When refactoring the naming from **piwik** to **matomo**, the names of the database fields have changed as well. Therefore some settings may be lost when updating to 1.2.* !!

## Requirements
Matomo (formerly piwik) is a 'Open Analytics Platform'. The tracking will be saved outside of contao.

A public available Matomo/Piwik installation is needed (Self-hosted or Cloud-hosted doesn't matter).

## Install
### Contao manager
Search for the package and install it
```bash
agoat/contao-matomo
```

### Managed edition
Add the package
```bash
# Using the composer
composer require agoat/contao-matomo
```
Registration and configuration is done by the manager-plugin automatically.

### Standard edition
Add the package
```bash
# Using the composer
composer require agoat/contao-matomo
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
            new Agoat\MatomoBundle\AgoatMatomoBundle(),
        ];
    }
}
```
