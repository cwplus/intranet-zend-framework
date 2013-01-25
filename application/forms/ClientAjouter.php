<?php

class Application_Form_ClientAjouter extends Zend_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        $registry = Zend_Registry::getInstance();

        $this->setName("clientAjouter")
                ->setAttrib('class', 'clientAjouter');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');
        
        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();
        
        //Select : civiilite
        $civilite = new Zend_Form_Element_Select('CIVILITE');
        $civilite->setLabel("Civilite");
        $civilite->addMultiOption("0", "Selectionner une Civilite");

        //Texte : nom
        $nom = new Zend_Form_Element_Text('NOM');
        $nom->setLabel("Nom");
        $nom->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $nom->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $nom->addFilter('stripTags');
        $nom->addFilter('stringTrim');

        //Texte : prenom
        $prenom = new Zend_Form_Element_Text('PRENOM');
        $prenom->setLabel("Prenom");
        $prenom->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $prenom->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $prenom->addFilter('stripTags');
        $prenom->addFilter('stringTrim');

        //Texte : email
        $email = new Zend_Form_Element_Text('EMAIL');
        $email->setLabel("Email");
        $email->setRequired(true);
        $email->addFilter('stripTags');
        $email->addFilter('stringTrim');
        $email->addValidator(new Zend_Validate_EmailAddress());
        $email->addValidator('stringLength', false, array('max' => 100));

        //Texte : entreprise
        $entreprise = new Zend_Form_Element_Text('ENTREPRISE');
        $entreprise->setLabel("Entreprise");
        //$entreprise->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $entreprise->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $entreprise->addFilter('stripTags');
        $entreprise->addFilter('stringTrim');

        //Texte : adresse
        $adresse = new Zend_Form_Element_Text('ADRESSE_01');
        $adresse->setLabel("Adresse");
        $adresse->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $adresse->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $adresse->addFilter('stripTags');
        $adresse->addFilter('stringTrim');

        //Texte : adresse complement
        $adresseComplement = new Zend_Form_Element_Text('ADRESSE_02');
        $adresseComplement->setLabel("Complement d'adresse");
        $adresseComplement->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $adresseComplement->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $adresseComplement->addFilter('stripTags');
        $adresseComplement->addFilter('stringTrim');

        //Texte : ville
        $ville = new Zend_Form_Element_Text('VILLE');
        $ville->setLabel("Ville");
        $ville->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $ville->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $ville->addFilter('stripTags');
        $ville->addFilter('stringTrim');

        //Texte : cp
        $cp = new Zend_Form_Element_Text('CODE_POSTAL');
        $cp->setLabel("Code postal");
        $cp->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $cp->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $cp->addFilter('stripTags');
        $cp->addFilter('stringTrim');

        //Texte : tel bureau
        $telBur = new Zend_Form_Element_Text('TEL_BUREAU');
        $telBur->setLabel("Tel bureau");
        $telBur->setDescription("ex: 05 46 01 01 01");
        $telBur->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $telBur->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $telBur->addFilter('stripTags');
        $telBur->addFilter('stringTrim');

        //Texte : tel domicile
        $telDom = new Zend_Form_Element_Text('TEL_DOMICILE');
        $telDom->setLabel("Tel domicile");
        $telDom->setDescription("ex: 05 46 02 02 02");
        $telDom->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $telDom->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $telDom->addFilter('stripTags');
        $telDom->addFilter('stringTrim');

        //Texte : tel mobile
        $telMob = new Zend_Form_Element_Text('TEL_MOBILE');
        $telMob->setLabel("Tel mobile");
        $telMob->setDescription("ex: 06 01 01 01 01");
        $telMob->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $telMob->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $telMob->addFilter('stripTags');
        $telMob->addFilter('stringTrim');

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
        $args[] = $civilite;
        $args[] = $nom;
        $args[] = $prenom;
        $args[] = $email;
        $args[] = $entreprise;
        $args[] = $adresse;
        $args[] = $adresseComplement;
        $args[] = $ville;
        $args[] = $cp;
        $args[] = $telBur;
        $args[] = $telDom;
        $args[] = $telMob;
        $args[] = $submit;
        $args[] = $retour;
        $this->addElements($args);
    }

    /**
     * 
     * permet de remplir la liste des civilites dans le formulaire
     * @param Zend_Db_Table_Abstract $civilites
     */
    public function remplirCivilite($civilites) {
        $elem = $this->getElement('CIVILITE');
        foreach ($civilites as $civilite) {
            $elem->addMultiOption($civilite->ID_CIVILITE, $civilite->VALEUR);
        }
    }

}

