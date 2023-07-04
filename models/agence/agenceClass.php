<?php

class agenceClass
{
    private $id_agence;
    private $nom_agence;
    private $contact_agence;
    private $adresse_agence;
    private $email_agence;
    private $boite_postale_agence;
    private $ifu_agence;
    private $rccm_agence;
    private $division_fiscale_agence;
    private $regime_imposition_agence;
    private $statut_agence;
    private $creat_agence;
    private $mod_agence;

    public function __construct($data)
    {
        $this->id_agence = $data ['id'];
        $this->nom_agence = $data ['nom'];
        $this->contact_agence = $data ['contact'];
        $this->adresse_agence = $data ['adresse'];
        $this->email_agence = $data ['email'];
        $this->boite_postale_agence = $data ['bp'];
        $this->rccm_agence = $data ['rccm'];
        $this->ifu_agence = $data ['ifu'];
        $this->division_fiscale_agence = $data ['df'];
        $this->ifu_agence = $data ['ifu'];
        $this->regime_imposition_agence = $data ['ri'];
        $this->statut_agence = $data ['statut'];
        $this->creat_agence = $data ['creat'];
        $this->mod_agence = $data ['mod'];
    }

    /**
     * @return mixed
     */
    public function getAdresseAgence()
    {
        return $this->adresse_agence;
    }

    /**
     * @param mixed $adresse_agence
     */
    public function setAdresseAgence($adresse_agence): void
    {
        $this->adresse_agence = $adresse_agence;
    }

    /**
     * @return mixed
     */
    public function getContactAgence()
    {
        return $this->contact_agence;
    }

    /**
     * @param mixed $contact_agence
     */
    public function setContactAgence($contact_agence): void
    {
        $this->contact_agence = $contact_agence;
    }

    /**
     * @return mixed
     */
    public function getIdAgence()
    {
        return $this->id_agence;
    }

    /**
     * @param mixed $id_agence
     */
    public function setIdAgence($id_agence): void
    {
        $this->id_agence = $id_agence;
    }

    /**
     * @return mixed
     */
    public function getNomAgence()
    {
        return $this->nom_agence;
    }

    /**
     * @param mixed $nom_agence
     */
    public function setNomAgence($nom_agence): void
    {
        $this->nom_agence = $nom_agence;
    }

    /**
     * @return mixed
     */
    public function getStatutAgence()
    {
        return $this->statut_agence;
    }

    /**
     * @param mixed $statut_agence
     */
    public function setStatutAgence($statut_agence): void
    {
        $this->statut_agence = $statut_agence;
    }

    /**
     * @return mixed
     */
    public function getCreatAgence()
    {
        return $this->creat_agence;
    }

    /**
     * @param mixed $creat_agence
     */
    public function setCreatAgence($creat_agence): void
    {
        $this->creat_agence = $creat_agence;
    }

    /**
     * @return mixed
     */
    public function getModAgence()
    {
        return $this->mod_agence;
    }

    /**
     * @param mixed $mod_agence
     */
    public function setModAgence($mod_agence): void
    {
        $this->mod_agence = $mod_agence;
    }

    /**
     * @return mixed
     */
    public function getBoitePostaleAgence()
    {
        return $this->boite_postale_agence;
    }

    /**
     * @param mixed $boite_postale_agence
     */
    public function setBoitePostaleAgence($boite_postale_agence): void
    {
        $this->boite_postale_agence = $boite_postale_agence;
    }

    /**
     * @return mixed
     */
    public function getDivisionFiscaleAgence()
    {
        return $this->division_fiscale_agence;
    }

    /**
     * @param mixed $division_fiscale_agence
     */
    public function setDivisionFiscaleAgence($division_fiscale_agence): void
    {
        $this->division_fiscale_agence = $division_fiscale_agence;
    }

    /**
     * @return mixed
     */
    public function getEmailAgence()
    {
        return $this->email_agence;
    }

    /**
     * @param mixed $email_agence
     */
    public function setEmailAgence($email_agence): void
    {
        $this->email_agence = $email_agence;
    }

    /**
     * @return mixed
     */
    public function getIfuAgence()
    {
        return $this->ifu_agence;
    }

    /**
     * @param mixed $ifu_agence
     */
    public function setIfuAgence($ifu_agence): void
    {
        $this->ifu_agence = $ifu_agence;
    }

    /**
     * @return mixed
     */
    public function getRccmAgence()
    {
        return $this->rccm_agence;
    }

    /**
     * @param mixed $rccm_agence
     */
    public function setRccmAgence($rccm_agence): void
    {
        $this->rccm_agence = $rccm_agence;
    }

    /**
     * @return mixed
     */
    public function getRegimeImpositionAgence()
    {
        return $this->regime_imposition_agence;
    }

    /**
     * @param mixed $regime_imposition_agence
     */
    public function setRegimeImpositionAgence($regime_imposition_agence): void
    {
        $this->regime_imposition_agence = $regime_imposition_agence;
    }
}