<?php

class auditClass
{
    private $id_audit;
    private $desc_audit;
    private $action_audit;
    private $creat_audit;
    private $user;

    public function __construct($data)
    {
        $this->id_audit = $data['id'];
        $this->desc_audit = $data['desc'];
        $this->action_audit = $data['action'];
        $this->creat_audit = $data['creat'];
        $this->user = $data['user'];
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

    /**
     * @return mixed
     */
    public function getActionAudit()
    {
        return $this->action_audit;
    }

    /**
     * @param mixed $action_audit
     */
    public function setActionAudit($action_audit): void
    {
        $this->action_audit = $action_audit;
    }

    /**
     * @return mixed
     */
    public function getCreatAudit()
    {
        return $this->creat_audit;
    }

    /**
     * @param mixed $creat_audit
     */
    public function setCreatAudit($creat_audit): void
    {
        $this->creat_audit = $creat_audit;
    }

    /**
     * @return mixed
     */
    public function getDescAudit()
    {
        return $this->desc_audit;
    }

    /**
     * @param mixed $desc_audit
     */
    public function setDescAudit($desc_audit): void
    {
        $this->desc_audit = $desc_audit;
    }

    /**
     * @return mixed
     */
    public function getIdAudit()
    {
        return $this->id_audit;
    }

    /**
     * @param mixed $id_audit
     */
    public function setIdAudit($id_audit): void
    {
        $this->id_audit = $id_audit;
    }

}