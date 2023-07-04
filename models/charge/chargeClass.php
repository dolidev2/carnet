<?php

class chargeClass
{
    private $id_charge;
    private $prix_charge;
    private $qte_charge;
    private $desc_charge;
    private $creat_charge;
    private $mod_charge;
    private $ressource;
    private $production;


    public function __construct($data)
    {
        $this->id_charge = $data['id'];
        $this->prix_charge = $data['prix'];
        $this->qte_charge = $data['qte'];
        $this->desc_charge = $data['desc'];
        $this->creat_charge = $data['creat'];
        $this->mod_charge = $data['mod'];
        $this->ressource = $data['ressource'];
        $this->production = $data['production'];
    }

    /**
     * @return mixed
     */
    public function getRessource()
    {
        return $this->ressource;
    }

    /**
     * @param mixed $ressource
     */
    public function setRessource($ressource): void
    {
        $this->ressource = $ressource;
    }

    /**
     * @return mixed
     */
    public function getCreatCharge()
    {
        return $this->creat_charge;
    }

    /**
     * @param mixed $creat_charge
     */
    public function setCreatCharge($creat_charge): void
    {
        $this->creat_charge = $creat_charge;
    }

    /**
     * @return mixed
     */
    public function getDescCharge()
    {
        return $this->desc_charge;
    }

    /**
     * @param mixed $desc_charge
     */
    public function setDescCharge($desc_charge): void
    {
        $this->desc_charge = $desc_charge;
    }

    /**
     * @return mixed
     */
    public function getIdCharge()
    {
        return $this->id_charge;
    }

    /**
     * @param mixed $id_charge
     */
    public function setIdCharge($id_charge): void
    {
        $this->id_charge = $id_charge;
    }

    /**
     * @return mixed
     */
    public function getModCharge()
    {
        return $this->mod_charge;
    }

    /**
     * @param mixed $mod_charge
     */
    public function setModCharge($mod_charge): void
    {
        $this->mod_charge = $mod_charge;
    }

    /**
     * @return mixed
     */
    public function getPrixCharge()
    {
        return $this->prix_charge;
    }

    /**
     * @param mixed $prix_charge
     */
    public function setPrixCharge($prix_charge): void
    {
        $this->prix_charge = $prix_charge;
    }

    /**
     * @return mixed
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param mixed $production
     */
    public function setProduction($production): void
    {
        $this->production = $production;
    }

    /**
     * @return mixed
     */
    public function getQteCharge()
    {
        return $this->qte_charge;
    }

    /**
     * @param mixed $qte_charge
     */
    public function setQteCharge($qte_charge): void
    {
        $this->qte_charge = $qte_charge;
    }
}