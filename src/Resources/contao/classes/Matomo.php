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

namespace Agoat\MatomoBundle\Contao;

use Contao\Frontend;
use Contao\Environment;
use Contao\Request;
use Contao\Input;
use Contao\Widget;


/**
 * Provide methods to handle matomo tracking code and urls
 */
class Matomo extends Frontend
{
 	/**
	 * Insert the tracking code for matomo
	 *
	 * @param string $strContent The page content
	 * @param string $strTemplate The page template
	 *
	 * @return string The page content
	 */
	public function trackingCode ($strContent, $strTemplate)
	{
		$objPage = $GLOBALS['objPage'];
		
		$siteDetails = \PageModel::findWithDetails($objPage->rootId);
		$pageDetails = \PageModel::findWithDetails($objPage->id);

		if ($siteDetails->matomoEnabled) 
		{
			if ($siteDetails->matomoIgnoreUsers AND Input::cookie('BE_USER_AUTH'))
				$jsTag = '<!-- MatomoTrackingTag: Tracking users disabled -->' . "\n";
			elseif ($siteDetails->matomoIgnoreMembers AND FE_USER_LOGGED_IN)
				$jsTag = '<!-- MatomoTrackingTag: Tracking members disabled -->' . "\n";
			else
			{
				$url = $siteDetails->matomoPath;
				$extensions	= str_replace(' ', '', $siteDetails->matomoExtensions);
				$domain = $objPage->domain ? $objPage->domain : Environment::get('host');
			
				$jsTag = '<script type="text/javascript">' . "\n";
				$jsTag .= 'var _paq = _paq || []; ' . "\n";
				
				// 404 errors
				if ($siteDetails->matomo404 AND $objPage->type == 'error_404')
				{
					$jsTag .= ' _paq.push(["setDocumentTitle", "404/URL = " + encodeURIComponent(document.location.pathname+document.location.search) + "/From = " + encodeURIComponent(document.referrer)]);' . "\n";
				}
				
				// Set document title
				else
				{
					// Use page title
					if ($siteDetails->matomoPageTitle)
					{
						$title = $objPage->pageTitle ? $objPage->pageTitle : $objPage->title;
					}
					else
					{
						$title = $objPage->title;

					}
					
					// Add page structure
					if ($siteDetails->matomoAddSiteStructure)
					{
						$objPages = \PageModel::findParentsById($objPage->pid);
						if ($objPages !== null)
						{
							while ($objPages->next())
							{
								$pretitles[] = $objPages->pageTitle ? $objPages->pageTitle : $objPages->title;
							}
							$pretitle = implode("/", array_reverse($pretitles)) . "/";
						}
					}
					// Add Domainname
					$title = $siteDetails->matomoAddDomain ? $domain . '/' . $pretitle . $title : $pretitle . $title;
					$jsTag .= ' _paq.push(["setDocumentTitle", "' . $title . '"]);' . "\n";
				}
				
				// Notice if the user do not wish to be tracked
				if ($siteDetails->matomoDoNotTrack) 
				{
					$jsTag .= ' _paq.push(["setDoNotTrack", true]);' . "\n";
				}
				
				// Track user over subdomains
				if ($siteDetails->matomoCookieDomains) 
				{
					$jsTag .= ' _paq.push(["setCookieDomain", "*.' . $domain . '"]);' . "\n";
				}
				
				// Set all subdomains to track as local
				if( $siteDetails->matomoSubdomains) 
				{
					$jsTag .= ' _paq.push(["setDomains", "*.' . $domain . '"]);' . "\n";
				}
				
				// Set specific domains and Files&Assets URL as local
				elseif (TL_FILES_URL || $objPage->staticSystem || $objPage->staticPlugins || $siteDetails->matomoDomains) 
				{
					$domains = array();
					TL_FILES_URL ? $domains[] = str_replace(array("http:","https:","/"),"",TL_FILES_URL) : '';
					TL_PLUGINS_URL ? $domains[] = str_replace(array("http:","https:","/"),"",TL_PLUGINS_URL) : '';
					$domains = $siteDetails->matomoDomains ? array_merge($domains,explode(",",str_replace(array("http://","https://"),"",$siteDetails->matomoDomains))) : $domains;
					$domains = array_unique($domains);
					$jsTag .= ' _paq.push(["setDomains", ["' . implode("\",\"",$domains) . '"]]);' . "\n";
				}
				
				// Set user language
				if ($siteDetails->matomoVarLanguage) 
				{
					$jsTag .= ' _paq.push(["setCustomVariable", 1, "Language", "' . $objPage->language . '", "visit"]);' . "\n";
				}
				
				// Set user logged in status
				if ($siteDetails->matomoVarUserName) 
				{
					$this->import('FrontendUser', 'User');
					$userstatus = (FE_USER_LOGGED_IN) ? $this->User->firstname . ' ' . $this->User->lastname . ' (' . $this->User->username . ')' : 'Anonymous';
					$jsTag .= ' _paq.push(["setCustomVariable", 2, "User", "' . $userstatus . '", "visit"]);' . "\n";
				}
				
				// Set custom variable for visit 
				if ($siteDetails->matomoVarVisitName && $siteDetails->matomoVarVisitValue) 
				{
					$jsTag .= ' _paq.push(["setCustomVariable", 3, "' . $siteDetails->matomoVarVisitName . '", "' . $siteDetails->matomoVarVisitValue . '", "visit"]);' . "\n";
				}
				
				
				// Set custom variable for page
				if ($pageDetails->matomoCatEnabled && $pageDetails->matomoVarPageName && $pageDetails->matomoVarPageValue) 
				{
					$jsTag .= ' _paq.push(["setCustomVariable", 1, "' .$pageDetails->matomoVarPageName . '", "' . $pageDetails->matomoVarPageValue . '", "page"]);' . "\n";
				}
				
				// Set download extensions (if not default)
				if ($extensions != '7z,aac,arc,arj,asf,asx,avi,bin,bz,bz2,csv,deb,dmg,doc,exe,flv,gif,gz,gzip,hqx,jar,jpg,jpeg,js,mp2,mp3,mp4,mpg,mpeg,mov,movie,msi,msp,odb,odf,odg,odp,ods,odt,ogg,ogv,pdf,phps,png,ppt,qt,qtm,ra,ram,rar,rpm,sea,sit,tar,tbz,tbz2,tgz,torrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip')
				{
					$extensions = str_replace(',', '|', $extensions);
				
					$jsTag .= ' _paq.push(["setDownloadExtensions", "' . $extensions . '"]);' . "\n";
				}

				$jsTag .= ' _paq.push(["trackPageView"]);' . "\n";
				$jsTag .= ' _paq.push(["enableLinkTracking"]);' . "\n";

				// Set content tracking (trackAllContentImpressions or trackVisibleContentImpressions);
				if ($siteDetails->matomoAllContentImpressions && !$siteDetails->matomoVisibleContentImpressions)
				{
					$jsTag .= ' _paq.push(["trackAllContentImpressions"]);' . "\n";
				}
				elseif ($siteDetails->matomoVisibleContentImpressions)
				{
					$jsTag .= ' _paq.push(["trackVisibleContentImpressions"]);' . "\n";				
				}
				
				$jsTag .= '(function() {' . "\n";
				$jsTag .= ' var u="' . $siteDetails->matomoPath .'";' . "\n";
				$jsTag .= ' _paq.push(["setTrackerUrl", u+"piwik.php"]);' . "\n";
				$jsTag .= ' _paq.push(["setSiteId", "' . $siteDetails->matomoSiteID . '"]);' . "\n";
				$jsTag .= ' var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";' . "\n";
				$jsTag .= ' g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);' . "\n";
				$jsTag .= '})();' . "\n";
				$jsTag .= '</script>' . "\n";
			}
			
			$jsTag .= "</body>";
				
			$strContent = str_replace('</body>', $jsTag, $strContent);
		}
		
        return $strContent;
	}

	
 	/**
	 * Validate the path and connection to the matomo server instance
	 *
	 * @param string $strRegexp The regex type
	 * @param string $varValue The value to validate
	 * @param Widget $objWidget The Reference to the widget
	 *
	 * @return true|false
	 */
	public function validateMatomoPath($strRegexp, $varValue, Widget $objWidget)
	{
		if($strRegexp == 'matomoPath')
		{
			if (!preg_match('/^[a-zA-Z0-9\.\+\/\?#%:,;\{\}\(\)\[\]@&=~_-]*$/', $varValue))
			{
				$objWidget->addError($GLOBALS['TL_LANG']['ERR']['url']);
			
				return true;
			}
			
			$varValue = preg_replace('/\/+$/i', '', $varValue) . '/';
			
			$objRequest = new Request();
			$objRequest->send($varValue . 'matomo.js');
			
			if($objRequest->hasError())
			{
				$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['matomoPath'], $objRequest->code, $objRequest->error));
			
				return true;
			}
		}
		
		return false;
	}
}
