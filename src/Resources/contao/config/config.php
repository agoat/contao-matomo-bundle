<?php

/*
 * Matomo analytics plugin for Contao Open Source CMS.
 *
 * @copyright  Arne Stappen (alias aGoat) 2017
 * @package    contao-matomo-bundle
 * @author     Arne Stappen <mehh@agoat.xyz>
 * @link       https://agoat.xyz
 * @license    LGPL-3.0
 */

 
/**
 * Add Hooks
 */

$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] 	= array('Agoat\\MatomoBundle\\Contao\\Matomo', 'trackingCode');
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] 			= array('Agoat\\MatomoBundle\\Contao\\Matomo', 'validateMatomoPath');

