<?php
require_once 'models/modelClass.php';
require_once 'models/personnel_ressource/personnelRessourceClass.php';

class personnelRessourceManager extends modelClass
{
    private $persRess;//Tableau de clients

    public function addPersRes($persRes)
    {
        $this->persRess[] = $persRes;
    }

    public function getPersRess()
    {
        return $this->persRess;
    }

    public function loadPersRes()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM personnel_ressource ps JOIN ressource r ON ps.ressource=r.id_res
                    WHERE r.agence=:agence ORDER BY  id_pers_res DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $allpersonnel = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allpersonnel as $pers)
        {
            $data = array(
                'id'=>$pers['id_pers_res'],
                'desc'=>$pers['desc_pers_res'],
                'personnel'=>$pers['personnel'],
                'ressource'=>$pers['ressource'],
                'creat'=>$pers['creat_pers_res'],
                'mod'=>$pers['mod_pers_res'],
            );
            $item = new personnelRessourceClass($data);
            $this->addPersRes($item);
        }
    }

    public function getPersonnels($ressource)
    {
        $data = [];
        if (!empty($this->persRess)){
            foreach ($this->persRess as $persRes){
                if($persRes->getRessource() === $ressource->getIdRes()){
                    array_push($data,$persRes);
                }
            }
        }
        return $data;
    }
    public function getPersResById($id)
    {
        if (!empty($this->persRess)){
            foreach ($this->persRess as $persRes){
                if($persRes->getIdPersRes() === $id){
                    return $persRes;
                }
            }
        }
    }

    public function getLastByRessource($ressource)
    {
        if (!empty($this->persRess)){
            foreach ($this->persRess as $persRes){
                if($persRes->getRessource() === $ressource){
                    return $persRes;
                }
            }
        }
    }

    public function addPersResBd($data)
    {
        $query = "INSERT INTO personnel_ressource (creat_pers_res, mod_pers_res, desc_pers_res, personnel, ressource) 
                   VALUES (:creat,:mod,:desc,:personnel,:ressource)";
        $stmt = $this->getBdd()->prepare($query);

        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":personnel",$data['personnel']);
        $stmt->bindValue(":ressource",$data['ressource']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $personnel = new personnelRessourceClass($data);
            $this->addPersRes($personnel);
        }
    }

    public function updatePersResBD($data)
    {
        $query = "UPDATE personnel_ressource SET desc_pers_res=:desc, personnel=:personnel, mod_pers_res=:mod WHERE id_pers_res=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":personnel",$data['personnel']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getPersResById($data['id'])->setDescPersRes($data['desc']);
            $this->getPersResById($data['id'])->setPersonnel($data['personnel']);
            $this->getPersResById($data['id'])->setModPersRes($data['mod']);
        }
    }
    public function updateModPersResBD($data)
    {
        $query = "UPDATE personnel_ressource SET mod_pers_res=:mod WHERE id_pers_res=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getPersResById($data['id'])->setModPersRes($data['mod']);
        }
    }

    public function deletePersResBD($id)
    {
        $query = "DELETE FROM personnel_ressource WHERE id_pers_res=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $personnel = $this->getPersResById($id);
            unset($personnel);
        }
    }
}