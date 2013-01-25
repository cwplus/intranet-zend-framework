<?php

class /* Application_Models_ */TPret extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'pret';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_PRET";

    /**
     * retourne toutes les resultats
     */
    public function getPrets($limit = null) {
        $query = $this->select();
        $query->where("ARCHIVE=0");
        $query->order('ID_PRET DESC');
        
        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $this->fetchAll($query);
    }

    /**
     * Retourne le resultat associe a l'id passe
     * @param int $id
     */
    public function getPret($id) {
        return $this->find($id)->current();
    }

    /**
     *
     * Permet d'ajouter un pret
     * @param int $idClient
     * @param int $idPreteur
     * @param date $dateD
     * @param date $dateF
     * @param string $typeMateriel
     * @return bool 
     */
    public function ajouter($idClient, $idPreteur, $dateD, $dateF, $typeMateriel) {
        $ajouter = $this->createRow();
        $ajouter->ID_CLIENT = $idClient;
        $ajouter->ID_PRETEUR = $idPreteur;
        $ajouter->DATE_DEBUT_PRET = $dateD;
        $ajouter->DATE_FIN_PRET = $dateF;
        $ajouter->TYPE_MATERIEL = $typeMateriel;
        return $ajouter->save();
    }

    /**
     *
     * Permet de modifier un pret
     * @param int $idPret
     * @param int $idClient
     * @param int $idPreteur
     * @param date $dateD
     * @param date $dateF
     * @param string $typeMateriel
     * @return bool 
     */
    public function modifier($idPret, $idClient, $idPreteur, $dateD, $dateF, $typeMateriel) {
        $select = $this->find($idPret)->current();
        if (!is_null($idClient)) {
            $select->ID_CLIENT = $idClient;
        }
        if (!is_null($idPreteur)) {
            $select->ID_PRETEUR = $idPreteur;
        }
        if (!is_null($dateD)) {
            $select->DATE_DEBUT_PRET = $dateD;
        }
        if (!is_null($dateF)) {
            $select->DATE_FIN_PRET = $dateF;
        }
        if (!is_null($typeMateriel)) {
            $select->TYPE_MATERIEL = $typeMateriel;
        }

        return $select->save();
    }

    /**
     * supprimer les prets dont l'id est présent dans $idPret
     * @param array $idPret
     */
    public function supprimer($idPret) {
        $select = $this->find($idPret)->current();
        if (!is_null($idPret)) {
            $select->ARCHIVE = 1;
        }
        return $select->save();

        //return $this->delete(array('ID_PRET IN (?)' => $idPret));
    }

    /**
     *
     * @param array $t
     * @return object 
     */
    /*
      public function rechercher($t = array()) {
      $select = $this->select()->from($this);
      if (!empty($t['VALEUR'])) {
      $select->where('VALEUR LIKE ?', '%' . $t['VALEUR'] . '%');
      }

      return $this->fetchAll($select);
      }
     */
}