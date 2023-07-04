<?php

require_once 'models/charge/chargeManager.php';
require_once 'models/ressource/ressourceManager.php';
require_once 'models/production/productionManager.php';
require_once 'models/audit/auditManager.php';
require_once 'models/stock/stockManager.php';
require_once 'models/caisse/caisseManager.php';
require_once 'models/config/config.php';

class chargeController
{
    private $chargeManager;
    private $ressourceManager;
    private $productionManager;
    private $auditManager;
    private $stockManager;
    private $caisseManager;
    private $config;

    public function __construct()
    {
        $this->chargeManager = new chargeManager();
        $this->chargeManager->loadCharge();

        $this->ressourceManager = new ressourceManager();
        $this->ressourceManager->loadRessource();

        $this->productionManager = new productionManager();
        $this->productionManager->loadProduction();

        $this->caisseManager = new caisseManager();
        $this->caisseManager->loadCaisse();

        $this->stockManager = new stockManager();

        $this->auditManager = new auditManager();
        $this->config = new configData();
    }

    public function addCharge($prod)
    {
        $ressources = $this->ressourceManager->getRessources();
        $prodDetail = $this->productionManager->productionDeatils($prod);

        $production = $this->productionManager->getProductionById($prod);
        $charges =$this->chargeManager->getChargesProduction($production);

        $data = [];
        if (!empty($charges)){
            foreach ($charges as $charge){
                $ressource = $this->ressourceManager->getRessourceById($charge->getRessource());
                $item = array(
                    'id' => $charge->getIdCharge(),
                    'prix' => $charge->getPrixCharge(),
                    'qte' => $charge->getQteCharge(),
                    'desc' => $charge->getDescCharge(),
                    'ressource' => $ressource->getNomRes(),
                    'production' => $charge->getProduction(),
                );
                array_push($data,$item);
            }
        }
        require 'views/charge/add.php';
    }
    public function addSaveCharge($prod)
    {
        $production = $this->productionManager->getProductionById($prod);
        if (isset($_POST['ressource']) && !empty($_POST['ressource']) && isset($_POST['prix']) && !empty($_POST['prix'])){
            for ($i=0; $i< count($_POST['prix']);$i++){

                $item = array(
                    'prix' => $this->fieldValidation($_POST['prix'][$i]),
                    'qte' => $this->fieldValidation($_POST['qte'][$i]),
                    'ressource' => $this->fieldValidation($_POST['ressource'][$i]),
                    'desc' => $this->fieldValidation($_POST['desc'][$i]),
                    'production' => $this->fieldValidation($_POST['prod']),
                    'creat' =>date("y-m-d"),
                    'mod' =>date("y-m-d"),
                );
                $idCharge = $this->chargeManager->addChargeBd($item);
                //Add sortie to caisse

                $ressource = $this->ressourceManager->getRessourceById($item['ressource']);
                $infosClientCommande = $this->chargeManager->getInfoClientCommandeFromCharge($idCharge);

                $itemCaisse = array(
                    'somme' => $item['prix'],
                    'desc' => $item['qte']." quantité de ".$ressource->getNomRes()." utilisé dans le modèle ".$infosClientCommande[0]['modele'] .
                        " dans la commande ".$infosClientCommande[0]['commande'] ." du client "
                        .$infosClientCommande[0]['nom']." ".$infosClientCommande[0]['prenom']." ".
                        $infosClientCommande[0]['contact'],
                    'type' => $this->config->caisse_sortie,
                    'creat' => date("Y-m-d"),
                    'mod' => date("Y-m-d"),
                    'user' => $_SESSION['id'],
                    'agence' =>$_SESSION['agence'],
                    'paiement' =>$this->config->inactif,
                    'personnel' =>$this->config->inactif,
                    'tissu' =>$this->config->inactif,
                    'charge' =>$idCharge,
                );
                $this->caisseManager->addCaisseBd($itemCaisse);
                //End caisse
                //Add audit for charge
                $audit = array(
                    'desc'=> "Ajout d'une charge : ".$item['desc']." dont le montant est ".$item['prix'],
                    'action'=>'Ajout',
                    'creat'=>date("Y-m-d"),
                    'user'=>$_SESSION['id'],
                );
                $this->auditManager->addAuditBd($audit);
                //Add stock
                $stock = array(
                    'prix_g'=> $this->config->inactif,
                    'prix_d'=> $item['prix'],
                    'quantite'=> $item['qte'],
                    'type'=> 'sortie',
                    'ressource'=> $item['ressource'],
                    'desc'=> $item['desc'],
                    'creat'=> date("Y-m-d"),
                    'mod'=> date("Y-m-d"),
                );
                $this->stockManager->addStockBd($stock);
                $res = $this->ressourceManager->getRessourceById($stock['ressource']);
                //Add Audit for stock
                $audit = array(
                    'desc'=> "Ajout d'une ".$stock['type']. " prix : ".$stock['prix_d'].' et '. $stock['prix_g'].' quantité '.$stock['quantite']." ressource : ".$res->getNomRes(),
                    'action'=>'Ajout',
                    'creat'=>date("Y-m-d"),
                    'user'=>$_SESSION['id'],
                );
                $this->auditManager->addAuditBd($audit);
            }
        }
        header('location: '.URL.'personnel/detail/'.$production->getPersonnel());
    }

    public function updateCharge($prod)
    {
        $ressources = $this->ressourceManager->getRessources();
        $prodDetail = $this->productionManager->productionDeatils($prod);

        $production = $this->productionManager->getProductionById($prod);
        $charges =$this->chargeManager->getChargesProduction($production);

        $data = [];
        if(!empty($charges)){
            foreach ($charges as $charge){
                    $ressource = $this->ressourceManager->getRessourceById($charge->getRessource());
                    $item = array(
                        'id' => $charge->getIdCharge(),
                        'prix' => $charge->getPrixCharge(),
                        'qte' => $charge->getQteCharge(),
                        'desc' => $charge->getDescCharge(),
                        'ressource' => $ressource->getNomRes(),
                        'id_res' => $ressource->getIdRes(),
                        'production' => $charge->getProduction(),
                    );
                array_push($data,$item);
            }
        }
        require 'views/charge/update.php';
    }

    public function updateSaveCharge($prod)
    {
        $production = $this->productionManager->getProductionById($prod);
        if (isset($_POST['ressource']) && !empty($_POST['ressource']) && isset($_POST['desc']) && !empty($_POST['desc']) && isset($_POST['prix']) && !empty($_POST['prix'])){
            for ($i=0; $i< count($_POST['prix']);$i++){

                $item = array(
                    'prix' => $this->fieldValidation($_POST['prix'][$i]),
                    'qte' => $this->fieldValidation($_POST['qte'][$i]),
                    'ressource' => $this->fieldValidation($_POST['ressource'][$i]),
                    'desc' => $this->fieldValidation($_POST['desc'][$i]),
                    'id' => $this->fieldValidation($_POST['charge'][$i]),
                    'mod' =>date("y-m-d"),
                );
                $this->chargeManager->updateChargeBD($item);

                //Update Caisse
                $caisse = $this->caisseManager->getCaisseByCharge($item['id']);
                $ressource = $this->ressourceManager->getRessourceById($item['ressource']);
                $infosClientCommande = $this->chargeManager->getInfoClientCommandeFromCharge($item['id']);

                $itemCaisse = array(
                    'somme' => $item['prix'],
                    'desc' => "Modification ".$item['qte']." quantité de ".$ressource->getNomRes()." utilisé dans le modèle ".$infosClientCommande[0]['modele'] .
                        " dans la commande ".$infosClientCommande[0]['commande'] ." du client "
                        .$infosClientCommande[0]['nom']." ".$infosClientCommande[0]['prenom']." ".
                        $infosClientCommande[0]['contact'],
                    'type' => $this->config->caisse_sortie,
                    'mod'=> date("Y-m-d"),
                    'id'=>$caisse->getIdCaisse()
                );
                $this->caisseManager->updateCaisseBD($itemCaisse);
                //End Update Caisse
                //Add Audit
                $audit = array(
                    'desc'=> "Modification de la charge : ".$item['desc']." dont le montant est ".$item['prix'],
                    'action'=>'Modification',
                    'creat'=>date("Y-m-d"),
                    'user'=>$_SESSION['id'],
                );
                $this->auditManager->addAuditBd($audit);
            }
        }
        header('location: '.URL.'personnel/detail/'.$production->getPersonnel());
    }

    public function deleteSaveCharge($id)
    {
        $charge = $this->chargeManager->getChargeById($id);
        $audit = array(
            'desc'=> "Suppression de la charge : ".$charge->getDescCharge()." dont le montant est ".$charge->getPrixCharge(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        //Delete from caisse
        $caisse = $this->caisseManager->getCaisseByCharge($id);
        $this->caisseManager->deleteCaisseBD($caisse->getIdCaisse());
        //End caisse

        $this->auditManager->addAuditBd($audit);
        $this->chargeManager->deleteChargeBD($id);
        header('location: '.URL.'personnel/charge/'.$charge->getProduction());
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

}