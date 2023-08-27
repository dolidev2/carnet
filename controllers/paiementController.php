<?php
require_once 'models/client/paiement/paiementClientManager.php';
require_once 'models/client/clientManager.php';
require_once 'models/client/commande/commandeClientManager.php';
require_once 'models/client/tissu/tissuClientManager.php';
require_once 'models/programme/programmeManager.php';
require_once 'models/modele/modeleManager.php';
require_once 'models/modele_composition/modeleCompManager.php';
require_once 'models/audit/auditManager.php';
require_once 'models/caisse/caisseManager.php';
require_once 'models/user/userManager.php';
require_once 'models/agence/agenceManager.php';
require_once 'models/config/config.php';

class paiementController
{
private $paiementManager;
private $clientManager;
private $commandeManager;
private $programmeManager;
private $modeleManager;
private $modeleCompoManager;
private $tissuManager;
private $auditManager;
private $caisseManager;
private $userManager;
private $agenceManager;
private $config;

public function __construct()
{
    $this->auditManager = new auditManager();

    $this->paiementManager = new paiementClientManager();
    $this->paiementManager->loadPaiement();

    $this->clientManager = new clientManager();
    $this->clientManager->loadClient();

    $this->commandeManager = new commandeClientManager();
    $this->commandeManager->loadCommande();

    $this->programmeManager = new programmeManager();
    $this->programmeManager->loadProgramme();

    $this->modeleManager = new modeleManager();
    $this->modeleManager->loadModele();

    $this->modeleCompoManager = new modeleCompManager();
    $this->modeleCompoManager->loadModeleComp();

    $this->tissuManager = new tissuClientManager();
    $this->tissuManager->loadTissu();

    $this->caisseManager = new caisseManager();
    $this->caisseManager->loadCaisse();

    $this->userManager = new userManager();
    $this->userManager->loadUser();

    $this->config = new configData();

    $this->agenceManager = new agenceManager();
    $this->agenceManager->loadAgence();
}

    public function displayPaiesCommande($commande)
    {
        $paies = $this->paiementManager->getPaiementsCommande($commande);
        require "views/client/info/home.php";
    }

    public function addPaie($id)
    {
        $commande = $this->commandeManager->getCommandeById($id);
        $client = $this->clientManager->getClientById($commande->getClient());
        $programmes = $this->programmeManager->getProgrammesCommande($commande);
        $data = [];
        $somme = $this->config->inactif;
        $remise = $this->config->inactif;
        if (!empty($programmes)){
            foreach ($programmes as $programme){
                $somme += $programme->getPrixCmt();
                $remise += $programme->getRemiseCmt();
                $simpleModele =  $this->modeleManager->getModeleById($programme->getModele());
                $compoModele =  $this->modeleCompoManager->getModeleCompById($programme->getModele());
               if(!empty($simpleModele)){
                   $nomModele = $simpleModele->getNomModele();
                   $prixModele = $simpleModele->getPrixModele();
               }
               if(!empty($compoModele)){
                   $nomModele = $compoModele->getNomModComp();
                   $prixModele = $compoModele->getPrixModComp();
               }
                $tissu = $this->tissuManager->getTissuById($programme->getTissu());
                if(!empty($tissu)){
                    if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!=0){
                        $somme +=$tissu->getPrixTissu();
                    }
                }
             
                $item = array(
                    'modele_nom'=>$nomModele,
                    'modele_prix'=>$prixModele,
                    'tissu'=>$tissu->getNomTissu(),
                );
                array_push($data,$item);
            }
        }

        $paies = $this->paiementManager->getPaiementsCommande($commande);
        $montant = $this->config->inactif;
        if (!empty($paies)){
            foreach ($paies as $paie){
                $montant += $paie->getSommePaie();
            }
        }
        $somme -= ($montant + $remise);
        $formAdd =  ( ($somme) == $this->config->inactif ) ? true : false ;

        require "views/client/paiement/add.php";
    }

    public function addSavePaie()
    {
        //Add Paiement
        $data = array(
            'somme'=> $this->fieldValidation($_POST['somme']),
            'desc'=> $this->fieldValidation($_POST['desc']),
            'commande'=> $this->fieldValidation($_POST['commande']),
            'type'=> $this->fieldValidation($_POST['type']),
            'creat'=> $this->fieldValidation($_POST['date_p']),
            'mod'=> date("Y-m-d"),
        );
        $id_paiement = $this->paiementManager->addPaiementBd($data);
        $commande = $this->commandeManager->getCommandeById($data['commande']);
        $client = $this->clientManager->getClientById($commande->getClient());

        //Add Caisse
        $desc = $data['type'].' de la commande :'.$commande->getDescCommande().' du client '.$client->getNomClient().' '.$client->getPrenomClient();
        $data_caisse = array(
            'somme'=> $data['somme'],
            'desc'=> $desc,
            'type'=> 'entre',
            'creat'=> date("Y-m-d"),
            'mod'=> date("Y-m-d"),
            'paiement'=> $id_paiement,
            'personnel'=>$this->config->inactif,
            'user'=> $_SESSION['id'],
            'agence'=> $_SESSION['agence'],
            'tissu'=> $this->config->inactif,
            'charge'=> $this->config->inactif,
        );
        $this->caisseManager->addCaisseBd($data_caisse);

        //Add audit
        $audit = array(
            'desc'=> "Ajout d'un paiement de : ".$data['somme']." motif ".$data['desc']. " de la commande : ".
                $commande->getDescCommande()." du client : ".$client->getNomclient().' '.$client->getPrenomclient().' '.$client->getContactclient(),
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function updatePaie($id)
    {
        $paieUp = $this->paiementManager->getPaiementById($id);
        $commande = $this->commandeManager->getCommandeById($paieUp->getCommande());
        $paies = $this->paiementManager->getPaiementsCommande($commande);

        $client = $this->clientManager->getClientById($commande->getClient());
        $programmes = $this->programmeManager->getProgrammesCommande($commande);

        $data = [];
        $somme = $this->config->inactif;
        $remise = $this->config->inactif;
        if (!empty($programmes)){
            foreach ($programmes as $programme){
                $somme += $programme->getPrixCmt();
                $remise += $programme->getRemiseCmt();
                $modele = $this->modeleManager->getModeleById($programme->getModele());
                $tissu = $this->tissuManager->getTissuById($programme->getTissu());

                if(!empty($tissu)){
                    if($tissu->getQuantiteTissu()!= $this->config->inactif && $tissu->getPrixTissu()!= $this->config->inactif){
                        $somme +=$tissu->getPrixTissu();
                    }
                }
                $item = array(
                    'modele_nom'=>$modele->getNomModele(),
                    'modele_prix'=>$modele->getPrixModele(),
                    'tissu'=>$tissu->getNomTissu(),
                );
                array_push($data,$item);
            }
        }

        $montant = $this->config->inactif;
        if (!empty($paies)){
            foreach ($paies as $pai){
                $montant += $pai->getSommePaie();
            }
        }

        $somme -= ($montant + $remise);
        $formAdd =  ( ($somme) == $this->config->inactif ) ? true : false ;
        require "views/client/paiement/update.php";
    }

    public function updateSavePaie($id)
    {
        $paie = $this->paiementManager->getPaiementById($id);
        $data = array(
            'somme'=> $this->fieldValidation($_POST['somme']),
            'type'=> $this->fieldValidation($_POST['type']),
            'desc'=> $this->fieldValidation($_POST['desc']),
            'id'=> $this->fieldValidation($_POST['paie']),
            'mod'=> date("Y-m-d"),
        );
        $this->paiementManager->updatePaiementBD($data);

        $commande = $this->commandeManager->getCommandeById($paie->getCommande());
        $client = $this->clientManager->getClientById($commande->getClient());

        $caisse = $this->caisseManager->getCaisseByPaiement($id);
        //Update Caisse
        $desc = 'Modification :'. $data['type'].' de la commande :'.$commande->getDescCommande().' du client '.$client->getNomClient().' '.$client->getPrenomClient();
        $data_caisse = array(
            'somme'=> $data['somme'],
            'desc'=> $desc,
            'type'=> 'entre',
            'mod'=> date("Y-m-d"),
            'id'=>$caisse->getIdCaisse(),
        );
        $this->caisseManager->updateCaisseBD($data_caisse);

        //Add audit
        $audit = array(
            'desc'=> "Modification du paiement de : ".$data['somme']." motif ".$data['desc']. " de la commande : ".
                $commande->getDescCommande()." du client : ".$client->getNomclient().' '.$client->getPrenomclient().' '.$client->getContactclient(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function deletePaie($id)
    {
        $paie = $this->paiementManager->getPaiementById($id);
        $commande = $this->commandeManager->getCommandeById($paie->getCommande());
        $client = $this->clientManager->getClientById($commande->getClient());
        $audit = array(
            'desc'=> "Suppression du paiement de : ".$paie->getSommePaie()." motif ".$paie->getDescPaie(). " de la commande : ".
                $commande->getDescCommande()." du client : ".$client->getNomclient().' '.$client->getPrenomclient().' '.$client->getContactclient(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);

        //Get id caisse
        $caisse = $this->caisseManager->getCaisseByPaiement($id);
        //delet caisse
        $this->caisseManager->deleteCaisseBD($caisse->getIdCaisse());

        $this->paiementManager->deletePaiementBD($id);
        header('location: '.URL.'client/info/'.$client->getIdClient().'/paiement_ajouter/'. $commande->getIdCommande());
    }

    public function recuPaie($id)
    {
        $paie = $this->paiementManager->getPaiementById($id);
        $commande =$this->commandeManager->getCommandeById($paie->getCommande());
        $client =$this->clientManager->getClientById($commande->getClient());
        $paies = $this->paiementManager->getPaiementsCommande($commande);
        $programmes = $this->programmeManager->getProgrammesCommande($commande);

        $somme = $this->config->inactif;
        $remise = $this->config->inactif;
        if (!empty($programmes)){
            foreach ($programmes as $programme){
                $somme += $programme->getPrixCmt();
                $remise += $programme->getRemiseCmt();
                $tissu = $this->tissuManager->getTissuById($programme->getTissu());
                if(!empty($tissu)){
                    if($tissu->getQuantiteTissu()!= $this->config->inactif && $tissu->getPrixTissu()!= $this->config->inactif){
                        $somme +=$tissu->getPrixTissu();
                    }
                }

            }
        }
        $somme -= $remise;

        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require 'views/client/paiement/recu.php';
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }
}