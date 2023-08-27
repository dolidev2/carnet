<?php

require_once 'models/programme/programmeManager.php';
require_once 'models/production/productionManager.php';
require_once 'models/personnel/personnelManager.php';
require_once 'models/rdv/rdvCommandeManager.php';
require_once 'models/charge/chargeManager.php';
require_once 'models/audit/auditManager.php';
require_once 'models/modele/modeleManager.php';
require_once 'models/client/commande/commandeClientManager.php';
require_once 'models/client/clientManager.php';
require_once 'models/modele_composition/modeleCompManager.php';

class programmeController
{
    private $programmeManager;
    private $productionManager;
    private $personnelManager;
    private $rdvManager;
    private $chargeManager;
    private $auditManager;
    private $modeleManager;
    private $commandeManager;
    private $clientManager;
    private $modeleCompManager;

    public function __construct()
    {
        $this->auditManager= new auditManager();

        $this->commandeManager= new commandeClientManager();
        $this->commandeManager->loadCommande();

        $this->programmeManager= new programmeManager();
        $this->programmeManager->loadProgramme();

        $this->productionManager= new productionManager();
        $this->productionManager->loadProduction();

        $this->personnelManager= new personnelManager();
        $this->personnelManager->loadPersonnel();

        $this->rdvManager= new rdvCommandeManager();
        $this->rdvManager->loadRdv();

        $this->chargeManager= new chargeManager();
        $this->chargeManager->loadCharge();

        $this->modeleManager= new modeleManager();
        $this->modeleManager->loadModele();

        $this->clientManager= new clientManager();
        $this->clientManager->loadClient();

        $this->modeleCompManager= new modeleCompManager();
        $this->modeleCompManager->loadModeleComp();
    }

    public function displayProgramme()
    {
        //Close programme to finish
        $programmes_statut = $this->programmeManager->getProgrammeStatut(0);
            if (!empty($programmes_statut)){
            $this->closeProgramme($programmes_statut);
        }
        //Get personnel data
        $personnels = $this->personnelManager->getPersonnels();

        $data_pers = [];
        $column = 0;
        if(!empty($personnels)){
            foreach ($personnels as $personnel){
                $task = $this->programmeManager->programmeToDoArticlesPersonnel($personnel->getIdPers());
                if(!empty($task)){
                    $data_task = [];
                    foreach ($task as $tk){
                        $rdv = '';
                        $commandeReport = $this->programmeManager->programmeRdvCommande($tk['id_commande']);
                        if (!empty($commandeReport)){
                            $rdv = $commandeReport[0]['creat_rdv'];
                            $tk['rdv'] = $rdv;
                        }
                        array_push($data_task,$tk);
                    }
                    $colCount = count($task);
                    if ($colCount >= $column){
                        $column = $colCount;
                    }
                    $item = array(
                        'personnel' => $personnel,
                        'travail' =>  $data_task
                    );
                    array_push($data_pers,$item);
                }
            }
        }
        //Get commande data
        $commandes = $this->programmeManager->programmeToDoCommande($_SESSION['agence']);
        $data = [];
        if(!empty($commandes)){
            foreach ($commandes as $commande){

                $commandeArticles = $this->programmeManager->programmeToDoCommandeArticles($commande['id_commande']);
                $commandeReport = $this->programmeManager->programmeRdvCommande($commande['id_commande']) ;
                $rdv = (!empty($commandeReport))? $commandeReport[0]['creat_rdv'] : '';

                if(!empty($commandeArticles)){
                    //Add articles available
                    $articles = [];
                    foreach ($commandeArticles as $article){
                        //Get qte prod by programme
                        $qteArticleProd = $this->productionManager->countProductionByProgramme($article['id_cmt'],'Montage');
                        $qteArticleProdDecoup = $this->productionManager->countProductionByProgramme($article['id_cmt'],'Découpage');
                        if (!empty($qteArticleProd)){
                            if ($qteArticleProd[0]['qte'] < $article['quantite_cmt']){
                                $itemArticle = array(
                                    'modele' =>[],
                                    'nom_modele' => $article['nom_modele'],
                                    'prix_modele' => $article['prix_modele'],
                                    'nom_tissu' => $article['nom_tissu'],
                                    'quantite_cmt' => $article['quantite_cmt'],
                                    'prix_cmt' => $article['prix_cmt'],
                                    'id_cmt' => $article['id_cmt'],
                                    'qte_prod' => $qteArticleProd[0]['qte'],
                                    'qte_prod_decoup' => $qteArticleProdDecoup[0]['qte'],
                                );

                                array_push($articles,$itemArticle);
                            }
                        }
                    }

                    $item = array(
                        'commande'=>$commande,
                        'articles'=>$articles,
                        'rdv'=>$rdv
                    );
                    array_push($data,$item);
                }
            }
            //commande from modele composition

            //Get compo modele
//                                $modeleCompId = $this->modeleCompManager->getModeleComp($article['id_modele']);
//                                $data_modele_comp = [];
//                                if(!empty($modeleCompId)){
//                                    foreach ($modeleCompId as $comp){
//                                        $modeleId = $this->modeleManager->getModeleById($comp['modele_comp']);
//                                        $modeleItem = array(
//                                            'nom_modele'=>$modeleId->getNomModele(),
//                                            'prix_modele'=>$modeleId->getPrixModele(),
//                                        );
//                                        array_push($data_modele_comp, $modeleItem);
//                                    }
//                                    $itemArticle['modele']= $data_modele_comp;
//                                }



        }
        require "views/commande/home.php";
    }
    public function displayPeriodeProgramme()
    {
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        //Get Personnel data
        $personnels = $this->personnelManager->getPersonnels();
        $data_pers = [];
        $column = 0;
        if(!empty($personnels)){
            foreach ($personnels as $personnel){
                $task = $this->programmeManager->programmePeriodeArticlesPersonnel($personnel->getIdPers(),$debut,$fin);
                if(!empty($task) && $task != NULL ){
                    $data_task = [];
                    foreach ($task as $tk){
                        $rdv = '';
                        $commandeReport = $this->programmeManager->programmeRdvCommande($tk['id_commande']);
                        if (!empty($commandeReport) && $commandeReport != NULL){
                            $rdv = $commandeReport[0]['creat_rdv'];
                            $tk['rdv'] = $rdv;
                        }
                        array_push($data_task,$tk);
                    }
                    $colCount = count($task);
                    if ($colCount >= $column){
                        $column = $colCount;
                    }
                    $item = array(
                        'personnel' => $personnel,
                        'travail' =>  $data_task
                    );
                    array_push($data_pers,$item);
                }
            }
        }

        //Get commande data
        $commandes = $this->programmeManager->programmePeriodeCommande($_SESSION['agence'],$debut,$fin);
        $data = [];
        if(!empty($commandes)){
            foreach ($commandes as $commande){
                $commandeReport = $this->programmeManager->programmeRdvPeriode($commande['id_commande'],$debut,$fin) ;
                $commandeArticles = $this->programmeManager->programmePeriodeCommandeArticles($commande['id_commande'],$debut,$fin);
                $rdv = (!empty($commandeReport))? $commandeReport[0]['creat_rdv'] : '';

                if(!empty($commandeArticles)){
                    //Add articles available
                    $articles = [];
                    foreach ($commandeArticles as $article){
                        //Get qte prod by programme
                        $qteArticleProd = $this->productionManager->countProductionByProgramme($article['id_cmt'],'Montage');
                        $qteArticleProdDecoup = $this->productionManager->countProductionByProgramme($article['id_cmt'],'Découpage');
                        if (!empty($qteArticleProd)){
                            if ($qteArticleProd[0]['qte'] < $article['quantite_cmt']){
                                $itemArticle = array(
                                    'nom_modele' => $article['nom_modele'],
                                    'prix_modele' => $article['prix_modele'],
                                    'nom_tissu' => $article['nom_tissu'],
                                    'quantite_cmt' => $article['quantite_cmt'],
                                    'prix_cmt' => $article['prix_cmt'],
                                    'id_cmt' => $article['id_cmt'],
                                    'qte_prod' => $qteArticleProd[0]['qte'],
                                    'qte_prod_decoup' => $qteArticleProdDecoup[0]['qte'],
                                );
                                array_push($articles,$itemArticle);
                            }
                        }
                    }

                    $item = array(
                        'commande'=>$commande,
                        'articles'=>$articles,
                        'rdv'=>$rdv
                    );
                    array_push($data,$item);
                }
            }
        }
        require 'views/commande/home_periode.php';
    }

    public function addSaveProgramme()
    {
        if (!empty($_POST['programme'])  && !empty($_POST['personnel']) && !empty($_POST['type']) && !empty($_POST['quantite']) ){
            //Montage
            if (!empty($_POST['type'][0]) && !empty($_POST['personnel'][0])){
                foreach ($_POST['programme'] as $programme){
                    //Get Infos
                    $prog = $this->programmeManager->getProgrammeById($programme);
                    $modele = $this->modeleManager->getModeleById($prog->getModele());
                    $personnel = $this->personnelManager->getPersonnelById($_POST['personnel'][0]);
                    $commande = $this->commandeManager->getCommandeById($prog->getCommande());

                    //Add Production
                    $item = array(
                        'desc' => $this->fieldValidation($_POST['type'][0]),
                        'creat' => date("Y-m-d"),
                        'mod' => date("Y-m-d"),
                        'rend' =>0,
                        'statut' =>0,
                        'somme' => $modele->getCoutModele(),
                        'quantite' => $_POST['quantite'][0],
                        'personnel' => $_POST['personnel'][0],
                        'cmt' => $programme,
                    );
                    $this->productionManager->addProductionBd($item);

                    //Add Audit
                    $audit = array(
                        'desc'=> $item['desc']." du modèle : ".$modele->getNomModele()." de la commande ".$commande->getDescCommande()." par le collaborateur ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
                        'action'=>'Ajout',
                        'creat'=>date("Y-m-d"),
                        'user'=>$_SESSION['id'],
                    );
                    $this->auditManager->addAuditBd($audit);
                }
            }
            //Découpage
            if (!empty($_POST['type'][1]) && !empty($_POST['personnel'][1])){
                foreach ($_POST['programme'] as $programme){
                    //Verify Quantity is correct
                    $qteArticleProd = $this->productionManager->countProductionByProgramme($programme,'Découpage');
                    $prog = $this->programmeManager->getProgrammeById($programme);
                    if (!empty($qteArticleProd) && $qteArticleProd[0]['qte'] < $prog->getQuantiteCmt()){
                        //Get Infos
                        $modele = $this->modeleManager->getModeleById($prog->getModele());
                        $personnel = $this->personnelManager->getPersonnelById($_POST['personnel'][1]);
                        $commande = $this->commandeManager->getCommandeById($prog->getCommande());

                        //Add Production
                        $item = array(
                            'desc' => $this->fieldValidation($_POST['type'][1]),
                            'creat' => date("Y-m-d"),
                            'mod' => date("Y-m-d"),
                            'rend' =>0,
                            'somme' =>$modele->getCoutDecoupModele(),
                            'statut' =>0,
                            'quantite' => $_POST['quantite'][1],
                            'personnel' => $_POST['personnel'][1],
                            'cmt' => $programme,
                        );
                        $this->productionManager->addProductionBd($item);

                        //Add audit
                        $audit = array(
                            'desc'=> $item['desc']." du modèle : ".$modele->getNomModele()." de la commande ".$commande->getDescCommande()." effectuée par le collaborateur ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
                            'action'=>'Ajout',
                            'creat'=>date("Y-m-d"),
                            'user'=>$_SESSION['id'],
                        );
                        $this->auditManager->addAuditBd($audit);
                    }
                }
            }
        }
        header('location: '.URL.'commande');
    }

    public function addSaveProgrammeOne()
    {
        if(!empty($_POST)){
            //Add production for personnel
            $item = array(
                'desc' => $this->fieldValidation($_POST['type']),
                'creat' => date("Y-m-d"),
                'mod' =>  date("Y-m-d"),
                'rend' => 0,
                'somme' => $this->fieldValidation($_POST['somme']),
                'quantite' => $this->fieldValidation($_POST['quantite']),
                'statut' =>0,
                'personnel' => $this->fieldValidation($_POST['personnel']) ,
                'cmt' =>$this->fieldValidation($_POST['id_cmt']),
            );
            $this->productionManager->addProductionBd($item);

            //Get infos
            $prog = $this->programmeManager->getProgrammeById($item['cmt']);
            $production = $this->productionManager->getProductionById($this->fieldValidation($_POST['id_prod']));
            $modele = $this->modeleManager->getModeleById($prog->getModele());
            $personnel = $this->personnelManager->getPersonnelById($item['personnel']);
            $commande = $this->commandeManager->getCommandeById($prog->getCommande());

            //Update somme for first personnel
            $cout = ($production->getDescProd() == 'Montage') ?  $modele->getCoutModele() : $modele->getCoutDecoupModele();
            $data_pers = array(
                'id'=>$this->fieldValidation($_POST['id_prod']),
                'somme'=> (!empty($_POST['somme']))? ($cout - $this->fieldValidation($_POST['somme'])): $cout,
                'mod'=>  date("Y-m-d"),
            );
            $this->productionManager->updateProductionSommeBD($data_pers);

            //Add audit
            $audit = array(
                'desc'=> $item['desc']." du modèle : ".$modele->getNomModele()." de la commande ".$commande->getDescCommande()." par le collaborateur ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
                'action'=>'Ajout',
                'creat'=>date("Y-m-d"),
                'user'=>$_SESSION['id'],
            );
            $this->auditManager->addAuditBd($audit);
        }

        header('location: '.URL.'commande');
    }

    public function closeArticle($id)
    {
        $data = array(
              'statut' => 1,
              'mod' => date("Y-m-d"),
              'id' => $id
        );
        $prod = $this->productionManager->getProductionById($id);
        $personnel = $this->personnelManager->getPersonnelById($prod->getPersonnel());
        $prog = $this->programmeManager->getProgrammeById($prod->getCmt());
        $modele = $this->modeleManager->getModeleById($prog->getModele());
        $commande = $this->commandeManager->getCommandeById($prog->getCommande());
        $client = $this->clientManager->getClientById($commande->getClient());
        $this->productionManager->updateProductionStatutBD($data);
        //Add audit
        $audit = array(
            'desc'=> "Fin des travaux du modèle : ".$modele->getNomModele()." de la commande ".
                $commande->getDescCommande()." du client ".$client->getNomClient()." ".$client->getPrenomclient().
                " par le collaborateur ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.
                $personnel->getContactPers(),
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);

        header('location: '.URL.'commande');
    }

    public function addSaveReportProgramme($commande)
    {
        //Add Report commande
        $data = array(
            'desc'=> $this->fieldValidation($_POST['desc']),
            'creat'=> $this->fieldValidation($_POST['date_report']),
            'mod'=> date("Y-m-d"),
            'commande'=> $commande,
        );
        $this->rdvManager->addRdvBd($data);

        //Add audit
        $cmd = $this->commandeManager->getCommandeById($commande);
        $audit = array(
            'desc'=> "Ajout du report de la commande : ".$cmd->getDescCommande()." date de Rdv: ".$data['creat'],
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);

        header('location: '.URL.'commande');
    }

    public function updateProgramme()
    {
        //Get Infos
        $production = $this->productionManager->getProductionById($this->fieldValidation($_POST['production']));
        $prog = $this->programmeManager->getProgrammeById($production->getCmt());
        $modele = $this->modeleManager->getModeleById($prog->getModele());
        $personnel = $this->personnelManager->getPersonnelById( $this->fieldValidation($_POST['personnel']));
        $commande = $this->commandeManager->getCommandeById($prog->getCommande());

        //Update Production
        $cout = ($this->fieldValidation($_POST['type']) == 'Montage')? $modele->getCoutModele():$modele->getCoutDecoupModele();
        $data = array(
            'id'=> $this->fieldValidation($_POST['production']),
            'personnel'=> $this->fieldValidation($_POST['personnel']),
            'desc'=> $this->fieldValidation($_POST['type']),
            'rend'=> $this->fieldValidation($_POST['rend']),
            'somme'=> $cout,
            'mod'=> date("Y-m-d"),
        );
        $this->productionManager->updateProductionBD($data);

        //Add audit
        $audit = array(
            'desc'=> "Modification du travail du modèle : ".$modele->getNomModele()." de la commande ".$commande->getDescCommande()." effectuée par le collaborateur ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        header('location: '.URL.'commande');
    }

    public function deleteProgramme($id)
    {
        //Delete charges and production
        $prod = $this->productionManager->getProductionById($id);
        $charges =  $this->chargeManager->getChargesProduction($prod);
        foreach ($charges as $charge){
            $this->chargeManager->deleteChargeBD($charge->getIdCharge());
        }

        //Get Infos
        $prog = $this->programmeManager->getProgrammeById($prod->getCmt());
        $modele = $this->modeleManager->getModeleById($prog->getModele());
        $personnel = $this->personnelManager->getPersonnelById($prod->getPersonnel());
        $commande = $this->commandeManager->getCommandeById($prog->getCommande());

        //Add audit
        $audit = array(
            'desc'=> "Suppression du travail du modèle : ".$modele->getNomModele()." de la commande ".$commande->getDescCommande()." effectuée par le collaborateur ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        //Delete Production
        $this->productionManager->deleteProductionBD($id);
        header('location: '.URL.'commande');
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

    public function closeProgramme($programmes)
    {
        foreach ($programmes as $programme){
            $prod = $this->productionManager->getProductionByCmt($programme->getIdCmt());
            if(!empty($prod)){
                $tot =0;
                $cpt = 0;
                foreach ($prod as $p){
                    if($p->getStatutProd() == 1){
                        $cpt ++;
                        $tot++;
                    }else{
                        $tot++;
                    }
                }
                //Close the task
                if ($tot == $cpt){
                    $data = array(
                        'statut' => 1,
                        'mod' => date("Y-m-d"),
                        'id' => $programme->getIdCmt()
                    );
                    $this->programmeManager->updateStatutProgrammeBD($data);
                }
            }
        }
    }

}