<?php

class /* Application_Models_ */TSav extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'sav';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_SAV";

    /**
     * Nom de/des table(s) dépendante(s)
     * @var type 
     */
    protected $_dependentTables = array('TLogin', 'TClient');

    /**
     * Tableau contenant les cles etrangeres de la table ainsi que la table et les attributs qu'elles referencent
     * @var array
     * 
     * columns :        colonne de la classe courante
     * refTableClass :  classe de la table à joindre
     * refColumns :     colonne de la table à joindre
     */
    protected $_referenceMap = array(
        'ID_LOGIN' => array(
            'columns' => 'ID_LOGIN',
            'refTableClass' => 'TLogin',
            'refColumns' => 'ID_LOGIN'
        ),
        'ID_CLIENT' => array(
            'columns' => 'ID_CLIENT',
            'refTableClass' => 'TClient',
            'refColumns' => 'ID_CLIENT'
        ),
        'ID_ETAT' => array(
            'columns' => 'ID_ETAT',
            'refTableClass' => 'TEtat',
            'refColumns' => 'ID_ETAT'
        )
    );

    /**
     * retourne toutes les resultats
     */
    public function getSavs($limit = null) {
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
    public function getSav($id) {
        return $this->find($id)->current();
    }

    /**
     *
     * @param array $t
     * @return object 
     */
    public function rechercher($t = array()) {
        $tbl_l = array(
            'L_NOM' => 'l.NOM',
            'L_PRENOM' => 'l.PRENOM'
        );
        $tbl_c = array(
            'C_NOM' => 'c.NOM',
            'C_PRENOM' => 'c.PRENOM',
            'C_ENTREPRISE' => 'c.ENTREPRISE'
        );
        $tbl_e = array(
            'E_VALEUR' => 'e.VALEUR'
        );
        $tbl_cc = array(
            'CC_NOM' => 'lc.NOM',
            'CC_PRENOM' => 'lc.PRENOM'
        );
        $tbl_ct = array(
            'CT_NOM' => 'lt.NOM',
            'CT_PRENOM' => 'lt.PRENOM'
        );
        

        $select = $this->select()
                ->setIntegrityCheck(false) // pour utiliser la jointure
                ->from(array('s' => $this->_name))
                //->joinUsing('login' => 'ID_LOGIN')
                //->joinUsing('client' => 'ID_CLIENT')
                ->join(array('l' => 'login'), 'l.ID_LOGIN=s.ID_LOGIN', $tbl_l)
                ->join(array('lc' => 'login'), 'lc.ID_LOGIN=s.CONTACT_COMMERCIAL', $tbl_cc)
                ->join(array('lt' => 'login'), 'lt.ID_LOGIN=s.CONTACT_TECHNIQUE', $tbl_ct)
                ->join(array('c' => 'client'), 'c.ID_CLIENT=s.ID_CLIENT', $tbl_c)
                ->join(array('e' => 'etat'), 'e.ID_ETAT=s.ID_ETAT', $tbl_e)
                ->order("ID_SAV DESC")
                ;

        if (!empty($t['ID'])) { $select->where('s.ID_SAV = ?', $t['ID']); }
        if (!empty($t['NUM_DEVIS'])) { $select->where('s.NUMERO_DEVIS = ?', $t['NUM_DEVIS']); }
        if (!empty($t['ETAT'])) { $select->where('s.ID_ETAT = ?', $t['ETAT']); }

        return $this->fetchAll($select);
    }
    
    /**
     * Permet d'ajouter un sav
     * @param int $idLogin id de la personne connecte
     * @param int $idClient id du client
     * @param int $idEtat id de l'etat
     * @param date $dateLivraison date de la livraison
     * @param int $contactCommercial id du contact commercial
     * @param int $contactTechnique id du contact technique
     * @param string $accessoireClient redactionnel sur les accessoires deposes par le client
     * @param string $commentairePanne redactionnel sur la panne
     * @param string $commentaireReparation redactionnel sur la reparation
     * @param string $numDevis numero du devis 
     * @param string $mdp mot de passe du client
     */
    public function ajouter($idLogin, $idClient, $idEtat, $dateLivraison, $contactCommercial, $contactTechnique, $accessoireClient, $commentairePanne, $commentaireReparation, $numDevis, $mdp) {
        $ajouter = $this->createRow();
        $ajouter->ID_LOGIN = $idLogin;
        $ajouter->ID_CLIENT = $idClient;
        $ajouter->ID_ETAT = $idEtat;
        $ajouter->DATE_CREATION = date('Y-m-d');
        $ajouter->DATE_LIVRAISON = $dateLivraison;
        $ajouter->CONTACT_COMMERCIAL = $contactCommercial;
        $ajouter->CONTACT_TECHNIQUE = $contactTechnique;
        $ajouter->ACCESSOIRE_CLIENT = $accessoireClient;
        $ajouter->COMMENTAIRE_PANNE = $commentairePanne;
        $ajouter->COMMENTAIRE_REPARATION = $commentaireReparation;
        $ajouter->NUMERO_DEVIS = $numDevis;
        $ajouter->MOT_DE_PASSE = $mdp;
        return $ajouter->save();
    }
    
    /**
     * Permet de modifier un sav
     * @param int $idSav id du sav
     * @param int $idLogin id de la personne connecte
     * @param int $idEtat id de l'etat
     * @param date $dateLivraison date de la livraison
     * @param int $contactCommercial id du contact commercial
     * @param int $contactTechnique id du contact technique
     * @param string $accessoireClient redactionnel sur les accessoires deposes par le client
     * @param string $commentairePanne redactionnel sur la panne
     * @param string $commentaireReparation redactionnel sur la reparation
     * @param string $numDevis numero du devis 
     * @param string $mdp mot de passe du client
     */
    public function modifier($idSav, $idLogin, $idEtat, $dateLivraison, $contactCommercial, $contactTechnique, $accessoireClient, $commentairePanne, $commentaireReparation, $numDevis, $mdp){
        $select = $this->find($idSav)->current();
        if (!is_null($idSav)) { $select->ID_SAV = $idSav; }
        if (!is_null($idLogin)) { $select->ID_LOGIN = $idLogin; }
        if (!is_null($idEtat)) { $select->ID_ETAT = $idEtat; }
        if (!is_null($dateLivraison)) { $select->DATE_LIVRAISON = $dateLivraison; }
        if (!is_null($contactCommercial)) { $select->CONTACT_COMMERCIAL = $contactCommercial; }
        if (!is_null($contactTechnique)) { $select->CONTACT_TECHNIQUE = $contactTechnique; }
        if (!is_null($accessoireClient)) { $select->ACCESSOIRE_CLIENT = $accessoireClient; }
        if (!is_null($commentairePanne)) { $select->COMMENTAIRE_PANNE = $commentairePanne; }
        if (!is_null($commentaireReparation)) { $select->COMMENTAIRE_REPARATION = $commentaireReparation; }
        if (!is_null($numDevis)) { $select->NUMERO_DEVIS = $numDevis; }
        if (!is_null($mdp)) { $select->MOT_DE_PASSE = $mdp; }

        return $select->save();
    }
    
    /**
     * supprimer un sav
     * @param array $idSav
     */
    public function supprimer($idSav) {
        return $this->delete(array('ID_SAV IN (?)' => $idSav));
    }

}
