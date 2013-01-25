<?php

class Zend_View_Helper_Flash extends Zend_View_Helper_Abstract {

    /**
     * Affichons ce nombre au format international pour la locale definie dans le bootstrap
     * @param string $valeur
     */
    public function flashMessage($mess, $type="success") {
        return "<div class='alert alert-".$type."'>".$mess."</div>";
    }
    
    public function direct() {
        parent::direct();
        
        
    }

}

//fin class