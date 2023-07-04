<?php
require_once 'models/modelClass.php';
require_once 'models/programme/programmeClass.php';

class programmeManager extends modelClass
{
    private $programmes;//Tableau de programmes

    public function addProgramme($programme)
    {
        $this->programmes[] = $programme;
    }

    public function getProgrammes()
    {
        return $this->programmes;
    }

    public function loadProgramme()
    {
        $agence = (isset($_SESSION['agence']) && !empty($_SESSION['agence']))? $_SESSION['agence'] : 0;
        $query = "SELECT * FROM commande_modele_tissu cmt JOIN  commande c ON c.id_commande=cmt.commande
                    JOIN client cl ON cl.id_client=c.client AND cl.agence=:agence ORDER BY id_cmt DESC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $allProgramme = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach ($allProgramme as $programme)
        {
            $data = array(
                'id'=> $programme['id_cmt'],
                'prix'=> $programme['prix_cmt'],
                'quantite'=> $programme['quantite_cmt'],
                'statut'=> $programme['statut_cmt'],
                'remise'=> $programme['remise_cmt'],
                'creat'=> $programme['creat_cmt'],
                'mod'=> $programme['mod_cmt'],
                'commande'=> $programme['commande'],
                'modele'=> $programme['modele'],
                'tissu'=> $programme['tissu'],
            );
            $item = new programmeClass($data);
            $this->addProgramme($item);
        }
    }

    public function getProgrammesCommande($commande)
    {
        $programmes_commande = [];
        if(!empty($this->programmes )){
            foreach ($this->programmes as $programme){
                if($programme->getCommande() === $commande->getIdCommande()){
                    array_push($programmes_commande,$programme);
                }
            }
        }
        return $programmes_commande;
    }

    public function getProgrammesCommandeId($commande)
    {
        $programmes_commande = [];
        if(!empty($this->programmes )){
            foreach ($this->programmes as $programme){
                if($programme->getCommande() === $commande){
                    array_push($programmes_commande,$programme);
                }
            }
        }
        return $programmes_commande;
    }

    public function getProgrammesModele($modele)
    {
        $programmes_modele = [];
        if(!empty($this->programmes )){
            foreach ($this->programmes as $programme){
                if($programme->getCommande() === $modele->getIdModele()){
                    array_push($programmes_modele,$programme);
                }
            }
        }
        return $programmes_modele;
    }

    public function getProgrammeById($id)
    {
        foreach ($this->programmes as $programme){
            if($programme->getIdCmt() === $id){
                return $programme;
            }
        }
    }

    public function getProgrammeStatut($statut)
    {
        $programmes_statut = [];
        if(!empty($this->programmes )){
            foreach ($this->programmes as $programme){
                if($programme->getStatutCmt() == $statut){
                    array_push($programmes_statut,$programme);
                }
            }
        }
        return $programmes_statut;
    }

    public function addProgrammeBd($data)
    {
        $query = "INSERT INTO commande_modele_tissu (prix_cmt,quantite_cmt,statut_cmt,remise_cmt,
                                                    creat_cmt, mod_cmt,commande, modele, tissu) 
                    VALUES (:prix,:quantite,:statut,:remise,:creat,:mod,:commande,:modele,:tissu)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":prix",$data['prix']);
        $stmt->bindValue(":quantite",$data['quantite']);
        $stmt->bindValue(":statut",$data['statut']);
        $stmt->bindValue(":remise",$data['remise']);
        $stmt->bindValue(":creat",$data['creat']);
        $stmt->bindValue(":mod",$data['creat']);
        $stmt->bindValue(":commande",$data['commande']);
        $stmt->bindValue(":modele",$data['modele']);
        $stmt->bindValue(":tissu",$data['tissu']);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result >0){
            $data['id'] =  $this->getBdd()->lastInsertId();
            $programme = new programmeClass($data);
            $this->addProgramme($programme);
        }
    }

    public function updateProgrammeBD($data)
    {
        $query = "UPDATE commande_modele_tissu SET prix_cmt=:prix, quantite_cmt=:qte, statut_cmt=:statut, remise_cmt=:remise,
                         modele=:modele, tissu=:tissu, mod_cmt=:mod WHERE id_cmt=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":prix",$data['prix']);
        $stmt->bindValue(":qte",$data['qte']);
        $stmt->bindValue(":statut",$data['statut']);
        $stmt->bindValue(":remise",$data['remise']);
        $stmt->bindValue(":modele",$data['modele']);
        $stmt->bindValue(":tissu",$data['tissu']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":id",$data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getProgrammeById($data['id'])->setPrixCmt($data['prix']);
            $this->getProgrammeById($data['id'])->setQuantiteCmt($data['qte']);
            $this->getProgrammeById($data['id'])->setModCmt($data['mod']);
            $this->getProgrammeById($data['id'])->setModele($data['modele']);
            $this->getProgrammeById($data['id'])->setTissu($data['tissu']);
            $this->getProgrammeById($data['id'])->setStatutCmt($data['statut']);
            $this->getProgrammeById($data['id'])->setRemiseCmt($data['remise']);
        }
    }

    public function updateStatutProgrammeBD($data)
    {
        $query = "UPDATE commande_modele_tissu SET statut_cmt=:statut, mod_cmt=:mod WHERE id_cmt=:id ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":statut",$data['statut']);
        $stmt->bindValue(":mod",$data['mod']);
        $stmt->bindValue(":id",$data['id']);

        $result = $stmt->execute();
        $stmt->closeCursor();
        if($result >0 ){
            $this->getProgrammeById($data['id'])->setStatutCmt($data['statut']);
            $this->getProgrammeById($data['id'])->setModCmt($data['mod']);
        }
    }

    public function deleteProgrammeBD($id)
    {
        $query = "DELETE FROM commande_modele_tissu WHERE id_cmt=:id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result >0 ){
            $programme = $this->getProgrammeById($id);
            unset($programme);
        }
    }

    public function programmeToDo()
    {
        $query = "SELECT * FROM commande c, commande_modele_tissu cmt , client cl, modele m WHERE
                   cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele AND
                   c.statut_commande=0 AND cmt.statut_cmt=0";
        $stmt = $this->getBdd()->prepare($query);
         $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function programmeToDoCommande($agence)
    {
        $query = "SELECT DISTINCT(c.id_commande), c.desc_commande, c.creat_commande, c.rdv_commande,
                    cl.nom_client, cl.prenom_client, cl.contact_client 
                    FROM commande c, commande_modele_tissu cmt , client cl, modele m
                    WHERE cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele AND
                   c.statut_commande=0 AND cmt.statut_cmt=0 AND cl.agence=:agence";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }
    public function programmeToDoCommandeArticles($commande)
    {
        $query = "SELECT m.id_modele,m.nom_modele, m.prix_modele, t.nom_tissu, cmt.quantite_cmt, cmt.prix_cmt, cmt.id_cmt  FROM commande c, 
                   commande_modele_tissu cmt , client cl, modele m, tissu t WHERE cmt.commande=c.id_commande AND c.client=cl.id_client 
                   AND cmt.modele=m.id_modele AND t.id_tissu = cmt.tissu AND c.statut_commande=0 AND cmt.statut_cmt=0 AND
                   c.id_commande=:commande";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$commande);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getProgrammeModele($commande)
    {
        $query = "SELECT nom_modele, quantite_cmt FROM commande_modele_tissu cmt 
                    JOIN modele m ON cmt.modele = m.id_modele
                    WHERE commande=:commande";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$commande);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }
    public function programmeRdvCommande($commande)
    {
        $query = "SELECT * FROM commande c, rdv r WHERE r.commande=c.id_commande AND c.statut_commande=0 AND c.id_commande=:commande ORDER BY r.creat_rdv DESC LIMIT 0,1";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$commande);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function programmeToDoArticlesPersonnel($personnel)
    {
        $query = "SELECT m.nom_modele, c.desc_commande, c.id_commande, c.rdv_commande, cmt.id_cmt, p.desc_prod, p.id_prod,p.quantite_prod, cl.nom_client, cl.prenom_client,
                   cl.contact_client, pe.nom_pers, pe.prenom_pers, pe.contact_pers, pe.id_pers FROM commande c, commande_modele_tissu cmt , client cl, modele m, tissu t, production p, personnel pe WHERE 
                   cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele AND t.id_tissu = cmt.tissu AND 
                   p.statut_prod=0 AND cmt.id_cmt = p.cmt AND pe.id_pers= p.personnel AND  p.personnel =:personnel";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$personnel);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function programmePeriodeArticlesPersonnel($personnel,$debut,$fin)
    {
        $query = "SELECT m.nom_modele, c.desc_commande, c.id_commande, c.rdv_commande, cmt.id_cmt, p.desc_prod,p.quantite_prod, p.id_prod, cl.nom_client, cl.prenom_client,
                   cl.contact_client, pe.nom_pers, pe.prenom_pers, pe.contact_pers, pe.id_pers FROM commande c, commande_modele_tissu cmt , client cl, modele m, tissu t, production p, personnel pe WHERE 
                   cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele AND t.id_tissu = cmt.tissu AND cmt.id_cmt = p.cmt AND pe.id_pers= p.personnel AND  p.personnel =:personnel
                   AND c.creat_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":personnel",$personnel);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function programmeRdvPeriode($commande, $debut,$fin)
    {
        $query = "SELECT * FROM commande c, rdv r WHERE r.commande=c.id_commande AND c.id_commande=:commande 
                  AND c.creat_commande BETWEEN :debut AND :fin ORDER BY r.id_rdv DESC LIMIT 0,1";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$commande);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function programmePeriodeCommande($agence,$debut, $fin)
    {
        $query = "SELECT DISTINCT(c.id_commande), c.desc_commande, c.creat_commande, c.rdv_commande, cl.nom_client,
                    cl.prenom_client, cl.contact_client 
                    FROM commande c, commande_modele_tissu cmt , client cl, modele m 
                    WHERE cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele 
                    AND cl.agence=:agence AND c.creat_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }
    public function getProgrammesCommandeAndStatut($commande, $statut)
    {
        $query = "SELECT m.nom_modele,t.nom_tissu, cmt.quantite_cmt  FROM commande c, commande_modele_tissu cmt , client cl, modele m, tissu t 
                  WHERE cmt.commande=c.id_commande AND c.client=cl.id_client AND cmt.modele=m.id_modele 
                  AND t.id_tissu = cmt.tissu AND c.id_commande=:commande AND cmt.statut_cmt =:statut";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$commande);
        $stmt->bindValue(":statut",$statut);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
   }

    public function getProgrammesPersonnel($commande)
    {
        $query = "SELECT m.nom_modele, t.nom_tissu, cmt.quantite_cmt
                  FROM commande_modele_tissu cmt 
                  JOIN modele m ON cmt.modele = m.id_modele
                  JOIN tissu t ON cmt.tissu = t.id_tissu
                  WHERE cmt.commande=:commande";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$commande);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function programmePeriodeCommandeArticles($commande,$debut, $fin)
    {
        $query = "SELECT m.nom_modele, m.prix_modele, t.nom_tissu, cmt.quantite_cmt, cmt.prix_cmt, cmt.id_cmt  FROM commande c, 
                   commande_modele_tissu cmt , client cl, modele m, tissu t WHERE cmt.commande=c.id_commande AND c.client=cl.id_client 
                   AND cmt.modele=m.id_modele AND t.id_tissu = cmt.tissu AND c.id_commande=:commande AND c.creat_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":commande",$commande);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }


    public function getCommandeRdvDetail($agence)
    {
        $query = "SELECT cl.nom_client, cl.prenom_client, cl.contact_client, c.desc_commande, c.rdv_commande, c.id_commande
                  FROM commande c JOIN  client cl ON cl.id_client=c.client
                  WHERE c.statut_commande = 0 AND cl.agence=:agence ORDER BY c.rdv_commande ASC";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getChiffreAffaireByModeleAgencePeriod($modele,$agence,$debut,$fin)
    {
        $query = "SELECT SUM((prix_cmt - remise_cmt)) as total, SUM(quantite_cmt) as quantite 
                    FROM client cl JOIN commande cmd ON cl.id_client=cmd.client
                    JOIN commande_modele_tissu cmt ON cmt.commande=cmd.id_commande
                    WHERE cmt.modele=:modele AND cl.agence=:agence AND cmd.creat_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->bindValue(":modele",$modele);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

    public function getChargeByModeleAgencePeriod($modele,$agence,$debut,$fin)
    {
        $query = "SELECT SUM(ch.prix_charge) as total , SUM(p.rend_prod) as rend
                    FROM client cl JOIN commande cmd ON cl.id_client=cmd.client
                    JOIN commande_modele_tissu cmt ON cmt.commande=cmd.id_commande
                    JOIN production p ON p.cmt=cmt.id_cmt
                    JOIN charge ch ON p.id_prod=ch.production
                    WHERE cmt.modele=:modele AND cl.agence=:agence AND cmd.creat_commande BETWEEN :debut AND :fin";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":agence",$agence);
        $stmt->bindValue(":modele",$modele);
        $stmt->bindValue(":debut",$debut);
        $stmt->bindValue(":fin",$fin);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result;
    }

}
