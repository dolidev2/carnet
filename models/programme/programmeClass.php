<?php

class programmeClass
{
    private $id_cmt;
    private $prix_cmt;
    private $quantite_cmt;
    private $statut_cmt;
    private $remise_cmt;
    private $creat_cmt;
    private $mod_cmt;
    private $commande;
    private $modele;
    private $tissu;

    public function __construct($data)
    {
        $this->id_cmt = $data['id'];
        $this->prix_cmt = $data['prix'];
        $this->quantite_cmt = $data['quantite'];
        $this->statut_cmt = $data['statut'];
        $this->remise_cmt = $data['remise'];
        $this->creat_cmt = $data['creat'];
        $this->mod_cmt = $data['mod'];
        $this->commande = $data['commande'];
        $this->modele = $data['modele'];
        $this->tissu = $data['tissu'];
    }

    /**
     * @return mixed
     */
    public function getRemiseCmt()
    {
        return $this->remise_cmt;
    }

    /**
     * @param mixed $remise_cmt
     */
    public function setRemiseCmt($remise_cmt): void
    {
        $this->remise_cmt = $remise_cmt;
    }
    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande): void
    {
        $this->commande = $commande;
    }

    /**
     * @return mixed
     */
    public function getCreatCmt()
    {
        return $this->creat_cmt;
    }

    /**
     * @param mixed $creat_cmt
     */
    public function setCreatCmt($creat_cmt): void
    {
        $this->creat_cmt = $creat_cmt;
    }

    /**
     * @return mixed
     */
    public function getIdCmt()
    {
        return $this->id_cmt;
    }

    /**
     * @param mixed $id_cmt
     */
    public function setIdCmt($id_cmt): void
    {
        $this->id_cmt = $id_cmt;
    }

    /**
     * @return mixed
     */
    public function getModCmt()
    {
        return $this->mod_cmt;
    }

    /**
     * @param mixed $mod_cmt
     */
    public function setModCmt($mod_cmt): void
    {
        $this->mod_cmt = $mod_cmt;
    }

    /**
     * @return mixed
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * @param mixed $modele
     */
    public function setModele($modele): void
    {
        $this->modele = $modele;
    }

    /**
     * @return mixed
     */
    public function getPrixCmt()
    {
        return $this->prix_cmt;
    }

    /**
     * @param mixed $prix_cmt
     */
    public function setPrixCmt($prix_cmt): void
    {
        $this->prix_cmt = $prix_cmt;
    }

    /**
     * @return mixed
     */
    public function getQuantiteCmt()
    {
        return $this->quantite_cmt;
    }

    /**
     * @param mixed $quantite_cmt
     */
    public function setQuantiteCmt($quantite_cmt): void
    {
        $this->quantite_cmt = $quantite_cmt;
    }

    /**
     * @return mixed
     */
    public function getStatutCmt()
    {
        return $this->statut_cmt;
    }

    /**
     * @param mixed $statut_cmt
     */
    public function setStatutCmt($statut_cmt): void
    {
        $this->statut_cmt = $statut_cmt;
    }

    /**
     * @return mixed
     */
    public function getTissu()
    {
        return $this->tissu;
    }

    /**
     * @param mixed $tissu
     */
    public function setTissu($tissu): void
    {
        $this->tissu = $tissu;
    }
}