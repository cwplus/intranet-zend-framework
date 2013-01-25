<?php
/**
 * Permet de generer une chaine de caractère unique.
 * @copyright eewee.fr
 */
class Mick_GenererSalt{
	public static function salt( $nbCaractere = 50 ){ 
   		$dynamicSalt = '';
		for ($i = 0; $i < $nbCaractere; $i++){
		    $dynamicSalt .= chr(rand(33, 126));
		}
		return $dynamicSalt;
	} 
}