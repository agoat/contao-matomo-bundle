<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package  	 Piwik Analytics
 * @author   	 Arne Stappen
 * @license  	 LGPL-3.0+ 
 * @copyright	 Arne Stappen 2011-2015
 */

namespace Agoat;

use Contao\Frontend;
use Contao\Request;
use Contao\Input;


class PiwikAnalytics extends Frontend
{

	public function trackingCode ($strContent, $strTemplate)
	{
		$objPage = $GLOBALS['objPage'];
		$siteDetails = $this->getPageDetails($objPage->rootId);
		$pageDetails = $this->getPageDetails($objPage->id);

		if($siteDetails->piwikEnabled) 
		{
			if($siteDetails->piwikIgnoreUsers AND Input::cookie('BE_USER_AUTH'))
				$jsTag = '<!-- PiwikTrackingTag: Tracking users disabled -->\n';
			elseif($siteDetails->piwikIgnoreMembers AND FE_USER_LOGGED_IN)
				$jsTag = '<!-- PiwikTrackingTag: Tracking members disabled -->\n';
			else
			{
				$url 		= $siteDetails->piwikPath;
				$extensions	= str_replace(' ', '', $siteDetails->piwikExtensions);
				$domain		= $objPage->domain ? $objPage->domain : Environment::get('host');
			
				$jsTag  = '<script type="text/javascript">' . "\n";
				$jsTag .= 'var _paq = _paq || []; ' . "\n";
				
				// 404 errors
				if($siteDetails->piwik404 AND $objPage->type == 'error_404')
				{
					$jsTag .= ' _paq.push(["setDocumentTitle", "404/URL = " + encodeURIComponent(document.location.pathname+document.location.search) + "/From = " + encodeURIComponent(document.referrer)]);' . "\n";
				}
				
				// set document title
				else
				{
					// use page title
					if($siteDetails->piwikPageTitle)
					{
						$title = $objPage->pageTitle ? $objPage->pageTitle : $objPage->title;
					}
					else
					{
						$title = $objPage->title;

					}
					
					// add page structure
					if($siteDetails->piwikAddSiteStructure)
					{
						$objPages = PageModel::findParentsById($objPage->pid);
						if ($objPages !== null)
						{
							while ($objPages->next())
							{
								$pretitles[] = $objPages->pageTitle ? $objPages->pageTitle : $objPages->title;
							}
							$pretitle = implode("/", array_reverse($pretitles)) . "/";
						}
					}
					// add Domainname
					$title = $siteDetails->piwikAddDomain ? $domain . '/' . $pretitle . $title : $pretitle . $title;
					$jsTag .= ' _paq.push(["setDocumentTitle", "' . $title . '"]);' . "\n";
				}
				
				// notice if the user do not wish to be tracked
				if($siteDetails->piwikDoNotTrack) 
				{
					$jsTag .= ' _paq.push(["setDoNotTrack", true]);' . "\n";
				}
				
				// track user over subdomains
				if($siteDetails->piwikCookieDomains) 
				{
					$jsTag .= ' _paq.push(["setCookieDomain", "*.' . $domain . '"]);' . "\n";
				}
				
				// set all subdomains to track as local
				if($siteDetails->piwikSubdomains) 
				{
					$jsTag .= ' _paq.push(["setDomains", "*.' . $domain . '"]);' . "\n";
				}
				
				// set specific domains and Files&Assets URL as local
				elseif(TL_FILES_URL || $objPage->staticSystem || $objPage->staticPlugins || $siteDetails->piwikDomains) 
				{
					$domains = array();
					TL_FILES_URL ? $domains[] = str_replace(array("http:","https:","/"),"",TL_FILES_URL) : '';
					TL_PLUGINS_URL ? $domains[] = str_replace(array("http:","https:","/"),"",TL_PLUGINS_URL) : '';
					$domains = $siteDetails->piwikDomains ? array_merge($domains,explode(",",str_replace(array("http://","https://"),"",$siteDetails->piwikDomains))) : $domains;
					$domains = array_unique($domains);
					$jsTag .= ' _paq.push(["setDomains", ["' . implode("\",\"",$domains) . '"]]);' . "\n";
				}
				
				// set user language
				if($siteDetails->piwikCustVarLanguage) 
				{
					$jsTag .= ' _paq.push(["setCustomVariable", 1, "Language", "' . $objPage->language . '", "visit"]);' . "\n";
				}
				
				// set user logged in status
				if($siteDetails->piwikCustVarUserName) 
				{
					$this->import('FrontendUser', 'User');
					$userstatus = (FE_USER_LOGGED_IN) ? $this->User->firstname . ' ' . $this->User->lastname . ' (' . $this->User->username . ')' : 'Anonymous';
					$jsTag .= ' _paq.push(["setCustomVariable", 2, "User", "' . $userstatus . '", "visit"]);' . "\n";
				}
				
				// set custom variable for visit 
				if($siteDetails->piwikCustVarVisitName && $siteDetails->piwikCustVarVisitValue) 
				{
					$jsTag .= ' _paq.push(["setCustomVariable", 3, "' . $siteDetails->piwikCustVarVisitName . '", "' . $siteDetails->piwikCustVarVisitValue . '", "visit"]);' . "\n";
				}
				
				
				// set custom variable for page
				if($pageDetails->piwikCatEnabled && $pageDetails->piwikCustVarPageName && $pageDetails->piwikCustVarPageValue) 
				{
					$jsTag .= ' _paq.push(["setCustomVariable", 1, "' .$pageDetails->piwikCustVarPageName . '", "' . $pageDetails->piwikCustVarPageValue . '", "page"]);' . "\n";
				}
				
				// set download extensions (if not default)
				if($extensions != '7z,aac,arc,arj,asf,asx,avi,bin,bz,bz2,csv,deb,dmg,doc,exe,flv,gif,gz,gzip,hqx,jar,jpg,jpeg,js,mp2,mp3,mp4,mpg,mpeg,mov,movie,msi,msp,odb,odf,odg,odp,ods,odt,ogg,ogv,pdf,phps,png,ppt,qt,qtm,ra,ram,rar,rpm,sea,sit,tar,tbz,tbz2,tgz,torrent,txt,wav,wma,wmv,wpd,xls,xml,z,zip')
				{
					$extensions = str_replace(',', '|', $extensions);
				
					$jsTag .= ' _paq.push(["setDownloadExtensions", "' . $extensions . '"]);' . "\n";
				}

				$jsTag .= ' _paq.push(["trackPageView"]);' . "\n";
				$jsTag .= ' _paq.push(["enableLinkTracking"]);' . "\n";

				// set content tracking (trackAllContentImpressions or trackVisibleContentImpressions);
				if ($siteDetails->piwikAllContentImpressions && !$siteDetails->piwikVisibleContentImpressions)
				{
					$jsTag .= ' _paq.push(["trackAllContentImpressions"]);' . "\n";
				}
				elseif ($siteDetails->piwikVisibleContentImpressions)
				{
					$jsTag .= ' _paq.push(["trackVisibleContentImpressions"]);' . "\n";				
				}
				
				$jsTag .= '(function() {' . "\n";
				$jsTag .= ' var u="' . $siteDetails->piwikPath .'";' . "\n";
				$jsTag .= ' _paq.push(["setTrackerUrl", u+"piwik.php"]);' . "\n";
				$jsTag .= ' _paq.push(["setSiteId", "' . $siteDetails->piwikSiteID . '"]);' . "\n";
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

	
	public function validatePiwikPath($strRegexp, $varValue, \Contao\Widget $objWidget)
	{
		if($strRegexp == 'piwikPath')
		{
			if (!preg_match('/^[a-zA-Z0-9\.\+\/\?#%:,;\{\}\(\)\[\]@&=~_-]*$/', $varValue))
			{
				$objWidget->addError($GLOBALS['TL_LANG']['ERR']['url']);
			
				return true;
			}
			
			$varValue = preg_replace('/\/+$/i', '', $varValue) . '/';
			
			$objRequest = new Request();
			$objRequest->send($varValue . 'piwik.js');
			
			if($objRequest->hasError())
			{
				$objWidget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['piwikPath'], $objRequest->code, $objRequest->error));
			
				return true;
			}
		}
		
		return false;
	}

}

