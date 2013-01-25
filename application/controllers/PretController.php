<?php
/**
 * PretController : gestion prets
 * @copyright eewee.fr
 */
class PretController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $t_pret = new TPret();

        $this->view->prets = $t_pret->getPrets();
        $this->view->titre = $this->getRequest()->getControllerName();
        $this->render();
    }

    public function ajouterAction() {
        $form = new Application_Form_PretAjouter();

        $t_client = new TClient();
        $t_pret = new TPret();
        $infos = $t_pret->getPret($this->_getParam('idPret'));
        
        
//        $this->view->form_clientAutocompletion = new ZendX_JQuery_Form_Element_AutoComplete('ID_CLIENT');
//        $this->view->form_clientAutocompletion->setLabel('Client');
//        $this->view->form_clientAutocompletion->setJQueryParam('data', array('Montreal', 'Amsterdam', 'Paris', 'Bordeaux', 'Larochelle'));

        if( is_numeric($this->_getParam('idClient')) ){
            //$form->ID_CLIENT->setAttrib('disabled', 'disabled');
            //$form->ID_CLIENT->setValue($this->_getParam('idClient'));
            $form->ID_CLIENT->setRequired(false);
            $form->supprimerElement('ID_CLIENT');
            $form->ajouterHiddenElement('ID_CLIENT', $this->_getParam('idClient'));
        }else{
            $form->remplirClient($t_client->getClients());
        }
        $form->remplirPreteur($t_pret->getPrets());

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'pret');
            }
            
            $form->populate($formData);
            if ($form->isValid($formData)) {

                if( is_numeric($this->_getParam('idClient')) ){
                    $idClient = $this->_getParam('idClient');
                }else{
                    $tbl_client = explode("|", $formData['ID_CLIENT']);
                    $idClient = trim($tbl_client[1]);
                }
    
                if ($t_pret->ajouter($idClient, $formData['ID_PRETEUR'], $formData['DATE_DEBUT_PRET'], $formData['DATE_FIN_PRET'], $formData['TYPE_MATERIEL'])) {
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

    public function editerAction() {
        $form = new Application_Form_PretEditer();

        $t_pret = new TPret();
        $infos = $t_pret->getPret($this->_getParam('idPret'));

        //$form->getElement('ID_PRETEUR')->addMultiOption('55','55');
        $form->remplirPreteur($t_pret->getPrets());

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            
            // clique btn retour
            if( isset($formData['btn_retour']) ){
                $this->_helper->getHelper('Redirector')->gotoSimple('index', 'pret');
            }
            
            $form->populate($formData);
            if ($form->isValid($formData)) {

                if ($t_pret->modifier($infos->ID_PRET, null, $formData['ID_PRETEUR'], $formData['DATE_DEBUT_PRET'], $formData['DATE_FIN_PRET'], $formData['TYPE_MATERIEL'])) {
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
        $t_pret = new TPret();

        if ($t_pret->supprimer($this->_getParam('idPret'))) {
            $this->view->messValidation = $this->_helper->flash->success("Suppression réalisée.");
        } else {
            $this->view->messValidation = $this->_helper->flash->error("ERREUR : suppression non réalisée.");
        }
    }

}

