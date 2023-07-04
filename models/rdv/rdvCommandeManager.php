<?php

require_once 'models/modelClass.php';
require_once 'models/rdv/rdvCommandeClass.php';

class rdvCommandeManager extends modelClass
{
    private $rdvs;//Tableau de rdvs

    public function addRdv($rdv)
    {
        $this->rdvs[] = $rdv;
    }

    public function getRdvs()
    {
        return $this->rdvs;
    }

    public function loadRdv()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM rdv ORDER BY id_rdv DESC");
        $query->execute();
        $allrdv = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allrdv as $rdv)
        {
            $data = array(
                'id'=> $rdv['id_rdv'],
                'desc'=> $rdv['desc_rdv'],
                'creat'=> $rdv['creat_rdv'],
                'mod'=> $rdv['mod_rdv'],
                'commande'=> $rdv['commande'],
            );
            $item = new rdvCommandeClass($data);
            $this->addRdv($item);
        }
    }

    public function getRdvAgence($agence, $debut , $fin)
    {
        $query = $this->getBdd()->prepare("
            SELECT * FROM rdv r 
                JOIN commande c ON r.commande=c.id_commande 
                JOIN client cl ON c.client=cl.id_client
                WHERE cl.agence =:agence AND creat_rdv BETWEEN :debut AND :fin
                     ORDER BY id_rdv DESC
        ");
        $query->bindValue(":agence", $agence);
        $query->bindValue(":debut", $debut);
        $query->bindValue(":fin", $fin);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();

        return $result;
    }

    public function getRdvsCommande($commande)
    {
        $rdvs_commande = [];
        if(!empty($this->rdvs )){
            foreach ($this->rdvs as $rdv){
                if($rdv->getCommande() === $commande->getIdCommande()){
                    array_push($rdvs_commande,$rdv);
                }
            }
        }
        return $rdvs_commande;
    }

    public function getRdvById($id)
    {
        foreach ($this->rdvs as $rdv){
            if($rdv->getIdRdv() === $id){
                return $rdv;
            }
        }
    }


    public function addRdvBd($data)
    {
        $query = "INSERT INTO rdv (desc_rdv, creat_rdv, mod_rdv,commande) 
                    VALUES (:desc,:creat,:mod,:commande)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":commande",$data['commande']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] =  $this->getBdd()->lastInsertId();
            $rdv = new rdvCommandeClass($data);
            $this->addRdv($rdv);
        }
    }

    public function updateRdvBD($data)
    {
        $query = "UPDATE rdv SET desc_rdv=:desc, mod_rdv=:mod WHERE id_rdv=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getRdvById($data['id'])->setDescRdv($data['desc']);
            $this->getRdvById($data['id'])->setModRdv($data['mod']);
        }
    }

    public function deleteRdvBD($id)
    {
        $query = "DELETE FROM rdv WHERE id_rdv=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $rdv = $this->getRdvById($id);
            unset($rdv);
        }
    }
}