<?php

class Application_Form_FicheCommandeEditer extends Zend_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        $registry = Zend_Registry::getInstance();

        $this->setName("ficheCommandeEditer")
                ->setAttrib('class', 'ficheCommandeEditer');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');
        
        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();
        
        //Select : etat
        $etat = new Zend_Form_Element_Select('ID_ETAT');
        $etat->setLabel("Etat");
        $etat->addMultiOption("0", "Selectionner un etat");

        //Select : fournisseur
        $fournisseur = new Zend_Form_Element_Select('ID_FOURNISSEUR');
        $fournisseur->setLabel("Fournisseur");
        $fournisseur->addMultiOption("0", "Selectionner un fournisseur");
        
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
        
        //Texte : commentaire
        $commentaire = new Zend_Form_Element_Textarea('COMMENTAIRE');
        $commentaire->setLabel("Commentaire");
        $commentaire->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $commentaire->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $commentaire->addFilter('stripTags');
        $commentaire->addFilter('stringTrim');
        $commentaire->setAttrib('cols', '40');
        $commentaire->setAttrib('rows', '4');
        
        //Texte : num devis
        $numDevis = new Zend_Form_Element_Text('ID_SAGE');
        $numDevis->setLabel("N° Devis (sage)");
        $numDevis->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $numDevis->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $numDevis->addFilter('stripTags');
        $numDevis->addFilter('stringTrim');
        
//        Ref
//        Designation
//        Qty

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
        $args[] = $fournisseur;
        $args[] = $dateLivraison;
        $args[] = $contactCommercial;
        $args[] = $contactTechnique;
        $args[] = $commentaire;
        $args[] = $numDevis;
        $args[] = $submit;
        $args[] = $retour;
        $this->addElements($args);
    }

    /**
     * permet de remplir la liste des etats dans le formulaire
     * @param Zend_Db_Table_Abstract $etats
     */
    public function remplirEtat($etats) {
        $elem = $this->getElement('ID_ETAT');
        foreach ($etats as $etat) {
            $elem->addMultiOption($etat->ID_ETAT, $etat->VALEUR);
        }
    }
    
    /**
     * permet de remplir la liste des etats dans le formulaire
     * @param Zend_Db_Table_Abstract $etats
     */
    public function remplirFournisseur($fournisseurs) {
        $elem = $this->getElement('ID_FOURNISSEUR');
        foreach ($fournisseurs as $fournisseur) {
            $elem->addMultiOption($fournisseur->ID_FOURNISSEUR, $fournisseur->VALEUR);
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

