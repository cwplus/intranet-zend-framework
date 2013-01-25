<?php

class Application_Form_PretEditer extends ZendX_JQuery_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        //$registry = Zend_Registry::getInstance();

        $this->setName("pretEditer")
                ->setAttrib('class', 'pretEditer');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');
        
        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();





        /*
          $form = new ZendX_JQuery_Form_Element_DatePicker(
          'dp1',
          array('jQueryParams' => array('defaultDate' => '2007/10/10'))
          );
         */





        //Date: date de debut
        $dateD = new ZendX_JQuery_Form_Element_DatePicker("DATE_DEBUT_PRET",
                        array(
                            'label' => 'Date debut du pret',
                            'required' => true,
                            'jQueryParams' =>
                            array(
                                'firstDay' => 1,
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                                'showWeek' => true,
                                'yearRange' => '1960:+0')));
        $dateD->addFilter('stripTags');
        $dateD->addFilter('stringTrim');
        $dateD->addValidator(new Zend_Validate_Date('Y-m-d'));
        
        //Date: date de fin
        $dateF = new ZendX_JQuery_Form_Element_DatePicker("DATE_FIN_PRET",
                        array(
                            'label' => 'Date fin du pret',
                            'required' => true,
                            'jQueryParams' =>
                            array(
                                'firstDay' => 1,
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '1960:+0')));
        $dateF->addFilter('stripTags');
        $dateF->addFilter('stringTrim');
        $dateF->addValidator(new Zend_Validate_Date('Y-m-d'));

        //select : preteur
        $idPreteur = new Zend_Form_Element_Select('ID_PRETEUR');
        $idPreteur->setLabel("Preteur");
        $idPreteur->addMultiOption('0', "Sélectionner un preteur");
//        $idPreteur->setAttrib('disable', 'disable');
        $idPreteur->setRegisterInArrayValidator(false);
        //Add filters
        $idPreteur->addFilter('stripTags');
        $idPreteur->addFilter('stringTrim');

        //Texte : type materiel
        $typeMateriel = new Zend_Form_Element_Text('TYPE_MATERIEL');
        $typeMateriel->setLabel("Type material prete");
        //$typeMateriel->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)));
        $typeMateriel->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $typeMateriel->addFilter('stripTags');
        $typeMateriel->addFilter('stringTrim');

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
        $args[] = $dateD;
        $args[] = $dateF;
        $args[] = $idPreteur;
        $args[] = $typeMateriel;
        $args[] = $submit;
        $args[] = $retour;
        $this->addElements($args);
    }

    /**
     * 
     * permet de remplir la liste des preteurs dans le formulaire
     * @param Zend_Db_Table_Abstract $preteurs
     */
    public function remplirPreteur($preteurs) {
        $t_login = new TLogin();

        $elem = $this->getElement('ID_PRETEUR');
        foreach ($preteurs as $preteur) {
            $infosLogin = $t_login->getLogin($preteur->ID_PRETEUR);
            $elem->addMultiOption($preteur->ID_PRETEUR, $infosLogin->NOM . " " . $infosLogin->PRENOM);
        }
    }

}