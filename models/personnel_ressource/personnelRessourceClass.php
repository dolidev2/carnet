<?php

class personnelRessourceClass
{
    private $id_pers_res;
    private $creat_pers_res;
    private $mod_pers_res;
    private $desc_pers_res;
    private $personnel;
    private $ressource;

    public function __construct($data)
    {
        $this->id_pers_res = $data['id'];
        $this->creat_pers_res = $data['creat'];
        $this->mod_pers_res = $data['mod'];
        $this->desc_pers_res = $data['desc'];
        $this->personnel = $data['personnel'];
        $this->ressource = $data['ressource'];
    }

    /**
     * @return mixed
     */
    public function getCreatPersRes()
    {
        return $this->creat_pers_res;
    }

    /**
     * @param mixed $creat_pers_res
     */
    public function setCreatPersRes($creat_pers_res): void
    {
        $this->creat_pers_res = $creat_pers_res;
    }

    /**
     * @return mixed
     */
    public function getDescPersRes()
    {
        return $this->desc_pers_res;
    }

    /**
     * @param mixed $desc_pers_res
     */
    public function setDescPersRes($desc_pers_res): void
    {
        $this->desc_pers_res = $desc_pers_res;
    }

    /**
     * @return mixed
     */
    public function getIdPersRes()
    {
        return $this->id_pers_res;
    }

    /**
     * @param mixed $id_pers_res
     */
    public function setIdPersRes($id_pers_res): void
    {
        $this->id_pers_res = $id_pers_res;
    }

    /**
     * @return mixed
     */
    public function getModPersRes()
    {
        return $this->mod_pers_res;
    }

    /**
     * @param mixed $mod_pers_res
     */
    public function setModPersRes($mod_pers_res): void
    {
        $this->mod_pers_res = $mod_pers_res;
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
}