<?php

class stockClass
{
    private $id_stock;
    private $prix_g_stock;
    private $prix_d_stock;
    private $quantite_stock;
    private $creat_stock;
    private $mod_stock;
    private $desc_stock;
    private $type_stock;
    private $ressource;

    public function __construct($data)
    {
        $this->id_stock = $data['id'];
        $this->prix_g_stock = $data['prix_g'];
        $this->prix_d_stock = $data['prix_d'];
        $this->quantite_stock = $data['quantite'];
        $this->creat_stock = $data['creat'];
        $this->mod_stock = $data['mod'];
        $this->desc_stock = $data['desc'];
        $this->type_stock = $data['type'];
        $this->ressource = $data['ressource'];
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
    public function getCreatStock()
    {
        return $this->creat_stock;
    }

    /**
     * @param mixed $creat_stock
     */
    public function setCreatStock($creat_stock): void
    {
        $this->creat_stock = $creat_stock;
    }

    /**
     * @return mixed
     */
    public function getDescStock()
    {
        return $this->desc_stock;
    }

    /**
     * @param mixed $desc_stock
     */
    public function setDescStock($desc_stock): void
    {
        $this->desc_stock = $desc_stock;
    }

    /**
     * @return mixed
     */
    public function getIdStock()
    {
        return $this->id_stock;
    }

    /**
     * @param mixed $id_stock
     */
    public function setIdStock($id_stock): void
    {
        $this->id_stock = $id_stock;
    }

    /**
     * @return mixed
     */
    public function getModStock()
    {
        return $this->mod_stock;
    }

    /**
     * @param mixed $mod_stock
     */
    public function setModStock($mod_stock): void
    {
        $this->mod_stock = $mod_stock;
    }

    /**
     * @return mixed
     */
    public function getPrixGStock()
    {
        return $this->prix_g_stock;
    }

    /**
     * @return mixed
     */
    public function getQuantiteStock()
    {
        return $this->quantite_stock;
    }

    /**
     * @param mixed $prix_stock
     */
    public function setPrixGStock($prix_stock): void
    {
        $this->prix_g_stock = $prix_stock;
    }

    /**
     * @return mixed
     */
    public function getPrixDStock()
    {
        return $this->prix_d_stock;
    }

    /**
     * @param mixed $prix_d_stock
     */
    public function setPrixDStock($prix_d_stock): void
    {
        $this->prix_d_stock = $prix_d_stock;
    }

    /**
     * @param mixed $quantite_stock
     */
    public function setQuantiteStock($quantite_stock): void
    {
        $this->quantite_stock = $quantite_stock;
    }

    /**
     * @return mixed
     */
    public function getTypeStock()
    {
        return $this->type_stock;
    }

    /**
     * @param mixed $type_stock
     */
    public function setTypeStock($type_stock): void
    {
        $this->type_stock = $type_stock;
    }
}