<?php

class ImpressionManager
{
    private $prints; //Tableau de prints

    public function addPrint($print)
    {
        $this->prints[] = $print;
    }

    public function getPrintsUser($user)
    {
        $prints_user = [];
        if(!empty($this->prints)){
            foreach ($this->prints as $print){
                if($print->getUser() === $user->getIdUser()){
                    array_push($prints_user,$print);
                }
            }
        }
        return $prints_user;
    }

    public function getPrintById($id)
    {
        foreach ($this->prints as $print){
            if($print->getIdPrint() === $id){
                return $print;
            }
        }
    }

    public function loadPrint()
    {
        $query ="SELECT * FROM impression";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->execute();
        $allprint = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allprint as $print)
        {
            $data = array(
                'id' => $print['id_print'],
                'desc' => $print['desc_print'],
                'creat' => $print['creat_print'],
                'user' => $print['user']
            );
            $item = new ImpressionClass($data);
            $this->addPrint($item);
        }
    }

    public function addPrintBD($data)
    {
        $query = "INSERT INTO impression(desc_print, creat_print,user)
                    VALUES (:desc,:creat,:user)";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':desc' , $data['desc']);
        $stmt->bindValue(':creat' , $data['creat']);
        $stmt->bindValue(':user' , $data['user']);

        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0 ){
            $data['id'] = $this->getBdd()->lastInsertId();
            $print = new impressionClass($data);
            $this->addPrint($print);
            return $data['id'];
        }
    }

    public function updatePrintBd($data)
    {
        $query = "UPDATE impression SET desc_print=:desc WHERE id_print=:id ";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':desc' , $data['desc']);
        $stmt->bindValue(':id' , $data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result > 0){
            $this->getprintById($data['id'])->setDescPrint($data['desc']);
        }
    }

        public function deletePrintBD($id)
    {
        $query = "DELETE FROM impression WHERE id_print=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':id' , $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $print = $this->getPrintById($id);
            unset($print);
        }
    }
}