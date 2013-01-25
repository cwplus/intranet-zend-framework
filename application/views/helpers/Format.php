<?php
class Zend_View_Helper_Format extends Zend_View_Helper_Abstract{
	/**
	 * Affichons ce nombre au format international pour la locale definie dans le bootstrap
	 * @param string $valeur
	 */
	public function formaterPrix($valeur){
//		setlocale(LC_MONETARY, 'fr_FR');
		return money_format('%!.0n', $valeur);
	}
	
	/**
	 * Function permettant de formater un kilometrage
	 * @param string $valeur
	 */
	public function formaterKm($valeur){
		return number_format($valeur, 0, ',', ' ');
	}
	
}//fin class