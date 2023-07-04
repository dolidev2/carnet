<?php
require_once "clientClass.php";
require_once "models/modelClass.php";

class clientManager extends modelClass
{
    private $clients;//Tableau de clients

    public function addClient($client)
    {
        $this->clients[] = $client;
    }

    public function getClients()
    {
     return $this->clients;
    }

    public function loadClient()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM client WHERE agence=:agence ORDER BY creat_client DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $allClient = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allClient as $client)
        {
            $item = new clientClass(
                $client['id_client'],$client['numero_mesure'],$client['nom_client'],$client['prenom_client'],$client['contact_client'],
                $client['adresse_client'],$client['type_client'], $client['boite_postal_client'],$client['ifu_client'],
                $client['rccm_client'],$client['division_fiscale_client'],$client['regime_imposition_client'],
                $client['creat_client'],$client['mod_client'],$client['client'],$client['agence']);
            $this->addClient($item);
        }
    }

    public function getClientById($id)
    {
        if (!empty($this->clients)){
            foreach ($this->clients as $client){
                if($client->getIdClient() === $id){
                    return $client;
                }
            }
        }
    }

    public function getClientFromAgence($agence)
    {

        $query = "SELECT * FROM client WHERE agence=:agence ORDER BY id_client DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $results;
    }


    public function addClientBd($data_client)
    {
        $query = "INSERT INTO client (numero_mesure,nom_client,prenom_client,contact_client, adresse_client,
                    type_client,boite_postal_client,ifu_client,rccm_client,division_fiscale_client,regime_imposition_client, 
                    creat_client, mod_client,client,agence) 
                    VALUES (:mesure,:nom,:prenom,:contact,:adresse,:type,:boite,:ifu,:rccm,:division,:regime,:creat,:mod, :client,:agence)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":mesure",$data_client['mesure'], PDO::PARAM_STR);
        $stmt->bindValue(":nom",$data_client['nom']);
        $stmt->bindValue(":prenom",$data_client['prenom'], PDO::PARAM_STR);
        $stmt->bindValue(":contact",$data_client['contact'], PDO::PARAM_STR);
        $stmt->bindValue(":adresse",$data_client['adresse'], PDO::PARAM_STR);
        $stmt->bindValue(":type",$data_client['type'], PDO::PARAM_STR);
        $stmt->bindValue(":boite",$data_client['boite'], PDO::PARAM_STR);
        $stmt->bindValue(":ifu",$data_client['ifu'], PDO::PARAM_STR);
        $stmt->bindValue(":rccm",$data_client['rccm'], PDO::PARAM_STR);
        $stmt->bindValue(":division",$data_client['division'], PDO::PARAM_STR);
        $stmt->bindValue(":regime",$data_client['regime'], PDO::PARAM_STR);
        $stmt->bindValue(":creat",$data_client['creat']);
        $stmt->bindValue(":mod",$data_client['creat']);
        $stmt->bindValue(":client",$data_client['client'], PDO::PARAM_INT);
        $stmt->bindValue(":agence",$data_client['agence'], PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $client = new clientClass(
                $this->getBdd()->lastInsertId(),$data_client['mesure'],$data_client['nom'],$data_client['prenom'],$data_client['contact'],
                $data_client['adresse'],$data_client['type'],$data_client['boite'],$data_client['ifu'],$data_client['rccm'],$data_client['division'],
                $data_client['regime'], $data_client['creat'],$data_client['creat'],$data_client['client'],$data_client['agence']
            );
            $this->addClient($client);
        }
    }

    public function updateClientBD($data_client)
    {
        $query = "UPDATE client SET numero_mesure=:mesure, nom_client=:nom, prenom_client=:prenom, contact_client=:contact,
                  adresse_client=:adresse,type_client=:type, boite_postal_client=:boite,ifu_client=:ifu,rccm_client=:rccm,
                  division_fiscale_client=:division,regime_imposition_client=:regime, creat_client=:creat, mod_client=:mod,
                  client=:client, agence=:agence WHERE id_client=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":mesure",$data_client['mesure'], PDO::PARAM_STR);
        $stmt->bindValue(":nom",$data_client['nom']);
        $stmt->bindValue(":prenom",$data_client['prenom'], PDO::PARAM_STR);
        $stmt->bindValue(":contact",$data_client['contact'], PDO::PARAM_STR);
        $stmt->bindValue(":adresse",$data_client['adresse'], PDO::PARAM_STR);
        $stmt->bindValue(":type",$data_client['type'], PDO::PARAM_STR);
        $stmt->bindValue(":boite",$data_client['boite'], PDO::PARAM_STR);
        $stmt->bindValue(":ifu",$data_client['ifu'], PDO::PARAM_STR);
        $stmt->bindValue(":rccm",$data_client['rccm'], PDO::PARAM_STR);
        $stmt->bindValue(":division",$data_client['division'], PDO::PARAM_STR);
        $stmt->bindValue(":regime",$data_client['regime'], PDO::PARAM_STR);
        $stmt->bindValue(":id",$data_client['id']);
        $stmt->bindValue(":creat",$data_client['creat']);
        $stmt->bindValue(":mod",$data_client['mod']);
        $stmt->bindValue(":client",$data_client['client'], PDO::PARAM_INT);
        $stmt->bindValue(":agence",$data_client['agence'], PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getClientById($data_client['id'])->setNumeroMesure($data_client['mesure']);
            $this->getClientById($data_client['id'])->setNomClient($data_client['nom']);
            $this->getClientById($data_client['id'])->setPrenomClient($data_client['prenom']);
            $this->getClientById($data_client['id'])->setContactClient($data_client['contact']);
            $this->getClientById($data_client['id'])->setAdresseClient($data_client['adresse']);
            $this->getClientById($data_client['id'])->setTypeClient($data_client['type']);
            $this->getClientById($data_client['id'])->setBoitePostalClient($data_client['boite']);
            $this->getClientById($data_client['id'])->setIfuClient($data_client['ifu']);
            $this->getClientById($data_client['id'])->setRccmClient($data_client['rccm']);
            $this->getClientById($data_client['id'])->setDivisionFiscaleClient($data_client['division']);
            $this->getClientById($data_client['id'])->setRegimeImpositionClient($data_client['regime']);
            $this->getClientById($data_client['id'])->setModClient($data_client['mod']);
            $this->getClientById($data_client['id'])->setCreatClient($data_client['creat']);
            $this->getClientById($data_client['id'])->setClient($data_client['client']);
            $this->getClientById($data_client['id'])->setAgence($data_client['agence']);
        }
    }

    public function deleteClientBD($id)
    {
        $query = "DELETE FROM client WHERE id_client=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $client = $this->getClientById($id);
            unset($client);
        }
    }

    public function getClientFromYear($debut,$fin)
    {
        $query = "SELECT * FROM client WHERE creat_client BETWEEN :debut AND :fin ORDER BY id_client DESC LIMIT 0,1";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getClientAgencePeriod($agence,$debut,$fin)
    {
        $query = "SELECT * FROM client WHERE agence = :agence AND creat_client BETWEEN :debut AND :fin  ORDER BY creat_client DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }


}