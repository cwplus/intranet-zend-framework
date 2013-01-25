<?php
class Application_Form_AuthLogin extends Zend_Form {
	public function init() {
        $this->setName("formLogin")
        	 ->setAttrib('class', 'formLogin')
        	 ->setAction('/Auth/login');
    	
        // traduction
		$t = Zend_Registry::get('Zend_Translate');
		
		//Texte : login
	    $email = new Zend_Form_Element_Text('email');
	    $email -> setLabel($t->_("Email"));
	    $email -> setRequired(true);
	    //Add filters
    	$email -> addFilter('stripTags');
    	$email -> addFilter('stringTrim');
    	//Add validateurs
    	$email -> addValidator(new Zend_Validate_EmailAddress());
    	$email -> addValidator('stringLength',false,array('max'=>100));
    	
    	//Texte : mot de passe
    	$password = new Zend_Form_Element_Password('password');
    	$password -> setLabel($t->_("Password"));
    	$password -> setRequired(true);
	    //Add filters
    	$password -> addFilter('stripTags');
    	$password -> addFilter('stringTrim');
    	//Add validateurs
    	$password -> addValidator('stringLength',false,array('max'=>30));
    	$password -> getDecorator('description')->setOption('escape',false);
    	/*
    	//Bouton : submit
    	$submit = new Zend_Form_Element_Image('connexion');
    	$submit -> setImage('/images/bouton/connexion.png');
    	$submit -> setDescription('Si vous ne vous souvenez pas de votre mot de passe, <a href="/Auth/pwd-oublie">cliquez ici.</a>');
//    	$submit -> setLabel('Connexion');
	$submit -> addDecorator('Description');
	$submit -> getDecorator('Description')->setEscape(false);
        */
        //Bouton : submit
        $submit = new Zend_Form_Element_Submit('btn_envoyer');
        $submit->setLabel($t->translate("Valider"));
        $submit->setAttrib("class", "btn btn-primary");

        //Bouton : retour
        $retour = new Zend_Form_Element_Submit('btn_retour');
        $retour->setLabel($t->translate("Retour"));
        $retour->setAttrib("class", "btn");
        
        
    	$this -> addElements(array($email, $password, $submit, $retour));
	}
}