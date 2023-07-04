<?php

class ressourceClass
{
    private $id_res;
    private $nom_res;
    private $desc_res;
    private $creat_res;
    private $mod_res;
    private $image_res;
    private $agence;

    public function __construct($data)
    {
        $this->id_res = $data['id'];
        $this->nom_res = $data['nom'];
        $this->desc_res = $data['desc'];
        $this->creat_res = $data['creat'];
        $this->mod_res = $data['mod'];
        $this->image_res = $data['image'];
        $this->agence = $data['agence'];
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
    public function getCreatRes()
    {
        return $this->creat_res;
    }

    /**
     * @param mixed $creat_res
     */
    public function setCreatRes($creat_res): void
    {
        $this->creat_res = $creat_res;
    }

    /**
     * @return mixed
     */
    public function getDescRes()
    {
        return $this->desc_res;
    }

    /**
     * @param mixed $desc_res
     */
    public function setDescRes($desc_res): void
    {
        $this->desc_res = $desc_res;
    }

    /**
     * @return mixed
     */
    public function getIdRes()
    {
        return $this->id_res;
    }

    /**
     * @param mixed $id_res
     */
    public function setIdRes($id_res): void
    {
        $this->id_res = $id_res;
    }

    /**
     * @return mixed
     */
    public function getImageRes()
    {
        return $this->image_res;
    }

    /**
     * @param mixed $image_res
     */
    public function setImageRes($image_res): void
    {
        $this->image_res = $image_res;
    }

    /**
     * @return mixed
     */
    public function getModRes()
    {
        return $this->mod_res;
    }

    /**
     * @param mixed $mod_res
     */
    public function setModRes($mod_res): void
    {
        $this->mod_res = $mod_res;
    }

    /**
     * @return mixed
     */
    public function getNomRes()
    {
        return $this->nom_res;
    }

    /**
     * @param mixed $nom_res
     */
    public function setNomRes($nom_res): void
    {
        $this->nom_res = $nom_res;
    }
}