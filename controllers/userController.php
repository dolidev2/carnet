<?php
require_once 'models/user/userManager.php';
require_once 'models/agence/agenceManager.php';
require_once 'models/audit/auditManager.php';
require_once 'models/config/config.php';

class userController
{
    private $userManager;
    private $userManagerLogin;
    private $agenceManager;
    private $auditManager;
    private $config;

    public function __construct()
    {
        $this->userManager = new userManager();
        $this->userManager->loadUser();

        $this->userManagerLogin = new userManager();
        $this->userManagerLogin->loadUserLogin();

        $this->agenceManager = new agenceManager();
        $this->agenceManager->loadAgence();

        $this->auditManager = new auditManager();
        $this->auditManager->loadAudit();

        $this->config = new configData();
    }

    public function displayLoginUser()
    {
        require 'views/user/login.php';

    }

    public function unloged()
    {
        foreach ( $_POST['user'] as $idUser){
            $userDisconnected = array(
                'id'=> $idUser,
                'connected'=>$this->config->inactif,
            );

            $this->userManager->updateUserConnectedBD($userDisconnected);
        }
    }
    public function loginUser()
    {
       $data = array(
            'username' => $this->fieldValidation($_POST['username']),
            'password' => $this->fieldValidation($_POST['password']),
        );
        $userInfo = $this->userManagerLogin->getUserByInfo($data);

        $response = 'unloged';
        if (!empty($userInfo)){
            if($userInfo->getRoleUser()!= $this->config->role_super_admin &&
                $userInfo->getConnectedUser() == $this->config->actif ){
                // User disconnected
                $userDisconnected = array(
                    'id'=> $userInfo->getIdUser(),
                    'connected'=>$this->config->inactif,
                );
                $this->userManager->updateUserConnectedBD($userDisconnected);
                require 'views/user/login.php';
            }
            // User connected
            $item = array(
                'id'=>$userInfo->getIdUser(),
                'connected'=>$this->config->actif,
            );
            $this->userManagerLogin->updateUserConnectedBD($item);
            
            $agence = $this->agenceManager->getAgenceById($userInfo->getAgence());
            //User
            $_SESSION['id'] = $userInfo->getIdUser();
            $_SESSION['role'] = $userInfo->getRoleUser();
            $_SESSION['nom'] = $userInfo->getNomUser();
            $_SESSION['prenom'] = $userInfo->getPrenomUser();
            $_SESSION['image'] = $userInfo->getImageUser();
            //Agence
            $_SESSION['agence'] = $agence->getIdAgence();
            $_SESSION['agence_role'] = $agence->getStatutAgence();
            $_SESSION['agence_nom'] = $agence->getNomAgence();
            $_SESSION['agence_contact'] = $agence->getContactAgence();
            $_SESSION['agence_adresse'] = $agence->getAdresseAgence();
            $_SESSION['agence_email'] = $agence->getEmailAgence();
            $_SESSION['agence_ifu'] = $agence->getIfuAgence();
            $_SESSION['agence_rccm'] = $agence->getRccmAgence();
            $_SESSION['agence_bp'] = $agence->getBoitePostaleAgence();
            $_SESSION['agence_ri'] = $agence->getRegimeImpositionAgence();
            $_SESSION['agence_df'] = $agence->getDivisionFiscaleAgence();
            $_SESSION['agence_df'] = $agence->getDivisionFiscaleAgence();

            $response = 'loged';

            $audit = array(
                'desc'=> "Connexion de l'utilisateur  ".$userInfo->getNomUser().' '.$userInfo->getPrenomUser(),
                'action'=>'Ajout',
                'creat'=>date("Y-m-d"),
                'user'=>$_SESSION['id'],
            );
            $this->auditManager->addAuditBd($audit);
        }
        echo $response;
    }

    public function unloginUser()
    {
        // User disconnected
        $data = array(
        'id'=> $_SESSION['id'],
        'connected'=>$this->config->inactif,
        );
        $this->userManager->updateUserConnectedBD($data);
        session_destroy();

        header('location:'.URL);
    }

    public function displayUser()
    {
        $users = $this->userManager->getUsers();
        require 'views/user/home.php';
    }

    public function displayDetailUser($id)
    {
        $user = $this->userManager->getUserById($id);
        $audits = $this->auditManager->getAuditUser($user->getIdUser());

        require 'views/user/detail.php';
    }

    public function addUser()
    {
        $agences = $this->agenceManager->getAgences();
        require 'views/user/add.php';
    }

    public function addSaveUser()
    {

        $repertoire = "public/image/user/";
        //Add User
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

        if (!empty($_FILES['image']['name'])){
            $image = $_FILES['image'];
            $ImageFace = $this->uploadImage($image,$repertoire);
        }else{
            $ImageFace = '';
        }
        $data = array(
            'prenom'=> $this->fieldValidation($_POST['prenom']),
            'nom'=> $this->fieldValidation($_POST['nom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'username'=> $this->fieldValidation($_POST['user']),
            'password'=> $this->fieldValidation($_POST['password']),
            'role'=> $this->fieldValidation($_POST['role']),
            'recto'=> $ImageRecto,
            'verso'=> $ImageVerso,
            'image'=> $ImageFace,
            'agence'=> $this->fieldValidation($_POST['agence']),
            'creat'=> date("Y-m-d"),
            'connected'=> $this->config->inactif,
            'mod'=> date("Y-m-d"),
        );
        $audit = array(
            'desc'=> "Ajout de l'utilisateur  ".$data['nom'].' '.$data['prenom'].' '.$data['contact'],
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->userManager->addUserBd($data);

    }

    public function updateUser($id)
    {
        $user = $this->userManager->getUserById($id);
        $agences = $this->agenceManager->getAgences();

        require 'views/user/update.php';
    }

    public function updateSaveUser()
    {
        $repertoire = "public/image/user/";
        $user = $this->userManager->getUserById($_POST['id_user']);

        $imageOldCnibRecto = $user->getCnibRectoUser();
        $imageRecentRecto = $_FILES['recto'];

        if($imageRecentRecto['size'] > 0){
            unlink($repertoire.''.$imageOldCnibRecto);
            $nomRecto = $this->uploadImage($imageRecentRecto,$repertoire);
        } else {
            $nomRecto = $imageOldCnibRecto;
        }

        $imageOldCnibVerso = $user->getCnibVersoUser();
        $imageRecentVerso = $_FILES['verso'];

        if($imageRecentVerso['size'] > 0){
            unlink($repertoire.''.$imageOldCnibVerso);
            $nomVerso = $this->uploadImage($imageRecentVerso,$repertoire);
        } else {
            $nomVerso = $imageOldCnibVerso;
        }

        $imageOldUser = $user->getImageUser();
        $imageUser = $_FILES['image'];

        if($imageUser['size'] > 0){
            unlink($repertoire.''.$imageOldUser);
            $nomImage = $this->uploadImage($imageUser,$repertoire);
        } else {
            $nomImage = $imageOldUser;
        }

        $password =  ($this->fieldValidation($_POST['password']) != '') ? 
        $this->fieldValidation($_POST['password']) : $user->getPasswordUser();

        $data = array(
            'prenom'=> $this->fieldValidation($_POST['prenom']),
            'nom'=> $this->fieldValidation($_POST['nom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'username'=> $this->fieldValidation($_POST['user']),
            'password'=> $password,
            'role'=> $this->fieldValidation($_POST['role_u']),
            'agence'=> $this->fieldValidation($_POST['agence']),
            'id'=> $this->fieldValidation($_POST['id_user']),
            'mod'=> date("Y-m-d"),
            'recto'=> $nomRecto,
            'verso'=> $nomVerso,
            'image'=> $nomImage,
        );
   
        $audit = array(
            'desc'=> "Modification de l'utilisateur  ".$data['nom'].' '.$data['prenom'].' '.$data['contact'],
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );

        $this->auditManager->addAuditBd($audit);
        $this->userManager->updateUserBD($data);
    }

    public function deleteSaveUser($id)
    {
        $user = $this->userManager->getUserById($id);
        $audit = array(
            'desc'=> "Suppression de l'utilisateur  ".$user->getNomUser().' '.$user->getPrenomUser().' '.$user->getContactUser(),
            'action'=>'Suppression',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->userManager->deleteUserBD($id);
        header('location: '.URL.'/utilisateur');
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
  
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file['name']);
    }
}