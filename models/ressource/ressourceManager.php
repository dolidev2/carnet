<?php

require_once "models/modelClass.php";
require_once "models/ressource/ressourceClass.php";

class ressourceManager extends modelClass
{
    private $ressources;//Tableau de ressources

    public function addRessource($ressource)
    {
        $this->ressources[] = $ressource;
    }

    public function getRessources()
    {
        return $this->ressources;
    }

    public function loadRessource()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM ressource WHERE agence=:agence ORDER BY id_res DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $allRessource = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allRessource as $res)
        {
            $data = array(
                'id'=>$res['id_res'],
                'nom'=>$res['nom_res'],
                'desc'=>$res['desc_res'],
                'creat'=>$res['creat_res'],
                'mod'=>$res['mod_res'],
                'image'=>$res['image_res'],
                'agence'=>$res['agence'],
            );
            $item = new ressourceClass($data);
            $this->addRessource($item);
        }
    }

    public function getRessourceById($id)
    {
        if (!empty($this->ressources)){
            foreach ($this->ressources as $ressource){
                if($ressource->getIdRes() == $id){
                    return $ressource;
                }
            }
        }
    }

    public function addRessourceBd($data)
    {
        $query = "INSERT INTO ressource (nom_res,desc_res, creat_res, mod_res,
                       image_res, agence) 
                    VALUES (:nom,:desc,:creat,:mod,:image, :agence)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom']);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":image",$data['image']);
        $stmt->bindValue(":agence",$data['agence']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $ressource = new ressourceClass($data);
            $this->addRessource($ressource);
        }
    }

    public function updateRessourceBD($data)
    {
        $query = "UPDATE ressource SET  nom_res=:nom, desc_res=:desc, mod_res=:mod,
                  image_res=:image, agence=:agence WHERE id_res=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom']);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":image",$data['image']);
        $stmt->bindValue(":agence",$data['agence']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getRessourceById($data['id'])->setNomRes($data['nom']);
            $this->getRessourceById($data['id'])->setDescRes($data['desc']);
            $this->getRessourceById($data['id'])->setModRes($data['mod']);
            $this->getRessourceById($data['id'])->setImageRes($data['image']);
            $this->getRessourceById($data['id'])->setAgence($data['agence']);
        }
    }

    public function deleteRessourceBD($id)
    {
        $query = "DELETE FROM ressource WHERE id_res=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $ressource = $this->getRessourceById($id);
            unset($ressource);
        }
    }

    public function ressourcePeriodAgence($agence, $debut, $fin)
    {
        $query = " SELECT DISTINCT id_res, nom_res, desc_res FROM ressource r JOIN stock s ON r.id_res=s.ressource
                    WHERE  agence=:agence AND s.creat_stock BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function stockPeriodAgence($ressource, $debut, $fin)
    {
        $query = " SELECT * FROM stock 
                    WHERE  ressource=:ressource AND creat_stock BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->bindValue(":ressource",$ressource);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }



}