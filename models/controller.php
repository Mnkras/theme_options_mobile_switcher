<?php    
defined('C5_EXECUTE') or die('Access Denied');
/**
 * @package Theme Options Mobile Switcher
 * @category Controller
 * @author Michael Krasnow <mnkras@gmail.com>
 * @copyright  Copyright (c) 2010-2012 Michael Krasnow (http://www.mnkras.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
Loader::library('TOMSBrowser', 'theme_options_mobile_switcher');
class TOMSMobileSwitcher {

	public function checkForMobile($view) {	
		$page = Page::getCurrentPage();
		$browser = new TOMSBrowser();
		if (!$page->isAdminArea()) {		
			if($browser->isMobile() && !isset($_COOKIE[SESSION.'_MOBILE'])) {
				define('IS_MOBILE_DEVICE', true);
				setcookie(SESSION.'_MOBILE', 2, strtotime('+10 year'), DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
				$theme = PageTheme::getByID(self::getMobileThemeID());
				$view->setTheme($theme);
			}
		}
		self::SetMobile($view);
	}

	public function SetMobile($view) {
		$page = Page::getCurrentPage();
		if (!$page->isAdminArea()) {
			if($_GET['site'] == 'full') {
				define('IS_MOBILE_DEVICE', false);
				setcookie(SESSION.'_MOBILE', 1, strtotime('+10 year'), DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
			} else
			if($_GET['site'] == 'mobile') {
				define('IS_MOBILE_DEVICE', true);
				setcookie(SESSION.'_MOBILE', 2, strtotime('+10 year'), DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
				$theme = PageTheme::getByID(self::getMobileThemeID());
				$view->setTheme($theme);
			} else
			if($_GET['site'] == 'unset') {
				setcookie(SESSION.'_MOBILE', null, -1, DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
			} else
			if (isset($_COOKIE[SESSION.'_MOBILE']) && $_COOKIE[SESSION.'_MOBILE'] == 2) {
				define('IS_MOBILE_DEVICE', true);
				$theme = PageTheme::getByID(self::getMobileThemeID());
				$view->setTheme($theme);	
			}
		}
		if(!defined('IS_MOBILE_DEVICE')) {
			define('IS_MOBILE_DEVICE', false);
		}
	}
	
	public function getMobileThemeID() {
		$co = new Config();
		$pkg = Package::getByHandle("theme_options_mobile_switcher");
		$co->setPackageObject($pkg);
		return $co->get('MOBILE_SITE_THEME_ID');
	}
}