<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	/*
	 * navigation.xml
	 */
	
	protected function _initNavigationXml()
	{
	    $this->bootstrap('layout');
	    $layout = $this->getResource('layout');
	    $view = $layout->getView();
	    $config = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml');
	 
	    $navigation = new Zend_Navigation($config);
	    $view->navigation($navigation);
	}
	
	
	
	/*
	 * application.ini
	 */
	
	/*
	protected function _initNavigationConfig()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		
		$navigation = new Zend_Navigation($this->getOption('navigation'));
		$view->navigation($navigation);
	}
	*/
	
	
}

