<?php
class /*Application_Models_*/TCivilite extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'civilite';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_CIVILITE";

    /**
     * retourne toutes les civilites 
     */
    public function getCivilites() {
        $query  = $this->select();
        return $this->fetchAll($query);
    }

    /**
     * Retourne la civilite associe a l'id passe
     * @param int $id
     */
    public function getCivilite($id) {
        return $this->find($id)->current();
    }

}
