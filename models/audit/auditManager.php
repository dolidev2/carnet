<?php

require_once 'models/modelClass.php';
require_once 'models/audit/auditClass.php';

class auditManager extends modelClass
{
    private $audits;//Tableau de audits

    public function addAudit($audit)
    {
        $this->audits[] = $audit;
    }

    public function getAudits()
    {
        return $this->audits;
    }

    public function loadAudit()
    {
        $query = $this->getBdd()->prepare("SELECT * FROM audit ORDER BY creat_audit DESC");
        $query->execute();
        $allaudit = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($allaudit as $audit)
        {
            $data = array(
                'id'=> $audit['id_audit'],
                'desc'=> $audit['desc_audit'],
                'action'=> $audit['action_audit'],
                'creat'=> $audit['creat_audit'],
                'user'=> $audit['user'],
            );
            $item = new auditClass($data);
            $this->addAudit($item);
        }
    }

    public function getAuditById($id)
    {
        foreach ($this->audits as $audit){
            if($audit->getIdAudit() === $id){
                return $audit;
            }
        }
    }

    public function getAuditsUser($user)
    {
        $audits_user = [];
        if(!empty($this->audits)){
            foreach ($this->audits as $audit){
                if($audit->getUser() === $user->getIdUser()){
                    array_push($audits_user,$audit);
                }
            }
        }
        return $audits_user;
    }

    public function addAuditBd($data)
    {
        $query = "INSERT INTO audit (desc_audit, action_audit, creat_audit, user) 
                    VALUES (:desc,:action,:creat,:user)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":action",$data['action']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":user",$data['user']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] =  $this->getBdd()->lastInsertId();
            $audit = new auditClass($data);
            $this->addAudit($audit);
        }
    }

    public function updateAuditBD($data)
    {
        $query = "UPDATE audit SET desc_audit=:desc, action_audit=:action WHERE id_audit=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":desc",$data['desc']);
        $stmt->bindValue(":action",$data['action']);
        $stmt->bindValue(":id",$data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getAuditById($data['id'])->setDescAudit($data['desc']);
            $this->getAuditById($data['id'])->setActionudit($data['action']);
        }
    }

    public function getAuditUser($user)
    {
        $query = "SELECT * FROM audit a JOIN user u ON a.user=u.id_user WHERE u.id_user =:user ORDER BY id_audit DESC ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":user",$user);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function deleteAuditBD($id)
    {
        $query = "DELETE FROM audit WHERE id_audit=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $audit = $this->getAuditById($id);
            unset($audit);
        }
    }
}