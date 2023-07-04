<?php

require_once 'models/modelClass.php';
require_once 'models/caisse/caisseClass.php';

class caisseManager extends modelClass
{
    private $caisses; //Tableau des caisses

    public function addCaisse($caisse)
    {
        $this->caisses[] = $caisse;
    }

    public function getCaisses()
    {
        return $this->caisses;
    }

    public function loadCaisse()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence'])) ? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM caisse WHERE agence=:agence ORDER BY id_caisse DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence", $agence);
        $stmt->execute();
        $allcaisse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allcaisse as $caisse) {
            $data = array(
                'id' => $caisse['id_caisse'],
                'type' => $caisse['type_caisse'],
                'somme' => $caisse['somme_caisse'],
                'desc' => $caisse['desc_caisse'],
                'creat' => $caisse['creat_caisse'],
                'mod' => $caisse['mod_caisse'],
                'user' => $caisse['user'],
                'paiement' => $caisse['paiement'],
                'personnel' => $caisse['personnel'],
                'agence' => $caisse['agence'],
                'tissu' => $caisse['tissu'],
                'charge' => $caisse['charge']
            );
            $item = new caisseClass($data);
            $this->addCaisse($item);
        }
    }

    public function getCaissesAgence($agence)
    {
        $caisses_prod = [];
        if (!empty($this->caisses)) {
            foreach ($this->caisses as $caisse) {
                if ($caisse->getAgence() === $agence->getIdAgence()) {
                    array_push($caisses_prod, $caisse);
                }
            }
        }

        return $caisses_prod;
    }

    public function getCaisseById($id)
    {
        if (!empty($this->caisses)) {
            foreach ($this->caisses as $caisse) {
                if ($caisse->getIdcaisse() === $id) {
                    return $caisse;
                }
            }
        }
    }

    public function getCaisseByPaiement($paie)
    {
        if (!empty($this->caisses)) {
            foreach ($this->caisses as $caisse) {
                if ($caisse->getPaiement() == $paie) {
                    return $caisse;
                }
            }
        }
    }

    public function getCaisseByTissu($tissu)
    {
        if (!empty($this->caisses)) {
            foreach ($this->caisses as $caisse) {
                if ($caisse->getTissu() == $tissu) {
                    return $caisse;
                }
            }
        }
    }

    public function getCaisseByCharge($charge)
    {
        if (!empty($this->caisses)) {
            foreach ($this->caisses as $caisse) {
                if ($caisse->getCharge() == $charge) {
                    return $caisse;
                }
            }
        }
    }

    public function getCaisseByPersonnel($pers)
    {
        if (!empty($this->caisses)) {
            foreach ($this->caisses as $caisse) {
                if ($caisse->getPersonnel() == $pers) {
                    return $caisse;
                }
            }
        }
    }

    public function addCaisseBd($data)
    {
        $query = "INSERT INTO caisse (somme_caisse, desc_caisse, type_caisse, creat_caisse, mod_caisse, paiement,personnel,user, agence,tissu,charge) 
                    VALUES (:somme,:desc,:type, :creat,:mod,:paiement,:personnel, :user, :agence, :tissu,:charge)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":somme", $data['somme']);
        $stmt->bindValue(":desc", $data['desc']);
        $stmt->bindValue(":type", $data['type']);
        $stmt->bindValue(":creat", $data['creat']);
        $stmt->bindValue(":mod", $data['mod']);
        $stmt->bindValue(":paiement", $data['paiement']);
        $stmt->bindValue(":personnel", $data['personnel']);
        $stmt->bindValue(":user", $data['user']);
        $stmt->bindValue(":agence", $data['agence']);
        $stmt->bindValue(":tissu", $data['tissu']);
        $stmt->bindValue(":charge", $data['charge']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $data['id'] = $this->getBdd()->lastInsertId();
            $caisse = new caisseClass($data);
            $this->addCaisse($caisse);
        }
    }

    public function updateCaisseBD($data)
    {
        $query = "UPDATE caisse SET somme_caisse=:somme, desc_caisse=:desc,type_caisse=:type, creat_caisse=:mod WHERE id_caisse=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":somme", $data['somme']);
        $stmt->bindValue(":type", $data['type']);
        $stmt->bindValue(":desc", $data['desc']);
        $stmt->bindValue(":mod", $data['date']);
        $stmt->bindValue(":id", $data['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if ($result > 0) {
            $this->getCaisseById($data['id'])->setSommeCaisse($data['somme']);
            $this->getCaisseById($data['id'])->setTypeCaisse($data['type']);
            $this->getCaisseById($data['id'])->setDescCaisse($data['desc']);
            $this->getCaisseById($data['id'])->setCreatCaisse($data['date']);
        }
    }

    public function updateSommeCaisseBD($data)
    {
        $query = "UPDATE caisse SET somme_caisse=:somme, mod_caisse=:mod WHERE id_caisse=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":somme", $data['somme']);
        $stmt->bindValue(":mod", $data['mod']);
        $stmt->bindValue(":id", $data['id']);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if ($result > 0) {
            $this->getCaisseById($data['id'])->setSommeCaisse($data['somme']);
            $this->getCaisseById($data['id'])->setModCaisse($data['mod']);

        }
    }

    public function deleteCaisseBD($id)
    {
        $query = "DELETE FROM caisse WHERE id_caisse=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $caisse = $this->getCaisseById($id);
            unset($caisse);
        }
    }

    public function getCaissePeriode($agence, $debut, $fin)
    {
        $query = "SELECT * FROM caisse WHERE agence =:agence AND creat_caisse BETWEEN :debut AND :fin ORDER BY creat_caisse DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence", $agence);
        $stmt->bindValue(":debut", $debut);
        $stmt->bindValue(":fin", $fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getPaiementCaisseByClientPeriod($client, $debut, $fin)
    {
        $query = "SELECT somme_caisse, desc_caisse,type_caisse,creat_caisse 
                    FROM paiement p JOIN caisse c ON p.id_paie=c.paiement
                    WHERE p.id_paie IN 
                    (SELECT id_paie 
                    FROM commande cmd JOIN client cl ON cl.id_client=cmd.client
                    JOIN paiement p ON p.commande=cmd.id_commande
                    WHERE cl.id_client=:client ) AND c.creat_caisse BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client", $client);
        $stmt->bindValue(":debut", $debut);
        $stmt->bindValue(":fin", $fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getChargeCaisseByClientPeriod($client, $debut, $fin)
    {
        $query = "SELECT somme_caisse, desc_caisse,type_caisse,creat_caisse 
                    FROM charge ch JOIN caisse c ON ch.id_charge=c.charge
                    WHERE ch.id_charge IN 
                    (SELECT id_charge 
                    FROM commande cmd JOIN client cl ON cl.id_client=cmd.client
                    JOIN commande_modele_tissu cmt ON cmt.commande=cmd.id_commande
                    JOIN production p ON p.cmt=cmt.id_cmt
                    JOIN charge ch ON ch.production=p.id_prod
                    WHERE cl.id_client=:client )  AND c.creat_caisse BETWEEN :debut AND :fin ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":client", $client);
        $stmt->bindValue(":debut", $debut);
        $stmt->bindValue(":fin", $fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

}