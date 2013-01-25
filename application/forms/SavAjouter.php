<?php

class Application_Form_SavAjouter extends Zend_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        $registry = Zend_Registry::getInstance();

        $this->setName("savAjouter")
                ->setAttrib('class', 'savAjouter');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');
        
        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();
        
        //Select : etat
        $etat = new Zend_Form_Element_Select('ETAT');
        $etat->setLabel("Etat");
        $etat->addMultiOption("0", "Selectionner un etat");

        //Date: date livraison
        $dateLivraison = new ZendX_JQuery_Form_Element_DatePicker("DATE_LIVRAISON",
                        array(
                            'label' => 'Date livraison',
                            'required' => true,
                            'jQueryParams' =>
                            array(
                                'firstDay' => 1,
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '1960:+0')));
        $dateLivraison->addFilter('stripTags');
        $dateLivraison->addFilter('stringTrim');
        $dateLivraison->addValidator(new Zend_Validate_Date('Y-m-d'));
        
        //Select : contact commercial
        $contactCommercial = new Zend_Form_Element_Select('CONTACT_COMMERCIAL');
        $contactCommercial->setLabel("Contact commercial");
        $contactCommercial->addMultiOption("0", "Selectionner une personne");
        
        //Select : contact technique
        $contactTechnique = new Zend_Form_Element_Select('CONTACT_TECHNIQUE');
        $contactTechnique->setLabel("Contact technique");
        $contactTechnique->addMultiOption("0", "Selectionner une personne");
        
        //Texte : accessoire client
        $accessoireClient = new Zend_Form_Element_Textarea('ACCESSOIRE_CLIENT');
        $accessoireClient->setLabel("Accessoire client");
        $accessoireClient->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $accessoireClient->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $accessoireClient->addFilter('stripTags');
        $accessoireClient->addFilter('stringTrim');
        $accessoireClient->setAttrib('cols', '40');
        $accessoireClient->setAttrib('rows', '4');
                
        //Texte : commentaire panne
        $commentairePanne = new Zend_Form_Element_Textarea('COMMENTAIRE_PANNE');
        $commentairePanne->setLabel("Commentaire panne");
        $commentairePanne->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $commentairePanne->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $commentairePanne->addFilter('stripTags');
        $commentairePanne->addFilter('stringTrim');
        $commentairePanne->setAttrib('cols', '40');
        $commentairePanne->setAttrib('rows', '4');
        
        //Texte : commentaire reparation
        $commentaireReparation = new Zend_Form_Element_Textarea('COMMENTAIRE_REPARATION');
        $commentaireReparation->setLabel("Commentaire reparation");
        $commentaireReparation->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $commentaireReparation->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $commentaireReparation->addFilter('stripTags');
        $commentaireReparation->addFilter('stringTrim');
        $commentaireReparation->setAttrib('cols', '40');
        $commentaireReparation->setAttrib('rows', '4');
        
        //Texte : num devis
        $numDevis = new Zend_Form_Element_Text('NUM_DEVIS');
        $numDevis->setLabel("N° Devis (sage)");
        $numDevis->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $numDevis->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $numDevis->addFilter('stripTags');
        $numDevis->addFilter('stringTrim');
        
        //Texte : mdp
        $mdp = new Zend_Form_Element_Text('MOT_DE_PASSE');
        $mdp->setLabel("Mot de passe");
        $mdp->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $mdp->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $mdp->addFilter('stripTags');
        $mdp->addFilter('stringTrim');

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
        $args[] = $etat;
        $args[] = $dateLivraison;
        $args[] = $contactCommercial;
        $args[] = $contactTechnique;
        $args[] = $accessoireClient;
        $args[] = $commentairePanne;
        $args[] = $commentaireReparation;
        $args[] = $numDevis;
        $args[] = $mdp;
        $args[] = $submit;
        $args[] = $retour;
        $this->addElements($args);
    }

    /**
     * permet de remplir la liste des etats dans le formulaire
     * @param Zend_Db_Table_Abstract $etats
     */
    public function remplirEtat($etats) {
        $elem = $this->getElement('ETAT');
        foreach ($etats as $etat) {
            $elem->addMultiOption($etat->ID_ETAT, $etat->VALEUR);
        }
    }
    
    /**
     * permet de remplir la liste des contacts commerciaux dans le formulaire
     * @param Zend_Db_Table_Abstract $etats
     */
    public function remplirCommercial($commercials) {
        $elem = $this->getElement('CONTACT_COMMERCIAL');
        foreach ($commercials as $commercial) {
            $elem->addMultiOption($commercial->ID_LOGIN, $commercial->NOM." ".$commercial->PRENOM);
        }

    }
    
    /**
     * permet de remplir la liste des contacts techniques dans le formulaire
     * @param Zend_Db_Table_Abstract $etats
     */
    public function remplirTechnique($techniques) {
        $elem = $this->getElement('CONTACT_TECHNIQUE');
        foreach ($techniques as $technique) {
            $elem->addMultiOption($technique->ID_LOGIN, $technique->NOM." ".$technique->PRENOM);
        }
    }

}

