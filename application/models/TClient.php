<?php

class /* Application_Models_ */TClient extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'client';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_CLIENT";

    /**
     * retourne toutes les resultats
     */
    public function getClients($limit = null) {
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
    public function getClient($id) {
        return $this->find($id)->current();
    }

    /**
     * Permet d'ajouter un fournisseur
     * @param string $nom nom du fournisseur
     */
    public function ajouter($idLogin, $civilite, $nom, $prenom, $email, $entreprise, $adresse, $complemetAdresse, $cp, $ville, $telBur, $telDom, $telMob) {
        $ajouter = $this->createRow();
        $ajouter->ID_LOGIN = $idLogin;
        $ajouter->DATE_HEURE = date('Y-m-d H:i:s');
        $ajouter->ENTREPRISE = $entreprise;
        $ajouter->CIVILITE = $civilite;
        $ajouter->NOM = $nom;
        $ajouter->PRENOM = $prenom;
        $ajouter->ADRESSE_01 = $adresse;
        $ajouter->ADRESSE_02 = $complemetAdresse;
        $ajouter->VILLE = $ville;
        $ajouter->CODE_POSTAL = $cp;
        $ajouter->TEL_BUREAU = $telBur;
        $ajouter->TEL_DOMICILE = $telDom;
        $ajouter->TEL_MOBILE = $telMob;
        $ajouter->EMAIL = $email;
        return $ajouter->save();
    }

    /**
     * Permet de modifier un client
     * @param int $idClient
     * @param int $idLogin
     * @param date $dateHeure
     * @param string $entreprise
     * @param int $civilite
     * @param string $nom
     * @param string $prenom
     * @param string $adresse
     * @param string $complemetAdresse
     * @param string $ville
     * @param int $cp
     * @param string $telBur
     * @param string $telDom
     * @param string $telMob
     * @param string $email
     */
    public function modifierClient(
    $idClient, $idLogin, $dateHeure, $entreprise, $civilite, $nom, $prenom, $adresse, $complemetAdresse, $ville, $cp, $telBur, $telDom, $telMob, $email
    ) {
        $modifClient = $this->find($idClient)->current();
        if (!is_null($idLogin)) {
            $modifClient->ID_LOGIN = $idLogin;
        }
        if (!is_null($dateHeure)) {
            $modifClient->DATE_HEURE = $dateHeure;
        }
        if (!is_null($entreprise)) {
            $modifClient->ENTREPRISE = $entreprise;
        }
        if (!is_null($civilite)) {
            $modifClient->CIVILITE = $civilite;
        }
        if (!is_null($nom)) {
            $modifClient->NOM = $nom;
        }
        if (!is_null($prenom)) {
            $modifClient->PRENOM = $prenom;
        }
        if (!is_null($adresse)) {
            $modifClient->ADRESSE_01 = $adresse;
        }
        if (!is_null($complemetAdresse)) {
            $modifClient->ADRESSE_02 = $complemetAdresse;
        }
        if (!is_null($ville)) {
            $modifClient->VILLE = $ville;
        }
        if (!is_null($cp)) {
            $modifClient->CODE_POSTAL = $cp;
        }
        if (!is_null($telBur)) {
            $modifClient->TEL_BUREAU = $telBur;
        }
        if (!is_null($telDom)) {
            $modifClient->TEL_DOMICILE = $telDom;
        }
        if (!is_null($telMob)) {
            $modifClient->TEL_MOBILE = $telMob;
        }
        if (!is_null($email)) {
            $modifClient->EMAIL = $email;
        }

        return $modifClient->save();
    }

    /**
     *
     * @param array $t
     * @return object 
     */
    public function rechercher($t=array()) {
        $select = $this->select()->from($this/* , array('ID_CLIENT', 'NOM', 'PRENOM', 'ADRESSE_01', 'ADRESSE_02') */);
        if (!empty($t['NOM'])) {
            $select->where('NOM LIKE ?', '%'.$t['NOM'].'%');
        }
        if (!empty($t['PRENOM'])) {
            $select->where('PRENOM LIKE ?', '%'.$t['PRENOM'].'%');
        }
        if (!empty($t['EMAIL'])) {
            $select->where('EMAIL LIKE ?', '%'.$t['EMAIL'].'%');
        }
        if (!empty($t['ENTREPRISE'])) {
            $select->where('ENTREPRISE LIKE ?', '%'.$t['ENTREPRISE'].'%');
        }
        if (!empty($t['ADRESSE_01'])) {
            $select->where('ADRESSE_01 LIKE ?', $t['ADRESSE_01']);
        }
        if (!empty($t['ADRESSE_02'])) {
            $select->where('ADRESSE_02 LIKE ?', $t['ADRESSE_02']);
        }
        if (!empty($t['CODE_POSTAL'])) {
            $select->where('CODE_POSTAL = ?', $t['CODE_POSTAL']);
        }
        if (!empty($t['VILLE'])) {
            $select->where('VILLE LIKE ?', '%'.$t['VILLE'].'%');
        }
        if (!empty($t['TEL_BUREAU'])) {
            $select->where('TEL_BUREAU LIKE ?', $t['TEL_BUREAU']);
        }
        if (!empty($t['TEL_DOMICILE'])) {
            $select->where('TEL_DOMICILE LIKE ?', $t['TEL_DOMICILE']);
        }
        if (!empty($t['TEL_MOBILE'])) {
            $select->where('TEL_MOBILE LIKE ?', $t['TEL_MOBILE']);
        }
        $select->order("ID_CLIENT DESC");
        return $this->fetchAll($select);
    }

}
