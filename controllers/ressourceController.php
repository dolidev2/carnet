<?php
require_once 'models/ressource/ressourceManager.php';
require_once 'models/personnel/personnelManager.php';
require_once 'models/personnel_ressource/personnelRessourceManager.php';
require_once 'models/audit/auditManager.php';
require_once 'models/agence/agenceManager.php';

class ressourceController
{
    private $ressourceManager;
    private $personnelManager;
    private $personnelRessourceManager;
    private $auditManager;
    private $agenceManager;

    public function __construct()
    {
        $this->auditManager = new auditManager();

        $this->ressourceManager = new ressourceManager();
        $this->ressourceManager->loadRessource();

        $this->personnelManager = new personnelManager();
        $this->personnelManager->loadPersonnel();

        $this->personnelRessourceManager = new personnelRessourceManager();
        $this->personnelRessourceManager->loadPersRes();

        $this->agenceManager = new agenceManager();
        $this->agenceManager->loadAgence();
    }

    public function addRessource()
    {
        $agences = $this->agenceManager->getAgences();
        require 'views/ressource/add.php';
    }

    public function addSaveRessource()
    {
        if (!empty($_FILES['image']['name'])){
            $image = $_FILES['image'];
            $repertoire = "public/image/ressource/";
            $nomImageAjoute = $this->uploadImage($image,$repertoire);
        }
        else{
            $nomImageAjoute = '';
        }
        $agence = (isset($_POST['agence']) && !empty($_POST['agence']))? $this->fieldValidation($_POST['agence']): $_SESSION['agence'];
        $data = array(
            'nom' => $this->fieldValidation($_POST['nom']),
            'desc' => $this->fieldValidation($_POST['desc']),
            'image' => $nomImageAjoute,
            'creat' => date("y-m-d"),
            'mod' => date("y-m-d"),
            'agence' => $agence
        );
        $this->ressourceManager->addRessourceBd($data);
        $audit = array(
            'desc'=> "Ajout d'une ressource : ".$data['nom'].' description '.$data['desc'],
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        header('location: '.URL.'ressource');
    }

    public function displayRessource()
    {
        $ressources = $this->ressourceManager->getRessources();
        require 'views/ressource/home.php';
    }

    public function detailRessource($id)
    {
        $ressource = $this->ressourceManager->getRessourceById($id);
        $personnels = $this->personnelManager->getPersonnels();
        $persRess = $this->personnelRessourceManager->getPersonnels($ressource);
        $data = [];
        if(!empty($persRess)){
            foreach ($persRess as $pers){
                $personnel = $this->personnelManager->getPersonnelById($pers->getPersonnel());
                $item = array(
                    'nom'=>$personnel->getNomPers(),
                    'prenom'=>$personnel->getPrenomPers(),
                    'contact'=>$personnel->getContactPers(),
                    'id_p'=>$personnel->getIdPers(),
                    'id'=>$pers->getIdPersRes(),
                    'desc'=>$pers->getDescPersRes(),
                    'creat'=>$pers->getCreatPersRes(),
                    'mod'=>$pers->getModPersRes(),
                );
                array_push($data,$item);
            }
        }
        require 'views/ressource/detail.php';
    }

    public function affectRessource()
    {
        $data = array(
            'ressource' => $this->fieldValidation($_POST['ressource']),
            'personnel' => $this->fieldValidation($_POST['personnel']),
            'desc' => $this->fieldValidation($_POST['desc']),
            'creat' => date("Y-m-d"),
            'mod' => date("Y-m-d")
        );
        $this->personnelRessourceManager->addPersResBd($data);
        //Change date of preview personnel
        $persLast = $this->personnelRessourceManager->getLastByRessource($data['ressource']);
        $item = array(
            'id' => $persLast->getIdPersRes(),
            'mod' =>date("Y-m-d"),
        );
        $this->personnelRessourceManager->updateModPersResBD($item);
        //Add audit
        $res = $this->ressourceManager->getRessourceById($data['ressource']);
        $pers = $this->personnelManager->getPersonnelById($data['personnel']);
        $audit = array(
            'desc'=> "Affectation de la ressource : ".$res->getNomRes().' description '.$res->getDescRes()." au collaborateur ".$pers->getNomPers().' '.$pers->getPrenomPers() ,
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function updateAffectRessource($id)
    {
        $resPers= $this->personnelRessourceManager->getPersResById($id);
        $data = array(
            'personnel' => $this->fieldValidation($_POST['personnelmod']),
            'desc' => $this->fieldValidation($_POST['descmod']),
            'id' => $id,
            'mod' => date("Y-m-d")
        );
        $this->personnelRessourceManager->updatePersResBD($data);
        $res = $this->ressourceManager->getRessourceById($resPers->getRessource());
        $pers = $this->personnelManager->getPersonnelById($data['personnel']);
        $audit = array(
            'desc'=> "Affectation de la ressource : ".$res->getNomRes().' description '.$res->getDescRes()." au collaborateur ".$pers->getNomPers().' '.$pers->getPrenomPers() ,
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        header('location: '.URL.'ressource/detail/'.$resPers->getRessource());
    }

    public function deleteAffectRessource($id)
    {
        $resPers= $this->personnelRessourceManager->getPersResById($id);
        $res = $this->ressourceManager->getRessourceById($resPers->getRessource());
        $pers = $this->personnelManager->getPersonnelById($resPers->getPersonnel());
        $audit = array(
            'desc'=> "Suppression de la ressource : ".$res->getNomRes().' description '.$res->getDescRes()." au collaborateur ".$pers->getNomPers().' '.$pers->getPrenomPers() ,
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->personnelRessourceManager->deletePersResBD($id);
        header('location: '.URL.'ressource/detail/'.$resPers->getRessource());
    }

    public function updateRessource($id)
    {
        $agences = $this->agenceManager->getAgences();
        $ressource = $this->ressourceManager->getRessourceById($id);
        require 'views/ressource/update.php';
    }

    public function updateSaveRessource($id)
    {
        $ressource = $this->ressourceManager->getRessourceById($id);
        if(!empty($_FILES['image']['name'])){
            $imageOld = $ressource->getImageRes();
            $imageRecent = $_FILES['image'];

            if($imageRecent['size'] > 0){
                unlink("public/image/ressource/".$imageOld);
                $repertoire =  $repertoire = "public/image/ressource/";
                $nomImageToAdd = $this->uploadImage($imageRecent,$repertoire);
            } else {
                $nomImageToAdd = $imageOld;
            }
        }
        else{
            $nomImageToAdd = '';
        }
        $agence = (isset($_POST['agence']) && !empty($_POST['agence']))? $this->fieldValidation($_POST['agence']): $_SESSION['agence'];
        $data = array(
            'nom' => $this->fieldValidation($_POST['nom']),
            'desc' => $this->fieldValidation($_POST['desc']),
            'mod' => date("Y-m-d"),
            'id' => $id,
            'image' => $nomImageToAdd,
            'agence'=>$agence
        );
        $this->ressourceManager->updateRessourceBD($data);

        $audit = array(
            'desc'=> "Modification de la ressource : ".$data['nom'].' description '.$data['desc'] ,
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        header('location: '.URL.'ressource');
    }

    public function deleteSaveRessource($id)
    {
        $ressource = $this->ressourceManager->getRessourceById($id);
        $audit = array(
            'desc'=> "Suppression de la ressource : ".$ressource->getNomRes().' description '.$ressource->getDescRes() ,
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        unlink("public/image/ressource/".$ressource->getImageRes());
        $this->ressourceManager->deleteRessourceBD($id);
        header('location: '.URL.'ressource');
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