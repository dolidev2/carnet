<?php

class productionClass
{
    private $id_prod;
    private $desc_prod;
    private $creat_prod;
    private $mod_prod;
    private $rend_prod;
    private $somme_prod;
    private $quantite_prod;
    private $statut_prod;
    private $personnel;
    private $cmt;

    public function __construct($data)
    {
        $this->id_prod = $data['id'];
        $this->desc_prod = $data['desc'];
        $this->creat_prod = $data['creat'];
        $this->mod_prod = $data['mod'];
        $this->rend_prod = $data['rend'];
        $this->somme_prod = $data['somme'];
        $this->quantite_prod = $data['quantite'];
        $this->statut_prod = $data['statut'];
        $this->personnel = $data['personnel'];
        $this->cmt = $data['cmt'];
    }

    /**
     * @return mixed
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }

    /**
     * @param mixed $personnel
     */
    public function setPersonnel($personnel): void
    {
        $this->personnel = $personnel;
    }

    /**
     * @return mixed
     */
    public function getQuantiteProd()
    {
        return $this->quantite_prod;
    }

    /**
     * @param mixed $quantite_prod
     */
    public function setQuantiteProd($quantite_prod): void
    {
        $this->quantite_prod = $quantite_prod;
    }
    /**
     * @return mixed
     */
    public function getCmt()
    {
        return $this->cmt;
    }

    /**
     * @param mixed $cmt
     */
    public function setCmt($cmt): void
    {
        $this->cmt = $cmt;
    }

    /**
     * @return mixed
     */
    public function getCreatProd()
    {
        return $this->creat_prod;
    }

    /**
     * @param mixed $creat_prod
     */
    public function setCreatProd($creat_prod): void
    {
        $this->creat_prod = $creat_prod;
    }

    /**
     * @return mixed
     */
    public function getDescProd()
    {
        return $this->desc_prod;
    }

    /**
     * @param mixed $desc_prod
     */
    public function setDescProd($desc_prod): void
    {
        $this->desc_prod = $desc_prod;
    }

    /**
     * @return mixed
     */
    public function getIdProd()
    {
        return $this->id_prod;
    }

    /**
     * @param mixed $id_prod
     */
    public function setIdProd($id_prod): void
    {
        $this->id_prod = $id_prod;
    }

    /**
     * @return mixed
     */
    public function getModProd()
    {
        return $this->mod_prod;
    }

    /**
     * @param mixed $mod_prod
     */
    public function setModProd($mod_prod): void
    {
        $this->mod_prod = $mod_prod;
    }

    /**
     * @return mixed
     */
    public function getRendProd()
    {
        return $this->rend_prod;
    }

    /**
     * @param mixed $rend_prod
     */
    public function setRendProd($rend_prod): void
    {
        $this->rend_prod = $rend_prod;
    }

    /**
     * @return mixed
     */
    public function getStatutProd()
    {
        return $this->statut_prod;
    }

    /**
     * @param mixed $statut_prod
     */
    public function setStatutProd($statut_prod): void
    {
        $this->statut_prod = $statut_prod;
    }

    /**
     * @return mixed
     */
    public function getSommeProd()
    {
        return $this->somme_prod;
    }

    /**
     * @param mixed $somme_prod
     */
    public function setSommeProd($somme_prod): void
    {
        $this->somme_prod = $somme_prod;
    }
}