<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options Mobile Switcher
 * @category Controller
 * @author Michael Krasnow <mnkras@gmail.com>
 * @copyright  Copyright (c) 2010-2012 Michael Krasnow (http://www.mnkras.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

class DashboardThemeOptionsMobileSwitcherController extends DashboardBaseController { 	

	public $helpers = array('html');

	public function view() {

		$this->addFooterItem('<script type="text/javscript">$(function(){$(\'.ccm-tooltip\').twipsy();});</script>');

		$tArray = array();
		
		$tArray = PageTheme::getList();
		
		$this->set('tArray', $tArray);
		$siteThemeID = 0;
		$co = new Config();
		$pkg = Package::getByHandle("theme_options_mobile_switcher");
		$co->setPackageObject($pkg);
		$obj = $co->get('MOBILE_SITE_THEME_ID');
		if($obj) {
			$siteThemeID = $obj;
		}
		
		$this->set('siteThemeID', $siteThemeID);
	}

	public function on_start() {
		parent::on_start();
		$co = new Config();
		$pkg = Package::getByHandle("theme_options_mobile_switcher");
		$co->setPackageObject($pkg);
		$enabled = $co->get('MOBILE_SITE_THEME_ENABLED');
		$this->set('disableThirdLevelNav', true);
		$this->set('mobile_enabled', $enabled);
	}
		
	public function activate_confirm($ptID, $token) {
		$l = PageTheme::getByID($ptID);
		$val = Loader::helper('validation/error');
		$valt = Loader::helper('validation/token');
		if (!$valt->validate('activate_mobile', $token)) {
			$val->add($valt->getErrorMessage());
			$this->set('error', $val);
		} else if (!is_object($l)) {
			$val->add(t('Invalid Theme'));
			$this->set('error', $val);
		} else {
			$co = new Config();
			$pkg = Package::getByHandle("theme_options_mobile_switcher");
			$co->setPackageObject($pkg);
			$obj = $co->save('MOBILE_SITE_THEME_ID', $ptID);
			$this->set('message', t('Mobile Theme activated'));
		}
		$this->view();
	}
	
	public function mobile_enabled() {
		$val = Loader::helper('validation/error');
		$valt = Loader::helper('validation/token');
		if (!$valt->validate('mobile_enabled')) {
			$val->add($valt->getErrorMessage());
			$this->set('error', $val);
		} else {
			$co = new Config();
			$pkg = Package::getByHandle("theme_options_mobile_switcher");
			$co->setPackageObject($pkg);
			$obj = $co->save('MOBILE_SITE_THEME_ENABLED', $this->post('MOBILE_ENABLED'));
			$this->set('message', t('Mobile Setting Saved'));
		}
		$this->view();
	}
	

}