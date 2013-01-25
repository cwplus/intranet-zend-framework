<?php

class Mick_Plugin_Authentification extends Zend_Controller_Plugin_Abstract {
    /**
     * Plugin d'authentification
     * 
     * Largement inspiré de :
     * http://julien-pauli.developpez.com/tutoriels/zend-framework/atelier/auth-http/?page=modele-MVC
     * */

    /**
     * @var Zend_Auth instance 
     */
    private $_auth;

    /**
     * @var Zend_Acl instance 
     */
    private $_acl;

    /**
     * Chemin de redirection lors de l'échec d'authentification
     */

    const FAIL_AUTH_MODULE = 'default';
    const FAIL_AUTH_ACTION = 'login';
    const FAIL_AUTH_CONTROLLER = 'auth';

    /**
     * Chemin de redirection lors de l'échec de contrôle des privilèges
     */
    const FAIL_ACL_MODULE = 'default';
    const FAIL_ACL_ACTION = 'error';
    const FAIL_ACL_CONTROLLER = 'error';

    /**
     * Constructeur
     */
    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
        $this->_auth = Zend_Auth::getInstance();
    }

    /**
     * Vérifie les autorisations
     * Utilise _request et _response hérités et injectés par le FC
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        // is the user authenticated
        if ($this->_auth->hasIdentity()) {
            // yes ! we get his role
            $user = $this->_auth->getIdentity();
            
            //echo "preDispatch Authentification : "; 
//            Zend_Debug::dump($user);
            
            $t_login = new TLogin();
//            echo "id (plugin auth) : " . $user->ID_LOGIN;
            if ($t_login->isAdmin($user->ID_LOGIN)) {
                //echo "role admin";
                $role = 'admin';
            }elseif( $t_login->isEmploye($user->ID_LOGIN) ){    
                $role = 'employe';
            }else{
                $role = 'client';
            }
        } else {
            // no = guest user
            $role = 'guest';
        }

        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $session = new Zend_Session_Namespace('layout');
        $session->controller = $controller;
        $session->action = $action;
        if ($controller != 'Auth') {
            $front = Zend_Controller_Front::getInstance();
            $default = $front->getDefaultModule();
            // compose le nom de la ressource
            if ($module == $default) {
                $resource = $controller;
            } else {
                $resource = $module . '_' . $controller;
            }

            // est-ce que la ressource existe ?
            if (!$this->_acl->has($resource)) {
                $resource = null;
            }
            // contrôle si l'utilisateur est autorisé
            if (!$this->_acl->isAllowed($role, $resource, $action)) {
                // l'utilisateur n'est pas autorisé à accéder à cette ressource
                // on va le rediriger
                if (!$this->_auth->hasIdentity()) {
                    /*
                    if ($request->getParam('controller') != 'favicon.ico' && $request->getParam('controller') != 'style') {
                        $request->getParams();
                        $sessionReqDem = new Zend_Session_Namespace('RequeteDemande');
                        $sessionReqDem->requete = $request->getParams();
                    }
                    */
                    // il n'est pas identifié -> module de login
                    $module = self::FAIL_AUTH_MODULE;
                    $controller = self::FAIL_AUTH_CONTROLLER;
                    $action = self::FAIL_AUTH_ACTION;
                } else {
                    // il est identifié -> error de privilèges
                    $module = self::FAIL_ACL_MODULE;
                    $controller = self::FAIL_ACL_CONTROLLER;
                    $action = self::FAIL_ACL_ACTION;
                }
                $request->setModuleName($module);
                $request->setControllerName($controller);
                $request->setActionName($action);
            }
        }
    }

}