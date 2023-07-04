<?php

require_once 'models/modelClass.php';
require_once 'models/stock/stockClass.php';

class stockManager extends modelClass
{
    private $stocks;//Tableau de stocks

    public function addStock($stock)
    {
        $this->stocks[] = $stock;
    }

    public function getStocks()
    {
        return $this->stocks;
    }

    public function getStockRessource()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM stock s JOIN ressource r ON s.ressource=r.id_res
                WHERE r.agence=:agence ORDER BY id_stock DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getStockRessourcePeriode($debut,$fin)
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM stock s, ressource r WHERE s.ressource =r.id_res AND r.agence=:agence
                   AND s.creat_stock BETWEEN :debut AND :fin ORDER BY s.creat_stock DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence", $agence);
        $stmt->bindValue(":debut", $debut);
        $stmt->bindValue(":fin", $fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getRessourcePeriode($data)
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM stock s, ressource r WHERE s.ressource =r.id_res AND r.id_res=:ressource
                   AND r.agence=:agence AND s.creat_stock BETWEEN :debut AND :fin ORDER BY s.creat_stock DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":ressource", $data['ressource']);
        $stmt->bindValue(":agence", $agence);
        $stmt->bindValue(":debut", $data['debut']);
        $stmt->bindValue(":fin", $data['fin']);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function loadStock()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM stock s JOIN ressource r ON s.ressource=r.id_res
                    WHERE r.agence=:agence ORDER BY id_stock DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $allstock = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allstock as $stock)
        {
            $data = array(
                'id'=> $stock['id_stock'],
                'desc'=> $stock['desc_stock'],
                'creat'=> $stock['creat_stock'],
                'mod'=> $stock['mod_stock'],
                'prix_g'=> $stock['prix_g_stock'],
                'prix_d'=> $stock['prix_d_stock'],
                'quantite'=> $stock['quantite_stock'],
                'type'=> $stock['type_stock'],
                'ressource'=> $stock['ressource'],
            );
            $item = new stockClass($data);
            $this->addStock($item);
        }
    }

    public function getStocksRessource($ressource)
    {
        $stocks_commande = [];
        if(!empty($this->stocks )){
            foreach ($this->stocks as $stock){
                if($stock->getRessource() === $ressource->getIdRes()){
                    array_push($stocks_commande,$stock);
                }
            }
        }
        return $stocks_commande;
    }

    public function getStockById($id)
    {
        foreach ($this->stocks as $stock){
            if($stock->getIdStock() === $id){
                return $stock;
            }
        }
    }


    public function addStockBd($data)
    {
        $query = "INSERT INTO stock (prix_g_stock,prix_d_stock, quantite_stock,creat_stock, mod_stock, desc_stock,
                   type_stock,ressource) 
                    VALUES (:prix_g,:prix_d,:quantite,:creat,:mod,:desc,:type,:ressource)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['creat']);
        $stmt->bindValue(":prix_g",$data['prix_g']);
        $stmt->bindValue(":prix_d",$data['prix_d']);
        $stmt->bindValue(":quantite",$data['quantite']);
        $stmt->bindValue(":type",$data['type']);
        $stmt->bindValue(":ressource",$data['ressource']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] =  $this->getBdd()->lastInsertId();
            $stock = new stockClass($data);
            $this->addstock($stock);
        }
    }

    public function updateStockBD($data)
    {
        $query = "UPDATE stock SET desc_stock=:desc, prix_g_stock=:prix_g, prix_d_stock=:prix_d, quantite_stock=:quantite,
                 mod_stock=:mod, type_stock=:type WHERE id_stock=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":prix_g",$data['prix_g']);
        $stmt->bindValue(":prix_d",$data['prix_d']);
        $stmt->bindValue(":quantite",$data['quantite']);
        $stmt->bindValue(":type",$data['type']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getStockById($data['id'])->setDescStock($data['desc']);
            $this->getStockById($data['id'])->setModStock($data['mod']);
            $this->getStockById($data['id'])->setPrixGStock($data['prix_g']);
            $this->getStockById($data['id'])->setPrixDStock($data['prix_d']);
            $this->getStockById($data['id'])->setQuantiteStock($data['quantite']);
            $this->getStockById($data['id'])->setTypeStock($data['type']);
        }
    }

    public function deleteStockBD($id)
    {
        $query = "DELETE FROM stock WHERE id_stock=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $stock = $this->getStockById($id);
            unset($stock);
        }
    }
}