<?php

class tissuClientClass
{
    private  $id_tissu;
    private  $nom_tissu;
    private  $desc_tissu;
    private  $quantite_tissu;
    private  $prix_tissu;
    private  $commission_tissu;
    private  $creat_tissu;
    private  $mod_tissu;
    private  $statut_tissu;
    private  $client;

    public function __construct($data)
    {
        $this->id_tissu = $data['id'];
        $this->nom_tissu = $data['nom'];
        $this->desc_tissu = $data['desc'];
        $this->quantite_tissu = $data['quantite'];
        $this->prix_tissu = $data['prix'];
        $this->commission_tissu = $data['com'];
        $this->creat_tissu = $data['creat'];
        $this->statut_tissu = $data['statut'];
        $this->mod_tissu = $data['mod'];
        $this->client = $data['client'];
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getCreatTissu()
    {
        return $this->creat_tissu;
    }

    /**
     * @param mixed $creat_tissu
     */
    public function setCreatTissu($creat_tissu): void
    {
        $this->creat_tissu = $creat_tissu;
    }

    /**
     * @return mixed
     */
    public function getDescTissu()
    {
        return $this->desc_tissu;
    }

    /**
     * @param mixed $desc_tissu
     */
    public function setDescTissu($desc_tissu): void
    {
        $this->desc_tissu = $desc_tissu;
    }

    /**
     * @return mixed
     */
    public function getIdTissu()
    {
        return $this->id_tissu;
    }

    /**
     * @param mixed $id_tissu
     */
    public function setIdTissu($id_tissu): void
    {
        $this->id_tissu = $id_tissu;
    }

    /**
     * @return mixed
     */
    public function getModTissu()
    {
        return $this->mod_tissu;
    }

    /**
     * @param mixed $mod_tissu
     */
    public function setModTissu($mod_tissu): void
    {
        $this->mod_tissu = $mod_tissu;
    }

    /**
     * @return mixed
     */
    public function getNomTissu()
    {
        return $this->nom_tissu;
    }

    /**
     * @param mixed $nom_tissu
     */
    public function setNomTissu($nom_tissu): void
    {
        $this->nom_tissu = $nom_tissu;
    }

    /**
     * @return mixed
     */
    public function getStatutTissu()
    {
        return $this->statut_tissu;
    }

    /**
     * @param mixed $statut_tissu
     */
    public function setStatutTissu($statut_tissu): void
    {
        $this->statut_tissu = $statut_tissu;
    }

    /**
     * @return mixed
     */
    public function getPrixTissu()
    {
        return $this->prix_tissu;
    }

    /**
     * @param mixed $prix_tissu
     */
    public function setPrixTissu($prix_tissu): void
    {
        $this->prix_tissu = $prix_tissu;
    }

    /**
     * @return mixed
     */
    public function getQuantiteTissu()
    {
        return $this->quantite_tissu;
    }

    /**
     * @param mixed $quantite_tissu
     */
    public function setQuantiteTissu($quantite_tissu): void
    {
        $this->quantite_tissu = $quantite_tissu;
    }

    /**
     * @return mixed
     */
    public function getCommissionTissu()
    {
        return $this->commission_tissu;
    }

    /**
     * @param mixed $commission_tissu
     */
    public function setCommissionTissu($commission_tissu): void
    {
        $this->commission_tissu = $commission_tissu;
    }

}