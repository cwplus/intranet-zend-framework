<?php
/**
 * ClientController : gestion clients
 * @copyright eewee.fr
 */
class ClientController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
//        $this->view->titre = $this->getRequest()->getControllerName();

        $form = new Application_Form_ClientRechercher();
        $formData = array();

        if ($this->_request->isPost()) {

            $formData = $this->_request->getPost();     // Recupere : post
//$formData = $this->_request->getParams(); // Recupere : get, post, etc ... 
//Zend_Debug::dump($formData);

            $form->populate($formData);

            if ($form->isValid($formData)) {
                $t_client = new TClient();
                $select = $t_client->rechercher($formData);
                //$select = $t_client->getClients();
                // PAGINATION
                $page = Zend_Paginator::factory($select);
                //if ($this->_request->isPost()) {
                //    $page->clearPageItemCache();
                //}
                $page->setPageRange(7);
                $page->setCurrentPageNumber($this->_getParam('page', 1));
                $page->setItemCountPerPage($this->_getParam('nbre', 10));
                //$page->setView($this->view);

                $this->view->formData = array("resultFormRecherche" => $formData);
                $this->view->resultatPagination = $page;
            }
        } else {
            foreach ($this->_request->getParams() as $kGet => $vGet) {
                if (
                        $kGet != "controller" &&
                        $kGet != "action" &&
                        $kGet != "module" &&
                        $kGet != "page"
                ) {
                    $formData[$kGet] = $vGet;
                }
            }
            $form->populate($formData);

            $t_client = new TClient();
            $select = $t_client->rechercher($formData);

            // PAGINATION
            $page = Zend_Paginator::factory($select);
            //if ($this->_request->isPost()) {
            //    $page->clearPageItemCache();
            //}
            $page->setPageRange(7);
            $page->setCurrentPageNumber($this->_getParam('page', 1));
            $page->setItemCountPerPage($this->_getParam('nbre', 10));
            //$page->setView($this->view);
            //$this->view->formData = array("resultFormRecherche" => $formData);
            $this->view->resultatPagination = $page;

            /**
             * ATTENTION : 
             * - $x->toArray() est un tableau avec la clef identique au nom du champ du formulaire (repect de la casse). 
             */
            /*
              if (is_object($infosClient)) {
              $form->populate($infosClient->toArray());
              }
             */
        }

        $this->view->form = $form;
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render();
    }

    /**
     * Action permettant d'ajouter un client (form + insertion).
     *
     */
    public function ajouterAction() {
        $form = new Application_Form_ClientAjouter();

        // remplir
        $t_civilite = new TCivilite();
        $form->remplirCivilite($t_civilite->getCivilites());

        $t_client = new TClient();

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'client');
            }

            //echo "retour : " . $formData['btn_retour'];
            //Zend_Debug::dump($formData);
            
            //echo "retour2 : ".$this->_request->getParam('btn_retour');

            $form->populate($formData);
            if ($form->isValid($formData)) {

                // remplacer plus tard par l'id de la personne connecté
                $idLogin = 1;

                if ($t_client->ajouter($idLogin, $formData['CIVILITE'], $formData['NOM'], $formData['PRENOM'], $formData['EMAIL'], $formData['ENTREPRISE'], $formData['ADRESSE_01'], $formData['ADRESSE_02'], $formData['CODE_POSTAL'], $formData['VILLE'], $formData['TEL_BUREAU'], $formData['TEL_DOMICILE'], $formData['TEL_MOBILE'])) {
                    $this->view->messValidation = $this->_helper->flash->success("Ajout réalisé.");
                    $form->reset();
                } else {
                    $this->view->messValidation = $this->_helper->flash->error("ERREUR : Ajout non réalisé.");
                }
            }
        }

        $this->view->form = $form;
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render();
    }

    /**
     * Action permettant d'editer un client (form + insertion).
     *
     */
    public function editerAction() {

        $form = new Application_Form_ClientEditer();

        $t_civilite = new TCivilite();
        $t_client = new TClient();

// remplir
        $form->remplirCivilite($t_civilite->getCivilites());

// infos client
        $infosClient = $t_client->getClient($this->_getParam('idClient'));

        if($this->_request->isPost()) {
            
            $formData = $this->_request->getPost();
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'client');
            }
            
            Zend_Debug::dump($formData);
            $form->populate($formData);
            if ($form->isValid($formData)) {
//Couleur interieur non rempli
                /*                if ($formData['couleurInt'] == '0') {
                  $formData['couleurInt'] = null;
                  }
                 */
                if ($t_client->modifierClient(
                                $infosClient->ID_CLIENT, null, date('Y-m-d H:i:s'), $formData['ENTREPRISE'], $formData['CIVILITE'], $formData['NOM'], $formData['PRENOM'], $formData['ADRESSE_01'], $formData['ADRESSE_02'], $formData['VILLE'], $formData['CODE_POSTAL'], $formData['TEL_BUREAU'], $formData['TEL_DOMICILE'], $formData['TEL_MOBILE'], $formData['EMAIL']
                )) {
                    /*
                      $this->view->success = '
                      <div class="alert alert-success">
                      Enregistrement réalisé.
                      </div>';
                     */
                    $this->view->messValidation = $this->_helper->flash->success("Mise à jour réalisée.");
//$this->_helper->flash->success($this->view->_("infobulle : Votre annonce a bien été modifiée !"));
                } else {
                    $this->view->messValidation = $this->_helper->flash->error("ERREUR : Mise à jour réalisée.");
//$this->_helper->flash->error($this->view->_("Une erreur est survenue lors de la modification de votre annonce !"));
                }

//Redirection sur la liste...
//$this->_helper->getHelper('Redirector')->gotoSimple('client', 'listing');
            }
        } else {
            /**
             * ATTENTION : 
             * - $x->toArray() est un tableau avec la clef identique au nom du champ du formulaire (repect de la casse). 
             */
            if (is_object($infosClient)) {
                $form->populate($infosClient->toArray());
            }
        }



        /*
          $form = new Application_Form_ModifAnnonceAdmin();

          //Retourne l'annonce en cours
          $t_annonce = new TAnnonce();
          $annonce = $t_annonce->getAnnonce($this->_getParam('idAnnonce'));

          //Initialisatyion des date pour la mopdification des options de parution
          $dateFinIni = $annonce->dateFinAffichage;
          $dateFinUrgIni = $annonce->dateFinUrgente;

          //Remplir les listes du formulaire
          $t_vehicules = new TVehicule();
          $form->remplirMarque($t_vehicules->getAllMarques(), $annonce->marque);
          if (!empty($annonce->marque)) {
          $form->remplirModele($t_vehicules->getModeleParMarque($annonce->marque), $annonce->modele);
          }
          if (!empty($annonce->modele)) {
          $form->remplirVersion($t_vehicules->getVersionParModele($annonce->modele), $annonce->version);
          }
          if (!empty($annonce->version)) {
          $form->remplirFinition($t_vehicules->getFinitionParVersion($annonce->version), $annonce->finition);
          }
          $form->remplirCarrosserie($t_vehicules->getAllCarrosserie(), $annonce->carrosserie);
          $form->remplirCarburant($t_vehicules->getAllCarburant(), $annonce->carburant);
          $t_couleur = new TCouleur();
          $form->remplirCouleurs($t_couleur->getAllCouleurs());
          $t_interieur = new TTypeInterieur();
          $form->remplirTypeInt($t_interieur->getAllInterieur());
          $t_peinture = new TTypePeinture();
          $form->remplirPeinture($t_peinture->getAllPeinture());
          $form->remplirPortes($t_vehicules->getAllPorte());
          $form->remplirVitesse($t_vehicules->getAllVitesse());
          $t_prix = new TTypePrix();
          $form->remplirPrix($t_prix->getAllPrix());

          $t_tarif = new TTarif();
          $dateFinParution = $t_annonce->getAnnonce($this->_getParam('idAnnonce'))->dateFinAffichage;
          //Affichage des bons tarifs
          $form->getElement('prolongation')->setLabel('Pronlonger cette annonce de ' . Zend_Registry::get('define')->duree->publication_annonce . ' mois.');
          $form->getElement('nbPhoto')->getValidator('PeriodeParution')->setDateFin($dateFinParution);
          $form->getElement('urgente')->setDescription($this->view->_("L\'annonce urgente est mise en valeur sur le site pendant") . ' ' . Zend_Registry::get('define')->duree->annonce_urgente . ' ' . $this->view->_("mois") . '<br />' . $this->view->_("Si vous ne prolongez pas cette annonce et que le temps de parution restant est inférieur à") . '  ' . Zend_Registry::get('define')->duree->annonce_urgente . ' ' . $this->view->_("mois, le temps d\'affichage de votre annonce (urgente) sera inférieur à") . ' ' . Zend_Registry::get('define')->duree->annonce_urgente . ' mois.');
          $form->getElement('urgente')->setLabel('(Re)Passer cette annonce en urgente (' . $t_tarif->getTarifParLib('urgenteProlong')->tarif . ' euros)');
          $form->getElement('urgente')->getValidator('PeriodeParution')->setDateFin($dateFinParution);

          //Afficher le nombre d'input type="file" en rapport avec le nombre de phots supplémentaires que le client a acheté
          $nbPhotoRestant = ($annonce->nbPhotoSup + 5) - $this->_helper->compteFichier(BASE_PATH . "/images/annonces/" . $annonce->idAnnonce);
          if ($nbPhotoRestant) {
          $form->getElement('photo')->setMultiFile($nbPhotoRestant);
          $form->getElement('photo')->addValidator(new Zend_Validate_File_Count($nbPhotoRestant));
          } else {
          $form->getElement('photo')->setAttrib('disable', 'disable');
          }

          if ($this->_request->isPost()) {
          $formData = $this->_request->getPost();
          $form->populate($formData);
          if ($form->isValid($formData)) {
          //Couleur interieur non rempli
          if ($formData['couleurInt'] == '0') {
          $formData['couleurInt'] = null;
          }

          //Type de peinture non rempli
          if ($formData['typePeinture'] == '0') {
          $formData['typePeinture'] = null;
          }

          //Type de prix non rempli
          if ($formData['typePrix'] == '0') {
          $formData['typePrix'] = null;
          }

          //Puissance fiscale non rempli
          if (empty($formData['puissanceFisc'])) {
          $formData['puissanceFisc'] = null;
          }

          //Puissance reelle non rempli
          if (empty($formData['puissanceReelle'])) {
          $formData['puissanceReelle'] = null;
          }

          //nombre de vitesse non rempli
          if (empty($formData['nbVitesse'])) {
          $formData['nbVitesse'] = null;
          }

          //Option libre non rempli
          if (empty($formData['optionsLibres'])) {
          $formData['optionsLibres'] = null;
          }

          //Autres infos non rempli
          if (empty($formData['autresInfos'])) {
          $formData['autresInfos'] = null;
          }
          //Ajout des equipements associe a l'annonce
          $t_equipementAnnonce = new TEquipementAnnonce();
          $t_equipementAnnonce->supprimerEquipementAnnonces(array($annonce->idAnnonce));
          foreach ($formData["optionsEquipementsFrom"] as $unGroupEquip) {
          foreach ($unGroupEquip as $equip) {
          $t_equipementAnnonce->ajouter($annonce->idAnnonce, $equip);
          }
          }

          //Test si un fichier a été uploade
          if (is_null($_FILES['photo']['name'][0])) {
          $arrayFileUploade = array_filter($_FILES['photo']['name']);
          } else {
          $arrayFileUploade = array($_FILES['photo']['name']);
          }
          if (!empty($arrayFileUploade)) {
          $this->uploadImages('photo', BASE_PATH . "/images/annonces/" . $annonce->idAnnonce);
          }

          if ($formData['prolongation'] == "0") {
          $dateFinAffichage = null;
          } else {
          if ($dateFinIni <= date('Y-m-d')) {
          $dateFinAffichage = date('Y-m-d', mktime(0, 0, 0, date("m") + Zend_Registry::get('define')->duree->publication_annonce, date("d"), date("Y")));
          } else {
          $date = explode('-', $dateFinIni);
          $dateFinAffichage = date('Y-m-d', mktime(0, 0, 0, $date[1] + Zend_Registry::get('define')->duree->publication_annonce, $date[2], $date[0]));
          }
          }
          if (empty($formData['nbPhoto'])) {
          $nbPhotos = null;
          } else {
          $nbPhotos = $formData['nbPhoto'];
          }
          if ($formData['urgente'] == "0") {
          $annonceUrgente = 0;
          $dateFinUrgente = null;
          } else {
          if ($dateFinUrgIni <= date('Y-m-d')) {
          $dateFinUrgente = date('Y-m-d', mktime(0, 0, 0, date("m") + Zend_Registry::get('define')->duree->publication_annonce, date("d"), date("Y")));
          } else {
          $date = explode('-', $dateFinUrgIni);
          $dateFinUrgente = date('Y-m-d', mktime(0, 0, 0, $date[1] + Zend_Registry::get('define')->duree->publication_annonce, $date[2], $date[0]));
          }
          $annonceUrgente = 1;
          }

          if ($t_annonce->modifierAdmin($annonce->idAnnonce, substr($formData['date'], 6, 4) . '-' . substr($formData['date'], 3, 2) . '-' . substr($formData['date'], 0, 2), $formData['km'], $formData['nbPropPrec'], $formData['typePeinture'], $formData['typeInt'], stripcslashes($formData['optionsLibres']), stripcslashes($formData['autresInfos']), $formData['prix'], $formData['typePrix'], date('Y-m-d'), $formData['couleurExt'], $formData['couleurInt'], $formData['carrosserie'], $formData['carburant'], $formData['boiteVitesse'], $formData['nbPortes'], $formData['nbVitesse'], $formData['puissanceFisc'], $formData['puissanceReelle'], $dateFinAffichage, $dateFinUrgente, $annonceUrgente, $nbPhotos)) {
          $this->_helper->flash->success($this->view->_("infobulle : Votre annonce a bien été modifiée !"));
          } else {
          $this->_helper->flash->error($this->view->_("Une erreur est survenue lors de la modification de votre annonce !"));
          }
          //Redirection sur la liste...
          $this->_helper->getHelper('Redirector')->gotoSimple('recherche', 'Annonce');
          } else {
          //Si formulaire reaffiché
          $t_vehicule = new TVehicule();
          if (!empty($formData['marque'])) {
          $form->remplirModele($t_vehicule->getModeleParMarque($formData['marque']), $formData['modele']);
          }
          if (!empty($formData['modele'])) {
          $form->remplirVersion($t_vehicule->getVersionParModele($formData['modele']), $formData['version']);
          }
          if (!empty($formData['version'])) {
          $form->remplirFinition($t_vehicule->getFinitionParVersion($formData['version']), $formData['finition']);
          }
          }
          }

          //Remplir les options et équipements
          $t_detailEquip = new TEquipementDetail();
          $t_annonceEquip = new TEquipementAnnonce();
          $formEquipement = array();
          foreach ($t_annonceEquip->getAllEquipParAnnonce($annonce->idAnnonce) as $unEquip) {
          $detailEquip = $t_detailEquip->getDetail($unEquip->idEquipement);
          $formEquipement['group' . $detailEquip->idEquipementGroupe][] = $detailEquip->idEquipDetail;
          }
         */


        /*
          $formPreremp = array(
          'boiteVitesse' => $annonce->boiteVitesse,
          'nbVitesse' => $annonce->nbVitesses,
          'nbPortes' => $annonce->nbPortes,
          'optionsLibres' => $annonce->optionEquipement,
          'autresInfos' => $annonce->autresInfos,
          'prix' => $annonce->prix,
          'typePrix' => $annonce->idOptionPrix,
          'annonce' => $annonce->idAnnonce
          );

          $form->populate($formPreremp);
         */
        $this->view->form = $form;
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render();
    }

}

