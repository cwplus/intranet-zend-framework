<?php
/**
 * FicheCommandeController : gestion commande
 * @copyright eewee.fr
 */
class FicheCommandeController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $form = new Application_Form_FicheCommandeRechercher();
        $t_etat = new TEtat();
        $t_fournisseur = new TFournisseur();

        // remplir
        $form->remplirEtat($t_etat->getEtats(null, "ficheCommande"));
        $form->remplirFournisseur($t_fournisseur->getFournisseurs());

        $formData = array();

        if ($this->_request->isPost()) {

            $formData = $this->_request->getPost();     // Recupere : post
            //$formData = $this->_request->getParams(); // Recupere : get, post, etc ... 

            $form->populate($formData);

            if ($form->isValid($formData)) {
                $t_ficheCommande = new TFicheCommande();
                $select = $t_ficheCommande->rechercher($formData);

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
            /* foreach ($this->_request->getParams() as $kGet => $vGet) {
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
             */
            
            $t_ficheCommande = new TFicheCommande();

            // POPULATE
            $formData = $this->_request->getParams();
            $form->populate($formData);

            // REQ
            $select = $t_ficheCommande->rechercher($formData);

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
    
    public function ajouterAction(){
        $form = new Application_Form_FicheCommandeAjouter();

        // remplir
        $t_etat = new TEtat();
        $t_fournisseur = new TFournisseur();
        $t_ficheCommande = new TFicheCommande();
        $t_login = new TLogin();

        $form->remplirFournisseur($t_fournisseur->getFournisseurs());
        $form->remplirEtat($t_etat->getEtats(null, "ficheCommande"));
        $form->remplirCommercial($t_login->getLogins());
        $form->remplirTechnique($t_login->getLogins());
        
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();

            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'fiche-commande');
            }

            $form->populate($formData);
            if ($form->isValid($formData)) {

                // remplacer plus tard par l'id de la personne connecté
                $idLogin = 1;

                if( is_numeric($this->_getParam('idClient')) ){
                    $idClient = $this->_getParam('idClient');
                }else{
                    $idClient = "";
                }
                
                if ($t_ficheCommande->ajouter($idLogin, $idClient, $formData['ID_ETAT'], $formData['ID_FOURNISSEUR'], $formData['DATE_LIVRAISON'], $formData['CONTACT_COMMERCIAL'], $formData['CONTACT_TECHNIQUE'], $formData['COMMENTAIRE'], $formData['ID_SAGE'])) {
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

    public function editerAction(){
        $form = new Application_Form_FicheCommandeEditer();

        // recup
        $t_fichecommande = new TFicheCommande();
        $infos = $t_fichecommande->getFicheCommande($this->_getParam('idFicheCommande'));
        
        // remplir
        $t_etat = new TEtat();
        $t_fournisseur = new TFournisseur();
        $t_ficheCommande = new TFicheCommande();
        $t_login = new TLogin();

        $form->remplirFournisseur($t_fournisseur->getFournisseurs());
        $form->remplirEtat($t_etat->getEtats(null, "ficheCommande"));
        $form->remplirCommercial($t_login->getLogins());
        $form->remplirTechnique($t_login->getLogins());
        
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['ID_FICHECOMMANDE'] = $this->_getParam('idFicheCommande');
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'fiche-commande');
            }
            
            $form->populate($formData);
            if ($form->isValid($formData)) {

                // remplacer plus tard par l'id de la personne connecté
                $idLogin = 1;

                if ($t_ficheCommande->modifier($this->_getParam('idFicheCommande'), $idLogin, $formData['ID_ETAT'], $formData['ID_FOURNISSEUR'], $formData['DATE_LIVRAISON'], $formData['CONTACT_COMMERCIAL'], $formData['CONTACT_TECHNIQUE'], $formData['COMMENTAIRE'], $formData['ID_SAGE'])) {
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
        $t_ficheCommande = new TFicheCommande();

        if ($t_ficheCommande->supprimer($this->_getParam('idFicheCommande'))) {
            $this->view->messValidation = $this->_helper->flash->success("Suppression réalisée.");
        } else {
            $this->view->messValidation = $this->_helper->flash->error("ERREUR : suppression non réalisée.");
        }
    }
}
