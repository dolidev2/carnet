<?php

require_once 'models/modelClass.php';
require_once 'models/charge/chargeClass.php';

class chargeManager extends modelClass
{
    private $charges; //Tableau des charges

    public function addCharge($charge)
    {
        $this->charges[] = $charge;
    }
    public function getCharges()
    {
        return $this->charges;
    }

    public function loadCharge()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM charge");
        $query->execute();
        $allcharge = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allcharge as $charge)
        {
            $data = array(
                'id'=> $charge['id_charge'],
                'prix'=> $charge['prix_charge'],
                'qte'=> $charge['qte_charge'],
                'desc'=> $charge['desc_charge'],
                'creat'=> $charge['creat_charge'],
                'mod'=> $charge['mod_charge'],
                'ressource'=> $charge['ressource'],
                'production'=> $charge['production']
            );
            $item = new chargeClass($data);
            $this->addCharge($item);
        }
    }
    public function getChargesProduction($production)
    {
        $charges_prod = [];
        if(!empty($this->charges)){
            foreach ($this->charges as $charge){
                if($charge->getProduction() === $production->getIdProd()){
                    array_push($charges_prod,$charge);
                }
            }
        }

        return $charges_prod;
    }

    public function getChargeById($id)
    {
        if(!empty($this->charges)){
            foreach ($this->charges as $charge){
                if($charge->getIdcharge() === $id){
                    return $charge;
                }
            }
        }
    }

    public function addChargeBd($data)
    {
        $query = "INSERT INTO charge (prix_charge,qte_charge, desc_charge, creat_charge, mod_charge,ressource, production) 
                    VALUES (:prix,:qte,:desc, :creat,:mod, :ressource, :production)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":prix",$data['prix']);
        $stmt->bindValue(":qte",$data['qte']);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":ressource",$data['ressource']);
        $stmt->bindValue(":production",$data['production']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $charge = new chargeClass($data);
            $this->addCharge($charge);

            return  $data['id'];
        }
    }

    public function updateChargeBD($data)
    {
        $query = "UPDATE charge SET prix_charge=:prix, qte_charge=:qte, desc_charge=:desc,ressource=:ressource, mod_charge=:mod WHERE id_charge=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":prix",$data['prix']);
        $stmt->bindValue(":qte",$data['qte']);
        $stmt->bindValue(":ressource",$data['ressource']);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":id",$data['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getChargeById($data['id'])->setPrixCharge($data['prix']);
            $this->getChargeById($data['id'])->setQteCharge($data['qte']);
            $this->getChargeById($data['id'])->setDescCharge($data['desc']);
            $this->getChargeById($data['id'])->setModCharge($data['mod']);
            $this->getChargeById($data['id'])->setRessource($data['ressource']);
        }
    }

    public function deleteChargeBD($id)
    {
        $query = "DELETE FROM charge WHERE id_charge=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $charge = $this->getChargeById($id);
            unset($charge);
        }
    }

    public function getChargesRessource($prod)
    {
        $query = "SELECT * FROM charge c JOIN ressource r  ON r.id_res=c.ressource WHERE c.production =:prod";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":prod",$prod);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }
    public function getInfoClientCommandeFromCharge($charge)
    {
        $query = "SELECT nom_modele as modele, nom_client as nom, prenom_client as prenom,
                    contact_client as contact ,desc_commande as commande FROM 
                    client cl JOIN commande cmd ON cl.id_client=cmd.client
                    JOIN commande_modele_tissu cmt ON cmd.id_commande=cmt.commande
                    JOIN modele m ON cmt.modele=m.id_modele
                    JOIN production p ON cmt.id_cmt=p.cmt
                    JOIN charge ch ON ch.production=p.id_prod
                    WHERE ch.id_charge =:charge";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":prod",$prod);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }
}