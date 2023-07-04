<?php

class userClass
{
    private $id_user;
    private $nom_user;
    private $prenom_user;
    private $contact_user;
    private $username_user;
    private $password_user;
    private $role_user;
    private $cnib_recto_user;
    private $cnib_verso_user;
    private $image_user;
    private $creat_user;
    private $mod_user;
    private $connected_user;
    private $agence;

    public function __construct($data)
    {
        $this->id_user = $data['id'];
        $this->nom_user = $data['nom'];
        $this->prenom_user = $data['prenom'];
        $this->contact_user = $data['contact'];
        $this->username_user = $data['username'];
        $this->password_user = $data['password'];
        $this->role_user = $data['role'];
        $this->cnib_recto_user = $data['recto'];
        $this->cnib_verso_user = $data['verso'];
        $this->image_user = $data['image'];
        $this->creat_user = $data['creat'];
        $this->mod_user = $data['mod'];
        $this->connected_user = $data['connected'];
        $this->agence = $data['agence'];
    }

    /**
     * @return mixed
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * @param mixed $agence
     */
    public function setAgence($agence): void
    {
        $this->agence = $agence;
    }

    /**
     * @return mixed
     */
    public function getContactUser()
    {
        return $this->contact_user;
    }

    /**
     * @param mixed $contact_user
     */
    public function setContactUser($contact_user): void
    {
        $this->contact_user = $contact_user;
    }

    /**
     * @return mixed
     */
    public function getCreatUser()
    {
        return $this->creat_user;
    }

    /**
     * @param mixed $creat_user
     */
    public function setCreatUser($creat_user): void
    {
        $this->creat_user = $creat_user;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getModUser()
    {
        return $this->mod_user;
    }

    /**
     * @param mixed $mod_user
     */
    public function setModUser($mod_user): void
    {
        $this->mod_user = $mod_user;
    }

    /**
     * @return mixed
     */
    public function getNomUser()
    {
        return $this->nom_user;
    }

    /**
     * @param mixed $nom_user
     */
    public function setNomUser($nom_user): void
    {
        $this->nom_user = $nom_user;
    }

    /**
     * @return mixed
     */
    public function getPasswordUser()
    {
        return $this->password_user;
    }

    /**
     * @param mixed $password_user
     */
    public function setPasswordUser($password_user): void
    {
        $this->password_user = $password_user;
    }

    /**
     * @return mixed
     */
    public function getPrenomUser()
    {
        return $this->prenom_user;
    }

    /**
     * @param mixed $prenom_user
     */
    public function setPrenomUser($prenom_user): void
    {
        $this->prenom_user = $prenom_user;
    }

    /**
     * @return mixed
     */
    public function getRoleUser()
    {
        return $this->role_user;
    }

    /**
     * @param mixed $role_user
     */
    public function setRoleUser($role_user): void
    {
        $this->role_user = $role_user;
    }

    /**
     * @return mixed
     */
    public function getUsernameUser()
    {
        return $this->username_user;
    }

    /**
     * @param mixed $username_user
     */
    public function setUsernameUser($username_user): void
    {
        $this->username_user = $username_user;
    }

    /**
     * @return mixed
     */
    public function getCnibRectoUser()
    {
        return $this->cnib_recto_user;
    }

    /**
     * @param mixed $cnib_recto_user
     */
    public function setCnibRectoUser($cnib_recto_user): void
    {
        $this->cnib_recto_user = $cnib_recto_user;
    }

    /**
     * @return mixed
     */
    public function getCnibVersoUser()
    {
        return $this->cnib_verso_user;
    }

    /**
     * @param mixed $cnib_verso_user
     */
    public function setCnibVersoUser($cnib_verso_user): void
    {
        $this->cnib_verso_user = $cnib_verso_user;
    }

    /**
     * @return mixed
     */
    public function getImageUser()
    {
        return $this->image_user;
    }

    /**
     * @param mixed $image_user
     */
    public function setImageUser($image_user): void
    {
        $this->image_user = $image_user;
    }


    /**
     * @return mixed
     */
    public function getConnectedUser()
    {
        return $this->connected_user;
    }

    /**
     * @param mixed $connected_user
     */
    public function setConnectedUser($connected_user): void
    {
        $this->connected_user = $connected_user;
    }
}