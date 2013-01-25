<?php
/**
 * Bootstrap : 
 * @copyright eewee.fr
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    /**
     * @var 
     * production
     * staging
     * testing 
     * development
     */

    protected function _initNavigationXml() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        // METHODE 1
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml');
        //METHODE 2
        //$config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation2.xml', 'nav');

        $container = new Zend_Navigation($config);
        $view->navigation($container);

//        Zend_Registry::set('Zend_Navigation', $container);
    }

    protected function _initDb() {
// charge le plugin de resource db, en lui passant bien sur
// sa configuration, lue depuis application.ini
        $pluginDb = $this->getPluginResource('db');
        $db = $pluginDb->getDbAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
// N'oublions pas de retourner l'objet configuré afin que le bootstap
// puisse le stocker dans son registre et nous le retourner à la demande
        return $db;
    }

    protected function _initView() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->setEncoding('UTF-8');
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        // Puis aller appeler echo $this->jQuery(); dans le header du layout (pourquoi: pour charger jquery et jquery-ui
        //
        //ZendX_JQuery::enableView($view);
        // CSS
        $view->headLink()
                ->setStylesheet($view->baseUrl() . '/css/bootstrap.css')
                ->appendStylesheet($view->baseUrl() . '/css/style.css')
                ->appendStylesheet($view->baseUrl() . '/css/form.css')
                //->appendStylesheet($view->baseUrl() . '/css/style.css')
                //      ->appendStylesheet($view->baseUrl() . '/css/bootstrap-responsive.min.css')
                //->appendStylesheet($view->baseUrl() . '/css/print.css', array('media' => 'print'))
                ->headLink(array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $view->baseUrl() . '/images/favicon.ico'), 'PREPEND');


        //Jquery
        $view->JQuery()->uiEnable();
        $view->JQuery()->addStylesheet($view->baseUrl() . '/js/jquery/css/smoothness/jquery-ui-1.8.16.custom.css')
                ->setLocalPath($view->baseUrl() . '/js/jquery/js/jquery-1.6.4.min.js')
                ->setUiLocalPath($view->baseUrl() . '/js/jquery/js/jquery-ui-1.8.16.custom.min.js');


        //Javascript
        //$view->headScript()->setFile($view->baseUrl() . '/js/fonctions.js', 'text/javascript');
        $view->headScript()->appendFile("http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-fr.js");

        // shadowbox
        //		$view->headScript()->appendFile($view->baseUrl().'/js/shadowbox/shadowbox.js','text/javascript');
        //$view->headScript()->appendFile('/js/shadowbox/shadowbox.js', 'text/javascript');
        //$view->headScript()->appendScript('Shadowbox.init({continuous:true,counterType:"skip"})');
        // JS
        //$view->headScript()->appendFile('http://platform.twitter.com/widgets.js', 'text/javascript');
        $view->headScript()->setFile($view->baseUrl() . '/js/jquery-1.7.1.min.js');
        $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap.min.js', 'text/javascript');
        /*
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-transition.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-alert.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-modal.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-dropdown.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-scrollspy.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-tab.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-tooltip.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-popover.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-button.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-collapse.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-carousel.js', 'text/javascript');
          $view->headScript()->appendFile($view->baseUrl() . '/js/bootstrap-typeahead.js', 'text/javascript');
         */



        //$view->headScript()->appendFile("http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-fr.js");
        //Initialisation du titre
        $view->headTitle('Mon site');
        $view->headTitle()->setSeparator(" : ");

        //Initialisation des balise meta
        $view->headMeta()->appendHttpEquiv("Content-Type", "text/html; charset=UTF-8");

        //Initialisation du doctype
        $view->doctype('HTML5');


        // Aide d'action
        Zend_Controller_Action_HelperBroker::addPrefix('Mick_Helpers');

        /*
          //Définition du cache a utiliser pour zend paginator.
          $cacheManager = $this->getPluginResource('cachemanager')->getCacheManager();
          Zend_Paginator::setCache($cacheManager->getCache('conf'));
          Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/paginator.phtml');
         */

        /**
         * init viewRenderer
         * we're gonna use .tpl.php templates
         * Michael : le but est de permettre d'utiliser _() au lieu de translate()
         * cf : classe Dpapa_View dans library/Dpapa/View.php
         */
        /*
          $view = new Dpapa_View(array('translate' => $translate));
          //$view->setEncoding($config->site->encoding);
          $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
          $viewRenderer->setView($view);


          //traductions de zend validation predefinies par zend
          $translatorValidateur = new Zend_Translate(
          array(
          'adapter' => 'array',
          'content' => APPLICATION_PATH . '/languages',
          'locale' => 'fr',
          'scan' => Zend_Translate::LOCALE_FILENAME
          )
          );
          Zend_Form::setDefaultTranslator($translatorValidateur);

          //Definition du cache pour les en-tetes js et css
          Zend_Registry::set('cache', $cacheManager->getCache('entete'));
          */
         
          //Salt unique pour toute l'appli
          Zend_Registry::set('saltUnique', 'SaltUniquePourLeSite;-)');
         
    }

    protected function _initTranslate() {

        // Locale : FR
        setlocale(LC_MONETARY, 'fr_FR');

        /**
         * 
         * Définition de la traduction : répertoire Application/languages
         * Utilisation : dans les vues, utiliser $this->translate() et dans les controller utiliser $this->view->translate()
         * Mise en place : décommenter le block ci-dessous mettre les lien vers le controller SwitchlanguageController
         * lien pour passer en francais : $this->url(array('controller' => 'Languageswitch', 'action' => 'switch', 'lang' => 'fr'), 'default', true)
         * ATTENTION : ne pas oublier de mettre "$language" dans la traduction des formulaires à la place de 'fr'
         */
        /*
          $translate = new Zend_Translate('gettext',
          APPLICATION_PATH . '/languages',
          null,
          array('scan' => Zend_Translate::LOCALE_FILENAME));

          $session = new Zend_Session_Namespace('language');
          Zend_Locale::setCache($cacheManager->getCache('conf'));
          $locale = new Zend_Locale();
          if (isset($session->lang)) {
          $requestedLanguage = $session->lang;
          $locale->setLocale($requestedLanguage);
          } else {
          $locale->setLocale(Zend_Locale::BROWSER);
          $requestedLanguage = substr(key($locale->getBrowser()), 0, 2);
          }
          if (in_array($requestedLanguage, $translate->getList())) {
          $language = $requestedLanguage;
          } else {
          $language = 'en';
          }
          $translate->setLocale($language);
          $translate->setCache($cacheManager->getCache('conf'));
          //Enregistrement de la translation dans le registre : utilisation avec translate()
          Zend_Registry::set('Zend_Translate', $translate);
         */

        // SOURCE : 
        // - part 1 : http://www.youtube.com/watch?v=FwPgqla-cRk
        // - part 2 : http://www.youtube.com/watch?v=L1VIXi_lbVk
        // POEDIT : 
        // - Dans préférence, onglet "analyseur", selectionner "PHP" puis modifier
        //   2nd champ : *.php;*.phtml (en gros juste mettre ;*.phtml à la fin)
        //   3th champ : xgettext --force-po -o %o %C %K %F -L php (en gros juste mettre -L php à la fin)
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        $translate = new Zend_Translate('gettext', APPLICATION_PATH . '/languages/fr/default.mo', 'fr');
        //$translate->addTranslation(APPLICATION_PATH.'languages/en/default.mo', 'en');
        $translate->setLocale('fr');
        $view->translate = $translate;
        Zend_Registry::set('Zend_Translate', $translate);
    }

    /**
     * Gestion des logs 
     */
    protected function _initLogFile() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        
        $writer = new Zend_Log_Writer_Stream($config->logfile);
        $log = new Zend_Log();
        
        // param. a enregistrer
        $log->setEventItem("user_name", $_SERVER['HTTP_USER_AGENT']);
        $log->setEventItem("client_ip", $_SERVER['REMOTE_ADDR']);
        // Ajout des param. pour l'enregistrement dans le journal de log
        $defaultFormat = Zend_Log_Formatter_Simple::DEFAULT_FORMAT;
        $format = '%client_ip% %user_name%'.$defaultFormat.'
';
        // Ajout du format du journal au log
        $writer->setFormatter(new Zend_Log_Formatter_Simple($format));
        
        $log->addWriter($writer);

        Zend_Registry::set('log', $log);
//        return $log;
        
        /*
        // ECRIRE DANS FICHIER DE LOG
        $log->log("Message d'information", Zend_Log::INFO);
        $log->info("Message d'information");
        //$log->log("Message d'urgence", Zend_Log::EMERG);
        $log->emerg("Message d'urgence");
        */
    }

    /*
      protected function _initLog() {
      $log = Zend_Log::factory(array(
      'timestampFormat' => 'Y-m-d H:i:s',
      array(
      'writerName' => 'Stream',
      'writerParams' => array(
      'stream' => APPLICATION_PATH . "/data/logs/" . date('W') . ".log"
      ),
      'formatterName' => 'Simple',
      'formatterParams' => array(
      'format' => '\'%timestamp%\';\'%priorityName%\';%message%' . PHP_EOL
      ),
      'filterName' => 'Priority',
      'filterParams' => array(
      'priority' => 6
      )
      )
      ));
      Zend_Registry::set('log', $log);
      return $log;
      }
     */

    protected function _initRouter() {
        /*
          $front = $this->getResource('FrontController');
          $router = $front->getRouter();
          $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
          $routing = new Zend_Controller_Router_Rewrite();
          $routing->addConfig($config, 'routes');
          $front->setRouter($routing);
         */
    }

    protected function _initConfig() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/define.ini', APPLICATION_ENV);
        Zend_Registry::set('define', $config);
    }

    protected function _initMail() {
        /*
          $mailOption = $this->getPluginResource('mail')->getOptions();
          $transport = new Zend_Mail_Transport_Smtp($mailOption['transport']['host'], $mailOption['transport']);
          Zend_Mail::setDefaultTransport($transport);
          Zend_Mail::setDefaultFrom($mailOption['defaultFrom']['email'], $mailOption['defaultFrom']['name']);
          Zend_Mail::setDefaultReplyTo($mailOption['defaultReplyTo']['email'], $mailOption['defaultReplyTo']['name']);
         */
    }

}

