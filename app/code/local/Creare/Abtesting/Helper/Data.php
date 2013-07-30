<?php

class Creare_Abtesting_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getCode()
	{
		$cookie = Mage::getModel('core/cookie')->get('abtesting');
		$session = Mage::getSingleton('core/session')->getAbTest();
		
		if(!$cookie){
			if($session){
				if($session == 'a'){
					return Mage::getStoreConfig('abtesting/accounts/acode');	
				} else {
					return Mage::getStoreConfig('abtesting/accounts/bcode');	
				}
			}
		} else {
			if($cookie == 'a'){
				return Mage::getStoreConfig('abtesting/accounts/acode');	
			} else {
				return Mage::getStoreConfig('abtesting/accounts/bcode');	
			}
		}
	}
}