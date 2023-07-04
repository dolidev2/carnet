<?php

require_once 'models/personnel/personnelManager.php';
require_once 'models/programme/programmeManager.php';
require_once 'models/paie_personnel/paiePersonnelManager.php';
require_once 'models/audit/auditManager.php';
require_once 'models/user/userManager.php';
require_once 'models/personnel_paiement/persPaieManager.php';
require_once 'models/caisse/caisseManager.php';
require_once 'models/agence/agenceManager.php';
require_once 'models/modele_personnel/modPersManager.php';
require_once 'models/modele/modeleManager.php';
require_once 'models/config/config.php';
require_once 'models/production/productionManager.php';
require_once 'models/programme/programmeManager.php';
require_once 'models/client/commande/commandeClientManager.php';

class personnelController
{
    private $personnelManager;
    private $programmeManager;
    private $paieManager;
    private $auditManager;
    private $userManager;
    private $persPaieManager;
    private $caisseManager;
    private $agenceManager;
    private $modPersManager;
    private $modeleManager;
    private $config;
    private $productionManager;
    private $commandeManager;

    public function __construct()
    {
        $this->auditManager = new auditManager();
        $this->config = new configData();

        $this->personnelManager = new personnelManager();
        $this->personnelManager->loadPersonnel();

        $this->programmeManager = new programmeManager();
        $this->programmeManager->loadProgramme();

        $this->paieManager = new paiePersonnelManager();
        $this->paieManager->loadPaies();

        $this->userManager = new userManager();
        $this->userManager->loadUser();

        $this->persPaieManager = new persPaieManager();
        $this->persPaieManager->loadPersPaie();

        $this->caisseManager = new caisseManager();
        $this->caisseManager->loadCaisse();

        $this->agenceManager = new agenceManager();
        $this->agenceManager->loadAgence();

        $this->modPersManager = new modPersManager();
        $this->modPersManager->loadmodPers();

        $this->modeleManager = new modeleManager();
        $this->modeleManager->loadModele();

        $this->productionManager = new productionManager();
        $this->productionManager->loadProduction();

        $this->commandeManager = new commandeClientManager();
        $this->commandeManager->loadCommande();

    }

    public function addPersonnel()
    {
        $agences = $this->agenceManager->getAgences();
        require 'views/personnel/add.php';
    }
    public function addSavePersonnel()
    {
        $repertoire = "public/image/personnel/";
        //Add Personnel
        if(!empty($_FILES['recto']['name'])){
            $recto = $_FILES['recto'];
            $ImageRecto = $this->uploadImage($recto,$repertoire);

        }else{
            $ImageRecto = '';
        }

        if (!empty($_FILES['verso']['name'])){
            $verso = $_FILES['verso'];
            $ImageVerso = $this->uploadImage($verso,$repertoire);
        }else{
            $ImageVerso = '';
        }

        $agence = (isset($_POST['agence']) && !empty($_POST['agence']))? $_POST['agence']:$_SESSION['agence'];
        $data = array(
            'nom'=> $this->fieldValidation($_POST['nom']),
            'prenom'=> $this->fieldValidation($_POST['prenom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'adresse'=> $this->fieldValidation($_POST['adresse']),
            'recto'=> $ImageRecto,
            'verso'=> $ImageVerso,
            'creat'=>date("Y-m-d"),
            'mod'=>date("Y-m-d"),
            'agence'=>$agence
        );
        $this->personnelManager->addPersonnelBd($data);

        //Add audit
        $audit = array(
            'desc'=> "Ajout d'un nouveau collaborateur: ".$data['nom'].' prénom '.$data['prenom'].' contact '.$data['contact'],
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        header('location: '.URL.'personnel');
    }

    public function displayPersonnel()
    {
        $personnels = $this->personnelManager->getPersonnels();
        require 'views/personnel/home.php';

    }

    public function detailPersonnel($id)
    {
        $jour = date('t', mktime(0, 0, 0, date("m"), 1, date("Y")));
        $date_debut = DateTime::createFromFormat('Y-m-d', date("Y") . '-' . date("m") . '-1')->format('Y-m-d');
        $date_fin = DateTime::createFromFormat('Y-m-d', date("Y") . '-' . date("m") . '-'.$jour)->format('Y-m-d');
        $personnel = $this->personnelManager->getPersonnelById($id);
        $programmes = $this->personnelManager->programmeArticles($id);

        //Type Prod
        $montage = $this->config->type_montage;
        $decoup = $this->config->type_decoupage;
        $inactif = $this->config->inactif;
        $actif= $this->config->actif;
        //End Type

        //Display chart production of personnel
        $data = [];
        $date = date("Y");
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'personnel'=>$id,
                'statut'=>0,
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            $productions = $this->personnelManager->loadPeriodProduction($item);
            $cout = $this->personnelManager->loadPeriodCout($item);
            $somme = 0;
            if(!empty($cout)){
                foreach ($cout as $ct){
                    $somme += $ct['somme_prod'] * $ct['quantite_prod'];
                }
            }
            $production = (isset($productions[0]['somme']) && $productions[0]['somme']!= NULL ) ? $productions[0]['somme'] : 0;
            $data_row = array(
                'mois'=> $i,
                'prod'=>$production,
                'cout'=>$somme
            );
            array_push($data,$data_row);
        }
        require 'views/personnel/detail.php';
        
    }

    public function periodePersonnel($id)
    {
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $personnel = $this->personnelManager->getPersonnelById($id);
        $programmes = $this->personnelManager->programmePeriodeArticles($id,$debut,$fin);
        //Display chart production of personnel
        $data = [];
        $date = date('Y', strtotime($fin));
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'personnel'=>$id,
                'statut'=>0,
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            $productions = $this->personnelManager->loadPeriodProduction($item);
            $cout = $this->personnelManager->loadPeriodCout($item);
            $somme = 0;
            if(!empty($cout)){
                foreach ($cout as $ct){
                    $somme += $ct['somme_prod'] * $ct['quantite_prod'];
                }
            }
            $production = (isset($productions[0]['somme'])) ? $productions[0]['somme'] : 0;
            $data_row = array(
                'mois'=> $i,
                'prod'=>$production,
                'cout'=>$somme
            );
            array_push($data,$data_row);
        }
        require 'views/personnel/detail_periode.php';
    }

    public function updatePersonnel($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        $agences = $this->agenceManager->getAgences();
        require 'views/personnel/update.php';
    }

    public function updateSavePersonnel($id)
    {
        //Update personnel
        $personnel = $this->personnelManager->getPersonnelById($id);
        $imageRectoOld = $personnel->getCnibRectoPers();
        $imageVersoOld = $personnel->getCnibVersoPers();
        $imageRecto = $_FILES['recto'];
        $imageVerso = $_FILES['verso'];

        if($imageRecto['size'] > 0){
            unlink("public/image/personnel/".$imageRectoOld);
            $repertoire =  $repertoire = "public/image/personnel/";
            $nomImageRecto = $this->uploadImage($imageRecto,$repertoire);
        } else {
            $nomImageRecto = $imageRectoOld;
        }

        if($imageVerso['size'] > 0){
            unlink("public/image/personnel/".$imageVersoOld);
            $repertoire =  $repertoire = "public/image/personnel/";
            $nomImageVerso = $this->uploadImage($imageVerso,$repertoire);
        } else {
            $nomImageVerso = $imageVersoOld;
        }
        $agence = (isset($_POST['agence']) && !empty($_POST['agence']))? $_POST['agence']:$_SESSION['agence'];
        $data = array(
            'nom'=> $this->fieldValidation($_POST['nom']),
            'prenom'=> $this->fieldValidation($_POST['prenom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'adresse'=> $this->fieldValidation($_POST['adresse']),
            'agence'=> $agence,
            'recto'=> $nomImageRecto,
            'verso'=> $nomImageVerso,
            'id'=>$id,
            'mod'=>date("Y-m-d")
        );
        $this->personnelManager->updatePersonnelBD($data);

        //Add audit
        $audit = array(
            'desc'=> "Modification des information du collaborateur: ".$data['nom'].' prénom '.$data['prenom'].' contact '.$data['contact'],
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        header('location: '.URL.'personnel');
    }

    public function deleteSavePersonnel($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        //Add audit
        $audit = array(
            'desc'=> "Suppression du collaborateur: ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->personnelManager->deletePersonnelBD($id);
        header('location: '.URL.'personnel');

    }

    public function deleteSavePersonnelPaiement($id)
    {
        $paie = $this->persPaieManager->getPersPaieById($id);
        $personnel = $this->personnelManager->getPersonnelById($paie->getPersonnel());

        //Add audit
        $audit = array(
            'desc'=> "Suppression du paiement de ". $paie->getSommePersPaie()."collaborateur: ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers()." pour la période du ". date("d-m-Y",strtotime($paie->getDebutPersPaie()))." au ".date("d-m-Y",strtotime($paie->getFinPersPaie())),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        //Delete Caisse
        $caisse = $this->caisseManager->getCaisseByPersonnel($id);
        $audit = array(
            'desc'=> "Suppression de la ligne de caisse ".$caisse->getDescCaisse()." dont le montant est ".$caisse->getSommeCaisse(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->caisseManager->deleteCaisseBD($caisse->getIdCaisse());
        $this->persPaieManager->deletepaieBD($id);
        header('location: '.URL.'personnel/paiement/'.$personnel->getIdPers());
    }

    public function StatPersonnel($id)
    {
        //Display chart production of personnel
        $jour = date('t', mktime(0, 0, 0, date("m"), 1, date("Y")));
        $date_debut = DateTime::createFromFormat('Y-m-d', date("Y") . '-' . date("m") . '-1')->format('Y-m-d');
        $date_fin = DateTime::createFromFormat('Y-m-d', date("Y") . '-' . date("m") . '-'.$jour)->format('Y-m-d');
        $personnel = $this->personnelManager->getPersonnelById($id);

        $data = [];
        $date = date("Y");
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'personnel'=>$id,
                'statut'=>0,
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            $productions = $this->personnelManager->loadPeriodProduction($item);
            $cout = $this->personnelManager->loadPeriodCout($item);
            $somme = 0;
            if(!empty($cout) && $cout != NULL){
                foreach ($cout as $ct){
                    $somme += $ct['somme_prod'] * $ct['quantite_cmt'];
                }
            }
            $production = (isset($productions[0]['somme']) && $productions[0]['somme']!= NULL ) ? $productions[0]['somme'] : 0;
            $data_row = array(
                'mois'=> $i,
                'prod'=>$production,
                'cout'=>$somme
            );
            array_push($data,$data_row);
        }
        require 'views/personnel/statistique.php';
    }

    public function StatPersonnelAnnee($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        //Display chart production of personnel for current year
        $data = [];
        $date = date("Y");
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $date));
            $date_debut = DateTime::createFromFormat('Y-m-d', $date . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $date . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'personnel'=>$id,
                'statut'=>0,
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            $productions = $this->personnelManager->loadPeriodProduction($item);
            $cout = $this->personnelManager->loadPeriodCout($item);
            $somme = 0;
            if(!empty($cout) && $cout != NULL){
                foreach ($cout as $ct){
                    $somme += $ct['somme_prod'] * $ct['quantite_cmt'];
                }
            }
            $production = (isset($productions[0]['somme']) && $productions[0]['somme']!= NULL ) ? $productions[0]['somme'] : 0;
            $data_row = array(
                'mois'=> $i,
                'prod'=>$production,
                'cout'=>$somme
            );
            array_push($data,$data_row);
        }

        //Display chart production of personnel for another year
        $data_annee = [];
        $year =$this->fieldValidation($_POST['dt_debut']);
        for ($i=1; $i<=12; $i++) {
            $jour = date('t', mktime(0, 0, 0, $i, 1, $year));
            $date_debut = DateTime::createFromFormat('Y-m-d', $year . '-' . $i . '-1')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', $year . '-' .$i .'-'.$jour)->format('Y-m-d');
            $item = array(
                'personnel'=>$id,
                'statut'=>0,
                'debut'=>$date_debut,
                'fin'=>$date_fin
            );
            $productions = $this->personnelManager->loadPeriodProduction($item);
            $cout = $this->personnelManager->loadPeriodCout($item);
            $somme = 0;
            if(!empty($cout) && $cout != NULL){
                foreach ($cout as $ct){
                    $somme += $ct['somme_prod'] * $ct['quantite_cmt'];
                }
            }
            $production = (isset($productions[0]['somme']) && $productions[0]['somme']!= NULL ) ? $productions[0]['somme'] : 0;
            $data_row = array(
                'mois'=> $i,
                'prod'=>$production,
                'cout'=>$somme
            );
            array_push($data_annee,$data_row);
        }
        require 'views/personnel/statistique.php';
    }

    public function paiementPdf($id,$debut,$fin,$paie)
    {
        $programmes = $this->personnelManager->programmePeriodeArticles($id,$debut,$fin);
        $avance = $this->personnelManager->avancePeriode($id,$debut,$fin);
        $personnel = $this->personnelManager->getPersonnelById($id);
        $tot = 0;
        if (!empty($avance) && $avance != NULL){
            foreach ($avance as $av){
                $tot += $av['somme_paie_pers'];
            }
        }
        $som = 0;
        if (!empty($programmes)){
            foreach ($programmes as $p){
                $som +=  (($p['quantite_prod'] * $p['somme_prod']) + ($p['quantite_prod']*$p['rend_prod']));
            }
            $paies = $this->persPaieManager->getPersPaieById($paie);
            if (isset($paie) && !empty($paie)){
                $item = array(
                    'somme'=>$som,
                    'id'=>$paies->getIdPersPaie(),
                );
                $this->persPaieManager->updateSommePersPaieBD($item);
                $caisse  = $this->caisseManager->getCaisseByPersonnel($paie);
                if ($caisse){
                    $data_caisee = array(
                        'somme' =>$som,
                        'mod' =>date("Y-m-d"),
                        'id' =>$caisse->getIdCaisse(),
                    );
                    $this->caisseManager->updateSommeCaisseBD($data_caisee);
                }
            }
        }
        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/personnel/pdf/paiement.php';
    }

    public function addAvanceSavePersonnel($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        //Add avance personnel
        $data = array(
            'somme' => $this->fieldValidation($_POST['somme']),
            'creat' => $this->fieldValidation($_POST['date']),
            'personnel'=>$id
        );
        $this->paieManager->addpaiesBd($data);

        //Add audit
        $audit = array(
            'desc'=> "Ajout d'une avance de: ".$data['somme']." pour ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        header('location: '.URL.'personnel/avance/'.$id);
    }

    public function displayAvancePersonnel($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        $avances = $this->paieManager->getPaiesByPersonnel($personnel);

        require "views/personnel/avance/home.php";
    }

    public function deleteAvanceSavePersonnel($idav)
    {
        $paiePers = $this->paieManager->getPaiesById($idav);
        $personnel = $this->personnelManager->getPersonnelById($paiePers->getPersonnel());

        //Add audit
        $audit = array(
            'desc'=> "Suppression de l'avance de ".$paiePers->getSommePaiePers()." de ".$personnel->getNomPers().' prénom '.$personnel->getNomPers().' contact '.$personnel->getContactPers(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->paieManager->deleteModeleBD($idav);
        header('location:'.URL."personnel/avance/".$personnel->getIdPers());
    }

    public function programmePersonnelPdf($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        $user  = $this->userManager->getUserById($_SESSION['id']);
        $taches = $this->programmeManager->programmeToDoArticlesPersonnel($id);
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);

        require 'views/personnel/pdf/programme.php';
    }

    public function displayPaiement($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        $paiements = $this->persPaieManager->getPersPaiePersonnel($personnel);

        require 'views/personnel/paiement/home.php';
    }
    public function addPaiementPers($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        $data = array(
           'somme'=>$this->fieldValidation($_POST['somme']),
           'debut'=>$this->fieldValidation($_POST['debut']),
           'fin'=>$this->fieldValidation($_POST['fin']),
           'creat'=>date("Y-m-d"),
           'personnel'=>$this->fieldValidation($id),
        );
        $id_paie = $this->persPaieManager->addPersPaieBD($data);
        //Add audit
        $audit = array(
            'desc'=> "Ajout du paiement de: ".$data['somme'].", période du ".date("d-m-Y",strtotime($data['debut'])) .
                " au ".date("d-m-Y",strtotime($data['fin'])) ." de".$personnel->getNomPers().' prénom '.
                $personnel->getPrenomPers().' contact '.$personnel->getContactPers(),
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $caisse = array(
            'somme'=>$this->config->inactif,
            'desc'=>"Paiement du personnel ".$personnel->getNomPers()." ".$personnel->getPrenomPers()." pour la période de ".$data['debut']." au ".$data['fin'],
            'type'=>$this->config->caisse_sortie,
            'creat'=>date("Y-m-d"),
            'mod'=>date("Y-m-d"),
            'paiement'=>$this->config->inactif,
            'personnel'=>$id_paie,
            'user'=>$_SESSION['id'],
            'agence'=>$_SESSION['agence'],
            'tissu'=>$this->config->inactif,
            'charge'=>$this->config->inactif,
        );
        $this->caisseManager->addCaisseBd($caisse);
        //Add audit
        $audit = array(
            'desc'=> "Ajout d'une entrée dans la caisse de: ".$caisse['somme'].", à la date du ".date("d-m-Y",strtotime($caisse['creat'])),
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function displayModelePersonnel($id)
    {
        $modPers = $this->modPersManager->getModelePersonnleDetail($id);
        $personnel = $this->personnelManager->getPersonnelById($id);
        $modeles = $this->modeleManager->getModeles();

        require "views/personnel/modele/home.php";
    }

    public function addModelePersonnel($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        $modeles = $this->modeleManager->getModeles();

        require "views/personnel/modele/add.php";
    }

    public function printModelePersonnel($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        $modPers = $this->modPersManager->getModelePersonnleDetail($id);

        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require "views/personnel/modele/pdf/production.php";
    }

    public function addSaveModelePersonnel($id)
    {
        $personnel = $this->personnelManager->getPersonnelById($id);
        if (!empty($_POST['modele'][0]) && !empty($_POST['qte_mod'][0]) ){
            for ($i=0; $i< count($_POST['modele']); $i++){
                 $modele = $this->modeleManager->getModeleById($_POST['modele'][$i]);
                 $item = array(
                     'modele'=>$this->fieldValidation($_POST['modele'][$i]),
                     'qte'=>$this->fieldValidation($_POST['qte_mod'][$i]),
                     'personnel'=>$id,
                     'creat'=>date("Y-m-d"),
                 );
                 $this->modPersManager->addmodPersBd($item);
                 //Add audit
                 $audit = array(
                     'desc'=> "Capacité de production de : ".$item[' qte']." du modèle ".$modele->getNomModele(). " de ".$personnel->getNomPers()." ".$personnel->getPrenomPers(),
                     'action'=>'Ajout',
                     'creat'=>date("Y-m-d"),
                     'user'=>$_SESSION['id'],
                 );
                 $this->auditManager->addAuditBd($audit);
            }
        }
        header('location: '.URL."personnel/production/".$personnel->getIdPers());

    }

    public function updateSaveModelePersonnel($idMod)
    {
        $modPers = $this->modPersManager->getmodPersById($idMod);
        $modele = $this->modeleManager->getModeleById($modPers->getModele());
        $personnel = $this->personnelManager->getPersonnelById($modPers->getPersonnel());
        $item = array(
            'modele' => $this->fieldValidation($_POST['modele']),
            'qte' => $this->fieldValidation($_POST['qte_mod']),
            'creat' => date("Y-m-d"),
            'id' => $idMod,
        );
        $this->modPersManager->updatemodPersBD($item);
        //Add audit
        $audit = array(
            'desc'=> "Modification de la capacité de production de : ".$item[' qte']." du modèle ".$modele->getNomModele(). " de ".$personnel->getNomPers()." ".$personnel->getPrenomPers(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);

        header('location: '.URL."personnel/production/".$personnel->getIdPers());
    }

    public function deleteSaveModelePersonnel($idMod)
    {
        $modPers = $this->modPersManager->getmodPersById($idMod);
        $modele = $this->modeleManager->getModeleById($modPers->getModele());
        $personnel = $this->personnelManager->getPersonnelById($modPers->getPersonnel());
        //Add audit
        $audit = array(
            'desc'=> "Suppression de la capacité de production de : ".$modPers->getQteModPers()." du modèle ".$modele->getNomModele(). " de ".$personnel->getNomPers()." ".$personnel->getPrenomPers(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->modPersManager->deletemodPersBD($idMod);

        header('location: '.URL."personnel/production/".$personnel->getIdPers());
    }

    public function updateSaveProduction($prod)
    {
        $production = $this->productionManager->getProductionById($prod);
        $programme = $this->programmeManager->getProgrammeById($production->getCmt());
        $commande = $this->commandeManager->getCommandeById($programme->getCommande());
        $modele = $this->modeleManager->getModeleById($programme->getModele());
        $personnel = $this->personnelManager->getPersonnelById($production->getPersonnel());

        $data=array(
          'type'=>$this->fieldValidation($_POST['type_prod']),
          'quantite'=>$this->fieldValidation($_POST['quantite_prod']),
          'debut'=>$this->fieldValidation($_POST['debut']),
          'fin'=>$this->fieldValidation($_POST['fin']),
          'rend'=>$this->fieldValidation($_POST['rend_prod']),
          'statut'=>$this->fieldValidation($_POST['statut_prod']),
          'somme'=>$this->fieldValidation($_POST['somme_prod']),
          'id'=>$prod,
        );

        //Add audit
        $audit = array(
            'desc'=> "Modification des informations de la production description: ".$data['type']." somme : ".$data['somme'].
                " quantité ".$data['quantite']. " rendement ".$data['rend']." du modèle ".$modele->getNomModele()." de la commande : "
                .$commande->getDescCommande(). "  du collaborateur : ".$personnel->getNomPers()." ".$personnel->getPrenomPers(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->productionManager->updateProductionPersonnelBD($data);
        header('location: '.URL."personnel/detail/".$production->getPersonnel());
    }

    public function deleteSaveProduction($prod)
    {
        $production = $this->productionManager->getProductionById($prod);
        $programme = $this->programmeManager->getProgrammeById($production->getCmt());
        $commande = $this->commandeManager->getCommandeById($programme->getCommande());
        $modele = $this->modeleManager->getModeleById($programme->getModele());
        $personnel = $this->personnelManager->getPersonnelById($production->getPersonnel());

        //Add audit
        $audit = array(
            'desc'=> "Suppression de la production description: ".$production->getDescProd()." somme : ".$production->getSommeProd().
                " quantité ".$production->getQuantiteProd(). " rendement ".$production->getRendProd()." du modèle ".$modele->getNomModele()." de la commande : "
                .$commande->getDescCommande(). "  du collaborateur : ".$personnel->getNomPers()." ".$personnel->getPrenomPers(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->productionManager->deleteProductionBD($prod);
        header('location: '.URL."personnel/detail/".$production->getPersonnel());
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

    private function uploadImage($file, $dir){
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");

        if(!file_exists($dir)) mkdir($dir,0777);

        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];

        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        if($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file['name']);
    }
}