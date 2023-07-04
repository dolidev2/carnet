<?php
require_once "models/modelClass.php";
require_once "models/client/mesure/mesureClientClass.php";

class mesureClientManager extends modelClass
{
    private $mesures;//Tableau de mesures

    public function addMesure($mesure)
    {
        $this->mesures[] = $mesure;
    }

    public function getMesuresClient($client)
    {
        $mesures_client = [];
        if (!empty($this->mesures)) {
            foreach ($this->mesures as $mesure) {
                if ($mesure->getClient() === $client->getIdClient()) {
                    array_push($mesures_client, $mesure);
                }
            }
        }

        return $mesures_client;
    }

    public function getMesureById($id)
    {
        foreach ($this->mesures as $mesure) {
            if ($mesure->getIdMesure() === $id) {
                return $mesure;
            }
        }
    }

    public function loadMesure()
    {
        $query = "SELECT * FROM mesure";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->execute();
        $allMesure = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($allMesure as $mesure) {
            $data = array(
                'id' => $mesure['id_mesure'],
                'epaule' => $mesure['epaule_mesure'],
                'l_epaule' => $mesure['l_epaule_mesure'],
                'l_manche' => $mesure['l_manche_mesure'],
                'bas' => $mesure['bas_mesure'],
                'poitrine' => $mesure['poitrine_mesure'],
                'dos' => $mesure['dos_mesure'],
                'bassin' => $mesure['bassin_mesure'],
                'l_taille' => $mesure['l_taille_mesure'],
                't_taille' => $mesure['t_taille_mesure'],
                't_genou' => $mesure['t_genou_mesure'],
                'ceinture' => $mesure['ceinture_mesure'],

                'poignet' => $mesure['poignet_mesure'],
                't_manche' => $mesure['t_manche_mesure'],
                'cole' => $mesure['cole_mesure'],
                'cuisse' => $mesure['cuisse_mesure'],
                'l_chemise' => $mesure['l_chemise_mesure'],
                'l_veste' => $mesure['l_veste_mesure'],
                'l_genou' => $mesure['l_genou_mesure'],
                'l_pantalon' => $mesure['l_pantalon_mesure'],
                'pantacourt' => $mesure['pantacourt_mesure'],
                'e_jambe' => $mesure['e_jambe_mesure'],
                'l_chemise_a' => $mesure['l_chemise_a_mesure'],

                'frappe' => $mesure['frappe_mesure'],
                'l_gilet' => $mesure['l_gilet_mesure'],
                'carrure' => $mesure['carrure_mesure'],

                'e_p_poitrine' => $mesure['e_p_poitrine_mesure'],
                'l_jupe' => $mesure['l_jupe_mesure'],
                'l_robe' => $mesure['l_robe_mesure'],
                'l_poitrine' => $mesure['l_poitrine_mesure'],
                'l_haut' => $mesure['l_haut_mesure'],

                'creat' => $mesure['creat_mesure'],
                'mod' => $mesure['mod_mesure'],
                'sexe' => $mesure['sexe_mesure'],
                't_tete' => $mesure['t_tete_mesure'],
                'client' => $mesure['client']
            );
            $item = new mesureClientClass($data);
            $this->addMesure($item);
        }
    }

    public function addMesureBD($data)
    {
        $query = "INSERT INTO mesure(epaule_mesure,l_epaule_mesure,bas_mesure,poitrine_mesure,dos_mesure,t_taille_mesure,bassin_mesure,l_taille_mesure,
                   t_genou_mesure,ceinture_mesure,poignet_mesure,t_manche_mesure,l_manche_mesure,cole_mesure,cuisse_mesure,l_chemise_mesure,
                   l_gilet_mesure,l_veste_mesure,l_genou_mesure,l_pantalon_mesure,pantacourt_mesure,e_jambe_mesure,l_chemise_a_mesure,frappe_mesure,carrure_mesure,
                   e_p_poitrine_mesure,l_jupe_mesure,l_robe_mesure,l_poitrine_mesure,l_haut_mesure, creat_mesure,mod_mesure,sexe_mesure,t_tete_mesure,client)
                    VALUES (:epaule,:l_epaule,:bas,:poitrine,:dos,:t_taille,:bassin,:l_taille,:t_genou,:ceinture,:poignet,
                            :t_manche,:l_manche,:cole,:cuisse,:l_chemise,:l_gilet,:l_veste,:l_genou,:l_pantalon,:pantacourt,:e_jambe,
                            :l_chemise_a,:frappe, :carrure,:e_p_poitrine ,:l_jupe ,:l_robe ,:l_poitrine ,:l_haut ,:creat, :mod,:sexe, :t_tete, :client)";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':epaule', $data['epaule']);
        $stmt->bindValue(':l_epaule', $data['l_epaule']);
        $stmt->bindValue(':bas', $data['bas']);
        $stmt->bindValue(':poitrine', $data['poitrine']);
        $stmt->bindValue(':dos', $data['dos']);
        $stmt->bindValue(':bassin', $data['bassin']);
        $stmt->bindValue(':l_taille', $data['l_taille']);
        $stmt->bindValue(':t_taille', $data['t_taille']);
        $stmt->bindValue(':t_genou', $data['t_genou']);
        $stmt->bindValue(':ceinture', $data['ceinture']);
        $stmt->bindValue(':poignet', $data['poignet']);

        $stmt->bindValue(':t_manche', $data['t_manche']);
        $stmt->bindValue(':l_manche', $data['l_manche']);
        $stmt->bindValue(':cole', $data['cole']);
        $stmt->bindValue(':cuisse', $data['cuisse']);
        $stmt->bindValue(':l_chemise', $data['l_chemise']);
        $stmt->bindValue(':l_gilet', $data['l_gilet']);
        $stmt->bindValue(':l_veste', $data['l_veste']);
        $stmt->bindValue(':l_genou', $data['l_genou']);
        $stmt->bindValue(':l_pantalon', $data['l_pantalon']);
        $stmt->bindValue(':pantacourt', $data['pantacourt']);
        $stmt->bindValue(':e_jambe', $data['e_jambe']);

        $stmt->bindValue(':l_chemise_a', $data['l_chemise_a']);
        $stmt->bindValue(':frappe', $data['frappe']);
        $stmt->bindValue(':carrure', $data['carrure']);

        $stmt->bindValue(':e_p_poitrine', $data['e_p_poitrine']);
        $stmt->bindValue(':l_jupe', $data['l_jupe']);
        $stmt->bindValue(':l_robe', $data['l_robe']);
        $stmt->bindValue(':l_poitrine', $data['l_poitrine']);
        $stmt->bindValue(':l_haut', $data['l_haut']);

        $stmt->bindValue(':creat', $data['creat']);
        $stmt->bindValue(':mod', $data['mod']);
        $stmt->bindValue(':sexe', $data['sexe']);
        $stmt->bindValue(':t_tete', $data['t_tete']);
        $stmt->bindValue(':client', $data['client']);

        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            $data['id'] = $this->getBdd()->lastInsertId();
            $mesure = new mesureClientClass($data);
            $this->addMesure($mesure);
        }
    }

    public function updateMesureBd($data)
    {
        $query = "UPDATE mesure SET 
                  epaule_mesure=:epaule, l_epaule_mesure=:l_epaule,bas_mesure=:bas, poitrine_mesure=:poitrine,dos_mesure=:dos, bassin_mesure=:bassin,
                  l_taille_mesure=:l_taille, t_genou_mesure=:t_genou, ceinture_mesure=:ceinture, poignet_mesure=:poignet,
                  t_manche_mesure=:t_manche, l_manche_mesure=:l_manche,cole_mesure=:cole, cuisse_mesure=:cuisse, l_chemise_mesure=:l_chemise,
                  l_gilet_mesure=:l_gilet, l_veste_mesure=:l_veste, l_genou_mesure=:l_genou, l_pantalon_mesure=:l_pantalon, pantacourt_mesure=:pantacourt,
                  e_jambe_mesure=:e_jambe, l_chemise_a_mesure=:l_chemise_a, frappe_mesure=:frappe, carrure_mesure=:carrure,
                  mod_mesure=:mod, t_taille_mesure=:t_taille, e_p_poitrine_mesure=:e_p_poitrine ,l_jupe_mesure=:l_jupe,
                  l_robe_mesure=:l_robe,l_poitrine_mesure=:l_poitrine,l_haut_mesure=:l_haut, sexe_mesure=:sexe, t_tete_mesure=:t_tete  WHERE id_mesure=:id ";

        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':epaule', $data['epaule']);
        $stmt->bindValue(':l_epaule', $data['l_epaule']);
        $stmt->bindValue(':l_manche', $data['l_manche']);
        $stmt->bindValue(':bas', $data['bas']);
        $stmt->bindValue(':poitrine', $data['poitrine']);
        $stmt->bindValue(':dos', $data['dos']);
        $stmt->bindValue(':bassin', $data['bassin']);
        $stmt->bindValue(':l_taille', $data['l_taille']);
        $stmt->bindValue(':t_taille', $data['t_taille']);
        $stmt->bindValue(':t_genou', $data['t_genou']);
        $stmt->bindValue(':ceinture', $data['ceinture']);

        $stmt->bindValue(':poignet', $data['poignet']);
        $stmt->bindValue(':t_manche', $data['t_manche']);
        $stmt->bindValue(':cole', $data['cole']);
        $stmt->bindValue(':cuisse', $data['cuisse']);
        $stmt->bindValue(':l_chemise', $data['l_chemise']);
        $stmt->bindValue(':l_veste', $data['l_veste']);
        $stmt->bindValue(':l_genou', $data['l_genou']);
        $stmt->bindValue(':l_pantalon', $data['l_pantalon']);
        $stmt->bindValue(':pantacourt', $data['pantacourt']);
        $stmt->bindValue(':e_jambe', $data['e_jambe']);
        $stmt->bindValue(':l_chemise_a', $data['l_chemise_a']);

        $stmt->bindValue(':frappe', $data['frappe']);
        $stmt->bindValue(':l_gilet', $data['l_gilet']);
        $stmt->bindValue(':carrure', $data['carrure']);

        $stmt->bindValue(':e_p_poitrine', $data['e_p_poitrine']);
        $stmt->bindValue(':l_jupe', $data['l_jupe']);
        $stmt->bindValue(':l_robe', $data['l_robe']);
        $stmt->bindValue(':l_poitrine', $data['l_poitrine']);
        $stmt->bindValue(':l_haut', $data['l_haut']);

        $stmt->bindValue(':mod', $data['mod']);
        $stmt->bindValue(':sexe', $data['sexe']);
        $stmt->bindValue(':t_tete', $data['t_tete']);
        $stmt->bindValue(':id', $data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if ($result > 0) {
            $this->getMesureById($data['id'])->setEpauleMesure($data['epaule']);
            $this->getMesureById($data['id'])->setLEpauleMesure($data['l_epaule']);
            $this->getMesureById($data['id'])->setLMancheMesure($data['l_manche']);
            $this->getMesureById($data['id'])->setBasMesure($data['bas']);
            $this->getMesureById($data['id'])->setPoitrineMesure($data['poitrine']);
            $this->getMesureById($data['id'])->setDosMesure($data['dos']);
            $this->getMesureById($data['id'])->setBassinMesure($data['bassin']);
            $this->getMesureById($data['id'])->setLTailleMesure($data['l_taille']);
            $this->getMesureById($data['id'])->setTGenouMesure($data['t_genou']);
            $this->getMesureById($data['id'])->setCeintureMesure($data['ceinture']);
            $this->getMesureById($data['id'])->setPoignetMesure($data['poignet']);
            $this->getMesureById($data['id'])->setTMancheMesure($data['t_manche']);
            $this->getMesureById($data['id'])->setColeMesure($data['cole']);
            $this->getMesureById($data['id'])->setCuisseMesure($data['cuisse']);
            $this->getMesureById($data['id'])->setLChemiseMesure($data['l_chemise']);
            $this->getMesureById($data['id'])->setLVesteMesure($data['l_veste']);
            $this->getMesureById($data['id'])->setLGenouMesure($data['l_genou']);
            $this->getMesureById($data['id'])->setLPantalonMesure($data['l_pantalon']);
            $this->getMesureById($data['id'])->setPantacourtMesure($data['pantacourt']);
            $this->getMesureById($data['id'])->setEJambeMesure($data['e_jambe']);
            $this->getMesureById($data['id'])->setLChemiseAMesure($data['l_chemise_a']);
            $this->getMesureById($data['id'])->setFrappeMesure($data['frappe']);
            $this->getMesureById($data['id'])->setLGiletMesure($data['l_gilet']);
            $this->getMesureById($data['id'])->setCarrureMesure($data['carrure']);

            $this->getMesureById($data['id'])->setEPPoitrineMesure($data['e_p_poitrine']);
            $this->getMesureById($data['id'])->setLJupeMesure($data['l_jupe']);
            $this->getMesureById($data['id'])->setLJupeMesure($data['l_robe']);
            $this->getMesureById($data['id'])->setLRobeMesure($data['l_robe']);
            $this->getMesureById($data['id'])->setLPoitrineMesure($data['l_poitrine']);
            $this->getMesureById($data['id'])->setLHautMesure($data['l_haut']);
            $this->getMesureById($data['id'])->setModMesure($data['mod']);
            $this->getMesureById($data['id'])->setSexeMesure($data['sexe']);
            $this->getMesureById($data['id'])->setTTeteMesure($data['t_tete']);
            $this->getMesureById($data['id'])->setTTailleMesure($data['t_taille']);
        }
    }

    public function deleteMesureBD($id)
    {
        $query = "DELETE FROM mesure WHERE id_mesure=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if ($result > 0) {
            $mesure = $this->getMesureById($id);
            unset($mesure);
        }
    }

}