<?php

class clientClass
{
    private $id_client ;
    private $nom_client;
    private $numero_mesure;
    private $prenom_client;
    private $contact_client;
    private $adresse_client;
    private $type_client;
    private $boite_postal_client;
    private $ifu_client;
    private $rccm_client;
    private $division_fiscale_client;
    private $regime_imposition_client;
    private $creat_client;
    private $mod_client;
    private $client;
    private $agence;

    public function __construct($id,$numero,$nom,$prenom,$contact,$adresse,$type,$boite_postal_client,
                                $ifu_client,$rccm_client, $division_fiscale_client,$regime_imposition_client,
                                $creat,$mod,$client,$agence)
    {
        $this->id_client = $id;
        $this->numero_mesure = $numero;
        $this->nom_client = $nom;
        $this->prenom_client = $prenom;
        $this->contact_client = $contact;
        $this->adresse_client = $adresse;
        $this->type_client = $type;
        $this->boite_postal_client = $boite_postal_client;
        $this->ifu_client = $ifu_client;
        $this->rccm_client = $rccm_client;
        $this->division_fiscale_client = $division_fiscale_client;
        $this->regime_imposition_client = $regime_imposition_client;
        $this->creat_client = $creat;
        $this->mod_client = $mod;
        $this->client = $client;
        $this->agence = $agence;
    }

    /**
     * @return mixed
     */
    public function getIdClient()
    {
        return $this->id_client;
    }

    /**
     * @param mixed $id_client
     */
    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }

    /**
     * @return mixed
     */
    public function getNumeroMesure()
    {
        return $this->numero_mesure;
    }

    /**
     * @param mixed $numero_mesure
     */
    public function setNumeroMesure($numero_mesure)
    {
        $this->numero_mesure = $numero_mesure;
    }
    /**
     * @return mixed
     */
    public function getNomClient()
    {
        return $this->nom_client;
    }

    /**
     * @param mixed $nom_client
     */
    public function setNomClient($nom_client)
    {
        $this->nom_client = $nom_client;
    }

    /**
     * @return mixed
     */
    public function getPrenomClient()
    {
        return $this->prenom_client;
    }

    /**
     * @param mixed $prenom_client
     */
    public function setPrenomClient($prenom_client)
    {
        $this->prenom_client = $prenom_client;
    }

    /**
     * @return mixed
     */
    public function getContactClient()
    {
        return $this->contact_client;
    }

    /**
     * @param mixed $contact_client
     */
    public function setContactClient($contact_client)
    {
        $this->contact_client = $contact_client;
    }

    /**
     * @return mixed
     */
    public function getAdresseClient()
    {
        return $this->adresse_client;
    }

    /**
     * @param mixed $adresse_client
     */
    public function setAdresseClient($adresse_client)
    {
        $this->adresse_client = $adresse_client;
    }

    /**
     * @return mixed
     */
    public function getTypeClient()
    {
        return $this->type_client;
    }

    /**
     * @param mixed $type_client
     */
    public function setTypeClient($type_client)
    {
        $this->type_client = $type_client;
    }

    /**
     * @return mixed
     */
    public function getCreatClient()
    {
        return $this->creat_client;
    }

    /**
     * @param mixed $creat_client
     */
    public function setCreatClient($creat_client)
    {
        $this->creat_client = $creat_client;
    }

    /**
     * @return mixed
     */
    public function getModClient()
    {
        return $this->mod_client;
    }

    /**
     * @param mixed $mod_client
     */
    public function setModClient($mod_client)
    {
        $this->mod_client = $mod_client;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getBoitePostalClient()
    {
        return $this->boite_postal_client;
    }

    /**
     * @param mixed $boite_postal_client
     */
    public function setBoitePostalClient($boite_postal_client): void
    {
        $this->boite_postal_client = $boite_postal_client;
    }

    /**
     * @return mixed
     */
    public function getDivisionFiscaleClient()
    {
        return $this->division_fiscale_client;
    }

    /**
     * @param mixed $division_fiscale_client
     */
    public function setDivisionFiscaleClient($division_fiscale_client): void
    {
        $this->division_fiscale_client = $division_fiscale_client;
    }

    /**
     * @return mixed
     */
    public function getIfuClient()
    {
        return $this->ifu_client;
    }

    /**
     * @param mixed $ifu_client
     */
    public function setIfuClient($ifu_client): void
    {
        $this->ifu_client = $ifu_client;
    }

    /**
     * @return mixed
     */
    public function getRccmClient()
    {
        return $this->rccm_client;
    }

    /**
     * @param mixed $rccm_client
     */
    public function setRccmClient($rccm_client): void
    {
        $this->rccm_client = $rccm_client;
    }

    /**
     * @return mixed
     */
    public function getRegimeImpositionClient()
    {
        return $this->regime_imposition_client;
    }

    /**
     * @param mixed $regime_imposition_client
     */
    public function setRegimeImpositionClient($regime_imposition_client): void
    {
        $this->regime_imposition_client = $regime_imposition_client;
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
}