<?php
require_once "models/modelClass.php";
require_once 'models/client/paiement/paiementClass.php';

class paiementClientManager extends modelClass
{
    private $paiements;//Tableau de paiements

    public function addPaiement($paiement)
    {
        $this->paiements[] = $paiement;
    }

    public function getPaiements()
    {
        return $this->paiements;
    }

    public function loadPaiement()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM paiement");
        $query->execute();
        $allPaiement = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allPaiement as $paiement)
        {
            $data = array(
                'id'=> $paiement['id_paie'],
                'somme'=> $paiement['somme_paie'],
                'type'=> $paiement['type_paie'],
                'desc'=> $paiement['desc_paie'],
                'creat'=> $paiement['creat_paie'],
                'mod'=> $paiement['mod_paie'],
                'commande'=> $paiement['commande']
            );
            $item = new PaiementClass($data);
            $this->addPaiement($item);
        }
    }

    public function getPaiementsCommande($commande)
    {
        $paiements_commande = [];
        if (!empty($this->paiements)){
            foreach ($this->paiements as $paiement){
                if($paiement->getCommande() === $commande->getIdCommande()){
                    array_push($paiements_commande,$paiement);
                }
            }
        }
        return $paiements_commande;
    }

    public function getPaiementsCommandeId($commande)
    {
        $paiements_commande = [];
        if (!empty($this->paiements)){
            foreach ($this->paiements as $paiement){
                if($paiement->getCommande() == $commande){
                    array_push($paiements_commande,$paiement);
                }
            }
        }
        return $paiements_commande;
    }
    public function getPaiementById($id)
    {
        foreach ($this->paiements as $paiement){
            if($paiement->getIdPaie() === $id){
                return $paiement;
            }
        }
    }

    public function addPaiementBd($data)
    {
        $query = "INSERT INTO paiement (somme_paie,type_paie,desc_paie,
                                                    creat_paie, mod_paie,commande) 
                    VALUES (:somme,:type,:desc,:creat,:mod,:commande)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":somme",$data['somme']);
        $stmt->bindValue(":type",$data['type']);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":commande",$data['commande']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] =  $this->getBdd()->lastInsertId();
            $paiement = new paiementClass($data);
            $this->addPaiement($paiement);
            return $data['id'];
        }
    }

    public function updatePaiementBD($data)
    {
        $query = "UPDATE paiement SET somme_paie=:somme, type_paie=:type, desc_paie=:desc,
                  mod_paie=:mod WHERE id_paie=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":somme",$data['somme']);
        $stmt->bindValue(":type",$data['type']);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":id",$data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getPaiementById($data['id'])->setSommePaie($data['somme']);
            $this->getPaiementById($data['id'])->setTypePaie($data['type']);
            $this->getPaiementById($data['id'])->setDescPaie($data['desc']);
            $this->getPaiementById($data['id'])->setModPaie($data['mod']);
        }
    }

    public function deletePaiementBD($id)
    {
        $query = "DELETE FROM paiement WHERE id_paie=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $paiement = $this->getPaiementById($id);
            unset($paiement);
        }
    }
}