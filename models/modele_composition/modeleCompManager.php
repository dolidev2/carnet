<?php
require_once 'models/modelClass.php';
require_once 'models/modele_composition/modeleCompClass.php';

class modeleCompManager extends modelClass
{

    private $modeles;//Tableau de modeles

    public function addModeleComp($modele)
    {
        $this->modeles[] = $modele;
    }

    public function getModelesComp()
    {
        return $this->modeles;
    }

    public function loadModeleComp()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM modele_composition ORDER BY id_mod_comp DESC ");
        $query->execute();
        $allModele = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allModele as $modele)
        {
            $data = array(
                'id'=> $modele['id_mod_comp'],
                'creat'=> $modele['creat_mod_comp'],
                'mod'=> $modele['mod_comp'],
                'nom'=> $modele['nom_mod_comp'],
                'desc'=> $modele['desc_mod_comp'],
                'recto'=> $modele['recto_mod_comp'],
                'verso'=> $modele['verso_mod_comp'],
                'prix'=> $modele['prix_mod_comp'],
            );
            $item = new modeleCompClass($data);
            $this->addModeleComp($item);
        }
    }

    public function getModeleCompById($id)
    {
        if(!empty($this->modeles)){
            foreach ($this->modeles as $modele){
                if($modele->getIdModComp() === $id){
                    return $modele;
                }
            }
        }
    }
    public function getModeleCompos($modeleId)
    {
        $data =[];
        if(!empty($this->modeles)){
            foreach ($this->modeles as $modele){
                if($modele->getModele() === $modeleId){
                   array_push($data, $modele);
                }
            }
        }
        return $data;
    }

    public function addModeleCompBd($data_modele)
    {
        $query = "INSERT INTO modele_composition (nom_mod_comp, desc_mod_comp, recto_mod_comp,
                                                    verso_mod_comp, prix_mod_comp,creat_mod_comp,mod_comp) 
                    VALUES (:nom, :desc, :recto, :verso, :prix, :creat, :mod)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":creat",$data_modele['creat']);
        $stmt->bindValue(":mod",$data_modele['mod']);
        $stmt->bindValue(":nom",$data_modele['nom']);
        $stmt->bindValue(":desc",$data_modele['desc']);
        $stmt->bindValue(":recto",$data_modele['recto']);
        $stmt->bindValue(":verso",$data_modele['verso']);
        $stmt->bindValue(":prix",$data_modele['prix']);

        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data_modele['id'] = $this->getBdd()->lastInsertId();
            $modele = new modeleCompClass($data_modele);
            $this->addModeleComp($modele);

            return $data_modele['id'];
        }
    }

    public function updateModeleCompBD($data_modele)
    {
        $query = "UPDATE modele_composition SET nom_mod_comp=:nom, mod_comp=:mod, desc_mod_comp=:desc,
                                                recto_mod_comp=:recto, verso_mod_comp=:verso, prix_mod_comp=:prix
                                                WHERE id_mod_comp=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data_modele['nom']);
        $stmt->bindValue(":mod",$data_modele['mod']);
        $stmt->bindValue(":desc",$data_modele['desc']);
        $stmt->bindValue(":recto",$data_modele['recto']);
        $stmt->bindValue(":verso",$data_modele['verso']);
        $stmt->bindValue(":prix",$data_modele['prix']);
        $stmt->bindValue(":id",$data_modele['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $this->getModeleCompById($data_modele['id'])->setNomModComp($data_modele['nom']);
            $this->getModeleCompById($data_modele['id'])->setDescModComp($data_modele['desc']);
            $this->getModeleCompById($data_modele['id'])->setRectoModComp($data_modele['recto']);
            $this->getModeleCompById($data_modele['id'])->setVersoModComp($data_modele['verso']);
            $this->getModeleCompById($data_modele['id'])->setPrixModComp($data_modele['prix']);
            $this->getModeleCompById($data_modele['id'])->setModComp($data_modele['mod']);
        }
    }

    public function deleteModeleCompBD($id)
    {
        $query = "DELETE FROM modele_composition WHERE id_mod_comp=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            unset($modele);
        }
    }
}