<?php
class Mick_GenerationMdp{
	////////////////////////////////////////////////////////////////////////////////////////////////////// 
	// @author Michael DUMONTET 
	// @but Créer un mdp aléatoirement 
	// @nom creerPassword() 
	// @param $nbCaractereMdp nb de caractères pr le mdp 
	public static function creerMdp( $nbCaractereMdp = 8 ){ 
		//Je ne garde pas les lettres suivante pour ne pas avoir de cause d'erreur av d'autre lettres : 
		// 0Oo l I 
		$chaine = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
		$pass = "";
		for($i=0; $i<$nbCaractereMdp; $i++){ 
			$pass .= $chaine[rand() % strlen($chaine)]; 
		}//fin for 
		return $pass; 
	}//fin fonction 
}