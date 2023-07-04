<?php

require_once 'models/modelClass.php';
require_once 'models/modele_personnel/modPersClass.php';

class modPersManager extends modelClass
{
    private $modPerss; //Tableau des modPerss

    public function addmodPers($modPers)
    {
        $this->modPerss[] = $modPers;
    }
    public function getmodPerss()
    {
        return $this->modPerss;
    }

    public function loadmodPers()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM modele_personnel");
        $query->execute();
        $allmodPers = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allmodPers as $modPers)
        {
            $data = array(
                'id'=> $modPers['id_mod_pers'],
                'qte'=> $modPers['qte_mod_pers'],
                'creat'=> $modPers['creat_mod_pers'],
                'personnel'=> $modPers['personnel'],
                'modele'=> $modPers['modele'],
            );
            $item = new modPersClass($data);
            $this->addmodPers($item);
        }
    }
    public function getPersonnels($personnel)
    {
        $personnels = [];
        if(!empty($this->modPerss)){
            foreach ($this->modPerss as $modPers){
                if($modPers->getPersonnel() === $personnel->getIdPers()){
                    array_push($personnels,$modPers);
                }
            }
        }
        return $personnels;
    }

    public function getModeles($modele)
    {
        $modeles = [];
        if(!empty($this->modPerss)){
            foreach ($this->modPerss as $modPers){
                if($modPers->getModele() === $modele->getIdModele()){
                    array_push($personnels,$modPers);
                }
            }
        }
        return $modeles;
    }

    public function getmodPersById($id)
    {
        if(!empty($this->modPerss)){
            foreach ($this->modPerss as $modPers){
                if($modPers->getIdmodPers() === $id){
                    return $modPers;
                }
            }
        }
    }

    public function addmodPersBd($data)
    {
        $query = "INSERT INTO modele_personnel (qte_mod_pers, creat_mod_pers, personnel,modele) 
                    VALUES (:qte, :creat, :personnel, :modele)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":qte",$data['qte']);
        $stmt->bindValue(":personnel",$data['personnel']);
        $stmt->bindValue(":modele",$data['modele']);
        $stmt->bindValue(":creat",$data['creat']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $modPers = new modPersClass($data);
            $this->addmodPers($modPers);
        }
    }

    public function updatemodPersBD($data)
    {
        $query = "UPDATE modele_personnel SET qte_mod_pers=:qte, modele=:modele,  creat_mod_pers=:creat WHERE id_mod_pers=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":qte",$data['qte']);
        $stmt->bindValue(":modele",$data['modele']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":id",$data['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getmodPersById($data['id'])->setQteModPers($data['qte']);
            $this->getmodPersById($data['id'])->setCreatModPers($data['creat']);
        }
    }

    public function deletemodPersBD($id)
    {
        $query = "DELETE FROM modele_personnel WHERE id_mod_pers=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $modPers = $this->getmodPersById($id);
            unset($modPers);
        }
    }

    public function getModelePersonnleDetail($personnel)
    {
        $query = "SELECT * FROM modele m 
                  JOIN modele_personnel mp ON m.id_modele = mp.modele
                  JOIN  personnel p   ON mp.personnel = p.id_pers 
                  WHERE p.id_pers =:personnel";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$personnel);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

}