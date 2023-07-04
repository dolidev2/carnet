<?php

require_once 'models/modelClass.php';
require_once 'models/paie_personnel/paiePersonnelClass.php';

class paiePersonnelManager extends modelClass
{

    private $paiess;//Tableau de paiess

    public function addPaies($paies)
    {
        $this->paiess[] = $paies;
    }

    public function getPaiess()
    {
        return $this->paiess;
    }

    public function loadPaies()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM paie_personnel ORDER BY id_paie_pers DESC");
        $query->execute();
        $allpaies = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allpaies as $paies)
        {
            $data = array(
                'id'=> $paies['id_paie_pers'],
                'somme'=> $paies['somme_paie_pers'],
                'creat'=> $paies['creat_paie_pers'],
                'personnel'=> $paies['personnel'],
            );
            $item = new paiePersonnelClass($data);
            $this->addPaies($item);
        }
    }

    public function getPaiesById($id)
    {
        if(!empty($this->paiess)){
            foreach ($this->paiess as $paies){
                if($paies->getIdPaiePers() === $id){
                    return $paies;
                }
            }
        }
    }

    public function getPaiesByPersonnel($pers)
    {
        $paie_pers = [];
        if(!empty($this->paiess)){
            foreach ($this->paiess as $paies){
                if($paies->getPersonnel() === $pers->getIdPers()){
                    array_push($paie_pers,$paies);
                }
            }
        }
        return $paie_pers;
    }

    public function addpaiesBd($data)
    {
        $query = "INSERT INTO paie_personnel (somme_paie_pers,creat_paie_pers,personnel) 
                    VALUES (:somme,:creat,:personnel)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":somme",$data['somme']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":personnel",$data['personnel']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $modele = new paiePersonnelClass($data);
            $this->addPaies($modele);
        }
    }

    public function deleteModeleBD($id)
    {
        $query = "DELETE FROM paie_personnel WHERE id_paie_pers=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $paies = $this->getPaiesById($id);
            unset($paies);
        }
    }

}