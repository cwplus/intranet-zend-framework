<?php
/**
 * AuthController : contient toutes les actions liees à l'authentification et à l'inscription.
 * @copyright eewee.fr
 */
class AuthController extends Zend_Controller_Action {

    public function init() {
        
    }

    /**
     * Action permettant de se connecter.
     * Elle affiche le form et fait le test (client existe et bon couple) et redirige vers page d'accueil (ou page précédente).
     */
    public function loginAction() {
        $formLog = new Application_Form_AuthLogin();
        if ($this->_request->isPost() /* && !is_null($this->_request->getParam('connexion_x')) */) {

            $formLog->populate($this->_request->getPost());
            $formData = $formLog->getValues();
            $bootstrap = $this->getInvokeArg('bootstrap');

            if ($formLog->isValid($formData)) {
                $db = $bootstrap->getResource('db');
                $dbAdapter = new Zend_Auth_Adapter_DbTable(
                                $db,
                                'login',
                                'EMAIL',
                                'MDP',
                                'ACTIVE = 1'
                        /*
                          "SHA1(CONCAT('"
                          . Zend_Registry::get('saltUnique')
                          . "',? ,SALT))

                          AND ACTIVE = 1"
                         */
                );
                //$t_client = new TClient();
                $dbAdapter->setIdentity($formData['email'])
                          ->setCredential(md5($formData['password']));
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($dbAdapter);
                if ($result->isValid()) {
                    $data = $dbAdapter->getResultRowObject(
                                null,                   // ???
                                array('MDP', 'SALT')    // valeur qui ne seront pas retournee
                           );
                    
                    //echo "data authController : ";
                    //Zend_Debug::dump($data);
                    
                    $auth->getStorage()->write($data);
                    
                    //echo "auth authController";
                    //Zend_Debug::dump($auth);
                    
                    // log: ajouter infos 
                    Zend_Registry::get('log')->log("Connexion OK", Zend_Log::INFO);
                    //$log = $bootstrap->getResource('log');
                    //$log->info("'Connexion OK';'".$_SERVER['REMOTE_ADDR']."';'".$data->email."';'".$_SERVER["HTTP_USER_AGENT"]."'");
                    //Redirection sur la requete demandée
                    $sessionReqDem = new Zend_Session_Namespace('RequeteDemande');
                    if ($sessionReqDem->requete['controller'] != 'Auth' && !is_null($sessionReqDem->requete)) {
                        if (!is_null($sessionReqDem->requete['params'])) {
                            unset($sessionReqDem->requete['params']['controller']);
                            unset($sessionReqDem->requete['params']['action']);
                        } else {
                            $sessionReqDem->requete['params'] = array();
                        }
                        $this->_helper->getHelper('Redirector')->gotoSimple($sessionReqDem->requete['action'], $sessionReqDem->requete['controller'], null, $sessionReqDem->requete['params']);
                    } else {
                        $this->_helper->redirector('index', 'index');
                    }
                } else {
                    //$formLog->addDecorator('Errors');
                    $this->_helper->flash->error('Il n\'existe pas d\'utilisateur avec cet email et/ou ce mot de passe ou votre compte est n\'a pas été validé !');
                    $formLog->getElement('btn_envoyer')->addError('Il n\'existe pas d\'utilisateur avec cet email et/ou ce mot de passe ou votre compte n\'a pas été validé !');

                    // log: ajouter infos 
                    Zend_Registry::get('log')->log("Connexion KO", Zend_Log::INFO);
                    //$log = $bootstrap->getResource('log');
                    //$log->notice("'Connexion KO';'".$_SERVER['REMOTE_ADDR']."';'".$formData['email']."';'".$_SERVER["HTTP_USER_AGENT"]."'");
                }
            } else {
                // log: ajouter infos 
                Zend_Registry::get('log')->log("Form login KO", Zend_Log::INFO);
                //$log = $bootstrap->getResource('log');
                //$log->notice("'Form login KO';'".$_SERVER['REMOTE_ADDR']."';'".$formData['email']."';'".$_SERVER["HTTP_USER_AGENT"]."'");
            }
        }
        $this->view->formLogin = $formLog;
        $this->render();
    }

    /**
     * Action permettant de se déconnecter.
     */
    public function logoutAction() {
        echo "<hr /><hr /><hr /><hr /><hr /><hr /><hr /><hr />toto";
        $session = new Zend_Session_Namespace('jetonDemande');
        $session->unsetAll();
        $session = new Zend_Session_Namespace('layout');
        $session->unsetAll();
        $session = new Zend_Session_Namespace('RequeteDemande');
        $session->unsetAll();
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('auth', 'index');
    }

    /**
     * Action permettant de changer de mot de passe.
     * Elle affiche le form avec un captcha et envoye un email avec le nouveau mot de passe
     */
    public function pwdOublieAction() {
        /* $formMdp = new Application_Form_PwdOublie();
          if ($this->_request->isPost() && !is_null($this->_request->getParam('envoyer_x'))) {

          $formData = $this->_request->getPost();
          $formMdp->populate($formData);
          if ($formMdp->isValid($formData)){
          $t_client = new TClient();
          $client = $t_client->existanceClient($formData['email']);
          if (count($client) == 1){
          $newMdp = Mick_GenerationMdp::creerMdp(10);
          $dynamicSalt = Mick_GenererSalt::salt();
          //Génération du nouveau grain de sable
          if ($t_client -> changePassword($client->current()->idClient, sha1(Zend_Registry::get('saltUnique').$newMdp.$dynamicSalt), $dynamicSalt)){
          echo "url : ".$this -> view -> url(array('controller' => 'Auth', 'action' => 'login'));


          echo "success message hereeeeee";
          $this->_helper->redirector('login','Auth');
          }else {
          echo "erreur message herrrrrrre";
          }
          }else{
          $formMdp -> getElement('email') -> addError($this->view->_("Désolé mais cet email n\'est pas dans la base de données !"));
          }
          }
          }
          $this->view->form = $formMdp;
          $this->render();
         */
    }

}