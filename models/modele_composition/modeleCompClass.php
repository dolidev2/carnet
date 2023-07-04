<?php

class modeleCompClass
{
    private $id_mod_comp;
    private $nom_mod_comp;
    private $desc_mod_comp;
    private $recto_mod_comp;
    private $verso_mod_comp;
    private $prix_mod_comp;
    private $creat_mod_comp;
    private $modele_comp;

    public function __construct($data)
    {
        $this->id_mod_comp = $data['id'];
        $this->nom_mod_comp = $data['nom'];
        $this->desc_mod_comp = $data['desc'];
        $this->recto_mod_comp = $data['recto'];
        $this->verso_mod_comp = $data['verso'];
        $this->prix_mod_comp = $data['prix'];
        $this->creat_mod_comp = $data['creat'];
        $this->mod_comp = $data['mod'];
    }

    /**
     * @return mixed
     */
    public function getCreatModComp()
    {
        return $this->creat_mod_comp;
    }

    /**
     * @param mixed $creat_mod_comp
     */
    public function setCreatModComp($creat_mod_comp): void
    {
        $this->creat_mod_comp = $creat_mod_comp;
    }

    /**
     * @return mixed
     */
    public function getIdModComp()
    {
        return $this->id_mod_comp;
    }

    /**
     * @param mixed $id_mod_comp
     */
    public function setIdModComp($id_mod_comp): void
    {
        $this->id_mod_comp = $id_mod_comp;
    }

    /**
     * @return mixed
     */
    public function getModComp()
    {
        return $this->mod_comp;
    }

    /**
     * @param mixed $mod_comp
     */
    public function setModComp($mod_comp): void
    {
        $this->mod_comp = $mod_comp;
    }

    /**
     * @return mixed
     */
    public function getModeleComp()
    {
        return $this->modele_comp;
    }

    /**
     * @param mixed $modele_comp
     */
    public function setModeleComp($modele_comp): void
    {
        $this->modele_comp = $modele_comp;
    }

    /**
     * @return mixed
     */
    public function getNomModComp()
    {
        return $this->nom_mod_comp;
    }

    /**
     * @param mixed $nom_mod_comp
     */
    public function setNomModComp($nom_mod_comp): void
    {
        $this->nom_mod_comp = $nom_mod_comp;
    }

    /**
     * @return mixed
     */
    public function getDescModComp()
    {
        return $this->desc_mod_comp;
    }

    /**
     * @param mixed $desc_mod_comp
     */
    public function setDescModComp($desc_mod_comp): void
    {
        $this->desc_mod_comp = $desc_mod_comp;
    }

    /**
     * @return mixed
     */
    public function getPrixModComp()
    {
        return $this->prix_mod_comp;
    }

    /**
     * @param mixed $prix_mod_comp
     */
    public function setPrixModComp($prix_mod_comp): void
    {
        $this->prix_mod_comp = $prix_mod_comp;
    }

    /**
     * @return mixed
     */
    public function getRectoModComp()
    {
        return $this->recto_mod_comp;
    }

    /**
     * @param mixed $recto_mod_comp
     */
    public function setRectoModComp($recto_mod_comp): void
    {
        $this->recto_mod_comp = $recto_mod_comp;
    }

    /**
     * @return mixed
     */
    public function getVersoModComp()
    {
        return $this->verso_mod_comp;
    }

    /**
     * @param mixed $verso_mod_comp
     */
    public function setVersoModComp($verso_mod_comp): void
    {
        $this->verso_mod_comp = $verso_mod_comp;
    }
}