<?php

require_once "models/modelClass.php";
require_once "models/agence/agenceClass.php";

class agenceManager extends modelClass
{
    private $agences; //Tableau des agences

    public function addAgence($agence)
    {
        $this->agences[] = $agence;
    }
    public function getAgences()
    {
        return $this->agences;
    }

    public function loadAgence()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM agence");
        $query->execute();
        $allAgence = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allAgence as $agence)
        {
            $data = array(
                'id'=> $agence['id_agence'],
                'nom'=> $agence['nom_agence'],
                'contact'=> $agence['contact_agence'],
                'adresse'=> $agence['adresse_agence'],
                'email'=> $agence['email_agence'],
                'bp'=> $agence['boite_postale_agence'],
                'ifu'=> $agence['ifu_agence'],
                'rccm'=> $agence['rccm_agence'],
                'df'=> $agence['division_fiscal_agence'],
                'ri'=> $agence['regime_imposition_agence'],
                'statut'=> $agence['statut_agence'],
                'creat'=> $agence['creat_agence'],
                'mod'=> $agence['mod_agence']
            );
            $item = new agenceClass($data);
            $this->addAgence($item);
        }
    }

    public function getAgenceById($id)
    {
        if(!empty($this->agences)){
            foreach ($this->agences as $agence){
                if($agence->getIdAgence() === $id){
                    return $agence;
                }
            }
        }
    }

    public function addAgenceBd($data)
    {
        $query = "INSERT INTO agence (nom_agence,contact_agence,adresse_agence,email_agence,boite_postale_agence,ifu_agence,
                    rccm_agence,division_fiscal_agence,regime_imposition_agence, statut_agence, creat_agence, mod_agence) 
                    VALUES (:nom,:contact,:adresse,:email,:bp,:ifu,:rccm,:df,:ri,:statut,:creat,:mod)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(":contact",$data['contact']);
        $stmt->bindValue(":adresse",$data['adresse'], PDO::PARAM_STR);
        $stmt->bindValue(":email",$data['email'], PDO::PARAM_STR);
        $stmt->bindValue(":bp",$data['bp'], PDO::PARAM_STR);
        $stmt->bindValue(":ifu",$data['ifu'], PDO::PARAM_STR);
        $stmt->bindValue(":rccm",$data['rccm'], PDO::PARAM_STR);
        $stmt->bindValue(":df",$data['df'], PDO::PARAM_STR);
        $stmt->bindValue(":ri",$data['ri'], PDO::PARAM_STR);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":statut",$data['statut']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $agence = new agenceClass($data);
            $this->addAgence($agence);
        }
    }

    public function updateAgenceBD($data)
    {
        $query = "UPDATE agence SET nom_agence=:nom, contact_agence=:contact, adresse_agence=:adresse,email_agence=:email,
                  boite_postale_agence=:bp, ifu_agence=:ifu,rccm_agence=:rccm,division_fiscal_agence=:df,
                  regime_imposition_agence=:ri, mod_agence=:mod, statut_agence=:statut WHERE id_agence=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom']);
        $stmt->bindValue(":contact",$data['contact']);
        $stmt->bindValue(":adresse",$data['adresse']);
        $stmt->bindValue(":email",$data['email'], PDO::PARAM_STR);
        $stmt->bindValue(":bp",$data['bp'], PDO::PARAM_STR);
        $stmt->bindValue(":ifu",$data['ifu'], PDO::PARAM_STR);
        $stmt->bindValue(":rccm",$data['rccm'], PDO::PARAM_STR);
        $stmt->bindValue(":df",$data['df'], PDO::PARAM_STR);
        $stmt->bindValue(":ri",$data['ri'], PDO::PARAM_STR);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":statut",$data['statut']);
        $stmt->bindValue(":id",$data['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $this->getAgenceById($data['id'])->setNomAgence($data['nom']);
            $this->getAgenceById($data['id'])->setContactAgence($data['contact']);
            $this->getAgenceById($data['id'])->setAdresseAgence($data['adresse']);
            $this->getAgenceById($data['id'])->setEmailAgence($data['email']);
            $this->getAgenceById($data['id'])->setBoitePostaleAgence($data['bp']);
            $this->getAgenceById($data['id'])->setIfuAgence($data['ifu']);
            $this->getAgenceById($data['id'])->setRccmAgence($data['rccm']);
            $this->getAgenceById($data['id'])->setDivisionFiscaleAgence($data['df']);
            $this->getAgenceById($data['id'])->setRegimeImpositionAgence($data['ri']);
            $this->getAgenceById($data['id'])->setStatutAgence($data['statut']);
            $this->getAgenceById($data['id'])->setModAgence($data['mod']);
        }
    }

    public function deleteAgenceBD($id)
    {
        $query = "DELETE FROM agence WHERE id_agence=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $agence = $this->getAgenceById($id);
            unset($agence);
        }
    }

}