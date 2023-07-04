<?php
require_once "models/client/clientManager.php";
require_once "models/client/mesure/mesureClientManager.php";
require_once "models/client/tissu/tissuClientManager.php";
require_once "models/client/commande/commandeClientManager.php";
require_once "models/modele/modeleManager.php";
require_once "models/programme/programmeManager.php";
require_once "models/audit/auditManager.php";
require_once "models/agence/agenceManager.php";
require_once "models/client/tissu_image/tissuImageManager.php";

class clientController
{
    private $clientManager;
    private $mesureClientManager;
    private $tissuClientManager;
    private $commandeClientManager;
    private $modeleManager;
    private $programmeManager;
    private $auditManager;
    private $agenceManager;
    private $tissuImageManager;

    public function __construct()
    {
        $this->clientManager = new clientManager();
        $this->clientManager->loadClient();

        $this->mesureClientManager = new mesureClientManager();
        $this->mesureClientManager->loadMesure();

        $this->tissuImageManager = new tissuImageManager();
        $this->tissuImageManager->loadTissu();

        $this->tissuClientManager = new tissuClientManager();
        $this->tissuClientManager->loadTissu();

        $this->commandeClientManager = new commandeClientManager();
        $this->commandeClientManager->loadCommande();

        $this->modeleManager = new modeleManager();
        $this->modeleManager->loadModele();

        $this->programmeManager = new programmeManager();
        $this->programmeManager->loadProgramme();

        $this->agenceManager = new agenceManager();
        $this->agenceManager->loadAgence();

        $this->auditManager = new auditManager();

    }

    //Client Info
    public function displayClient()
    {
        $clients = $this->clientManager->getClients();
        require "views/client/info/home.php";
    }

    public function addClient()
    {
        $debut = DateTime::createFromFormat('Y-m-d', date("Y") . '-01-01')->format('Y-m-d');
        $fin = DateTime::createFromFormat('Y-m-d', date("Y") . '-12-31')->format('Y-m-d');
        $client = $this->clientManager->getClientFromYear($debut,$fin);
        $clients = $this->clientManager->getClients();
        $agences = $this->agenceManager->getAgences();
        if ( !empty($client[0])){
            $num = explode('-',$client[0]['numero_mesure']);
            $numero = 'CLTN°-'.($num[1]+1).'-'.date('Y');
        }else{
            $numero = 'CLTN°-'.'1'.'-'.date('Y');
        }
        require "views/client/info/add.php";
    }

    public function addSaveClient()
    {
        //Extract numero mesure of client
        $creat = $this->fieldValidation($_POST['creat']);
        $year = explode('-',$creat);
        $debut = DateTime::createFromFormat('Y-m-d', $year[0]. '-01-01')->format('Y-m-d');
        $fin = DateTime::createFromFormat('Y-m-d', $year[0] . '-12-31')->format('Y-m-d');
        $clients = $this->clientManager->getClientFromYear($debut,$fin);
        if (!empty($clients)){
            $num = explode('-',$clients[0]['numero_mesure']);
            $numero = 'CLTN°-'.($num[1]+1).'-'.$year[0];
        }else{
            $numero = 'CLTN°-'.'1'.'-'.$year[0];
        }

        $data = array(
            'nom'=> $this->fieldValidation($_POST['nom']),
            'prenom'=> $this->fieldValidation($_POST['prenom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'adresse'=> $this->fieldValidation($_POST['adresse']),
            'mesure'=> $numero,
            'client'=> $this->fieldValidation($_POST['client']),
            'type'=> $this->fieldValidation($_POST['type']),
            'boite'=> $this->fieldValidation($_POST['boite']),
            'ifu'=> $this->fieldValidation($_POST['ifu']),
            'rccm'=> $this->fieldValidation($_POST['rccm']),
            'division'=> $this->fieldValidation($_POST['division']),
            'regime'=> $this->fieldValidation($_POST['regime']),
            'creat'=> $this->fieldValidation($_POST['creat']),
            'agence'=> $this->fieldValidation($_POST['agence']),
        );

       $this->clientManager->addClientBd($data);
        $audit = array(
            'desc'=> "Ajout d'un nouveau client: ".$data['nom']." prénom ".$data['prenom']." contact ".$data['contact']. " mesure ".$data['mesure'],
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
//        $this->auditManager->addAuditBd($audit);
    }

    public function updateClient($id)
    {
        $clients = $this->clientManager->getClients();
        $client =  $this->clientManager->getClientById($id);
        $agences =  $this->agenceManager->getAgences();

        require "views/client/info/update.php";
    }

    public function updateSaveClient()
    {
        $agence = (isset($_POST['agence']) && !empty($_POST['agence']))? $_POST['agence'] : $_SESSION['agence'];
        $data = array(
            'nom'=> $this->fieldValidation($_POST['nom']),
            'prenom'=> $this->fieldValidation($_POST['prenom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'adresse'=> $this->fieldValidation($_POST['adresse']),
            'mesure'=> $this->fieldValidation($_POST['mesure']),
            'client'=> $this->fieldValidation($_POST['client']),
            'type'=> $this->fieldValidation($_POST['type']),
            'boite'=> $this->fieldValidation($_POST['boite']),
            'ifu'=> $this->fieldValidation($_POST['ifu']),
            'rccm'=> $this->fieldValidation($_POST['rccm']),
            'division'=> $this->fieldValidation($_POST['division']),
            'regime'=> $this->fieldValidation($_POST['regime']),
            'id'=> $this->fieldValidation($_POST['id']),
            'mod'=> date("Y-m-d"),
            'creat'=> $this->fieldValidation($_POST['creat']),
            'agence'=>$agence,
        );
        $this->clientManager->updateClientBD($data);
        $audit = array(
            'desc'=> "Modification du client: ".$data['nom']." prénom ".$data['prenom']." contact ".$data['contact']. " mesure ".$data['mesure'],
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function deleteClient($id)
    {
        $client =  $this->clientManager->getClientById($id);
        $audit = array(
            'desc'=> "Supression du client: ".$client->getNomClient()." prénom ".$client->getPrenomClient()." contact ".$client->getContactClient(). " mesure ".$client->getNumeroMesure(),
            'action'=>'Supression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->clientManager->deleteClientBD($id);
        header('location: '.URL.'client');
    }
    public function detailClient($id)
    {
        $client = $this->clientManager->getClientById($id);
        $mesures = $this->mesureClientManager->getMesuresClient($client);
        $tissus = $this->tissuClientManager->getTissusClient($client);
        $data_images = [];
        if (!empty($tissus)){
            foreach ($tissus as $tissu){
                $images = $this->tissuImageManager->getImagesTissu($tissu);
                array_push($data_images,$images);
            }
        }
        $nomDossierclient = str_replace(' ', '', $client->getNomClient()).'-'.
            str_replace(' ', '', $client->getPrenomClient()).'-'.str_replace(' ', '', $client->getContactClient());
        $commandes = $this->commandeClientManager->getCommandesClient($client);
        //Get all commandes
        $commandesClient = [];
        if(!empty($commandes)){
            foreach ($commandes as $commande){
                $somme = 0;
                $remise = 0;
                $programmes = $this->programmeManager->getProgrammesCommande($commande);
                if (!empty($programmes)){
                    foreach ($programmes as $programme){
                        $somme += $programme->getPrixCmt();
                        $remise += $programme->getRemiseCmt();
                        $tissu = $this->tissuClientManager->getTissuById($programme->getTissu());
                        if(!empty($tissu)){
                            if($tissu->getQuantiteTissu()!= 0 && $tissu->getPrixTissu()!= 0){
                                $somme +=$tissu->getPrixTissu();
                            }
                        }
                    }
                }
                $data = array(
                    'commande' => $commande,
                    'total' => ($somme -$remise)
                );
                array_push($commandesClient,$data);
            }
        }
        //get all commande, mesure, tissu,
        require "views/client/info/detail.php";
    }
    //End Client Info

    public function recommandation($id)
    {
        $client = $this->clientManager->getClientById($id);
        $parent = '';
        if (!empty($client)){
            if ($client->getClient()!= 0){
                $parent  = $this->clientManager->getClientById($client->getClient());
            }
            $clients = $this->clientManager->getClients();
            $enfants = [];
            foreach ($clients as $cl){
                if($cl->getClient() == $client->getIdClient()){
                    $petit = [];
                    foreach ($clients as $clt){
                        if ($cl->getIdClient() == $clt->getClient()){
                            $it = array(
                                'nom'=> $clt->getNomClient(),
                                'prenom'=> $clt->getPrenomClient(),
                            );
                            array_push($petit,$it);
                        }
                    }

                    $item = array(
                        'enfant'=>array(
                            'nom'=> $cl->getNomClient(),
                            'prenom'=> $cl->getPrenomClient(),
                        ),
                        'petit'=>$petit,
                    );
                    array_push($enfants,$item);
                }
            }
        }

        require "views/client/recommendation/home.php";
    }

    public function ajouterCommandeClient()
    {
        require "views/client/commande/add.php";
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }
}