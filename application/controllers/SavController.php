<?php
/**
 * SavController : gestion SAV
 * @copyright eewee.fr
 */
class SavController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    /**
     * Formulaire de recherche + tableau de resultats 
     */
    public function indexAction() {
        $form = new Application_Form_SavRechercher();
        $t_etat = new TEtat();

        // remplir
        $form->remplirEtat($t_etat->getEtats(null, "sav"));

        $formData = array();

        if ($this->_request->isPost()) {

            $formData = $this->_request->getPost();     // Recupere : post
            //$formData = $this->_request->getParams(); // Recupere : get, post, etc ... 

            $form->populate($formData);

            if ($form->isValid($formData)) {
                $t_sav = new TSav();
                $select = $t_sav->rechercher($formData);

                // PAGINATION
                $page = Zend_Paginator::factory($select);
                //if ($this->_request->isPost()) { $page->clearPageItemCache(); }
                $page->setPageRange(7);
                $page->setCurrentPageNumber($this->_getParam('page', 1));
                $page->setItemCountPerPage($this->_getParam('nbre', 10));
                //$page->setView($this->view);

                $this->view->formData = array("resultFormRecherche" => $formData);
                $this->view->resultatPagination = $page;
            }
        } else {
            $t_sav = new TSav();

            // POPULATE
            $formData = $this->_request->getParams();
            $form->populate($formData);

            // REQ
            $select = $t_sav->rechercher($formData);

            // PAGINATION
            $page = Zend_Paginator::factory($select);
            //if ($this->_request->isPost()) { $page->clearPageItemCache(); }
            $page->setPageRange(7);
            $page->setCurrentPageNumber($this->_getParam('page', 1));
            $page->setItemCountPerPage($this->_getParam('nbre', 10));
            //$page->setView($this->view);
            //$this->view->formData = array("resultFormRecherche" => $formData);
            $this->view->resultatPagination = $page;
        }

        $this->view->form = $form;
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render();
    }
    
    
    public function ajouterAction() {
        $form = new Application_Form_SavAjouter();

        // remplir
        $t_etat = new TEtat();
        $t_login = new TLogin();
        $t_client = new TClient();
        $t_sav = new TSav();

        $form->remplirEtat($t_etat->getEtats(null, "sav"));
        $form->remplirCommercial($t_login->getLogins());
        $form->remplirTechnique($t_login->getLogins());
        
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'sav');
            }

            //echo "retour : " . $formData['btn_retour'];
            //echo "retour2 : ".$this->_request->getParam('btn_retour');

            $form->populate($formData);
            if ($form->isValid($formData)) {

                // remplacer plus tard par l'id de la personne connecté
                $idLogin = 1;

                if( is_numeric($this->_getParam('idClient')) ){
                    $idClient = $this->_getParam('idClient');
                }else{
                    $idClient = "";
                }
                
                if ($t_sav->ajouter($idLogin, $idClient, $formData['ETAT'], $formData['DATE_LIVRAISON'], $formData['CONTACT_COMMERCIAL'], $formData['CONTACT_TECHNIQUE'], $formData['ACCESSOIRE_CLIENT'], $formData['COMMENTAIRE_PANNE'], $formData['COMMENTAIRE_REPARATION'], $formData['NUM_DEVIS'], $formData['MOT_DE_PASSE'])) {
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
    
    public function editerAction() {
        $form = new Application_Form_SavEditer();

        // recup
        $t_sav = new TSav();
        $infos = $t_sav->getSav($this->_getParam('idSav'));

        // remplir
        $t_etat = new TEtat();
        $t_login = new TLogin();
        $t_client = new TClient();
        
        $form->remplirEtat($t_etat->getEtats(null, "sav"));
        $form->remplirCommercial($t_login->getLogins());
        $form->remplirTechnique($t_login->getLogins());
        
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['ID_SAV'] = $this->_getParam('idSav');

            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'sav');
            }
            
            $form->populate($formData);
            if ($form->isValid($formData)) {

                // remplacer plus tard par l'id de la personne connecté
                $idLogin = 1;
                
                if ($t_sav->modifier($this->_getParam('idSav'), $idLogin, $formData['ID_ETAT'], $formData['DATE_LIVRAISON'], $formData['CONTACT_COMMERCIAL'], $formData['CONTACT_TECHNIQUE'], $formData['ACCESSOIRE_CLIENT'], $formData['COMMENTAIRE_PANNE'], $formData['COMMENTAIRE_REPARATION'], $formData['NUMERO_DEVIS'], $formData['MOT_DE_PASSE'])) {
                    $this->view->messValidation = $this->_helper->flash->success("Modification réalisée.");
                    $form->reset();
                } else {
                    $this->view->messValidation = $this->_helper->flash->error("ERREUR : Modification non réalisée.");
                }
            }
        } else {
            /**
             * ATTENTION : 
             * - $x->toArray() est un tableau avec la clef identique au nom du champ du formulaire (repect de la casse). 
             */
            if (is_object($infos)) {
                $form->populate($infos->toArray());
            }
        }

        $this->view->form = $form;
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render(); 
    }
    
    public function supprimerAction() {
        $t_sav = new TSav();

        if ($t_sav->supprimer($this->_getParam('idSav'))) {
            $this->view->messValidation = $this->_helper->flash->success("Suppression réalisée.");
        } else {
            $this->view->messValidation = $this->_helper->flash->error("ERREUR : suppression non réalisée.");
        }
    }
}

