<?php

require_once 'models/modelClass.php';
require_once 'models/client/commande/commandeClientClass.php';

class commandeClientManager extends modelClass
{
    private $commandes;//Tableau de commandes

    public function addCommande($commande)
    {
        $this->commandes[] = $commande;
    }

    public function getCommandes()
    {
        return $this->commandes;
    }



    public function loadCommande()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM commande c, client cl 
                    WHERE c.client=cl.id_client AND cl.agence=:agence
                    ORDER BY id_commande DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $allcommande = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allcommande as $commande)
        {
            $data = array(
                'id'=>$commande['id_commande'],
                'desc'=>$commande['desc_commande'],
                'creat'=>$commande['creat_commande'],
                'mod'=>$commande['mod_commande'],
                'statut'=>$commande['statut_commande'],
                'rdv'=>$commande['rdv_commande'],
                'client'=>$commande['id_client'],
            );
            $item = new commandeClientClass($data);
            $this->addCommande($item);
        }
    }

    public function getCommandeFromClient($debut,$fin,$client)
    {

        $query = "SELECT * FROM commande WHERE client=:client  AND creat_commande BETWEEN :debut AND :fin  ORDER BY id_commande DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client",$client);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $results;
    }

    public function getCommandeFromYear($debut,$fin)
    {
        $query = "SELECT * FROM commande WHERE creat_commande BETWEEN :debut AND :fin ORDER BY id_commande DESC LIMIT 0,1";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    //Chiffre d'affaire couture client periode
    public function loadCoutureClientPeriode($data)
    {
        $query ="SELECT SUM(somme_paie) as somme FROM paiement p, commande cmd WHERE 
                    cmd.id_commande=p.commande AND cmd.client=:client AND p.creat_paie BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client",$data['client']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

       return $result;
    }

    public function loadFrequenceCouturePeriodId($data)
    {
        $query ="SELECT cmt.tissu FROM commande c, commande_modele_tissu cmt WHERE 
                c.id_commande = cmt.commande AND c.client =:client AND c.creat_commande BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client",$data['client']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

       return $result;
    }

    public function loadCoutureDepensePeriod($data)
    {
        $query ="SELECT rend_prod, somme_prod,quantite_prod FROM commande c, commande_modele_tissu cmt, production p WHERE 
                c.id_commande = cmt.commande AND cmt.id_cmt = p.cmt  AND c.client =:client AND c.creat_commande BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client",$data['client']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }
    public function loadCoutureDepensePeriodByModele($data)
    {
        $query ="SELECT rend_prod, somme_prod,quantite_prod FROM commande c, commande_modele_tissu cmt, production p, modele m WHERE 
                    m.id_modele = cmt.modele AND c.id_commande = cmt.commande AND cmt.id_cmt = p.cmt  AND c.client =:client AND
                    m.id_modele=:modele AND c.creat_commande BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":modele",$data['modele']);
        $stmt->bindValue(":client",$data['client']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadChiffreAffaire($data)
    {
        $query ="SELECT SUM(somme_caisse) as somme FROM caisse WHERE 
                    type_caisse=:type_cais AND creat_caisse BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":type_cais",$data['type']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }




    //Chiffre d'affaire tissu client periode
    public function loadTissuClientPeriod($data)
    {
        $query ="SELECT * FROM commande c, tissu t, client cl WHERE 
                t.client = cl.id_client AND c.client = cl.id_client AND cl.id_client =:client 
                AND t.commission_tissu != 0 AND c.creat_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client",$data['client']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadProfitCouture($data)
    {
        $query ="SELECT m.id_modele, m.nom_modele ,SUM(cmt.prix_cmt)  as profit FROM commande c, commande_modele_tissu cmt ,modele m WHERE 
                c.id_commande = cmt.commande AND cmt.modele = m.id_modele AND c.client =:client AND c.creat_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client",$data['client']);
        $stmt->bindValue(":debut",$data['debut']);
        $stmt->bindValue(":fin",$data['fin']);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadCommandeDetail($id)
    {
        $query ="SELECT * FROM commande c, commande_modele_tissu cmt ,modele m, tissu t
                 WHERE c.id_commande = cmt.commande AND cmt.modele=m.id_modele AND t.id_tissu=cmt.tissu
                 AND c.id_commande =:commande";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadCommandeDetailComposition($id)
    {
        $query ="SELECT * FROM commande c, commande_modele_tissu cmt ,modele_composition m, tissu t
                 WHERE c.id_commande = cmt.commande AND cmt.modele=m.id_mod_comp AND t.id_tissu=cmt.tissu
                 AND c.id_commande =:commande";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadCoutTotalCouture($id)
    {
        $query ="SELECT SUM(cmt.prix_cmt) as somme  FROM commande c, commande_modele_tissu cmt
                 WHERE c.id_commande = cmt.commande AND c.id_commande =:commande";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$id);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getRdvPeriodAgence($agence, $debut, $fin)
    {
        $query ="SELECT * FROM commande c JOIN client cl ON c.client=cl.id_client
                 WHERE  cl.agence=:agence AND rdv_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getCommandesClient($client)
    {
        $commandes_client = [];
        if(!empty($this->commandes)){
            foreach ($this->commandes as $commande){
                if($commande->getClient() === $client->getIdClient()){
                    array_push($commandes_client,$commande);
                }
            }
        }
        return $commandes_client;
    }

    public function getCommandeById($id)
    {
        if (!empty($this->commandes)){
            foreach ($this->commandes as $commande){
                if($commande->getIdCommande() === $id){
                    return $commande;
                }
            }
        }
    }

    public function addCommandeBd($data_commande)
    {
        $query = "INSERT INTO commande (desc_commande,creat_commande,mod_commande, rdv_commande,
                    statut_commande, client) 
                    VALUES (:desc,:creat,:mod,:rdv,:statut,:client)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data_commande['desc']);
        $stmt->bindValue(":creat",$data_commande['creat']);
        $stmt->bindValue(":mod",$data_commande['mod']);
        $stmt->bindValue(":rdv",$data_commande['rdv']);
        $stmt->bindValue(":statut",$data_commande['statut']);
        $stmt->bindValue(":client",$data_commande['client']);

        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data_commande['id'] = $this->getBdd()->lastInsertId();
            $commande = new commandeClientClass($data_commande);
            $this->addCommande($commande);
        }
    }

    public function updateCommandeBD($data)
    {
        $query = "UPDATE commande SET desc_commande=:desc, rdv_commande=:rdv, statut_commande=:statut,  creat_commande=:creat, mod_commande=:mod WHERE id_commande=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":statut",$data['statut']);
        $stmt->bindValue(":rdv",$data['rdv']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['mod']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getCommandeById($data['id'])->setDescCommande($data['desc']);
            $this->getCommandeById($data['id'])->setRdvCommande($data['rdv']);
            $this->getCommandeById($data['id'])->setModCommande($data['mod']);
            $this->getCommandeById($data['id'])->setCreatCommande($data['creat']);
            $this->getCommandeById($data['id'])->setStatutCommande($data['statut']);
        }
    }

    public function deleteCommandeBD($id)
    {
        $query = "DELETE FROM commande WHERE id_commande=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $commande = $this->getCommandeById($id);
            unset($commande);
        }
    }

}