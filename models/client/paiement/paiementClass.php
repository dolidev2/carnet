<?php

class paiementClass
{
    private $id_paie;
    private $somme_paie;
    private $type_paie;
    private $desc_paie;
    private $creat_paie;
    private $mod_paie;
    private $commande;

    public function __construct($data)
    {
        $this->id_paie = $data['id'];
        $this->somme_paie = $data['somme'];
        $this->type_paie = $data['type'];
        $this->desc_paie = $data['desc'];
        $this->creat_paie = $data['creat'];
        $this->mod_paie = $data['mod'];
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
    public function getCreatPaie()
    {
        return $this->creat_paie;
    }

    /**
     * @param mixed $creat_paie
     */
    public function setCreatPaie($creat_paie): void
    {
        $this->creat_paie = $creat_paie;
    }

    /**
     * @return mixed
     */
    public function getDescPaie()
    {
        return $this->desc_paie;
    }

    /**
     * @param mixed $desc_paie
     */
    public function setDescPaie($desc_paie): void
    {
        $this->desc_paie = $desc_paie;
    }

    /**
     * @return mixed
     */
    public function getIdPaie()
    {
        return $this->id_paie;
    }

    /**
     * @param mixed $id_paie
     */
    public function setIdPaie($id_paie): void
    {
        $this->id_paie = $id_paie;
    }

    /**
     * @return mixed
     */
    public function getModPaie()
    {
        return $this->mod_paie;
    }

    /**
     * @param mixed $mod_paie
     */
    public function setModPaie($mod_paie): void
    {
        $this->mod_paie = $mod_paie;
    }

    /**
     * @return mixed
     */
    public function getSommePaie()
    {
        return $this->somme_paie;
    }

    /**
     * @param mixed $somme_paie
     */
    public function setSommePaie($somme_paie): void
    {
        $this->somme_paie = $somme_paie;
    }

    /**
     * @return mixed
     */
    public function getTypePaie()
    {
        return $this->type_paie;
    }

    /**
     * @param mixed $type_paie
     */
    public function setTypePaie($type_paie): void
    {
        $this->type_paie = $type_paie;
    }
}