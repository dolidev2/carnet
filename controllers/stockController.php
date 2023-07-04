<?php

require_once 'models/stock/stockManager.php';
require_once 'models/ressource/ressourceManager.php';
require_once 'models/audit/auditManager.php';

class stockController
{
    private $stockManager;
    private $ressourceManager;
    private $auditManager;

    public function __construct()
    {
        $this->auditManager = new auditManager();

        $this->stockManager = new stockManager();
        $this->stockManager->loadStock();

        $this->ressourceManager = new ressourceManager();
        $this->ressourceManager->loadRessource();
    }

    public function displayStock()
    {
        $stocks = $this->stockManager->getStockRessource();
        $sorties = [];
        if(!empty($stocks)){
            foreach ($stocks as $stock){
                if ($stock['type_stock'] == 'entre'){
                    array_push($entres,$stock);
                }
                if ($stock['type_stock'] == 'sortie'){
                    array_push($sorties,$stock);
                }
            }
        }
        $ressource = $this->ressourceManager->getRessources();

        require 'views/stock/home.php';
    }

    public function addSaveStock()
    {
        $data = array(
            'prix_g'=> $this->fieldValidation($_POST['prix_g']),
            'prix_d'=> $this->fieldValidation($_POST['prix_d']),
            'quantite'=> $this->fieldValidation($_POST['qte_stock']),
            'type'=> $this->fieldValidation($_POST['type_stock']),
            'ressource'=> $this->fieldValidation($_POST['ressource']),
            'desc'=> $this->fieldValidation($_POST['desc']),
            'creat'=> date("Y-m-d"),
            'mod'=> date("Y-m-d"),
        );
        $res = $this->ressourceManager->getRessourceById($data['ressource']);
        $audit = array(
            'desc'=> "Ajout d'une ".$data['type']. " prix : ".$data['prix_d'].' et '. $data['prix_g'].' quantité '.$data['auqntite']." ressource : ".$res->getNomRes(),
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->stockManager->addStockBd($data);
        header('location: '.URL.'/stock');

    }

    public function updateSaveStock()
    {
        $data = array(
            'prix_g'=> $this->fieldValidation($_POST['prix_g']),
            'prix_d'=> $this->fieldValidation($_POST['prix_d']),
            'quantite'=> $this->fieldValidation($_POST['qte_stock']),
            'type'=> $this->fieldValidation($_POST['type_stock']),
            'ressource'=> $this->fieldValidation($_POST['ressource']),
            'desc'=> $this->fieldValidation($_POST['desc']),
            'id'=> $this->fieldValidation($_POST['id_stock']),
            'mod'=> date("Y-m-d"),
        );
        $res = $this->ressourceManager->getRessourceById($data['ressource']);
        $audit = array(
            'desc'=> "Modification d'une ".$data['type']. " prix : ".$data['prix_d'].' et '. $data['prix_g'].' quantité '.$data['auqntite']." ressource : ".$res->getNomRes(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->stockManager->updateStockBD($data);
        header('location: '.URL.'/stock');
    }

    public function deleteSaveStock($id)
    {
        $stock = $this->stockManager->getStockById($id);
        $res = $this->ressourceManager->getRessourceById($stock->getRessource());
        $audit = array(
            'desc'=> "Suppression d'une ".$stock->getTypeStock(). " prix : ".$stock->getPrixDStock().' et '.$stock->getPrixGStock().' quantité '.$stock->getQuantiteStock()." ressource : ".$res->getNomRes(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->stockManager->deleteStockBD($id);
        header('location: '.URL.'/stock');
    }

    public function periodeStock()
    {
        $stocks = $this->stockManager->getStockRessource();
        $ressource = $this->ressourceManager->getRessources();
        require 'views/stock/home_periode.php';
    }

    public function periodeAvStock()
    {
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $stocks = $this->stockManager->getStockRessourcePeriode($debut,$fin);

        $entres = [];
        $sorties = [];
        if(!empty($stocks)){
            foreach ($stocks as $stock){
                if ($stock['type_stock'] == 'entre'){
                    array_push($entres,$stock);
                }
                if ($stock['type_stock'] == 'sortie'){
                    array_push($sorties,$stock);
                }
            }
        }
        $ressource = $this->ressourceManager->getRessources();

        require 'views/stock/home_periode.php';
    }

    public function ressourcePeriodeStock()
    {
        $item = array(
            'debut'=>$this->fieldValidation($_POST['dt_debut']),
            'fin'=>$this->fieldValidation($_POST['dt_fin']),
            'ressource'=>$this->fieldValidation($_POST['ressource']),
        );
        $stocks = $this->stockManager->getRessourcePeriode($item);
        $entres = [];
        $sorties = [];
        if(!empty($stocks)){
            foreach ($stocks as $stock){
                if ($stock['type_stock'] == 'entre'){
                    array_push($entres,$stock);
                }
                if ($stock['type_stock'] == 'sortie'){
                    array_push($sorties,$stock);
                }
            }
        }
          $ressource = $this->ressourceManager->getRessources();
        require 'views/stock/resource_periode.php';
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

}