<?php
/**
 * IndexController : 
 * @copyright eewee.fr
 */
class IndexController extends Zend_Controller_Action {

    public function init() {
        /*
        // NAVIGATION : http://www.zendcasts.com/zend_navigation-dynamically-creating-a-menu-a-sitemap-and-breadcrumbs/2009/06/
        $uri = $this->_request->getPathInfo();
        //die($uri);
        $activeNav = $this->view->navigation()->findByUri($uri);
        $activeNav->active = true;
        */
    }

    public function indexAction() {
        // action body
        $this->view->toto = "toto ici";
    }
    
    public function aboutAction() {
        
    }

    public function contactAction() {
        
    }

    public function sitemapAction() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        echo $this->view->navigation()->sitemap();
    }

}

