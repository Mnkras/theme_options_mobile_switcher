<?php       
defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options Mobile Switcher
 * @category Controller
 * @author Michael Krasnow <mnkras@gmail.com>
 * @copyright  Copyright (c) 2010-2012 Michael Krasnow (http://www.mnkras.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
class ThemeOptionsMobileSwitcherPackage extends Package {

	protected $pkgHandle = 'theme_options_mobile_switcher';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.0';
	
	public function getPackageName() {
		return t("Theme Options Mobile Switcher");
	}
	
	public function getPackageDescription() {
		return t("Easily redirect mobile devices to a mobile theme on your site.");
	}
	
	public function install() {
		$pkg = parent::install();
		
		Loader::model('single_page');
		
		$sp = SinglePage::add('/dashboard/'.$this->pkgHandle, $pkg);
		$sp->update(array('cName'=>t("Mobile Theme"), 'cDescription'=>t("Set a theme for mobile devices.")));
		
		//add mobile theme stuff
		$co = new Config();
		$pkg = Package::getByHandle($this->pkgHandle);
		$co->setPackageObject($pkg);
		$co->save('MOBILE_SITE_THEME_ENABLED', 1);
		$co->save('MOBILE_SITE_THEME_ID', 0);

	}
	
	public function on_start() {
	
		/* Mobile Device Stuff */
		$co = new Config();
		$pkg = Package::getByHandle($this->pkgHandle);
		$co->setPackageObject($pkg);
		$en = $co->get('MOBILE_SITE_THEME_ENABLED');
		$at = $co->get('MOBILE_SITE_THEME_ID');
		if($en == 1 && $at > 0) {
			Events::extend('on_start', 'TOMSMobileSwitcher', 'checkForMobile', './'.DIRNAME_PACKAGES.'/'.$this->pkgHandle.'/'.DIRNAME_MODELS.'/mobile_switcher.php');
		}
	}

}