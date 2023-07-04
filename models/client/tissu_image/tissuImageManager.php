<?php

require_once 'models/modelClass.php';
require_once 'models/client/tissu_image/tissuImageClass.php';

class tissuImageManager extends modelClass
{
    private $images; //Tableau de tissus

    public function addTissuImage($image)
    {
        $this->images[] = $image;
    }

    public function getImagesTissu($tissu)
    {
        $images_tissu = [];
        if(!empty($this->images)){
            foreach ($this->images as $image){
                if($image->getTissu() === $tissu->getIdTissu()){
                    array_push($images_tissu,$image);
                }
            }
        }
        return $images_tissu;
    }

    public function getTissuImageById($id)
    {
        foreach ($this->images as $image){
            if($image->getIdTissuImage() === $id){
                return $image;
            }
        }
    }

    public function loadTissu()
    {
        $query ="SELECT * FROM tissu_image";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->execute();
        $allTissu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allTissu as $tissu)
        {
            $data = array(
                'id' => $tissu['id_tissu_image'],
                'image' => $tissu['image_tissu'],
                'creat' => $tissu['creat_tissu_image'],
                'mod' => $tissu['mod_tissu_image'],
                'tissu' => $tissu['tissu']
            );
            $item = new tissuImageClass($data);
            $this->addTissuImage($item);
        }
    }

    public function addTissuImageBD($data)
    {
        $query = "INSERT INTO tissu_image(image_tissu,creat_tissu_image,mod_tissu_image,tissu)
                    VALUES (:image,:creat, :mod,:tissu)";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':image' , $data['image']);
        $stmt->bindValue(':creat' , $data['creat']);
        $stmt->bindValue(':mod' , $data['mod']);
        $stmt->bindValue(':tissu' , $data['tissu']);

        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $data['id'] = $this->getBdd()->lastInsertId();
            $tissu = new tissuImageClass($data);
            $this->addTissuImage($tissu);
        }
    }

    public function updateTissuImageBd($data)
    {
        $query = "UPDATE tissu_image SET image_tissu=:image, mod_tissu_image=:mod WHERE id_tissu_image=:id ";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':image' , $data['image']);
        $stmt->bindValue(':mod' , $data['mod']);
        $stmt->bindValue(':id' , $data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result > 0){
            $this->getTissuImageById($data['id'])->setImageTissu($data['nom']);
            $this->getTissuImageById($data['id'])->setModImageTissu($data['mod']);
        }
    }

    public function deleteTissuImageBD($id)
    {
        $query = "DELETE FROM tissu_image WHERE id_tissu_image=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':id' , $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $tissu = $this->getTissuImageById($id);
            unset($tissu);
        }
    }

}