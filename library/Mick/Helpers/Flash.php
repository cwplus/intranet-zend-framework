<?php

class Mick_Helpers_Flash extends Zend_Controller_Action_Helper_Abstract {

    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'info';
    const SUCCESS = 'success';

    public function error($message) {
        return $this->_addMessage($message, self::ERROR);
    }

    public function success($message) {
        return $this->_addMessage($message, self::SUCCESS);
    }

    public function warning($message) {
        return $this->_addMessage($message, self::WARNING);
    }

    public function notice($message) {
        return $this->_addMessage($message, self::NOTICE);
    }

    private function _addMessage($message, $type) {
        $html = "
        <div class='alert alert-" . $type . "'>
            <a class='close' data-dismiss='alert'>×</a>
            " . $message . "
        </div>";
        return $html;

//        $this->_factory($message, $type, $class, $method);
//        return $this;
    }

    /*
      protected function _factory($message, $type, $class = null, $method = null) {
      $messg = new stdClass();
      $messg->message = $message;
      $messg->type = $type;
      $messg->class = $class;
      $messg->method = $method;
      return $messg;
      }


      public function direct() {
      //return $this;
      }
     */
}