<?php

class Application_Form_SavRechercher extends Zend_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        //$registry = Zend_Registry::getInstance();

        $this->setName("savRechercher")
                ->setAttrib('class', 'savRechercher');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');

        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();

        //Texte : id
        $id = new Zend_Form_Element_Text('ID');
        $id->setLabel("Id");
        $id->addValidator(new Zend_Validate_Int());
        $id->addValidator(new Zend_Validate_StringLength(array('max' => 10)));
        $id->addFilter('stripTags');
        $id->addFilter('stringTrim');

        //Texte : id
        $numDevis = new Zend_Form_Element_Text('NUM_DEVIS');
        $numDevis->setLabel("N° Devis");
        $numDevis->addValidator(new Zend_Validate_Int());
        $numDevis->addValidator(new Zend_Validate_StringLength(array('max' => 10)));
        $numDevis->addFilter('stripTags');
        $numDevis->addFilter('stringTrim');

        //Select : etat
        $etat = new Zend_Form_Element_Select('ETAT');
        $etat->setLabel("Etat");
        $etat->addMultiOption("0", "");

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
        $args[] = $id;
        $args[] = $numDevis;
        $args[] = $etat;
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

}