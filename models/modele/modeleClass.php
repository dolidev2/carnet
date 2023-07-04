<?php

class modeleClass
{
private $id_modele;
private $nom_modele;
private $desc_modele;
private $recto_modele;
private $verso_modele;
private $creat_modele;
private $mod_modele;
private $prix_modele;
private $cout_modele;
private $cout_decoup_modele;

public function __construct($data)
{
    $this->id_modele = $data['id'];
    $this->nom_modele = $data['nom'];
    $this->desc_modele = $data['desc'];
    $this->recto_modele = $data['recto'];
    $this->verso_modele = $data['verso'];
    $this->creat_modele = $data['creat'];
    $this->mod_modele = $data['mod'];
    $this->prix_modele = $data['prix'];
    $this->cout_modele = $data['cout'];
    $this->cout_decoup_modele = $data['cout_decoup'];
}

    /**
     * @return mixed
     */
    public function getCreatModele()
    {
        return $this->creat_modele;
    }

    /**
     * @param mixed $creat_modele
     */
    public function setCreatModele($creat_modele): void
    {
        $this->creat_modele = $creat_modele;
    }

    /**
     * @return mixed
     */
    public function getDescModele()
    {
        return $this->desc_modele;
    }

    /**
     * @param mixed $desc_modele
     */
    public function setDescModele($desc_modele): void
    {
        $this->desc_modele = $desc_modele;
    }

    /**
     * @return mixed
     */
    public function getIdModele()
    {
        return $this->id_modele;
    }

    /**
     * @param mixed $id_modele
     */
    public function setIdModele($id_modele): void
    {
        $this->id_modele = $id_modele;
    }

    /**
     * @return mixed
     */
    public function getRectoModele()
    {
        return $this->recto_modele;
    }

    /**
     * @param mixed $recto_modele
     */
    public function setRectoModele($recto_modele): void
    {
        $this->recto_modele = $recto_modele;
    }

    /**
     * @return mixed
     */
    public function getVersoModele()
    {
        return $this->verso_modele;
    }

    /**
     * @param mixed $verso_modele
     */
    public function setVersoModele($verso_modele): void
    {
        $this->verso_modele = $verso_modele;
    }
    /**
     * @return mixed
     */
    public function getModModele()
    {
        return $this->mod_modele;
    }

    /**
     * @param mixed $mod_modele
     */
    public function setModModele($mod_modele): void
    {
        $this->mod_modele = $mod_modele;
    }

    /**
     * @return mixed
     */
    public function getPrixModele()
    {
        return $this->prix_modele;
    }

    /**
     * @param mixed $prix_modele
     */
    public function setPrixModele($prix_modele): void
    {
        $this->prix_modele = $prix_modele;
    }

    /**
     * @return mixed
     */
    public function getNomModele()
    {
        return $this->nom_modele;
    }

    /**
     * @param mixed $nom_modele
     */
    public function setNomModele($nom_modele): void
    {
        $this->nom_modele = $nom_modele;
    }

    /**
     * @return mixed
     */
    public function getCoutModele()
    {
        return $this->cout_modele;
    }

    /**
     * @param mixed $cout_modele
     */
    public function setCoutModele($cout_modele): void
    {
        $this->cout_modele = $cout_modele;
    }

    /**
     * @return mixed
     */
    public function getCoutDecoupModele()
    {
        return $this->cout_decoup_modele;
    }

    /**
     * @param mixed $cout_decoup_modele
     */
    public function setCoutDecoupModele($cout_decoup_modele): void
    {
        $this->cout_decoup_modele = $cout_decoup_modele;
    }
}