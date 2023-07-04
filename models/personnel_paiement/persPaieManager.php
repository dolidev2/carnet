<?php
require_once 'models/modelClass.php';
require_once 'models/personnel_paiement/persPaieClass.php';

class persPaieManager extends modelClass
{
    private $paies; //Tableau de paies

    public function addPersPaie($paie)
    {
        $this->paies[] = $paie;
    }

    public function getPersPaiePersonnel($personnel)
    {
        $paies_personnel = [];
        if(!empty($this->paies)){
            foreach ($this->paies as $paie){
                if($paie->getPersonnel() === $personnel->getIdPers()){
                    array_push($paies_personnel,$paie);
                }
            }
        }

        return $paies_personnel;
    }

    public function getPersPaieById($id)
    {
        foreach ($this->paies as $paie){
            if($paie->getIdPersPaie() === $id){
                return $paie;
            }
        }
    }

    public function loadPersPaie()
    {
        $query ="SELECT * FROM personnel_paiement ORDER BY creat_pers_paie DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->execute();
        $allpaie = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allpaie as $paie)
        {
            $data = array(
                'id' => $paie['id_pers_paie'],
                'debut' => $paie['debut_pers_paie'],
                'fin' => $paie['fin_pers_paie'],
                'somme' => $paie['somme_pers_paie'],
                'creat' => $paie['creat_pers_paie'],
                'personnel' => $paie['personnel'],
            );
            $item = new persPaieClass($data);
            $this->addPersPaie($item);
        }
    }

    public function addPersPaieBD($data)
    {
        $query = "INSERT INTO personnel_paiement(debut_pers_paie,fin_pers_paie,somme_pers_paie, creat_pers_paie, personnel)
                    VALUES (:debut,:fin,:somme,:creat,:personnel)";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':debut' , $data['debut']);
        $stmt->bindValue(':fin' , $data['fin']);
        $stmt->bindValue(':somme' , $data['somme']);
        $stmt->bindValue(':personnel' , $data['personnel']);
        $stmt->bindValue(':creat' , $data['creat']);

        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $data['id'] = $this->getBdd()->lastInsertId();
            $paie = new persPaieClass($data);
            $this->addPersPaie($paie);

            return $data['id'];
        }
    }

    public function updateSommePersPaieBD($data)
    {
        $query = "UPDATE personnel_paiement SET somme_pers_paie=:somme WHERE id_pers_paie=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":somme",$data['somme']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getPersPaieById($data['id'])->setSommePersPaie($data['somme']);
        }
    }

    public function deletepaieBD($id)
    {
        $query = "DELETE FROM personnel_paiement WHERE id_pers_paie=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':id' , $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $paie = $this->getPersPaieById($id);
            unset($paie);
        }
    }
}