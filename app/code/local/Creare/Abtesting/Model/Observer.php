<?php

class Creare_Abtesting_Model_Observer
{
	public function removeAbSession()
	{	
		Mage::getSingleton('core/session')->setAbTesting('');
	}
	
	public function removeTempSession()
	{
		Mage::getSingleton('core/session')->setAbTest('');
	}
}