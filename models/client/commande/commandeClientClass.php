<?php

class commandeClientClass
{
private $id_commande;
private $desc_commande;
private $creat_commande;
private $mod_commande;
private $statut_commande;
private $rdv_commande;
private $client;

public function __construct($data)
{
    $this->id_commande =  $data['id'];
    $this->desc_commande =  $data['desc'];
    $this->statut_commande =  $data['statut'];
    $this->rdv_commande =  $data['rdv'];
    $this->creat_commande =  $data['creat'];
    $this->mod_commande =  $data['mod'];
    $this->client =  $data['client'];
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
    public function getCreatCommande()
    {
        return $this->creat_commande;
    }

    /**
     * @param mixed $creat_commande
     */
    public function setCreatCommande($creat_commande): void
    {
        $this->creat_commande = $creat_commande;
    }

    /**
     * @return mixed
     */
    public function getDescCommande()
    {
        return $this->desc_commande;
    }

    /**
     * @param mixed $desc_commande
     */
    public function setDescCommande($desc_commande): void
    {
        $this->desc_commande = $desc_commande;
    }

    /**
     * @return mixed
     */
    public function getIdCommande()
    {
        return $this->id_commande;
    }

    /**
     * @param mixed $id_commande
     */
    public function setIdCommande($id_commande): void
    {
        $this->id_commande = $id_commande;
    }

    /**
     * @return mixed
     */
    public function getModCommande()
    {
        return $this->mod_commande;
    }

    /**
     * @param mixed $mod_commande
     */
    public function setModCommande($mod_commande): void
    {
        $this->mod_commande = $mod_commande;
    }

    /**
     * @return mixed
     */
    public function getRdvCommande()
    {
        return $this->rdv_commande;
    }

    /**
     * @param mixed $rdv_commande
     */
    public function setRdvCommande($rdv_commande): void
    {
        $this->rdv_commande = $rdv_commande;
    }

    /**
     * @return mixed
     */
    public function getStatutCommande()
    {
        return $this->statut_commande;
    }

    /**
     * @param mixed $statut_commande
     */
    public function setStatutCommande($statut_commande): void
    {
        $this->statut_commande = $statut_commande;
    }
}