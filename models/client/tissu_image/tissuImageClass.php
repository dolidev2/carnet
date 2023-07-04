<?php

class tissuImageClass
{
    private $id_tissu_image;
    private $image_tissu;
    private $creat_image_tissu;
    private $mod_image_tissu;
    private $tissu;

    public function __construct($data)
    {
        $this->id_tissu_image = $data['id'];
        $this->image_tissu = $data['image'];
        $this->creat_image_tissu = $data['creat'];
        $this->mod_image_tissu = $data['mod'];
        $this->tissu = $data['tissu'];
    }

    /**
     * @return mixed
     */
    public function getTissu()
    {
        return $this->tissu;
    }

    /**
     * @param mixed $image_tissu
     */
    public function setImageTissu($image_tissu): void
    {
        $this->image_tissu = $image_tissu;
    }

    /**
     * @return mixed
     */
    public function getImageTissu()
    {
        return $this->image_tissu;
    }

    /**
     * @param mixed $id_tissu_image
     */
    public function setIdTissuImage($id_tissu_image): void
    {
        $this->id_tissu_image = $id_tissu_image;
    }

    /**
     * @return mixed
     */
    public function getIdTissuImage()
    {
        return $this->id_tissu_image;
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
    public function getCreatImageTissu()
    {
        return $this->creat_image_tissu;
    }

    /**
     * @param mixed $creat_image_tissu
     */
    public function setCreatImageTissu($creat_image_tissu): void
    {
        $this->creat_image_tissu = $creat_image_tissu;
    }

    /**
     * @return mixed
     */
    public function getModImageTissu()
    {
        return $this->mod_image_tissu;
    }

    /**
     * @param mixed $mod_image_tissu
     */
    public function setModImageTissu($mod_image_tissu): void
    {
        $this->mod_image_tissu = $mod_image_tissu;
    }

}