<?php

class Application_Form_FournisseurEditer extends Zend_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        //$registry = Zend_Registry::getInstance();

        $this->setName("fournisseurEditer")
                ->setAttrib('class', 'fournisseurEditer');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');
        
        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();
        //
        //Texte : nom
        $nom = new Zend_Form_Element_Text('VALEUR');
        $nom->setLabel("Nom du fournisseur");
        $nom->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $nom->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $nom->addFilter('stripTags');
        $nom->addFilter('stringTrim');

        //Bouton : submit
        $submit = new Zend_Form_Element_Submit('btn_envoyer');
        $submit->setLabel($t->translate("Valider"));
        $submit->setAttrib("class", "btn btn-primary");

        //Bouton : retour
        $retour = new Zend_Form_Element_Submit('btn_retour');
        $retour->setLabel($t->translate("Retour"));
        $retour->setAttrib("class", "btn");

        //Req
        $args = array();
        $args[] = $nom;
        $args[] = $submit;
        $args[] = $retour;
        $this->addElements($args);
    }

    /**
     * 
     * permet de remplir la liste des civilites dans le formulaire
     * @param Zend_Db_Table_Abstract $civilites
     */
    /*
      public function remplirCivilite($civilites) {
      $elem = $this->getElement('CIVILITE');
      foreach ($civilites as $civilite) {
      $elem->addMultiOption($civilite->ID_CIVILITE, $civilite->VALEUR);
      }
      }
     */
}