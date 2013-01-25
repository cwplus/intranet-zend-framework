<?php
class Zend_View_Helper_DateFormat extends Zend_View_Helper_Abstract{
	/**
	 * Function permettant d'afficher la date au format francais (jj/mm/aaaa)
	 * @param string $dateAFormater
	 * @param string $type (dd/MM/yyyy, yyyy)
	 */
	public function dateFormat($dateAFormater, $type="default"){
		$date = new Zend_Date($dateAFormater);
		
		switch( $type ){
			case "yyyy" : 
				return $date->toString('yyyy');
				break;
				
			default : 
				return $date->toString('dd/MM/yyyy');
		}//fin switch
		
	}//fin dateFormat
	
}//fin class