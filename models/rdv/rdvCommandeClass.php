<?php

class rdvCommandeClass
{

    private $id_rdv;
    private $creat_rdv;
    private $mod_rdv;
    private $desc_rdv;
    private $commande;

    public function __construct($data)
    {
        $this->id_rdv = $data['id'];
        $this->creat_rdv = $data['creat'];
        $this->mod_rdv = $data['mod'];
        $this->desc_rdv = $data['desc'];
        $this->commande = $data['commande'];
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
    public function getCreatRdv()
    {
        return $this->creat_rdv;
    }

    /**
     * @param mixed $creat_rdv
     */
    public function setCreatRdv($creat_rdv): void
    {
        $this->creat_rdv = $creat_rdv;
    }

    /**
     * @return mixed
     */
    public function getDescRdv()
    {
        return $this->desc_rdv;
    }

    /**
     * @param mixed $desc_rdv
     */
    public function setDescRdv($desc_rdv): void
    {
        $this->desc_rdv = $desc_rdv;
    }

    /**
     * @return mixed
     */
    public function getIdRdv()
    {
        return $this->id_rdv;
    }

    /**
     * @param mixed $id_rdv
     */
    public function setIdRdv($id_rdv): void
    {
        $this->id_rdv = $id_rdv;
    }

    /**
     * @return mixed
     */
    public function getModRdv()
    {
        return $this->mod_rdv;
    }

    /**
     * @param mixed $mod_rdv
     */
    public function setModRdv($mod_rdv): void
    {
        $this->mod_rdv = $mod_rdv;
    }

}