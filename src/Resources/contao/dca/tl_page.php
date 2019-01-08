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
 * Add palette to tl_page
 */  
// Root page 
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'matomoEnabled';

$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace('{publish_legend}', '{matomo_legend},matomoEnabled;{publish_legend}', $GLOBALS['TL_DCA']['tl_page']['palettes']['root']);
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['matomoEnabled'] = 'matomoPath,matomoSiteID,matomoIgnoreMembers,matomoIgnoreUsers,matomoCustVarUserName,matomoCustVarLanguage,matomoPageTitle,matomoAddDomain,matomoAddSiteStructure,matomoDoNotTrack,matomoAllContentImpressions,matomoVisibleContentImpressions,matomo404,matomoCookieDomains,matomoDomains,matomoSubdomains,matomoExtensions,matomoCustVarVisitName,matomoCustVarVisitValue';

// Regular page
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'matomoCatEnabled';

$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace('{publish_legend}', '{matomo_legend},matomoCatEnabled;{publish_legend}', $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']);
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['matomoCatEnabled'] = 'matomoCustVarPageName,matomoCustVarPageValue';


/**
 * Add fields to tl_page
 */ 
$GLOBALS['TL_DCA']['tl_page']['fields'] = array_merge(
	$GLOBALS['TL_DCA']['tl_page']['fields'], array(
		'matomoEnabled' => array(
			'label'         => &$GLOBALS['TL_LANG']['tl_page']['matomoEnabled'],
			'inputType'     => 'checkbox',
			'exclude'       => true,
			'eval'          => array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'matomoPath' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoPath'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'matomoPath', 'trailingSlash'=>true, 'tl_class'=>'w50', 'maxlength'=>255),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'matomoSiteID' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoSiteID'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50', 'maxlength'=>4),
			'sql'			=> "varchar(4) NOT NULL default ''"
		),	
		'matomoIgnoreMembers' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoIgnoreMembers'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoIgnoreUsers' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoIgnoreUsers'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoDoNotTrack' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoDoNotTrack'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoCustVarUserName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoCustVarUserName'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoCustVarLanguage' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoCustVarLanguage'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoPageTitle' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoPageTitle'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoAddDomain' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoAddDomain'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoAddSiteStructure' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoAddSiteStructure'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoCustVarVisitName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoCustVarVisitName'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 clr', 'maxlength'=>128),
			'sql'			=> "varchar(128) NOT NULL default ''"
		),
		'matomoCustVarVisitValue' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoCustVarVisitValue'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50', 'maxlength'=>128),
			'sql'			=> "varchar(128) NOT NULL default ''"
		),
		'matomoCookieDomains' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoCookieDomains'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomo404' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomo404'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoAllContentImpressions' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoAllContentImpressions'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoVisibleContentImpressions' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoVisibleContentImpressions'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoDomains' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoDomains'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 clr', 'maxlength'=>255),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'matomoSubdomains' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoSubdomains'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 m12'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoExtensions' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoExtensions'],
			'default'		=> '7z,aac,arc,arj,asf,asx,avi,bin,bz,bz2,csv,deb,dmg,doc,exe,flv,gif,gz,gzip,hqx,jar,jpg,jpeg,js,mp2,mp3,mp4,mpg,mpeg,mov,movie,msi,msp,odb,odf,odg,odp,ods,odt,ogg,ogv,pdf,phps,png,ppt,qt,qtm,ra,ram,rar,rpm,sea,sit,tar,tbz,tbz2,tgz,torrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip',
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'long clr'),
			'save_callback'	=> array(
				array('tl_layout_MatomoTrackingTag', 'defaultExtensions')
			),
			'sql'			=> "text NULL"
		),
		
		'matomoCatEnabled' => array(
			'label'         => &$GLOBALS['TL_LANG']['tl_page']['matomoCatEnabled'],
			'inputType'     => 'checkbox',
			'exclude'       => true,
			'eval'          => array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'matomoCustVarPageName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoCustVarPageName'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 clr', 'maxlength'=>128),
			'sql'			=> "varchar(128) NOT NULL default ''"
		),
		'matomoCustVarPageValue' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['matomoCustVarPageValue'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50', 'maxlength'=>128),
			'sql'			=> "varchar(128) NOT NULL default ''"
		),

	)
);


/**
 * Provide methods that are used by the data configuration array.
 */
class tl_layout_MatomoTrackingTag extends Backend
{
	/**
	 * Set the default matomo extensions if empty
	 *
	 * @param string $value
	 *
	 * @return string $value
	 */
	public function defaultExtensions($value)
	{
		return (empty($value)) ? $GLOBALS['TL_DCA']['tl_page']['fields']['matomoExtensions']['default'] : $value;
	}
}

