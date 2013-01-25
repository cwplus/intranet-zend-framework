<?php

class /* Application_Models_ */TFicheCommande extends Zend_Db_Table_Abstract {

    /**
     * 
     * Nom de la table
     * @var string
     */
    protected $_name = 'ficheCommande';

    /**
     * 
     * Nom de la cle primaire de la table
     * @var string
     */
    protected $_primary = "ID_FICHECOMMANDE";

    /**
     * Nom de/des table(s) dépendante(s)
     * @var type 
     */
    protected $_dependentTables = array('TLogin', 'TClient', 'TFournisseur');

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
        'ID_FOURNISSEUR' => array(
            'columns' => 'ID_FOURNISSEUR',
            'refTableClass' => 'TFournisseur',
            'refColumns' => 'ID_FOURNISSEUR'
        ),
        'ID_ETAT' => array(
            'columns' => 'ID_ETAT',
            'refTableClass' => 'TEtat',
            'refColumns' => 'ID_ETAT'
        )
    );

    /*
      protected $_referenceMap = array(
      'peinture' => array(
      'columns' => 'idTypePeinture',
      'refTableClass' => 'TTypePeinture'
      ),
      'interieur' => array(
      'columns' => 'idTypeInterieur',
      'refTableClass' => 'TTypeInterieur'
      ),
      'prix' => array(
      'columns' => 'idOptionPrix',
      'refTableClass' => 'TTypePrix'
      ),
      'couleurExt' => array(
      'columns' => 'idCouleurExt',
      'refTableClass' => 'TCouleur'
      ),
      'couleurInt' => array(
      'columns' => 'idCouleurInt',
      'refTableClass' => 'TCouleur'
      ),
      'client' => array(
      'columns' => 'idClient',
      'refTableClass' => 'TClient'
      )
      );
     */

    /**
     * retourne toutes les resultats
     */
    public function getFichesCommandes($limit = null) {
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
    public function getFicheCommande($id) {
        return $this->find($id)->current();
    }

    /**
     * Permet d'ajouter un fournisseur
     * @param string $nom nom du fournisseur
     */
    /*    public function ajouter($idLogin, $civilite, $nom, $prenom, $email, $entreprise, $adresse, $complemetAdresse, $cp, $ville, $telBur, $telDom, $telMob) {
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
     */
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
    /*    public function modifierClient(
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
     */

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
        $tbl_f = array(
            'F_VALEUR' => 'f.VALEUR'//,
//            'F_ID' => 'f.ID_FOURNISSEUR'
        );
        $tbl_e = array(
            'E_VALEUR' => 'e.VALEUR'
        );
        

        $select = $this->select()
                ->setIntegrityCheck(false) // pour utiliser la jointure
                ->from(array('fc' => $this->_name))
                //->joinUsing('login' => 'ID_LOGIN')
                //->joinUsing('client' => 'ID_CLIENT')
                ->join(array('l' => 'login'), 'l.ID_LOGIN=fc.ID_LOGIN', $tbl_l)
                ->join(array('c' => 'client'), 'c.ID_CLIENT=fc.ID_CLIENT', $tbl_c)
                ->join(array('f' => 'fournisseur'), 'f.ID_FOURNISSEUR=fc.ID_FOURNISSEUR', $tbl_f)
                ->join(array('e' => 'etat'), 'e.ID_ETAT=fc.ID_ETAT', $tbl_e)
                ->order("ID_FICHECOMMANDE DESC")
                ;

        if (!empty($t['NOM'])) { $select->where('c.NOM LIKE ?', '%' . $t['NOM'] . '%'); }
        if (!empty($t['PRENOM'])) { $select->where('c.PRENOM LIKE ?', '%' . $t['PRENOM'] . '%'); }
        if (!empty($t['ENTREPRISE'])) { $select->where('c.ENTREPRISE LIKE ?', '%' . $t['ENTREPRISE'] . '%'); }
        if (!empty($t['ID'])) { $select->where('fc.ID_FICHECOMMANDE = ?', $t['ID']); }
        if (!empty($t['ETAT'])) { $select->where('fc.ID_ETAT = ?', $t['ETAT']); }
        if (!empty($t['FOURNISSEUR'])) { $select->where('fc.ID_FOURNISSEUR = ?', $t['FOURNISSEUR']); }
        if (!empty($t['REF'])) { $select->where('fc.REF = ?', $t['REF']); }
        if (!empty($t['DESIGNATION'])) { $select->where('fc.DESIGNATION LIKE ?', '%' . $t['DESIGNATION'] . '%'); }
        
//        $select->order("F_ID", "DESC");
//        echo $select;

//        $select->where("fc.ID_FICHECOMMANDE=?', 2937);
        /*
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
         */

        // AFFICHAGE COMPLET
        //$row = $this->fetchAll();
        //Zend_Debug::dump($row->current()->findDependentRowset('TLogin')->toArray());
        //Zend_Debug::dump($row->current()->toArray());
        // AFFICHER REQUETE
        //Zend_Debug::dump($select->__toString());
        return $this->fetchAll($select);
    }
    
    /**
     * Permet d'ajouter une fiche de commande
     * @param int $idLogin id de la personne connecte
     * @param int $idClient id du client
     * @param int $idEtat id de l'etat
     * @param int $idFournisseur id du fournisseur
     * @param date $dateLivraison date de la livraison
     * @param int $contactCommercial id du contact commercial
     * @param int $contactTechnique id du contact technique
     * @param string $commentaire redactionnel
     * @param string $idSage numero sage
     */
    public function ajouter($idLogin, $idClient, $idEtat, $idFournisseur, $dateLivraison, $contactCommercial, $contactTechnique, $commentaire, $idSage) {
        $ajouter = $this->createRow();
        $ajouter->ID_LOGIN = $idLogin;
        $ajouter->ID_CLIENT = $idClient;
        $ajouter->ID_ETAT = $idEtat;
        $ajouter->ID_FOURNISSEUR = $idFournisseur;
        $ajouter->DATE_CREATION = date('Y-m-d');
        $ajouter->DATE_LIVRAISON = $dateLivraison;
        $ajouter->CONTACT_COMMERCIAL = $contactCommercial;
        $ajouter->CONTACT_TECHNIQUE = $contactTechnique;
        $ajouter->COMMENTAIRE = $commentaire;
        $ajouter->ID_SAGE = $idSage;
        return $ajouter->save();
    }
    
    /**
     * Permet de modifier une fiche de commande
     * @param int $idFicheCommande id de la fiche de commande
     * @param int $idLogin id de la personne connecte
     * @param int $idClient id du client
     * @param int $idEtat id de l'etat
     * @param int $idFournisseur id du fournisseur
     * @param date $dateLivraison date de la livraison
     * @param int $contactCommercial id du contact commercial
     * @param int $contactTechnique id du contact technique
     * @param string $commentaire redactionnel
     * @param string $idSage numero sage
     */
    public function modifier($idFicheCommande, $idLogin, $idEtat, $idFournisseur, $dateLivraison, $contactCommercial, $contactTechnique, $commentaire, $idSage){
        $select = $this->find($idFicheCommande)->current();
        if (!is_null($idLogin)) { $select->ID_LOGIN = $idLogin; }
        if (!is_null($idEtat)) { $select->ID_ETAT = $idEtat; }
        if (!is_null($idFournisseur)) { $select->ID_FOURNISSEUR = $idFournisseur; }
        if (!is_null($dateLivraison)) { $select->DATE_LIVRAISON = $dateLivraison; }
        if (!is_null($contactCommercial)) { $select->CONTACT_COMMERCIAL = $contactCommercial; }
        if (!is_null($contactTechnique)) { $select->CONTACT_TECHNIQUE = $contactTechnique; }
        if (!is_null($commentaire)) { $select->COMMENTAIRE = $commentaire; }
        if (!is_null($idSage)) { $select->ID_SAGE = $idSage; }

        return $select->save();
    }
    
    /**
     * supprimer une fiche de commande
     * @param array $idFicheCommande
     */
    public function supprimer($idFicheCommande) {
        return $this->delete(array('ID_FICHECOMMANDE IN (?)' => $idFicheCommande));
    }

}
