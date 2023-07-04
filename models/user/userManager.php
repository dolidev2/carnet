<?php

require_once 'models/modelClass.php';
require_once 'models/user/userClass.php';

class userManager extends modelClass
{
    private $users;//Tableau de users

    public function addUser($user)
    {
        $this->users[] = $user;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function loadUser()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM user WHERE agence=:agence";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $alluser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($alluser as $user)
        {
            $data = array(
                'id'=> $user['id_user'],
                'nom'=> $user['nom_user'],
                'prenom'=> $user['prenom_user'],
                'contact'=> $user['contact_user'],
                'username'=> $user['username_user'],
                'password'=> $user['password_user'],
                'creat'=> $user['creat_user'],
                'mod'=> $user['mod_user'],
                'role'=> $user['role_user'],
                'recto'=> $user['cnib_recto_user'],
                'verso'=> $user['cnib_verso_user'],
                'image'=> $user['image_user'],
                'connected'=> $user['connected_user'],
                'agence'=> $user['agence'],
            );
            $item = new userClass($data);
            $this->addUser($item);
        }
    }

    public function loadUserLogin()
    {
        $query = "SELECT * FROM user";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->execute();
        $alluser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($alluser as $user)
        {
            $data = array(
                'id'=> $user['id_user'],
                'nom'=> $user['nom_user'],
                'prenom'=> $user['prenom_user'],
                'contact'=> $user['contact_user'],
                'username'=> $user['username_user'],
                'password'=> $user['password_user'],
                'creat'=> $user['creat_user'],
                'mod'=> $user['mod_user'],
                'role'=> $user['role_user'],
                'recto'=> $user['cnib_recto_user'],
                'verso'=> $user['cnib_verso_user'],
                'image'=> $user['image_user'],
                'connected'=> $user['connected_user'],
                'agence'=> $user['agence'],
            );
            $item = new userClass($data);
            $this->addUser($item);
        }
    }

    public function getUserById($id)
    {
        foreach ($this->users as $user){
            if($user->getIdUser() === $id){
                return $user;
            }
        }
    }

    public function getUserByInfo($data)
    {
        foreach ($this->users as $user){
            if($user->getUsernameUser() == $data['username'] && $user->getPasswordUser() == $data['password']){
                return $user;
            }
        }
    }

    public function addUserBd($data)
    {
        $query = "INSERT INTO user (nom_user, prenom_user, contact_user, username_user, password_user,role_user,
                  cnib_recto_user,cnib_verso_user,image_user, creat_user, mod_user,connected_user, agence) 
                    VALUES (:nom,:prenom,:contact,:username,:password,:role,:recto,:verso,:image,:creat,:mod,:connected,:agence)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom']);
        $stmt->bindValue(":prenom",$data['prenom']);
        $stmt->bindValue(":contact",$data['contact']);
        $stmt->bindValue(":username",$data['username']);
        $stmt->bindValue(":password",$data['password']);
        $stmt->bindValue(":role",$data['role']);
        $stmt->bindValue(":recto",$data['recto']);
        $stmt->bindValue(":verso",$data['verso']);
        $stmt->bindValue(":image",$data['image']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['creat']);
        $stmt->bindValue(":connected",$data['connected']);
        $stmt->bindValue(":agence",$data['agence']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] =  $this->getBdd()->lastInsertId();
            $user = new userClass($data);
            $this->addUser($user);
        }
    }

    public function updateUserBD($data)
    {
        $query = "UPDATE user SET nom_user=:nom, prenom_user=:prenom, contact_user=:contact, username_user=:username,
                  password_user=:password, role_user=:role, cnib_recto_user=:recto, cnib_verso_user=:verso,
                  image_user=:image,  mod_user=:mod WHERE id_user=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":nom",$data['nom']);
        $stmt->bindValue(":prenom",$data['prenom']);
        $stmt->bindValue(":contact",$data['contact']);
        $stmt->bindValue(":username",$data['username']);
        $stmt->bindValue(":password",$data['password']);
        $stmt->bindValue(":role",$data['role']);
        $stmt->bindValue(":recto",$data['recto']);
        $stmt->bindValue(":verso",$data['verso']);
        $stmt->bindValue(":image",$data['image']);
        $stmt->bindValue(":id",$data['id']);
        $stmt->bindValue(":mod",$data['mod']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getUserById($data['id'])->setNomUser($data['nom']);
            $this->getUserById($data['id'])->setPrenomUser($data['prenom']);
            $this->getUserById($data['id'])->setContactUser($data['contact']);
            $this->getUserById($data['id'])->setUsernameUser($data['username']);
            $this->getUserById($data['id'])->setPasswordUser($data['password']);
            $this->getUserById($data['id'])->setRoleUser($data['role']);
            $this->getUserById($data['id'])->setCnibRectoUser($data['recto']);
            $this->getUserById($data['id'])->setCnibVersoUser($data['verso']);
            $this->getUserById($data['id'])->setImageUser($data['image']);
            $this->getUserById($data['id'])->setModUser($data['mod']);
        }
    }

    public function updateUserConnectedBD($data)
    {
        $query = "UPDATE user SET connected_user=:connected WHERE id_user=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":connected",$data['connected']);
        $stmt->bindValue(":id",$data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getUserById($data['id'])->setConnectedUser($data['connected']);
        }
    }


    public function deleteUserBD($id)
    {
        $query = "DELETE FROM user WHERE id_user=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $user = $this->getUserById($id);
            unset($user);
        }
    }
}