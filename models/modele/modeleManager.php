<?php
require_once "models/modelClass.php";
require_once "models/modele/modeleClass.php";

class modeleManager extends modelClass
{
    private $modeles;//Tableau de modeles

    public function addModele($modele)
    {
        $this->modeles[] = $modele;
    }

    public function getModeles()
    {
        return $this->modeles;
    }

    public function loadModele()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM modele ORDER BY id_modele DESC ");
        $query->execute();
        $allModele = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allModele as $modele)
        {
            $data = array(
                'id'=> $modele['id_modele'],
                'desc'=> $modele['desc_modele'],
                'nom'=> $modele['nom_modele'],
                'recto'=> $modele['recto_modele'],
                'verso'=> $modele['verso_modele'],
                'creat'=> $modele['creat_modele'],
                'mod'=> $modele['mod_modele'],
                'prix'=> $modele['prix_modele'],
                'cout'=> $modele['cout_modele'],
                'cout_decoup'=> $modele['cout_decoup_modele'],
            );
            $item = new modeleClass($data);
            $this->addModele($item);
        }
    }

    public function getModeleById($id)
    {
        if(!empty($this->modeles)){
            foreach ($this->modeles as $modele){
                if($modele->getIdModele() === $id){
                    return $modele;
                }
            }
        }
    }

    public function addModeleBd($data_modele)
    {
        $query = "INSERT INTO modele (nom_modele,desc_modele,recto_modele,verso_modele, creat_modele, mod_modele, prix_modele,cout_modele, cout_decoup_modele) 
                    VALUES (:nom,:desc,:recto,:verso,:creat,:mod, :prix,:cout,:cout_decoup)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data_modele['nom']);
        $stmt->bindValue(":desc",$data_modele['desc']);
        $stmt->bindValue(":recto",$data_modele['recto']);
        $stmt->bindValue(":verso",$data_modele['verso']);
        $stmt->bindValue(":creat",$data_modele['creat']);
        $stmt->bindValue(":mod",$data_modele['mod']);
        $stmt->bindValue(":prix",$data_modele['prix']);
        $stmt->bindValue(":cout",$data_modele['cout']);
        $stmt->bindValue(":cout_decoup",$data_modele['cout_decoup']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data_modele['id'] = $this->getBdd()->lastInsertId();
            $modele = new modeleClass($data_modele);
            $this->addModele($modele);
            return $data_modele['id'];
        }
    }

    public function updateModeleBD($data_modele)
    {
        $query = "UPDATE modele SET nom_modele=:nom, desc_modele=:desc, recto_modele=:recto, verso_modele=:verso,
                  mod_modele=:mod,prix_modele=:prix, cout_modele=:cout, cout_decoup_modele=:cout_decoup WHERE id_modele=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data_modele['nom'], PDO::PARAM_STR);
        $stmt->bindValue(":desc",$data_modele['desc'], PDO::PARAM_STR);
        $stmt->bindValue(":recto",$data_modele['recto'], PDO::PARAM_STR);
        $stmt->bindValue(":verso",$data_modele['verso'], PDO::PARAM_STR);
        $stmt->bindValue(":mod",$data_modele['mod']);
        $stmt->bindValue(":prix",$data_modele['prix']);
        $stmt->bindValue(":cout",$data_modele['cout']);
        $stmt->bindValue(":cout_decoup",$data_modele['cout_decoup']);
        $stmt->bindValue(":id",$data_modele['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $this->getModeleById($data_modele['id'])->setNomModele($data_modele['nom']);
            $this->getModeleById($data_modele['id'])->setDescModele($data_modele['desc']);
            $this->getModeleById($data_modele['id'])->setRectoModele($data_modele['recto']);
            $this->getModeleById($data_modele['id'])->setVersoModele($data_modele['verso']);
            $this->getModeleById($data_modele['id'])->setPrixModele($data_modele['prix']);
            $this->getModeleById($data_modele['id'])->setCoutModele($data_modele['cout']);
            $this->getModeleById($data_modele['id'])->setCoutDecoupModele($data_modele['cout_decoup']);
            $this->getModeleById($data_modele['id'])->setModmodele($data_modele['mod']);
        }
    }

    public function deleteModeleBD($id)
    {
        $query = "DELETE FROM modele WHERE id_modele=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $modele = $this->getModeleById($id);
            unset($modele);
        }
    }
}