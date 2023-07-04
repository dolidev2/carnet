<?php

class ImpressionClass
{

    private $id_print;
    private $desc_print;
    private $creat_print;
    private $user;

    public function __construct($data)
    {
        $this->id_print = $data['id_print'];
        $this->desc_print = $data['desc_print'];
        $this->creat_print = $data['creat_print'];
        $this->user = $data['user'];
    }

    /**
     * @return mixed
     */
    public function getCreatPrint()
    {
        return $this->creat_print;
    }

    /**
     * @param mixed $creat_print
     */
    public function setCreatPrint($creat_print): void
    {
        $this->creat_print = $creat_print;
    }

    /**
     * @return mixed
     */
    public function getDescPrint()
    {
        return $this->desc_print;
    }

    /**
     * @param mixed $desc_print
     */
    public function setDescPrint($desc_print): void
    {
        $this->desc_print = $desc_print;
    }

    /**
     * @return mixed
     */
    public function getIdPrint()
    {
        return $this->id_print;
    }

    /**
     * @param mixed $id_print
     */
    public function setIdPrint($id_print): void
    {
        $this->id_print = $id_print;
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

}