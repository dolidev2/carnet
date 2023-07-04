<?php

class mesureClientClass
{
    private $id_mesure;
    private $epaule_mesure;
    private $l_epaule_mesure;
    private $bas_mesure;
    private $poitrine_mesure;
    private $dos_mesure;
    private $bassin_mesure;
    private $l_taille_mesure;
    private $t_taille_mesure;
    private $t_genou_mesure;
    private $ceinture_mesure;
    private $poignet_mesure;

    private $t_manche_mesure;
    private $l_manche_mesure;
    private $cole_mesure;
    private $cuisse_mesure;
    private $l_chemise_mesure;
    private $l_gilet_mesure;
    private $l_veste_mesure;
    private $l_genou_mesure;
    private $l_pantalon_mesure;
    private $pantacourt_mesure;
    private $e_jambe_mesure;

    private $l_chemise_a_mesure;
    private $frappe_mesure;
    private $carrure_mesure;

    private $e_p_poitrine_mesure;
    private $l_jupe_mesure;
    private $l_robe_mesure;
    private $l_poitrine_mesure;
    private $l_haut_mesure;

    private $creat_mesure;
    private $mod_mesure;
    private $sexe_mesure;
    private $t_tete_mesure;
    private $client;

    public function __construct($data)
    {
        $this->id_mesure = $data['id'];
        $this->epaule_mesure = $data['epaule'];
        $this->l_epaule_mesure = $data['l_epaule'];
        $this->l_manche_mesure = $data['l_manche'];
        $this->bas_mesure = $data['bas'];
        $this->poitrine_mesure = $data['poitrine'];
        $this->dos_mesure = $data['dos'];
        $this->bassin_mesure = $data['bassin'];
        $this->l_taille_mesure = $data['l_taille'];
        $this->t_taille_mesure = $data['t_taille'];
        $this->t_genou_mesure = $data['t_genou'];

        $this->ceinture_mesure = $data['ceinture'];
        $this->poignet_mesure = $data['poignet'];
        $this->t_manche_mesure = $data['t_manche'];
        $this->cole_mesure = $data['cole'];
        $this->cuisse_mesure = $data['cuisse'];
        $this->l_chemise_mesure = $data['l_chemise'];
        $this->l_veste_mesure = $data['l_veste'];
        $this->l_genou_mesure = $data['l_genou'];
        $this->l_pantalon_mesure = $data['l_pantalon'];
        $this->pantacourt_mesure = $data['pantacourt'];
        $this->e_jambe_mesure = $data['e_jambe'];

        $this->l_chemise_a_mesure = $data['l_chemise_a'];
        $this->frappe_mesure = $data['frappe'];
        $this->l_gilet_mesure = $data['l_gilet'];
        $this->carrure_mesure = $data['carrure'];

        $this->e_p_poitrine_mesure = $data['e_p_poitrine'];
        $this->l_jupe_mesure = $data['l_jupe'];
        $this->l_robe_mesure = $data['l_robe'];
        $this->l_poitrine_mesure = $data['l_poitrine'];
        $this->l_haut_mesure = $data['l_haut'];

        $this->creat_mesure = $data['creat'];
        $this->mod_mesure = $data['mod'];
        $this->sexe_mesure = $data['sexe'];
        $this->t_tete_mesure = $data['t_tete'];
        $this->client = $data['client'];
    }

    /**
     * @return mixed
     */
    public function getModMesure()
    {
        return $this->mod_mesure;
    }

    /**
     * @param mixed $mod_mesure
     */
    public function setModMesure($mod_mesure)
    {
        $this->mod_mesure = $mod_mesure;
    }

    /**
     * @return mixed
     */
    public function getLTailleMesure()
    {
        return $this->l_taille_mesure;
    }

    /**
     * @param mixed $l_taille_mesure
     */
    public function setLTailleMesure($l_taille_mesure)
    {
        $this->l_taille_mesure = $l_taille_mesure;
    }

    /**
     * @return mixed
     */
    public function getLMancheMesure()
    {
        return $this->l_manche_mesure;
    }

    /**
     * @param mixed $l_manche_mesure
     */
    public function setLMancheMesure($l_manche_mesure)
    {
        $this->l_manche_mesure = $l_manche_mesure;
    }

    /**
     * @return mixed
     */
    public function getIdMesure()
    {
        return $this->id_mesure;
    }

    /**
     * @param mixed $id_mesure
     */
    public function setIdMesure($id_mesure)
    {
        $this->id_mesure = $id_mesure;
    }

    /**
     * @return mixed
     */
    public function getTTailleMesure()
    {
        return $this->t_taille_mesure;
    }

    /**
     * @param mixed $t_taille_mesure
     */
    public function setTTailleMesure($t_taille_mesure): void
    {
        $this->t_taille_mesure = $t_taille_mesure;
    }

    /**
     * @return mixed
     */
    public function getEpauleMesure()
    {
        return $this->epaule_mesure;
    }

    /**
     * @param mixed $epaule_mesure
     */
    public function setEpauleMesure($epaule_mesure)
    {
        $this->epaule_mesure = $epaule_mesure;
    }

    /**
     * @return mixed
     */
    public function getCuisseMesure()
    {
        return $this->cuisse_mesure;
    }

    /**
     * @param mixed $cuisse_mesure
     */
    public function setCuisseMesure($cuisse_mesure)
    {
        $this->cuisse_mesure = $cuisse_mesure;
    }

    /**
     * @return mixed
     */
    public function getCreatMesure()
    {
        return $this->creat_mesure;
    }

    /**
     * @param mixed $creat_mesure
     */
    public function setCreatMesure($creat_mesure)
    {
        $this->creat_mesure = $creat_mesure;
    }

    /**
     * @return mixed
     */
    public function getCeintureMesure()
    {
        return $this->ceinture_mesure;
    }

    /**
     * @param mixed $ceinture_mesure
     */
    public function setCeintureMesure($ceinture_mesure)
    {
        $this->ceinture_mesure = $ceinture_mesure;
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
    public function getBasMesure()
    {
        return $this->bas_mesure;
    }

    /**
     * @param mixed $bas_mesure
     */
    public function setBasMesure($bas_mesure)
    {
        $this->bas_mesure = $bas_mesure;
    }

    /**
     * @return mixed
     */
    public function getBassinMesure()
    {
        return $this->bassin_mesure;
    }

    /**
     * @param mixed $bassin_mesure
     */
    public function setBassinMesure($bassin_mesure)
    {
        $this->bassin_mesure = $bassin_mesure;
    }

    /**
     * @return mixed
     */
    public function getCarrureMesure()
    {
        return $this->carrure_mesure;
    }

    /**
     * @param mixed $carrure_mesure
     */
    public function setCarrureMesure($carrure_mesure)
    {
        $this->carrure_mesure = $carrure_mesure;
    }

    /**
     * @return mixed
     */
    public function getColeMesure()
    {
        return $this->cole_mesure;
    }

    /**
     * @param mixed $cole_mesure
     */
    public function setColeMesure($cole_mesure)
    {
        $this->cole_mesure = $cole_mesure;
    }

    /**
     * @return mixed
     */
    public function getEJambeMesure()
    {
        return $this->e_jambe_mesure;
    }

    /**
     * @param mixed $e_jambe_mesure
     */
    public function setEJambeMesure($e_jambe_mesure)
    {
        $this->e_jambe_mesure = $e_jambe_mesure;
    }

    /**
     * @return mixed
     */
    public function getFrappeMesure()
    {
        return $this->frappe_mesure;
    }

    /**
     * @param mixed $frappe_mesure
     */
    public function setFrappeMesure($frappe_mesure)
    {
        $this->frappe_mesure = $frappe_mesure;
    }

    /**
     * @return mixed
     */
    public function getLChemiseAMesure()
    {
        return $this->l_chemise_a_mesure;
    }

    /**
     * @param mixed $l_chemise_a_mesure
     */
    public function setLChemiseAMesure($l_chemise_a_mesure)
    {
        $this->l_chemise_a_mesure = $l_chemise_a_mesure;
    }

    /**
     * @return mixed
     */
    public function getLChemiseMesure()
    {
        return $this->l_chemise_mesure;
    }

    /**
     * @param mixed $l_chemise_mesure
     */
    public function setLChemiseMesure($l_chemise_mesure)
    {
        $this->l_chemise_mesure = $l_chemise_mesure;
    }

    /**
     * @return mixed
     */
    public function getLEpauleMesure()
    {
        return $this->l_epaule_mesure;
    }

    /**
     * @param mixed $l_epaule_mesure
     */
    public function setLEpauleMesure($l_epaule_mesure)
    {
        $this->l_epaule_mesure = $l_epaule_mesure;
    }

    /**
     * @return mixed
     */
    public function getLGenouMesure()
    {
        return $this->l_genou_mesure;
    }

    /**
     * @param mixed $l_genou_mesure
     */
    public function setLGenouMesure($l_genou_mesure)
    {
        $this->l_genou_mesure = $l_genou_mesure;
    }

    /**
     * @return mixed
     */
    public function getLGiletMesure()
    {
        return $this->l_gilet_mesure;
    }

    /**
     * @param mixed $l_gilet_mesure
     */
    public function setLGiletMesure($l_gilet_mesure)
    {
        $this->l_gilet_mesure = $l_gilet_mesure;
    }

    /**
     * @return mixed
     */
    public function getLPantalonMesure()
    {
        return $this->l_pantalon_mesure;
    }

    /**
     * @param mixed $l_pantalon_mesure
     */
    public function setLPantalonMesure($l_pantalon_mesure)
    {
        $this->l_pantalon_mesure = $l_pantalon_mesure;
    }

    /**
     * @return mixed
     */
    public function getLVesteMesure()
    {
        return $this->l_veste_mesure;
    }

    /**
     * @param mixed $l_veste_mesure
     */
    public function setLVesteMesure($l_veste_mesure)
    {
        $this->l_veste_mesure = $l_veste_mesure;
    }

    /**
     * @return mixed
     */
    public function getPoignetMesure()
    {
        return $this->poignet_mesure;
    }

    /**
     * @param mixed $poignet_mesure
     */
    public function setPoignetMesure($poignet_mesure)
    {
        $this->poignet_mesure = $poignet_mesure;
    }

    /**
     * @return mixed
     */
    public function getPoitrineMesure()
    {
        return $this->poitrine_mesure;
    }

    /**
     * @param mixed $poitrine_mesure
     */
    public function setPoitrineMesure($poitrine_mesure)
    {
        $this->poitrine_mesure = $poitrine_mesure;
    }

    /**
     * @return mixed
     */
    public function getTGenouMesure()
    {
        return $this->t_genou_mesure;
    }

    /**
     * @param mixed $t_genou_mesure
     */
    public function setTGenouMesure($t_genou_mesure)
    {
        $this->t_genou_mesure = $t_genou_mesure;
    }

    /**
     * @return mixed
     */
    public function getTMancheMesure()
    {
        return $this->t_manche_mesure;
    }

    /**
     * @param mixed $t_manche_mesure
     */
    public function setTMancheMesure($t_manche_mesure)
    {
        $this->t_manche_mesure = $t_manche_mesure;
    }

    /**
     * @return mixed
     */
    public function getLRobeMesure()
    {
        return $this->l_robe_mesure;
    }

    /**
     * @param mixed $l_robe_mesure
     */
    public function setLRobeMesure($l_robe_mesure): void
    {
        $this->l_robe_mesure = $l_robe_mesure;
    }

    /**
     * @return mixed
     */
    public function getLJupeMesure()
    {
        return $this->l_jupe_mesure;
    }

    /**
     * @param mixed $l_jupe_mesure
     */
    public function setLJupeMesure($l_jupe_mesure): void
    {
        $this->l_jupe_mesure = $l_jupe_mesure;
    }

    /**
     * @return mixed
     */
    public function getEPPoitrineMesure()
    {
        return $this->e_p_poitrine_mesure;
    }

    /**
     * @param mixed $e_p_poitrine_mesure
     */
    public function setEPPoitrineMesure($e_p_poitrine_mesure): void
    {
        $this->e_p_poitrine_mesure = $e_p_poitrine_mesure;
    }

    /**
     * @return mixed
     */
    public function getLHautMesure()
    {
        return $this->l_haut_mesure;
    }

    /**
     * @param mixed $l_haut_mesure
     */
    public function setLHautMesure($l_haut_mesure): void
    {
        $this->l_haut_mesure = $l_haut_mesure;
    }

    /**
     * @return mixed
     */
    public function getLPoitrineMesure()
    {
        return $this->l_poitrine_mesure;
    }

    /**
     * @param mixed $l_poitrine_mesure
     */
    public function setLPoitrineMesure($l_poitrine_mesure): void
    {
        $this->l_poitrine_mesure = $l_poitrine_mesure;
    }

    /**
     * @return mixed
     */
    public function getSexeMesure()
    {
        return $this->sexe_mesure;
    }

    /**
     * @param mixed $sexe_mesure
     */
    public function setSexeMesure($sexe_mesure): void
    {
        $this->sexe_mesure = $sexe_mesure;
    }

    /**
     * @return mixed
     */
    public function getDosMesure()
    {
        return $this->dos_mesure;
    }

    /**
     * @param mixed $dos_mesure
     */
    public function setDosMesure($dos_mesure): void
    {
        $this->dos_mesure = $dos_mesure;
    }

    /**
     * @return mixed
     */
    public function getPantacourtMesure()
    {
        return $this->pantacourt_mesure;
    }

    /**
     * @param mixed $pantacourt_mesure
     */
    public function setPantacourtMesure($pantacourt_mesure): void
    {
        $this->pantacourt_mesure = $pantacourt_mesure;
    }

    /**
     * @return mixed
     */
    public function getTTeteMesure()
    {
        return $this->t_tete_mesure;
    }

    /**
     * @param mixed $t_tete_mesure
     */
    public function setTTeteMesure($t_tete_mesure): void
    {
        $this->t_tete_mesure = $t_tete_mesure;
    }
}