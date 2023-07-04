<?php

class persPaieClass
{
    private $id_pers_paie;
    private $debut_pers_paie;
    private $fin_pers_paie;
    private $somme_pers_paie;
    private $creat_pers_paie;
    private $personnel;

    public function __construct($data)
    {
        $this->id_pers_paie = $data['id'];
        $this->debut_pers_paie = $data['debut'];
        $this->fin_pers_paie = $data['fin'];
        $this->somme_pers_paie = $data['somme'];
        $this->creat_pers_paie = $data['creat'];
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
    public function getCreatPersPaie()
    {
        return $this->creat_pers_paie;
    }

    /**
     * @param mixed $creat_pers_paie
     */
    public function setCreatPersPaie($creat_pers_paie): void
    {
        $this->creat_pers_paie = $creat_pers_paie;
    }

    /**
     * @return mixed
     */
    public function getDebutPersPaie()
    {
        return $this->debut_pers_paie;
    }

    /**
     * @param mixed $debut_pers_paie
     */
    public function setDebutPersPaie($debut_pers_paie): void
    {
        $this->debut_pers_paie = $debut_pers_paie;
    }

    /**
     * @return mixed
     */
    public function getFinPersPaie()
    {
        return $this->fin_pers_paie;
    }

    /**
     * @param mixed $fin_pers_paie
     */
    public function setFinPersPaie($fin_pers_paie): void
    {
        $this->fin_pers_paie = $fin_pers_paie;
    }

    /**
     * @return mixed
     */
    public function getIdPersPaie()
    {
        return $this->id_pers_paie;
    }

    /**
     * @param mixed $id_pers_paie
     */
    public function setIdPersPaie($id_pers_paie): void
    {
        $this->id_pers_paie = $id_pers_paie;
    }

    /**
     * @return mixed
     */
    public function getSommePersPaie()
    {
        return $this->somme_pers_paie;
    }

    /**
     * @param mixed $somme_pers_paie
     */
    public function setSommePersPaie($somme_pers_paie): void
    {
        $this->somme_pers_paie = $somme_pers_paie;
    }

}