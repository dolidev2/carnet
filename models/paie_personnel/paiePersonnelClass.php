<?php

class paiePersonnelClass
{
    private $id_paie_pers;
    private $somme_paie_pers;
    private $creat_paie_pers;
    private $personnel;

    public function __construct($data)
    {
        $this->id_paie_pers = $data['id'];
        $this->somme_paie_pers = $data['somme'];
        $this->creat_paie_pers = $data['creat'];
        $this->personnel = $data['personnel'];
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
    public function getCreatPaiePers()
    {
        return $this->creat_paie_pers;
    }

    /**
     * @param mixed $creat_paie_pers
     */
    public function setCreatPaiePers($creat_paie_pers): void
    {
        $this->creat_paie_pers = $creat_paie_pers;
    }

    /**
     * @return mixed
     */
    public function getIdPaiePers()
    {
        return $this->id_paie_pers;
    }

    /**
     * @param mixed $id_paie_pers
     */
    public function setIdPaiePers($id_paie_pers): void
    {
        $this->id_paie_pers = $id_paie_pers;
    }

    /**
     * @return mixed
     */
    public function getSommePaiePers()
    {
        return $this->somme_paie_pers;
    }

    /**
     * @param mixed $somme_paie_pers
     */
    public function setSommePaiePers($somme_paie_pers): void
    {
        $this->somme_paie_pers = $somme_paie_pers;
    }
}
