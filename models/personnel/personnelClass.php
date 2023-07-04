<?php

class personnelClass
{
    private $id_pers;
    private $nom_pers;
    private $prenom_pers;
    private $contact_pers;
    private $adresse_pers;
    private $cnib_recto_pers;
    private $cnib_verso_pers;
    private $creat_pers;
    private $mod_pers;
    private $agence;

    public function __construct($data)
    {
        $this->id_pers = $data['id'];
        $this->nom_pers = $data['nom'];
        $this->prenom_pers = $data['prenom'];
        $this->contact_pers = $data['contact'];
        $this->adresse_pers = $data['adresse'];
        $this->cnib_recto_pers = $data['recto'];
        $this->cnib_verso_pers = $data['verso'];
        $this->creat_pers = $data['creat'];
        $this->mod_pers = $data['mod'];
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
    public function getAdressePers()
    {
        return $this->adresse_pers;
    }

    /**
     * @param mixed $adresse_pers
     */
    public function setAdressePers($adresse_pers): void
    {
        $this->adresse_pers = $adresse_pers;
    }

    /**
     * @return mixed
     */
    public function getContactPers()
    {
        return $this->contact_pers;
    }

    /**
     * @param mixed $contact_pers
     */
    public function setContactPers($contact_pers): void
    {
        $this->contact_pers = $contact_pers;
    }

    /**
     * @return mixed
     */
    public function getCreatPers()
    {
        return $this->creat_pers;
    }

    /**
     * @param mixed $creat_pers
     */
    public function setCreatPers($creat_pers): void
    {
        $this->creat_pers = $creat_pers;
    }

    /**
     * @return mixed
     */
    /**
     * @return mixed
     */
    public function getCnibRectoPers()
    {
        return $this->cnib_recto_pers;
    }

    /**
     * @param mixed $cnib_recto_pers
     */
    public function setCnibRectoPers($cnib_recto_pers): void
    {
        $this->cnib_recto_pers = $cnib_recto_pers;
    }

    /**
     * @return mixed
     */
    public function getIdPers()
    {
        return $this->id_pers;
    }

    /**
     * @param mixed $id_pers
     */
    public function setIdPers($id_pers): void
    {
        $this->id_pers = $id_pers;
    }

    /**
     * @return mixed
     */
    public function getCnibVersoPers()
    {
        return $this->cnib_verso_pers;
    }

    /**
     * @param mixed $cnib_verso_pers
     */
    public function setCnibVersoPers($cnib_verso_pers): void
    {
        $this->cnib_verso_pers = $cnib_verso_pers;
    }

    /**
     * @return mixed
     */
    public function getModPers()
    {
        return $this->mod_pers;
    }

    /**
     * @param mixed $mod_pers
     */
    public function setModPers($mod_pers): void
    {
        $this->mod_pers = $mod_pers;
    }

    /**
     * @return mixed
     */
    public function getNomPers()
    {
        return $this->nom_pers;
    }

    /**
     * @param mixed $nom_pers
     */
    public function setNomPers($nom_pers): void
    {
        $this->nom_pers = $nom_pers;
    }

    /**
     * @return mixed
     */
    public function getPrenomPers()
    {
        return $this->prenom_pers;
    }

    /**
     * @param mixed $prenom_pers
     */
    public function setPrenomPers($prenom_pers): void
    {
        $this->prenom_pers = $prenom_pers;
    }
}