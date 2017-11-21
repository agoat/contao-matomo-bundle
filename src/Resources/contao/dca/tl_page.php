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
 * Add palette to tl_page
 */  
// Root page 
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'piwikEnabled';

$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace('{publish_legend}', '{piwik_legend},piwikEnabled;{publish_legend}', $GLOBALS['TL_DCA']['tl_page']['palettes']['root']);
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['piwikEnabled'] = 'piwikPath,piwikSiteID,piwikIgnoreMembers,piwikIgnoreUsers,piwikCustVarUserName,piwikCustVarLanguage,piwikPageTitle,piwikAddDomain,piwikAddSiteStructure,piwikDoNotTrack,piwikAllContentImpressions,piwikVisibleContentImpressions,piwik404,piwikCookieDomains,piwikDomains,piwikSubdomains,piwikExtensions,piwikCustVarVisitName,piwikCustVarVisitValue';

// Regular page
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'piwikCatEnabled';

$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace('{publish_legend}', '{piwik_legend},piwikCatEnabled;{publish_legend}', $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']);
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['piwikCatEnabled'] = 'piwikCustVarPageName,piwikCustVarPageValue';


/**
 * Add fields to tl_page
 */ 
$GLOBALS['TL_DCA']['tl_page']['fields'] = array_merge(
	$GLOBALS['TL_DCA']['tl_page']['fields'], array(
		'piwikEnabled' => array(
			'label'         => &$GLOBALS['TL_LANG']['tl_page']['piwikEnabled'],
			'inputType'     => 'checkbox',
			'exclude'       => true,
			'eval'          => array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'piwikPath' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikPath'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'piwikPath', 'trailingSlash'=>true, 'tl_class'=>'w50', 'maxlength'=>255),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'piwikSiteID' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikSiteID'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50', 'maxlength'=>4),
			'sql'			=> "varchar(4) NOT NULL default ''"
		),	
		'piwikIgnoreMembers' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikIgnoreMembers'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikIgnoreUsers' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikIgnoreUsers'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikDoNotTrack' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikDoNotTrack'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikCustVarUserName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikCustVarUserName'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikCustVarLanguage' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikCustVarLanguage'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikPageTitle' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikPageTitle'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikAddDomain' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikAddDomain'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikAddSiteStructure' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikAddSiteStructure'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikCustVarVisitName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikCustVarVisitName'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 clr', 'maxlength'=>128),
			'sql'			=> "varchar(128) NOT NULL default ''"
		),
		'piwikCustVarVisitValue' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikCustVarVisitValue'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50', 'maxlength'=>128),
			'sql'			=> "varchar(128) NOT NULL default ''"
		),
		'piwikCookieDomains' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikCookieDomains'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwik404' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwik404'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikAllContentImpressions' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikAllContentImpressions'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikVisibleContentImpressions' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikVisibleContentImpressions'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikDomains' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikDomains'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 clr', 'maxlength'=>255),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'piwikSubdomains' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikSubdomains'],
			'inputType'		=> 'checkbox',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 m12'),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikExtensions' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikExtensions'],
			'default'		=> '7z,aac,arc,arj,asf,asx,avi,bin,bz,bz2,csv,deb,dmg,doc,exe,flv,gif,gz,gzip,hqx,jar,jpg,jpeg,js,mp2,mp3,mp4,mpg,mpeg,mov,movie,msi,msp,odb,odf,odg,odp,ods,odt,ogg,ogv,pdf,phps,png,ppt,qt,qtm,ra,ram,rar,rpm,sea,sit,tar,tbz,tbz2,tgz,torrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip',
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'long clr'),
			'save_callback'	=> array(
				array('tl_layout_PiwikTrackingTag', 'defaultExtensions')
			),
			'sql'			=> "text NULL"
		),
		
		'piwikCatEnabled' => array(
			'label'         => &$GLOBALS['TL_LANG']['tl_page']['piwikCatEnabled'],
			'inputType'     => 'checkbox',
			'exclude'       => true,
			'eval'          => array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default '0'"
		),
		'piwikCustVarPageName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikCustVarPageName'],
			'inputType'		=> 'text',
			'exclude'		=> true,
			'eval'			=> array('tl_class'=>'w50 clr', 'maxlength'=>128),
			'sql'			=> "varchar(128) NOT NULL default ''"
		),
		'piwikCustVarPageValue' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_page']['piwikCustVarPageValue'],
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
class tl_layout_PiwikTrackingTag extends Backend
{
	/**
	 * Set the default piwik extensions if empty
	 *
	 * @param string $value
	 *
	 * @return string $value
	 */
	public function defaultExtensions($value)
	{
		if(trim($value) == '') 
			return $GLOBALS['TL_DCA']['tl_page']['fields']['piwikExtensions']['default'];
		else
			return $value;
	}
}

