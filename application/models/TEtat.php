<?php

class /* Application_Models_ */TEtat extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'etat';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_ETAT";

    /**
     * retourne toutes les resultats
     * @param int $limit
     */
    public function getEtats($limit = null, $qui = null) {
        $query = $this->select();

        if (!is_null($limit)) {
            $query->limit($limit);
        }
        if (!is_null($qui)) {
            $query->where("QUI = ?", $qui);
        }

        return $this->fetchAll($query);
    }

    /**
     * Retourne le resultat associe a l'id passe
     * @param int $id
     */
    public function getEtat($id) {
        return $this->find($id)->current();
    }

}

