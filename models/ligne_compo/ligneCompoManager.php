<?php
    require_once 'models/modelClass.php';
    require_once 'models/ligne_compo/ligneModeleCompClass.php';

class ligneCompoManager extends modelClass{

    //Tableau des compositions
    private $ligneCompos;

    public function addLigneCompo($ligneCompo)
    {
        $this->ligneCompos[] = $ligneCompo;
    }

    public function getLigneCompos()
    {
        return $this->ligneCompos;
    }

    public function loadLigneCompos()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM ligne_compo ORDER BY id_mod_comp DESC");
        $query->execute();
        $allpaies = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allpaies as $paies)
        {
            $data = array(
                'id'=> $paies['id_mod_comp'],
                'modele'=> $paies['modele'],
                'modele_comp'=> $paies['modele_comp'],
                'creat'=> $paies['creat_mod_comp'],
                'mod'=> $paies['mod_comp'],
            );
            $item = new ligneModeleCompClass($data);
            $this->addLigneCompo($item);
        }
    }

    public function getLigneById($id)
    {
        if(!empty($this->ligneCompos)){
            foreach ($this->ligneCompos as $ligne){
                if($ligne->getIdModComp() == $id){
                    return $ligne;
                }
            }
        }
    }

    public function getLigneByModeleCompo($modCompo)
    {
        $lignes = [];
        if(!empty($this->ligneCompos)){
            foreach ($this->ligneCompos as $compo){
                if($compo->getModeleComp() === $modCompo){
                    array_push($lignes,$compo);
                }
            }
        }
        return $lignes;
    }

    public function getLigneByModele($modele)
    {
        $lignes = [];
        if(!empty($this->ligneCompos)){
            foreach ($this->ligneCompos as $compo){
                if($compo->getIdModComp() == $modele){
                    array_push($lignes,$compo);
                }
            }
        }
        return $lignes;
    }

    public function addLigneCompoBd($data)
    {
        $query = "INSERT INTO ligne_compo (modele, modele_comp, creat_mod_comp, mod_comp)
                        VALUES (:model,:comp,:creat,:mod)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":model", $data['modele']);
        $stmt->bindValue(":comp", $data['modele_comp']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] = $this->getBdd()->lastInsertId();
            $modele = new ligneModeleCompClass($data);
            $this->addLigneCompo($modele);
        }
    }

    public function updateLigneCompoBD($data_modele)
    {
        $query = "UPDATE ligne_compo SET modele=:modele, mod_comp=:mod WHERE id_mod_comp=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":modele",$data_modele['modele']);
        $stmt->bindValue(":mod",$data_modele['mod']);
        $stmt->bindValue(":id",$data_modele['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $this->getLigneById($data_modele['id'])->setModele($data_modele['modele']);
            $this->getLigneById($data_modele['id'])->setMod($data_modele['mod']);
        }
    }

    public function deleteLigneCompoBD($id)
    {
        $query = "DELETE FROM ligne_compo WHERE id_mod_comp=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $ligneCompo = $this->getLigneById($id);
            unset($ligneCompo);
        }
    }

}


?>