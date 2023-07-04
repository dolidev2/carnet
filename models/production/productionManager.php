<?php

require_once 'models/modelClass.php';
require_once 'models/production/productionClass.php';

class productionManager extends modelClass
{
    private $productions;//Tableau de productions

    public function addProduction($production)
    {
        $this->productions[] = $production;
    }

    public function getProductions()
    {
        return $this->productions;
    }

    public function loadProduction()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM production");
        $query->execute();
        $allproduction = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allproduction as $production)
        {
            $data = array(
                'id'=> $production['id_prod'],
                'desc'=> $production['desc_prod'],
                'creat'=> $production['creat_prod'],
                'mod'=> $production['mod_prod'],
                'rend'=> $production['rend_prod'],
                'somme'=> $production['somme_prod'],
                'quantite'=> $production['quantite_prod'],
                'statut'=> $production['statut_prod'],
                'personnel'=> $production['personnel'],
                'cmt'=> $production['cmt']
            );
            $item = new productionClass($data);
            $this->addProduction($item);
        }
    }

    public function getProductionsPersonnel($personnel)
    {
        $productions_commande = [];
        if(!empty($this->productions )){
            foreach ($this->productions as $production){
                if($production->getCommande() === $personnel->getIdPers()){
                    array_push($productions_commande,$production);
                }
            }
        }
        return $productions_commande;
    }

    public function getProductionById($id)
    {
        foreach ($this->productions as $production){
            if($production->getIdProd() === $id){
                return $production;
            }
        }
    }
    public function getProductionByCmt($id)
    {
        $productions = [];
        if(!empty($this->productions )){
            foreach ($this->productions as $production){
                if($production->getCmt() == $id){
                    array_push($productions,$production);
                }
            }
        }
        return $productions;
    }

    public function addProductionBd($data)
    {
        $query = "INSERT INTO production (desc_prod, creat_prod, mod_prod, rend_prod,somme_prod,quantite_prod,statut_prod, personnel, cmt) 
                    VALUES (:desc,:creat,:mod,:rend,:somme, :quantite,:statut,:personnel,:cmt)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['creat']);
        $stmt->bindValue(":rend",$data['rend']);
        $stmt->bindValue(":somme",$data['somme']);
        $stmt->bindValue(":quantite",$data['quantite']);
        $stmt->bindValue(":statut",$data['statut']);
        $stmt->bindValue(":personnel",$data['personnel']);
        $stmt->bindValue(":cmt",$data['cmt']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] =  $this->getBdd()->lastInsertId();
            $production = new productionClass($data);
            $this->addProduction($production);
        }
    }

    public function updateProductionBD($data)
    {
        $query = "UPDATE production SET desc_prod=:desc, personnel=:personnel, mod_prod=:mod, rend_prod=:rend, somme_prod=:somme,
                      quantite_prod=:quantite WHERE id_prod=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":personnel",$data['personnel']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":rend",$data['rend']);
        $stmt->bindValue(":somme",$data['somme']);
        $stmt->bindValue(":quantite",$data['quantite']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getProductionById($data['id'])->setDescProd($data['desc']);
            $this->getProductionById($data['id'])->setPersonnel($data['personnel']);
            $this->getProductionById($data['id'])->setModProd($data['mod']);
            $this->getProductionById($data['id'])->setRendProd($data['rend']);
            $this->getProductionById($data['id'])->setSommeProd($data['somme']);
            $this->getProductionById($data['id'])->setQuantiteProd($data['quantite']);
        }
    }

    public function updateProductionStatutBD($data)
    {
        $query = "UPDATE production SET statut_prod=:statut, mod_prod=:mod WHERE id_prod=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":statut",$data['statut']);
        $stmt->bindValue(":mod",$data['mod']);


        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getProductionById($data['id'])->setStatutProd($data['statut']);
            $this->getProductionById($data['id'])->setModProd($data['mod']);
        }
    }
    public function updateProductionSommeBD($data)
    {
        $query = "UPDATE production SET somme_prod=:somme, mod_prod=:mod WHERE id_prod=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":somme",$data['somme']);
        $stmt->bindValue(":mod",$data['mod']);


        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getProductionById($data['id'])->setSommeProd($data['somme']);
            $this->getProductionById($data['id'])->setModProd($data['mod']);
        }
    }

    public function updateProductionPersonnelBD($data)
    {
        $query = "UPDATE production SET desc_prod=:type, quantite_prod=:quantite, 
                    creat_prod=:debut, mod_prod=:fin, rend_prod=:rend, statut_prod=:statut,
                    somme_prod=:somme WHERE id_prod=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":somme",$data['somme']);
        $stmt->bindValue(":type",$data['type']);
        $stmt->bindValue(":quantite",$data['quantite']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->bindValue(":rend",$data['rend']);
        $stmt->bindValue(":statut",$data['statut']);


        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getProductionById($data['id'])->setSommeProd($data['somme']);
            $this->getProductionById($data['id'])->setModProd($data['fin']);
            $this->getProductionById($data['id'])->setCreatProd($data['debut']);
            $this->getProductionById($data['id'])->setDescProd($data['type']);
            $this->getProductionById($data['id'])->setRendProd($data['rend']);
            $this->getProductionById($data['id'])->setStatutProd($data['statut']);
            $this->getProductionById($data['id'])->setQuantiteProd($data['quantite']);
        }
    }

    public function deleteProductionBD($id)
    {
        $query = "DELETE FROM production WHERE id_prod=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $production = $this->getProductionById($id);
            unset($production);
        }
    }

    public function productionDeatils($prod)
    {
        $query = "SELECT m.nom_modele,c.statut_commande, cmt.quantite_cmt, c.desc_commande, m.cout_modele, c.creat_commande, c.mod_commande,
                   cl.nom_client, cl.prenom_client, cl.contact_client, p.id_prod, p.somme_prod FROM commande c, commande_modele_tissu cmt , client cl,
                   modele m, tissu t, production p WHERE cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele AND
                   t.id_tissu = cmt.tissu AND cmt.id_cmt = p.cmt AND p.id_prod =:production";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":production",$prod);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function countProductionByProgramme($cmt,$type)
    {
        $query = "SELECT sum(p.quantite_prod) as qte FROM commande_modele_tissu cmt JOIN  production p 
                  ON cmt.id_cmt = p.cmt WHERE cmt.id_cmt =:cmt AND p.desc_prod =:type";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":cmt",$cmt);
        $stmt->bindValue(":type",$type);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

}