<?php
require_once "models/client/clientManager.php";
require_once "models/client/tissu/tissuClientManager.php";
require_once "models/audit/auditManager.php";
require_once "models/client/tissu_image/tissuImageManager.php";
require_once "models/caisse/caisseManager.php";
require_once "models/config/config.php";

class tissuController
{
    private $tissuManager;
    private $clientManager;
    private $auditManager;
    private $tissuImageManager;
    private $caisseManager;
    private $config;

public function __construct()
{
    $this->auditManager = new auditManager();

    $this->clientManager = new clientManager();
    $this->clientManager->loadClient();

    $this->tissuImageManager = new tissuImageManager();
    $this->tissuImageManager->loadTissu();

    $this->tissuManager = new tissuClientManager();
    $this->tissuManager->loadTissu();

    $this->caisseManager = new caisseManager();

    $this->config = new configData();

}
    public function addTissu($id)
    {
        $client = $this->clientManager->getClientById($id);
        require "views/client/tissu/add.php";
    }

    public function addSaveTissu()
    {
        $data = array(
            'nom' => $this->fieldValidation($_POST['nom']),
            'desc' => $this->fieldValidation($_POST['desc']),
            'quantite' => $this->fieldValidation($_POST['qte']),
            'prix' => $this->fieldValidation($_POST['prix']),
            'com' => $this->fieldValidation($_POST['com']),
            'creat' => date("y-m-d"),
            'mod' => date("y-m-d"),
            'statut' => $this->config->inactif,
            'client' => $this->fieldValidation($_POST['client']),
        );
        $idTissu = $this->tissuManager->addTissuBd($data);

        $client = $this->clientManager->getClientById($data['client']);
        $nomClient = str_replace(' ', '', $client->getNomClient());
        $prenomClient = str_replace(' ', '', $client->getPrenomClient());
        $contactClient = str_replace(' ', '', $client->getContactClient());
        $nomDossierclient = $nomClient.'-'.$prenomClient.'-'.$contactClient;
        $repertoire = "public/image/tissu/".$nomDossierclient.'/';

        if (!empty($_FILES['image']['name'][0])){
            $images = $_FILES['image'];
            for($i=0; $i< count($images); $i++){
                if($images['size'][$i] > 0){
                $nomImageAjoute = $this->uploadImage($images['name'][$i],$images['tmp_name'][$i],$repertoire);
                $data_image = array(
                    'image' => $nomImageAjoute,
                    'creat' => date("Y-m-d"),
                    'mod' => date("Y-m-d"),
                    'tissu' => $idTissu ,
                );
                $this->tissuImageManager->addTissuImageBD($data_image);
                }
            }
        }

        //Add Caisse
        if ($data['com']!= 0){
            $item = array(
                'somme' => $data['com'],
                'desc' => "Achat de tisssu ".$data['nom']." pour le client ".$client->getNomClient()." ".$client->getPrenomClient(),
                'type' => 'entre',
                'creat' => date("Y-m-d"),
                'mod' => date("Y-m-d"),
                'user' => $_SESSION['id'],
                'agence' =>$_SESSION['agence'],
                'paiement' =>$this->config->inactif,
                'personnel' =>$this->config->inactif,
                'tissu' =>$idTissu,
                'charge' =>$this->config->inactif,
            );
            $this->caisseManager->addCaisseBd($item);
            //Add audit
            $audit = array(
                'desc'=> "Achat de tisssu ".$data['nom']." pour le client ".$client->getNomClient()." ".$client->getPrenomClient(),
                'action'=>'Ajout',
                'creat'=>date("Y-m-d"),
                'user'=>$_SESSION['id'],
            );
            $this->auditManager->addAuditBd($audit);
        }
        //Add audit
        $audit = array(
            'desc'=> "Ajout d'un tissu ".$data['nom']. " description : ".$data['desc']." Client : ".$client->getNomClient(),
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);

        header('location: '.URL.'client/info/'.$_POST['client']);
    }

    public function updateTissu($id)
    {
        $tissu = $this->tissuManager->getTissuById($id);
        $client = $this->clientManager->getClientById($tissu->getClient());
        $nomDossierclient = str_replace(' ', '', $client->getNomClient()).'-'.
            str_replace(' ', '', $client->getPrenomClient()).'-'.str_replace(' ', '', $client->getContactClient());
        require "views/client/tissu/update.php";
    }

    public function updateSaveTissu($id)
    {
        $tissu = $this->tissuManager->getTissuById($id);
        $client = $this->clientManager->getClientById($tissu->getClient());
        $nomDossierclient = str_replace(' ', '', $client->getNomClient()).'-'.
            str_replace(' ', '', $client->getPrenomClient()).'-'.str_replace(' ', '', $client->getContactClient());

        if (!empty($_FILES['image']['name'][0])){
            $images = $_FILES['image'];
            $repertoire = "public/image/tissu/".$nomDossierclient.'/';
            $imagesOld =  $this->tissuImageManager->getImagesTissu($tissu);
            foreach ($imagesOld as $image){
                unlink("public/image/tissu/".$nomDossierclient.'/'.$image->getImageTissu());
                $this->tissuImageManager->deleteTissuImageBD($image->getIdTissuImage());
            }
            for($i=0; $i< count($images); $i++){
                if($images['size'][$i] > 0){
                    $nomImageAjoute = $this->uploadImage($images['name'][$i],$images['tmp_name'][$i],$repertoire);
                    $data_image = array(
                        'image' => $nomImageAjoute,
                        'creat' => date("Y-m-d"),
                        'mod' => date("Y-m-d"),
                        'tissu' => $id ,
                    );
                    $this->tissuImageManager->addTissuImageBD($data_image);
                }
            }
        }
        $data = array(
            'nom' => $this->fieldValidation($_POST['nom']),
            'desc' => $this->fieldValidation($_POST['desc']),
            'quantite' => $this->fieldValidation($_POST['qte']),
            'prix' => $this->fieldValidation($_POST['prix']),
            'com' => $this->fieldValidation($_POST['com']),
            'mod' => date("Y-m-d"),
            'id' => $id,
        );
        $this->tissuManager->updateTissuBd($data);

        $audit = array(
            'desc'=> "Modification du tissu ".$data['nom']. " description : ".$data['desc']." Client : ".$client->getNomClient(),
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);

        //Update Tissu
        if ($data['com'] != $this->config->inactif){
            $caisse = $this->caisseManager->getCaisseByTissu($id);
            $item = array(
                'somme' => $data['com'],
                'desc' => "Modification du tisssu ".$data['nom']." pour le client ".$client->getNomClient()." ".$client->getPrenomClient(),
                'type' => 'entre',
                'mod'=> date("Y-m-d"),
                'id'=>$caisse->getIdCaisse()
            );
            $this->caisseManager->updateCaisseBD($item);
        }
        header('location: '.URL.'client/info/'.$client->getIdClient());
    }

    public function displayTissu($id)
    {
        $tissu = $this->tissuManager->getTissuById($id);
        $client = $this->clientManager->getClientById($tissu->getClient());
        $nomDossierclient = str_replace(' ', '', $client->getNomClient()).'-'.
            str_replace(' ', '', $client->getPrenomClient()).'-'.str_replace(' ', '', $client->getContactClient());
        require "views/client/tissu/detail.php";
    }

    public function deleteTissu($id)
    {
        $tissu = $this->tissuManager->getTissuById($id);

        $client = $this->clientManager->getClientById($tissu->getClient());
        $tissuImages = $this->tissuImageManager->getImagesTissu($tissu);
        $nomDossierclient = str_replace(' ', '', $client->getNomClient()).'-'.
            str_replace(' ', '', $client->getPrenomClient()).'-'.str_replace(' ', '', $client->getContactClient());

        //Delete Tissu Image
        if (!empty($tissuImages)){
            foreach ($tissuImages as $img){
                unlink("public/image/tissu/".$nomDossierclient.'/'.$img->getImageTissu());
                $this->tissuImageManager->deleteTissuImageBD($img->getIdTissuImage());
            }
        }

        //Add Audit
        $audit = array(
            'desc'=> "Suppression du tissu ".$tissu->getNomTissu(). " description : ".$tissu->getDescTissu()." Client : ".$client->getNomClient(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->tissuManager->deleteTissuBD($id);
        header('location: '.URL.'client/info/'.$client->getIdClient());
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));

    }

    private function uploadImage($filename, $filetmp, $dir){
        if(!isset($filename) || empty($filename))
            throw new Exception("Vous devez indiquer une image");

        if(!file_exists($dir)) mkdir($dir,0777);

        $extension = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$filename;

        if(!getimagesize($filetmp))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
//        if($file['size'] > 500000)
//            throw new Exception("Le fichier est trop gros");
        if(!move_uploaded_file($filetmp, $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$filename);
    }

}