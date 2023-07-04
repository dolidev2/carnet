<?php

require_once "models/modelClass.php";
require_once "models/personnel/personnelClass.php";

class personnelManager extends modelClass
{
    private $personnels;//Tableau de clients

    public function addPersonnel($personnel)
    {
        $this->personnels[] = $personnel;
    }

    public function getPersonnels()
    {
        return $this->personnels;
    }

    public function loadPersonnel()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;

        $query = "SELECT * FROM personnel WHERE agence=:agence ORDER BY id_pers DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $allpersonnel = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allpersonnel as $pers)
        {
            $data = array(
                'id'=>$pers['id_pers'],
                'nom'=>$pers['nom_pers'],
                'prenom'=>$pers['prenom_pers'],
                'contact'=>$pers['contact_pers'],
                'adresse'=>$pers['adresse_pers'],
                'recto'=>$pers['cnib_recto_pers'],
                'verso'=>$pers['cnib_verso_pers'],
                'creat'=>$pers['creat_pers'],
                'mod'=>$pers['mod_pers'],
                'agence'=>$pers['agence']
            );
            $item = new personnelClass($data);
            $this->addPersonnel($item);
        }
    }

    public function getPersonnelById($id)
    {
        if (!empty($this->personnels)){
            foreach ($this->personnels as $personnel){
                if($personnel->getIdPers() === $id){
                    return $personnel;
                }
            }
        }
    }

    public function getPersonnelFromAgence($agence)
    {

        $query = "SELECT * FROM personnel WHERE agence=:agence ORDER BY id_pers DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $results;
    }

    public function getPersonnelByAgence($agence)
    {
        $persAgence = [];
        if (!empty($this->personnels)){
            foreach ($this->personnels as $personnel){
                if($personnel->getAgence() === $agence){
                    array_push($persAgence,$personnel);
                }
            }
        }
        return $persAgence;
    }

    public function addPersonnelBd($data)
    {
        $query = "INSERT INTO personnel (nom_pers,prenom_pers, contact_pers, adresse_pers,
                   cnib_recto_pers,cnib_verso_pers,creat_pers, mod_pers, agence) 
                   VALUES (:nom,:prenom,:contact,:adresse,:recto,:verso,:creat,:mod,:agence)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom']);
        $stmt->bindValue(":prenom",$data['prenom']);
        $stmt->bindValue(":contact",$data['contact']);
        $stmt->bindValue(":adresse",$data['adresse']);
        $stmt->bindValue(":recto",$data['recto']);
        $stmt->bindValue(":verso",$data['verso']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":agence",$data['agence']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $personnel = new personnelClass($data);
            $this->addPersonnel($personnel);
        }
    }

    public function updatePersonnelBD($data)
    {
        $query = "UPDATE personnel SET  nom_pers=:nom, prenom_pers=:prenom, contact_pers=:contact, agence=:agence,
                  adresse_pers=:adresse,cnib_recto_pers=:recto, cnib_verso_pers=:verso,mod_pers=:mod WHERE id_pers=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom']);
        $stmt->bindValue(":prenom",$data['prenom']);
        $stmt->bindValue(":contact",$data['contact']);
        $stmt->bindValue(":adresse",$data['adresse']);
        $stmt->bindValue(":agence",$data['agence']);
        $stmt->bindValue(":recto",$data['recto']);
        $stmt->bindValue(":verso",$data['verso']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getPersonnelById($data['id'])->setNomPers($data['nom']);
            $this->getPersonnelById($data['id'])->setPrenomPers($data['prenom']);
            $this->getPersonnelById($data['id'])->setContactPers($data['contact']);
            $this->getPersonnelById($data['id'])->setAdressePers($data['adresse']);
            $this->getPersonnelById($data['id'])->setAgence($data['agence']);
            $this->getPersonnelById($data['id'])->setCnibRectoPers($data['recto']);
            $this->getPersonnelById($data['id'])->setCnibVersoPers($data['verso']);
            $this->getPersonnelById($data['id'])->setModPers($data['mod']);
        }
    }

    public function deletePersonnelBD($id)
    {
        $query = "DELETE FROM personnel WHERE id_pers=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $personnel = $this->getpersonnelById($id);
            unset($personnel);
        }
    }

    public function programmeArticles($personnel)
    {
        $query = "SELECT m.nom_modele,c.statut_commande, cmt.quantite_cmt, c.desc_commande, 
                  m.cout_modele,m.cout_decoup_modele, cmt.creat_cmt, cmt.mod_cmt,p.quantite_prod, 
                  p.desc_prod, cl.nom_client, cl.prenom_client, cl.contact_client, p.id_prod,
                  p.statut_prod,cmt.statut_cmt, p.creat_prod, p.mod_prod, p.rend_prod,p.somme_prod
                  FROM commande c, commande_modele_tissu cmt , client cl,
                  modele m, tissu t, production p WHERE cmt.commande=c.id_commande AND c.client=cl.id_client
                  AND cmt.modele=m.id_modele AND t.id_tissu = cmt.tissu AND cmt.id_cmt = p.cmt AND 
                  p.personnel =:personnel ORDER BY c.id_commande DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$personnel);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function programmePeriodeArticles($personnel,$debut,$fin)
    {
        $query = "SELECT m.nom_modele,c.statut_commande, cmt.quantite_cmt, c.desc_commande, m.cout_modele, 
                  c.creat_commande, c.mod_commande, cl.nom_client, cl.prenom_client, cl.contact_client, 
                  p.quantite_prod,p.somme_prod, p.creat_prod,p.mod_prod, p.id_prod, p.rend_prod, p.statut_prod,cmt.creat_cmt,
                  cmt.mod_cmt 
                  FROM commande c, commande_modele_tissu cmt , client cl, modele m, tissu t, production p 
                  WHERE cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele AND
                  t.id_tissu = cmt.tissu AND cmt.id_cmt = p.cmt AND p.personnel =:personnel AND
                  p.mod_prod BETWEEN :debut AND :fin ORDER BY c.id_commande DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$personnel);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function avancePeriode($personnel,$debut,$fin)
    {
        $query = "SELECT * FROM paie_personnel WHERE personnel=:personnel AND 
                  creat_paie_pers  BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$personnel);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadPeriodProduction($data)
    {
        $query ="SELECT SUM(cmt.prix_cmt) as somme FROM commande c, commande_modele_tissu cmt, production p WHERE 
                 c.id_commande = cmt.commande AND cmt.id_cmt=p.cmt AND p.personnel=:personnel
                 AND p.creat_prod BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$data['personnel']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadPeriodCout($data)
    {
        $query ="SELECT  p.somme_prod ,p.quantite_prod,cmt.quantite_cmt, cmt.id_cmt FROM commande c, commande_modele_tissu cmt, production p, modele m WHERE 
                 c.id_commande = cmt.commande AND cmt.id_cmt=p.cmt AND m.id_modele=cmt.modele
                 AND p.personnel=:personnel AND p.creat_prod BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$data['personnel']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

}