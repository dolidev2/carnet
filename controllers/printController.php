<?php

require_once 'models/client/commande/commandeClientManager.php';
require_once 'models/client/clientManager.php';
require_once 'models/modele/modeleManager.php';
require_once 'models/agence/agenceManager.php';
require_once 'models/personnel/personnelManager.php';
require_once 'models/ressource/ressourceManager.php';
require_once 'models/caisse/caisseManager.php';
require_once 'models/agence/agenceManager.php';
require_once 'models/config/config.php';
require_once 'models/user/userManager.php';
require_once 'models/programme/programmeManager.php';
require_once 'models/client/paiement/paiementClientManager.php';
require_once 'models/production/productionManager.php';
require_once 'models/charge/chargeManager.php';
require_once 'models/client/tissu/tissuClientManager.php';
require_once 'models/rdv/rdvCommandeManager.php';
require_once 'models/stock/stockManager.php';

class printController
{
    private $agenceManager;
    private $commandeManager;
    private $clientManager;
    private $modeleManager;
    private $personnelManager;
    private $ressourceManager;
    private $caisseManager;
    private $userManager;
    private $programmeManager;
    private $config;
    private $paiementManager;
    private $productionManager;
    private $chargeManager;
    private $tissuManager;
    private $rdvManager;
    private $stockManager;

    public function __construct()
    {
       $this->commandeManager = new commandeClientManager();
       $this->commandeManager->loadCommande();

       $this->clientManager = new clientManager();
       $this->clientManager->loadClient();

        $this->modeleManager = new modeleManager();
        $this->modeleManager->loadModele();

        $this->personnelManager = new personnelManager();
        $this->personnelManager->loadPersonnel();

        $this->ressourceManager = new ressourceManager();
        $this->ressourceManager->loadRessource();

        $this->caisseManager = new caisseManager();
        $this->caisseManager->loadCaisse();

        $this->config = new configData();

        $this->agenceManager = new agenceManager();
        $this->agenceManager->loadAgence();

        $this->userManager = new userManager();
        $this->userManager->loadUserLogin();

        $this->programmeManager = new programmeManager();
        $this->programmeManager->loadProgramme();

        $this->paiementManager = new paiementClientManager();
        $this->paiementManager->loadPaiement();

        $this->productionManager = new productionManager();
        $this->productionManager->loadProduction();

        $this->chargeManager = new chargeManager();
        $this->chargeManager->loadCharge();

        $this->tissuManager = new tissuClientManager();
        $this->tissuManager->loadTissu();

        $this->rdvManager = new rdvCommandeManager();
        $this->rdvManager->loadRdv();

        $this->stockManager = new stockManager();
        $this->stockManager->loadStock();
    }

    public function displayHome()
    {
        $agences = $this->agenceManager->getAgences();
        $clients = $this->clientManager->getClients();
        require 'views/print/home.php';
    }

    public function printChiffreAffairePeriode()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $caisses = $this->caisseManager->getCaissePeriode($agenceId,$debut,$fin);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $entre = $this->config->caisse_entre;
        $sortie = $this->config->caisse_sortie;
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/print/pdf/chiffreAffairePeriode.php';
    }

    public function chiffreAffaireClient()
    {
        $idClient = $this->fieldValidation($_POST['client']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $caisseEntre = $this->caisseManager->getPaiementCaisseByClientPeriod($idClient,$debut,$fin);
        $caisseSortie = $this->caisseManager->getChargeCaisseByClientPeriod($idClient,$debut,$fin);

        $client = $this->clientManager->getClientById($idClient);
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/print/pdf/chiffreAffaireClient.php';
    }

    public function classementModeleByAgencePeriod()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $modeles = $this->modeleManager->getModeles();
        $data = [];
        foreach ($modeles as $modele){
            $recetteModele = $this->programmeManager->getChiffreAffaireByModeleAgencePeriod($modele->getIdModele(),$agenceId,$debut,$fin);
            $depenseModele = $this->programmeManager->getChargeByModeleAgencePeriod($modele->getIdModele(),$agenceId,$debut,$fin);

            $quantite_prod = ($recetteModele[0]['quantite'] != '')? $recetteModele[0]['quantite']:0;
            $rend_prod= ($depenseModele[0]['rend'] != '')? $depenseModele[0]['rend']:0;
            $charge_prod= ($depenseModele[0]['total'] != '')? $depenseModele[0]['total']:0;
            $cout_prod_montage = $modele->getCoutModele() * $quantite_prod ;
            $cout_prod_decoupage = $modele->getCoutDecoupModele() * $quantite_prod ;

            $item = array(
                'modele'=>$modele,
                'recette'=>($recetteModele[0]['total'] != '')? $recetteModele[0]['total']: 0,
                'depense'=>($rend_prod + $charge_prod + $cout_prod_montage + $cout_prod_decoupage),
                'quantite'=>$quantite_prod,
                'rend'=>$rend_prod,
                'charge'=>$charge_prod,
                'montage'=>$cout_prod_montage,
                'decoupage'=>$cout_prod_decoupage,
            );
            array_push($data,$item);
        }
        $array_recette = array_column($data,'recette');

        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);
        array_multisort($array_recette, SORT_DESC, $data);;

        require 'views/print/pdf/classementModele.php';
    }

    public function classementPeriodPersonnel()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $personnels = $this->personnelManager->getPersonnelFromAgence($agenceId);
        $data = [];
        foreach ($personnels as $pers){
            $item = array(
                'personnel'=>$pers['id_pers'],
                'debut'=>$debut,
                'fin'=>$fin,
            );
            $couts_pers = $this->personnelManager->loadPeriodCout($item);
            $cout_modele_ca = 0;
            $cout_modele_dep = 0;
            foreach ($couts_pers as $cout){
                $programme = $this->programmeManager->getProgrammeById($cout['id_cmt']);
                $modele = $this->modeleManager->getModeleById($programme->getModele());
                $cout_modele_ca = $modele->getPrixModele() * $cout['quantite_prod'] ;
                $cout_modele_dep = $cout['somme_prod'] * $cout['quantite_prod'] ;
            }
            $item_detail = array(
                'personnel'=>$pers,
                'recette'=>$cout_modele_ca,
                'depense'=>$cout_modele_dep,
            );
            array_push($data,$item_detail);
        }
        $array_recette = array_column($data,'recette');
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);
        array_multisort($array_recette, SORT_DESC, $data);

        require 'views/print/pdf/classementPeriodPersonnel.php';
    }

    public function classementPeriodClient()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $clients = $this->clientManager->getClientFromAgence($agenceId);
        $data = [];
        foreach ($clients as $client){
            $total_charge =0;
            $total_prod =0;
            $total_paie =0;
            $total_tissu =0;
            $commandes = $this->commandeManager->getCommandeFromClient($debut, $fin,$client['id_client']);
            foreach ($commandes as $commande){

                $paiements = $this->paiementManager->getPaiementsCommandeId($commande['id_commande']);
                foreach ($paiements as $paie){
                    $total_paie += $paie->getSommePaie();
                }
                $programmes = $this->programmeManager->getProgrammesCommandeId($commande['id_commande']);
                foreach ($programmes as $programme){
                    $tissus = $this->tissuManager->getTissuById($programme->getTissu());
                    foreach ($tissus as $tissu){
                        if ($tissu->commission_tissu() != $this->config->inactif){
                            $total_tissu += $tissu->commission_tissu();
                        }
                    }

                    $productions = $this->productionManager->getProductionByCmt($programme->getIdCmt());
                    foreach ($productions as $prod){
                        $charges =  $this->chargeManager->getChargesProduction($prod);
                        foreach ($charges as $charge){
                            $total_charge += $charge->getPrixCharge();
                        }
                        $total_prod += ($prod->getSommeProd() * $prod->getQuantiteProd()) + $prod->getRendProd();
                    }
                }
            }
            $item = array(
                'client' => $client,
                'recette' => ($total_paie + $total_tissu),
                'depense' => ($total_prod+$total_charge),
            );
            array_push($data,$item);
        }
        $array_recette = array_column($data,'recette');
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);
        array_multisort($array_recette, SORT_DESC, $data);

        require 'views/print/pdf/classementPeriodClient.php';
    }

    public function classementPeriodClientTissu()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $tissus = $this->tissuManager->getTissuAchete($agenceId,$debut,$fin );
        $clients = $this->tissuManager->getTissuAcheteByClient($agenceId,$debut,$fin);

        $array_total = array_column($clients,'total');
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);
        array_multisort($array_total, SORT_DESC, $clients);

        require 'views/print/pdf/classementTissuAchete.php';
    }

    public function rdvPeriod()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        $rdvs = $this->commandeManager->getRdvPeriodAgence($agenceId,$debut,$fin);
        $data = [];
        foreach ($rdvs as $rdv) {
            $articles = $this->programmeManager->getProgrammeModele($rdv['id_commande']);
            $item = array(
                'rdv' => $rdv['rdv_commande'],
                'commande' => $rdv['desc_commande'],
                'articles' => $articles,
                'client' => $rdv['nom_client'].' '.$rdv['prenom_client'].' '.$rdv['contact_client'],
            );
            array_push($data,$item);
        }

        $array_rdv = array_column($data,'rdv');
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);
        array_multisort($array_rdv, SORT_ASC, $data);

        require 'views/print/pdf/classementRdvPeriod.php';
    }

    public function caissePeriod()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        $caisses = $this->caisseManager->getCaissePeriode($agenceId,$debut,$fin);
        $entre = $this->config->caisse_entre;
        $sortie = $this->config->caisse_sortie;

        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/print/pdf/caissePeriod.php';
    }

    public function rdvReportePeriod()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        $rdvs = $this->rdvManager->getRdvAgence($agenceId,$debut,$fin);
        $data = [];
        foreach ($rdvs as $rdv) {
            $articles = $this->programmeManager->getProgrammeModele($rdv['id_commande']);
            $item = array(
                'rdv' => $rdv['creat_rdv'],
                'commande' => $rdv['desc_commande'],
                'articles' => $articles,
                'client' => $rdv['nom_client'].' '.$rdv['prenom_client'].' '.$rdv['contact_client'],
            );
            array_push($data,$item);
        }

        $array_rdv = array_column($data,'rdv');
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);
        array_multisort($array_rdv, SORT_ASC, $data);

        require 'views/print/pdf/classementRdvPeriod.php';
        
    }

    public function listStockRessource()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        $ressources = $this->ressourceManager->ressourcePeriodAgence($agenceId,$debut,$fin);

        $data = [];
        foreach ($ressources as $ressource){
            $entre = 0;
            $sorti = 0;
            $stocks = $this->ressourceManager->stockPeriodAgence($ressource['id_res'],$debut,$fin);
            $items = [];
            foreach ($stocks as $stock){
                if ($stock['type_stock'] == $this->config->caisse_entre){
                    $entre +=$stock['quantite_stock'];
                }
                if ($stock['type_stock'] == $this->config->caisse_sortie){
                    $sorti +=$stock['quantite_stock'];

                }
                $item = array(
                    'desc'=> $stock['desc_stock'],
                    'quantite'=> $stock['quantite_stock'],
                    'prix_g'=> $stock['prix_g_stock'],
                    'prix_d'=> $stock['prix_d_stock'],
                    'date'=> $stock['creat_stock'],
                );
                array_push($items, $item);
            }
            $itemData = array(
                'ressource'=>$ressource,
                'entre'=>$entre,
                'sorti'=>$sorti,
                'stock'=>$items,
            );
            array_push($data, $itemData);
        }


        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/print/pdf/listStockRessource.php';
    }

    public function commandeClientPeriod()
    {
        $clientId = $this->fieldValidation($_POST['client']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        $client =  $this->clientManager->getClientById($clientId);
        $commandes =  $this->commandeManager->getCommandeFromClient($debut,$fin,$clientId);
        $data = [];
        foreach ($commandes as $commande){
            $programmes = $this->programmeManager->programmePeriodeCommandeArticles($commande['id_commande'],$debut, $fin);

            $item = array(
                'commande'=>$commande,
                'articles'=>$programmes,
            );
            array_push($data , $item);
        }

        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($client->getAgence());
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/print/pdf/commandeClientPeriod.php';

    }

    public function listClientPeriodAgence()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        $clients = $this->clientManager->getClientAgencePeriod($agenceId,$debut, $fin);


        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        $agenceUser = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/print/pdf/commandeClientPeriod.php';
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

}