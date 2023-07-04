<?php
require_once "models/client/commande/commandeClientManager.php";
require_once "models/programme/programmeManager.php";
require_once "models/client/clientManager.php";
require_once "models/personnel/personnelManager.php";
require_once "models/user/userManager.php";
require_once "models/audit/auditManager.php";
require_once "models/client/tissu/tissuClientManager.php";
require_once "models/caisse/caisseManager.php";

class statistiqueController
{
    private $commandeManager;
    private $programmeManager;
    private $clientManager;
    private $personnelManager;
    private $userManager;
    private $auditManager;
    private $tissuManager;
    private $caisseManager;

    public function __construct()
    {
        $this->commandeManager = new commandeClientManager();
        $this->commandeManager->loadCommande();

        $this->programmeManager = new programmeManager();
        $this->programmeManager->loadProgramme();

        $this->clientManager = new clientManager();
        $this->clientManager->loadClient();

        $this->personnelManager = new personnelManager();
        $this->personnelManager->loadPersonnel();

        $this->userManager = new userManager();
        $this->userManager->loadUser();

        $this->auditManager = new auditManager();
        $this->auditManager->loadAudit();

        $this->tissuManager = new tissuClientManager();
        $this->tissuManager->loadTissu();

        $this->caisseManager = new caisseManager();
        $this->caisseManager->loadCaisse();
    }

    public function displayHome()
    {
        //Get info personnel task
        $personnels = $this->personnelManager->getPersonnelByAgence($_SESSION['agence']);
        $data_pers = [];
        $column = 0;
        if(!empty($personnels)){
            foreach ($personnels as $personnel){
                $task = $this->programmeManager->programmeToDoArticlesPersonnel($personnel->getIdPers());
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
        //Get info Commande
        $data_commande = [];
        $commandes = $this->programmeManager->getCommandeRdvDetail($_SESSION['agence']);
        if(!empty($commandes)):
            foreach ($commandes as $commande):
                $cmd = $this->commandeManager->getCommandeById($commande['id_commande']);
                $programmes =  $this->programmeManager->getProgrammesCommande($cmd);
                if (!empty($programmes)):
                    $somme = 0;
                    $tache = 0;
                    foreach ($programmes as $programme):
                        $somme += $programme->getPrixCmt();
                        if($programme->getStatutCmt() == 1):
                            $tache++;
                        endif;
                    endforeach;
                    $item = array(
                        'nom' => $commande['nom_client'],
                        'prenom' => $commande['prenom_client'],
                        'contact' => $commande['contact_client'],
                        'desc' => $commande['desc_commande'],
                        'rdv' => $commande['rdv_commande'],
                        'somme' => $somme,
                        'tache' => $tache,
                        'total' => count($programmes),
                    );
                    array_push($data_commande, $item);
                endif;
            endforeach;
        endif;
        //Liste commandes clients
        $commandes_client = $this->commandeManager->getCommandes();
        if (!empty($commandes_client)){
            $data_cmd = [];
            foreach ($commandes_client as $cmd){
                if($cmd->getStatutCommande() == 0 ){
                    $client = $this->clientManager->getClientById($cmd->getClient());
                    $item = array(
                        'nom' => $client->getNomClient(),
                        'prenom' => $client->getPrenomClient(),
                        'contact' => $client->getContactClient(),
                        'client' => $client->getIdClient(),
                        'desc' => $cmd->getDescCommande(),
                        'creat' => $cmd->getCreatCommande(),
                        'rdv' => $cmd->getRdvCommande(),
                        'commande' => $cmd->getIdCommande(),
                    );
                    array_push($data_cmd,$item);
                }
            }
        }
        require "views/partials/home.php";
    }

    public function statistiqueClient($client,$annee)
    {
        $date = !empty($annee) ? $annee: date("Y");
        $data = [];
        $data_modele = [];
        $array_modele = [];
        $array_recette = [];
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'client'=>$client,
                'type'=>'entre',
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            //Chiffre d'Affaire
            $chiffreAffaire = $this->commandeManager->loadChiffreAffaire($item);
            //Frequence couture
            $results = $this->commandeManager->loadCoutureClientPeriode($item);
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result = (isset($results[0]['somme']) ) ? $results[0]['somme'] : 0;
            $result += $somme;

            $chiffreSomme = (isset($chiffreAffaire[0]['somme']) ) ? $chiffreAffaire[0]['somme'] : 0;
            $chiffreSomme += $somme;

            $data_row = array(
                'mois'=> $i,
                'montant'=>$result,
                'chiffre'=>$chiffreSomme
            );
            array_push($data,$data_row);

            //Recettes && Depenses
            $cout_modeles= $this->commandeManager->loadCoutureClientPeriode($item);
            $result = (isset($cout_modeles[0]['somme']) ) ? $cout_modeles[0]['somme'] : 0;
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result +=$somme;

            $cout_coutures = $this->commandeManager->loadCoutureDepensePeriod($item);
            $sommeCharge = 0;
            if (!empty($cout_charges) && $cout_charges != NULL){
                foreach ($cout_charges as $cout){
                    $sommeCharge += $cout['charge'];
                }
            }
            if(!empty($cout_coutures)){
                foreach ($cout_coutures as $cout) {
                    $sommeCharge += $cout['rend_prod'] + ($cout['somme_prod'] * $cout['quantite_prod']);
                }
            }
            $data_rows = array(
                'mois'=> $i,
                'charge'=>$sommeCharge,
                'profit'=>$result,
            );
            array_push($array_recette, $data_rows);
        }

        //Liste des modeles pour l'annee
        $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-01-01')->format('Y-m-d');
        $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-12-31')->format('Y-m-d');
        $item = array(
            'client'=>$client,
            'debut'=>$date_debut,
            'fin'=>$date_fin,
        );
        $profitModele = $this->commandeManager->loadProfitCouture($item);
        $liste_modele = [];
        if(!empty($profitModele) ){
            foreach ($profitModele as $profit){
                $total = 0;
                $item['modele'] = $profit['id_modele'];
                $couts_modele = $this->commandeManager->loadCoutureDepensePeriodByModele($item);
                if(!empty($couts_modele)){
                    foreach ($couts_modele as $cout){
                        $total += $cout['rend_prod'] + ( $cout['somme_prod'] * $cout['quantite_prod']);
                    }
                }
                $array = array(
                    'modele'=> $profit['nom_modele'],
                    'profit'=> $profit['profit'],
                    'charge'=> $total,
                );
                array_push($liste_modele, $array);
            }
        }
        $clients = $this->clientManager->getClientById($client);

        require "views/client/info/statistique.php";
    }

    public function frequenceCouture($client)
    {
        $date = date("Y");
        $data = [];
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'client'=>$client,
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            //Chiffre d'Affaire
            $chiffreAffaire = $this->commandeManager->loadChiffreAffaire($item);
            //Frequence couture
            $results = $this->commandeManager->loadCoutureClientPeriode($item);
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result = (isset($results[0]['somme']) ) ? $results[0]['somme'] : 0;
            $result += $somme;

            $chiffreSomme = (isset($chiffreAffaire[0]['somme']) ) ? $chiffreAffaire[0]['somme'] : 0;
            $chiffreSomme += $somme;

            $data_row = array(
                'mois'=> $i,
                'montant'=>$result,
                'chiffre'=>$chiffreSomme
            );
            array_push($data,$data_row);
        }
        $clients = $this->clientManager->getClientById($client);
        require "views/client/statistique/frequence_couture.php";
    }

    public function frequenceCoutureAnnee($client)
    {
        //Annee en cours
        $date = date("Y");
        $data = [];
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'client'=>$client,
                'type'=>'entre',
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            //Chiffre d'Affaire
            $chiffreAffaire = $this->commandeManager->loadChiffreAffaire($item);
            //Frequence couture
            $results = $this->commandeManager->loadCoutureClientPeriode($item);
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result = (isset($results[0]['somme']) ) ? $results[0]['somme'] : 0;
            $result += $somme;

            $chiffreSomme = (isset($chiffreAffaire[0]['somme']) ) ? $chiffreAffaire[0]['somme'] : 0;
            $chiffreSomme += $somme;

            $data_row = array(
                'mois'=> $i,
                'montant'=>$result,
                'chiffre'=>$chiffreSomme
            );
            array_push($data,$data_row);
        }

        //Annee choisir
        $year = $this->fieldValidation($_POST['dt_debut']);
        $data_choose = [];
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $year));
            $date_debut = DateTime::createFromFormat('Y-m-d', $year . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $year . '-' . $i . '-'.$jour)->format('Y-m-d');
            $item = array(
                'client'=>$client,
                'type'=>'entre',
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            //Chiffre d'Affaire
            $chiffreAffaire = $this->commandeManager->loadChiffreAffaire($item);
            //Frequence couture
            $results = $this->commandeManager->loadCoutureClientPeriode($item);
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result = (isset($results[0]['somme']) ) ? $results[0]['somme'] : 0;
            $result += $somme;

            $chiffreSomme = (isset($chiffreAffaire[0]['somme']) ) ? $chiffreAffaire[0]['somme'] : 0;
            $chiffreSomme += $somme;

            $data_row = array(
                'mois'=> $i,
                'montant'=>$result,
                'chiffre'=>$chiffreSomme
            );
            array_push($data_choose,$data_row);
        }

        $clients = $this->clientManager->getClientById($client);
        require "views/client/statistique/frequence_couture.php";
    }
    public function profitCouture($client)
    {
        $date = date("Y");
        $array_recette = [];
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'client'=>$client,
                'type'=>'entre',
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            //Recettes && Depenses
            $cout_modeles= $this->commandeManager->loadCoutureClientPeriode($item);
            $result = (isset($cout_modeles[0]['somme']) ) ? $cout_modeles[0]['somme'] : 0;
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result +=$somme;

            $cout_coutures = $this->commandeManager->loadCoutureDepensePeriod($item);
            $sommeCharge = 0;
            if (!empty($cout_charges) && $cout_charges != NULL){
                foreach ($cout_charges as $cout){
                    $sommeCharge += $cout['charge'];
                }
            }
            if(!empty($cout_coutures)){
                foreach ($cout_coutures as $cout) {
                    $sommeCharge += $cout['rend_prod'] + ($cout['somme_prod'] * $cout['quantite_prod']);
                }
            }
            $data_rows = array(
                'mois'=> $i,
                'charge'=>$sommeCharge,
                'profit'=>$result,
            );
            array_push($array_recette, $data_rows);
        }

        $clients = $this->clientManager->getClientById($client);
        require "views/client/statistique/recette_depense.php";
    }

    public function profitCoutureAnne($client)
    {
        $date = date("Y");
        $array_recette = [];
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'client'=>$client,
                'type'=>'entre',
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            //Recettes && Depenses
            $cout_modeles= $this->commandeManager->loadCoutureClientPeriode($item);
            $result = (isset($cout_modeles[0]['somme']) ) ? $cout_modeles[0]['somme'] : 0;
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result +=$somme;

            $cout_coutures = $this->commandeManager->loadCoutureDepensePeriod($item);
            $sommeCharge = 0;
            if (!empty($cout_charges) && $cout_charges != NULL){
                foreach ($cout_charges as $cout){
                    $sommeCharge += $cout['charge'];
                }
            }
            if(!empty($cout_coutures)){
                foreach ($cout_coutures as $cout) {
                    $sommeCharge += $cout['rend_prod'] + ($cout['somme_prod'] * $cout['quantite_prod']);
                }
            }
            $data_rows = array(
                'mois'=> $i,
                'charge'=>$sommeCharge,
                'profit'=>$result,
            );
            array_push($array_recette, $data_rows);
        }
        //Annee choisir
        $data = [];
        $year = $this->fieldValidation($_POST['dt_debut']);
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $year));
            $date_debut = DateTime::createFromFormat('Y-m-d', $year . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $year . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'client'=>$client,
                'type'=>'entre',
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            //Recettes && Depenses
            $cout_modeles= $this->commandeManager->loadCoutureClientPeriode($item);
            $result = (isset($cout_modeles[0]['somme']) ) ? $cout_modeles[0]['somme'] : 0;
            //Get price of tissu if exist
            $programmes = $this->commandeManager->loadFrequenceCouturePeriodId($item);
            $somme =0;
            if (!empty($programmes)){
                foreach ($programmes as $programme) {
                    $tissu = $this->tissuManager->getTissuById($programme['tissu']);
                    if(!empty($tissu)){
                        if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                            $somme +=$tissu->getPrixTissu();
                        }
                    }
                }
            }
            $result +=$somme;

            $cout_coutures = $this->commandeManager->loadCoutureDepensePeriod($item);
            $sommeCharge = 0;
            if (!empty($cout_charges) && $cout_charges != NULL){
                foreach ($cout_charges as $cout){
                    $sommeCharge += $cout['charge'];
                }
            }
            if(!empty($cout_coutures)){
                foreach ($cout_coutures as $cout) {
                    $sommeCharge += $cout['rend_prod'] + ($cout['somme_prod'] * $cout['quantite_prod']);
                }
            }
            $data_rows = array(
                'mois'=> $i,
                'charge'=>$sommeCharge,
                'profit'=>$result,
            );
            array_push($data, $data_rows);
        }

        $clients = $this->clientManager->getClientById($client);
        require "views/client/statistique/recette_depense.php";

    }

    public function modele($client)
    {
        //Liste des modeles pour l'annee
        $date = date("Y");
        $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-01-01')->format('Y-m-d');
        $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-12-31')->format('Y-m-d');
        $item = array(
            'client'=>$client,
            'debut'=>$date_debut,
            'fin'=>$date_fin,
        );
        $profitModele = $this->commandeManager->loadProfitCouture($item);
        $liste_modele = [];
        if(!empty($profitModele) ){
            foreach ($profitModele as $profit){
                $total = 0;
                $item['modele'] = $profit['id_modele'];
                $couts_modele = $this->commandeManager->loadCoutureDepensePeriodByModele($item);
                if(!empty($couts_modele)){
                    foreach ($couts_modele as $cout){
                        $total += $cout['rend_prod'] + ( $cout['somme_prod'] * $cout['quantite_prod']);
                    }
                }
                $array = array(
                    'modele'=> $profit['nom_modele'],
                    'profit'=> $profit['profit'],
                    'charge'=> $total,
                );
                array_push($liste_modele, $array);
            }
        }

        $clients = $this->clientManager->getClientById($client);
        require "views/client/statistique/modele.php";
    }

    public function modeleAnnee($client)
    {
        //Liste des modeles pour l'annee
        $date = date("Y");
        $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-01-01')->format('Y-m-d');
        $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-12-31')->format('Y-m-d');
        $item = array(
            'client' => $client,
            'debut' => $date_debut,
            'fin' => $date_fin,
        );
        $profitModele = $this->commandeManager->loadProfitCouture($item);
        $liste_modele = [];
        if (!empty($profitModele)) {
            foreach ($profitModele as $profit) {
                $total = 0;
                $item['modele'] = $profit['id_modele'];
                $couts_modele = $this->commandeManager->loadCoutureDepensePeriodByModele($item);
                if (!empty($couts_modele)) {
                    foreach ($couts_modele as $cout) {
                        $total += $cout['rend_prod'] + ($cout['somme_prod'] * $cout['quantite_prod']);
                    }
                }
                $array = array(
                    'modele' => $profit['nom_modele'],
                    'profit' => $profit['profit'],
                    'charge' => $total,
                );
                array_push($liste_modele, $array);
            }
        }

        if (!empty($profitModele)) {
            //Annee Choisir
            $year = $this->fieldValidation($_POST['dt_debut']);
            $date_debut = DateTime::createFromFormat('Y-m-d', $year . '-01-01')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $year . '-12-31')->format('Y-m-d');
            $item = array(
                'client' => $client,
                'debut' => $date_debut,
                'fin' => $date_fin
            );
            $profitModele = $this->commandeManager->loadProfitCouture($item);
            $data = [];
            if (!empty($profitModele)) {
                foreach ($profitModele as $profit) {
                    $total = 0;
                    $item['modele'] = $profit['id_modele'];
                    $couts_modele = $this->commandeManager->loadCoutureDepensePeriodByModele($item);
                    if (!empty($couts_modele)) {
                        foreach ($couts_modele as $cout) {
                            $total += $cout['rend_prod'] + ($cout['somme_prod'] * $cout['quantite_prod']);
                        }
                    }
                    $array = array(
                        'modele' => $profit['nom_modele'],
                        'profit' => $profit['profit'],
                        'charge' => $total,
                    );
                    array_push($data, $array);
                }
            }
            $clients = $this->clientManager->getClientById($client);
            require "views/client/statistique/modele.php";
        }
    }


    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

}