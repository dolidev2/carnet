<?php
require_once "models/modelClass.php";
require_once "models/client/tissu/tissuClientClass.php";

class tissuClientManager extends modelClass {

    private $tissus; //Tableau de tissus

    public function addTissu($tissu)
    {
        $this->tissus[] = $tissu;
    }

    public function getTissusClient($client)
    {
        $tissus_client = [];
        if(!empty($this->tissus)){
            foreach ($this->tissus as $tissu){
                if($tissu->getClient() === $client->getIdClient()){
                    array_push($tissus_client,$tissu);
                }
            }
        }

        return $tissus_client;
    }

    public function getTissus()
    {

        return $this->tissus;

    }

    public function getTissuById($id)
    {
        foreach ($this->tissus as $tissu){
            if($tissu->getIdTissu() === $id){
                return $tissu;
            }
        }
    }

    public function loadTissu()
    {
        $query ="SELECT * FROM tissu";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->execute();
        $allTissu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allTissu as $tissu)
        {
            $data = array(
                'id' => $tissu['id_tissu'],
                'nom' => $tissu['nom_tissu'],
                'desc' => $tissu['desc_tissu'],
                'quantite' => $tissu['quantite_tissu'],
                'prix' => $tissu['prix_tissu'],
                'com' => $tissu['commission_tissu'],
                'creat' => $tissu['creat_tissu'],
                'mod' => $tissu['mod_tissu'],
                'statut' => $tissu['statut_tissu'],
                'client' => $tissu['client']
            );
            $item = new tissuClientClass($data);
            $this->addTissu($item);
        }
    }

    public function getTissuAchete($agence,$debut, $fin)
    {
        $query ="SELECT * FROM tissu t
                    JOIN client c ON t.client=c.id_client
                    WHERE prix_tissu !=0 AND agence=:agence AND creat_tissu BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':agence' , $agence);
        $stmt->bindValue(':debut' , $debut);
        $stmt->bindValue(':fin' , $fin);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $results;
    }

    public function getTissuAcheteByClient($agence,$debut, $fin)
    {
        $query ="SELECT SUM(prix_tissu) as total ,SUM(commission_tissu) as commission, 
                    nom_client, prenom_client, contact_client FROM tissu t
                    JOIN client c ON t.client=c.id_client
                    WHERE prix_tissu !=0 AND agence=:agence AND creat_tissu BETWEEN :debut AND :fin 
                    GROUP BY nom_client, prenom_client";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':agence' , $agence);
        $stmt->bindValue(':debut' , $debut);
        $stmt->bindValue(':fin' , $fin);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $results;
    }

    public function addTissuBD($data)
    {
        $query = "INSERT INTO tissu(nom_tissu,desc_tissu, quantite_tissu, prix_tissu,commission_tissu,creat_tissu,mod_tissu,statut_tissu,client)
                    VALUES (:nom,:desc,:quantite,:prix,:com,:creat, :mod,:statut,:client)";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':nom' , $data['nom']);
        $stmt->bindValue(':desc' , $data['desc']);
        $stmt->bindValue(':quantite' , $data['quantite']);
        $stmt->bindValue(':prix' , $data['prix']);
        $stmt->bindValue(':com' , $data['com']);
        $stmt->bindValue(':creat' , $data['creat']);
        $stmt->bindValue(':mod' , $data['mod']);
        $stmt->bindValue(':statut' , $data['statut']);
        $stmt->bindValue(':client' , $data['client']);

        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $data['id'] = $this->getBdd()->lastInsertId();
            $tissu = new tissuClientClass($data);
            $this->addTissu($tissu);
            return $data['id'];
        }
    }

    public function updateTissuBd($data)
    {
        $query = "UPDATE tissu SET nom_tissu=:nom, desc_tissu=:desc, quantite_tissu=:quantite,
                 prix_tissu=:prix, commission_tissu=:com ,mod_tissu=:mod WHERE id_tissu=:id ";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':nom' , $data['nom']);
        $stmt->bindValue(':desc' , $data['desc']);
        $stmt->bindValue(':quantite' , $data['quantite']);
        $stmt->bindValue(':prix' , $data['prix']);
        $stmt->bindValue(':com' , $data['com']);
        $stmt->bindValue(':mod' , $data['mod']);
        $stmt->bindValue(':id' , $data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result > 0){
            $this->getTissuById($data['id'])->setNomTissu($data['nom']);
            $this->getTissuById($data['id'])->setDescTissu($data['desc']);
            $this->getTissuById($data['id'])->setQuantiteTissu($data['quantite']);
            $this->getTissuById($data['id'])->setPrixTissu($data['prix']);
            $this->getTissuById($data['id'])->setCommissionTissu($data['prix']);
            $this->getTissuById($data['id'])->setModTissu($data['mod']);
        }
    }

    public function updateTissuStatutBd($data)
    {
        $query = "UPDATE tissu SET statut_tissu=:statut, mod_tissu=:mod WHERE id_tissu=:id ";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':statut' , $data['statut']);
        $stmt->bindValue(':mod' , $data['mod']);
        $stmt->bindValue(':id' , $data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result > 0){
            $this->getTissuById($data['id'])->setStatutTissu($data['statut']);
            $this->getTissuById($data['id'])->setModTissu($data['mod']);
        }
    }

    public function deleteTissuBD($id)
    {
        $query = "DELETE FROM tissu WHERE id_tissu=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':id' , $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $tissu = $this->getTissuById($id);
            unset($tissu);
        }
    }

}