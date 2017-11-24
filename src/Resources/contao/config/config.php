<?php

/*
 * Piwik analytics plugin for Contao Open Source CMS.
 *
 * @copyright  Arne Stappen (alias aGoat) 2017
 * @package    contao-piwikanalytics
 * @author     Arne Stappen <mehh@agoat.xyz>
 * @link       https://agoat.xyz
 * @license    LGPL-3.0
 */

 
/**
 * Add Hooks
 */

$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] 	= array('Agoat\\PiwikAnalyticsBundle\\Contao\\PiwikAnalytics', 'trackingCode');
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] 			= array('Agoat\\PiwikAnalyticsBundle\\Contao\\PiwikAnalytics', 'validatePiwikPath');

