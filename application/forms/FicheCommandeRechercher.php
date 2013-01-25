<?php

class Application_Form_FicheCommandeRechercher extends Zend_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        //$registry = Zend_Registry::getInstance();

        $this->setName("ficheCommandeRechercher")
                ->setAttrib('class', 'ficheCommandeRechercher');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');

        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();
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

        //Texte : entreprise
        $entreprise = new Zend_Form_Element_Text('ENTREPRISE');
        $entreprise->setLabel("Entreprise");
        $entreprise->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $entreprise->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $entreprise->addFilter('stripTags');
        $entreprise->addFilter('stringTrim');

        //Texte : id
        $id = new Zend_Form_Element_Text('ID');
        $id->setLabel("Id");
        $id->addValidator(new Zend_Validate_Int());
        $id->addValidator(new Zend_Validate_StringLength(array('max' => 10)));
        $id->addFilter('stripTags');
        $id->addFilter('stringTrim');

        //Select : etat
        $etat = new Zend_Form_Element_Select('ETAT');
        $etat->setLabel("Etat");
        $etat->addMultiOption("0", "");

        //Select : fournisseur
        $fournisseur = new Zend_Form_Element_Select('FOURNISSEUR');
        $fournisseur->setLabel("Fournisseur");
        $fournisseur->addMultiOption("0", "");

        //Texte : ref
        $ref = new Zend_Form_Element_Text('REF');
        $ref->setLabel("Ref");
        $ref->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $ref->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $ref->addFilter('stripTags');
        $ref->addFilter('stringTrim');

        //Texte : designation
        $designation = new Zend_Form_Element_Text('DESIGNATION');
        $designation->setLabel("Designation");
        $designation->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $designation->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $designation->addFilter('stripTags');
        $designation->addFilter('stringTrim');

        //Bouton : submit
        $submit = new Zend_Form_Element_Submit('btn_envoyer');
        $submit->setLabel($t->translate("Valider"));
        $submit->setAttrib("class", "btn btn-primary");

        //Bouton : retour
        //$retour = new Zend_Form_Element_Submit('btn_retour');
        //$retour->setLabel($t->translate("Retour"));
        //$retour->setAttrib("class", "btn");
        //Bouton : reset
        $reset = new Zend_Form_Element_Reset('btn_reset');
        $reset->setLabel($t->translate("Reset"));
        $reset->setAttrib("class", "btn");

        //Req
        $args = array();
        $args[] = $nom;
        $args[] = $prenom;
        $args[] = $entreprise;
        $args[] = $id;
        $args[] = $etat;
        $args[] = $fournisseur;
        $args[] = $ref;
        $args[] = $designation;
        $args[] = $submit;
        $args[] = $reset;
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
     * permet de remplir la liste des fournisseurs dans le formulaire
     * @param Zend_Db_Table_Abstract $fournisseurs
     */
    public function remplirFournisseur($fournisseurs) {
        $elem = $this->getElement('FOURNISSEUR');
        foreach ($fournisseurs as $fournisseur) {
            $elem->addMultiOption($fournisseur->ID_FOURNISSEUR, $fournisseur->VALEUR);
        }
    }

}