<?php

class Application_Form_PretAjouter extends ZendX_JQuery_Form {

    public function init() {
        // recup info pour le define.ini (entre autre)
        //$registry = Zend_Registry::getInstance();

        $this->setName("pretAjouter")
                ->setAttrib('class', 'pretAjouter');

        // traduction
        $t = Zend_Registry::get('Zend_Translate');
        
        // Instance d'authentification
        //$auth = Zend_Auth::getInstance();
        
        //Autocomplete: client
        $idClient = new ZendX_JQuery_Form_Element_AutoComplete('ID_CLIENT');
        $idClient->setLabel('Client');
        $idClient->setRequired(true);
        $idClient->setJQueryParam('minLength', 1);
        //$idClient->setJQueryParam('data', array('Montreal', 'Amsterdam', 'Paris', 'Bordeaux', 'Larochelle'));
        
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

        /*
          // SOURCE pour autocompletion : http://www.zendcasts.com/autocomplete-control-with-zendx_jquery/2010/07/
          //select : client
          $idClient = new Zend_Form_Element_Select('ID_CLIENT');
          $idClient->setLabel("Client");
          $idClient->addMultiOption('0', "Sélectionner un client");
          //        $idClient->setAttrib('disable', 'disable');
          $idClient->setRegisterInArrayValidator(false);
          //Add filters
          $idClient->addFilter('stripTags');
          $idClient->addFilter('stringTrim');
         */

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
        $typeMateriel->setRequired(true);
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
//        if( is_numeric($this::_getParam('idClient')) ){
            $args[] = $idClient;
//        }
        $args[] = $idPreteur;
        $args[] = $typeMateriel;
        $args[] = $submit;
        $args[] = $retour;
        $this->addElements($args);
    }

    /**
     * 
     * permet de remplir la liste des clients dans le formulaire
     * @param Zend_Db_Table_Abstract $clients
     */
    public function remplirClient($clients) {
        $elem = $this->getElement('ID_CLIENT');

        foreach ($clients as $client) {
            $array[] = $client->NOM . " " . $client->PRENOM . " - " . $client->ENTREPRISE . " | " . $client->ID_CLIENT;
            //$elem->setJQueryParams(array($client->ID_CLIENT => $client->PRENOM));
        }
        $elem->setJQueryParam('data', $array/* array('Montreal', 'Amsterdam', 'Paris', 'Bordeaux', 'Larochelle') */);
        
        /*
          $elem = $this->getElement('ID_CLIENT');
          foreach ($clients as $client) {
          $elem->addMultiOption($client->ID_CLIENT, $client->NOM." ".$client->PRENOM." (".$client->ENTREPRISE.")");
          }
         */
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
    
    public function supprimerElement($name){
        $this->removeElement($name);
    }
    
    public function ajouterHiddenElement($name, $value){
        $hidden = new Zend_Form_Element_Hidden($name);
        $args[] = $hidden;
        $this->addElements($args);
        $this->$name->setValue($value);
    }
}