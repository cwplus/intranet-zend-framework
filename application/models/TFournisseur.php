<?php

class /* Application_Models_ */TFournisseur extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'fournisseur';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_FOURNISSEUR";

    /**
     * retourne toutes les resultats
     */
    public function getFournisseurs($limit = null) {
        $query = $this->select();

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $this->fetchAll($query);
    }

    /**
     * Retourne le resultat associe a l'id passe
     * @param int $id
     */
    public function getFournisseur($id) {
        return $this->find($id)->current();
    }

    /**
     * Permet d'ajouter un fournisseur
     * @param string $nom nom du fournisseur
     */
    public function ajouter($nom) {
        $ajouter = $this->createRow();
        $ajouter->VALEUR = $nom;
        return $ajouter->save();
    }

    /**
     * Permet de modifier un fournisseur
     * @param int $idFournisseur
     * @param string $nom nom du fournisseur
     */
    public function modifier($idFournisseur, $nom) {
        $select = $this->find($idFournisseur)->current();
        if (!is_null($nom)) {
            $select->VALEUR = $nom;
        }

        return $select->save();
    }

    /**
     * supprimer les fournisseurs dont l'id est présent dans $idFournisseur
     * @param array $idFournisseur
     */
    public function supprimer($idFournisseur) {
        return $this->delete(array('ID_FOURNISSEUR IN (?)' => $idFournisseur));
    }

    /**
     *
     * @param array $t
     * @return object 
     */
    public function rechercher($t = array()) {
        $select = $this->select()->from($this);
        if (!empty($t['VALEUR'])) {
            $select->where('VALEUR LIKE ?', '%' . $t['VALEUR'] . '%');
        }

        return $this->fetchAll($select);
    }

}