<?php
/**
 * FournisseurController : gestion fournisseurs
 * @copyright eewee.fr
 */
class FournisseurController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $t_fournisseur = new TFournisseur();
        $this->view->fournisseurs = $t_fournisseur->getFournisseurs();
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render();
    }

    public function ajouterAction() {
        $form = new Application_Form_FournisseurAjouter();

        $t_fournisseur = new TFournisseur();

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'fournisseur');
            }
            
            $form->populate($formData);
            if ($form->isValid($formData)) {

                if ($t_fournisseur->ajouter($formData['VALEUR'])) {
                    $this->view->messValidation = $this->_helper->flash->success("Mise à jour réalisée.");
                } else {
                    $this->view->messValidation = $this->_helper->flash->error("ERREUR : Mise à jour non réalisée.");
                }
            }
        }

        $this->view->form = $form;
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render();
    }

    public function editerAction() {
        $form = new Application_Form_FournisseurEditer();

        $t_fournisseur = new TFournisseur();
        $infos = $t_fournisseur->getFournisseur($this->_getParam('idFournisseur'));

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'fournisseur');
            }
            
            $form->populate($formData);
            if ($form->isValid($formData)) {

                if ($t_fournisseur->modifier($infos->ID_FOURNISSEUR, $formData['VALEUR'])) {
                    $this->view->messValidation = $this->_helper->flash->success("Mise à jour réalisée.");
                } else {
                    $this->view->messValidation = $this->_helper->flash->error("ERREUR : Mise à jour non réalisée.");
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
        
    }

}

