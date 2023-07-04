<?php

class caisseClass
{
    private $id_caisse;
    private $somme_caisse;
    private $desc_caisse;
    private $type_caisse;
    private $creat_caisse;
    private $mod_caisse;
    private $paiement;
    private $personnel;
    private $user;
    private $agence;
    private $tissu;
    private $charge;

    public function __construct($data)
    {
        $this->id_caisse = $data['id'];
        $this->somme_caisse = $data['somme'];
        $this->desc_caisse = $data['desc'];
        $this->type_caisse = $data['type'];
        $this->creat_caisse = $data['creat'];
        $this->mod_caisse = $data['mod'];
        $this->paiement = $data['paiement'];
        $this->personnel = $data['personnel'];
        $this->user = $data['user'];
        $this->agence = $data['agence'];
        $this->tissu = $data['tissu'];
        $this->charge = $data['charge'];
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
    public function getCreatCaisse()
    {
        return $this->creat_caisse;
    }

    /**
     * @param mixed $creat_caisse
     */
    public function setCreatCaisse($creat_caisse): void
    {
        $this->creat_caisse = $creat_caisse;
    }

    /**
     * @return mixed
     */
    public function getDescCaisse()
    {
        return $this->desc_caisse;
    }

    /**
     * @param mixed $desc_caisse
     */
    public function setDescCaisse($desc_caisse): void
    {
        $this->desc_caisse = $desc_caisse;
    }

    /**
     * @return mixed
     */
    public function getIdCaisse()
    {
        return $this->id_caisse;
    }

    /**
     * @param mixed $id_caisse
     */
    public function setIdCaisse($id_caisse): void
    {
        $this->id_caisse = $id_caisse;
    }

    /**
     * @return mixed
     */
    public function getModCaisse()
    {
        return $this->mod_caisse;
    }

    /**
     * @param mixed $mod_caisse
     */
    public function setModCaisse($mod_caisse): void
    {
        $this->mod_caisse = $mod_caisse;
    }

    /**
     * @return mixed
     */
    public function getSommeCaisse()
    {
        return $this->somme_caisse;
    }

    /**
     * @param mixed $somme_caisse
     */
    public function setSommeCaisse($somme_caisse): void
    {
        $this->somme_caisse = $somme_caisse;
    }

    /**
     * @return mixed
     */
    public function getTypeCaisse()
    {
        return $this->type_caisse;
    }

    /**
     * @param mixed $type_caisse
     */
    public function setTypeCaisse($type_caisse): void
    {
        $this->type_caisse = $type_caisse;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPaiement()
    {
        return $this->paiement;
    }

    /**
     * @param mixed $paiement
     */
    public function setPaiement($paiement): void
    {
        $this->paiement = $paiement;
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

    /**
     * @return mixed
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * @param mixed $charge
     */
    public function setCharge($charge): void
    {
        $this->charge = $charge;
    }
}