<?php

class /* Application_Models_ */TLogin extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'login';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_LOGIN";

    /**
     * Retourne le resultat associe a l'id passe
     * @param int $id
     */
    public function getLogin($id) {
        return $this->find($id)->current();
    }

    /**
     * retourne toutes les resultats
     */
    public function getLogins($limit = null) {
        $query = $this->select();
        $query->where("ACTIVE=1");

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $this->fetchAll($query);
    }

    /**
     * Retourne un row. Permet donc de savoir instantanément si ce compte est active.
     * @param int $idClient
     */
    public function isActive($idClient) {
        return $this->find($idClient)->current()->ACTIVE;
    }

    /**
     * Retourne un row. Permet donc de savoir instantanément si ce compte est un compte d'amin.
     * @param int $idClient
     */
    public function isAdmin($idClient) {
        $row = $this->find($idClient)->current();
        
        if( $row->DROIT == 1 && $row->ACTIVE == 1 ){
            return true;
        }else{
            return false;
        }
    }


    /**
     * Retourne le champs admin pour le client $idClient. Permet donc de savoir instantanément si ce client est un admin.
     * @param int $idClient
     */
    public function isEmploye($idClient) {
        $row = $this->find($idClient)->current();
        
        if( $row->DROIT == 2 && $row->ACTIVE == 1 ){
            return true;
        }else{
            return false;
        }
    }
    
    

}