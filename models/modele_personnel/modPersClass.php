<?php

class modPersClass
{

    private $id_mod_pers;
    private $qte_mod_pers;
    private $creat_mod_pers;
    private $personnel;
    private $modele;

    public function __construct($data)
    {
        $this->id_mod_pers = $data['id'];
        $this->qte_mod_pers = $data['qte'];
        $this->creat_mod_pers = $data['creat'];
        $this->personnel = $data['personnel'];
        $this->modele = $data['modele'];
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
    public function getCreatModPers()
    {
        return $this->creat_mod_pers;
    }

    /**
     * @param mixed $creat_mod_pers
     */
    public function setCreatModPers($creat_mod_pers): void
    {
        $this->creat_mod_pers = $creat_mod_pers;
    }

    /**
     * @return mixed
     */
    public function getIdModPers()
    {
        return $this->id_mod_pers;
    }

    /**
     * @param mixed $id_mod_pers
     */
    public function setIdModPers($id_mod_pers): void
    {
        $this->id_mod_pers = $id_mod_pers;
    }

    /**
     * @return mixed
     */
    public function getQteModPers()
    {
        return $this->qte_mod_pers;
    }

    /**
     * @param mixed $qte_mod_pers
     */
    public function setQteModPers($qte_mod_pers): void
    {
        $this->qte_mod_pers = $qte_mod_pers;
    }
}