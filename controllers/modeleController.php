<?php
    require_once "models/modele/modeleManager.php";
    require_once "models/programme/programmeManager.php";
    require_once "models/audit/auditManager.php";
    require_once "models/modele_composition/modeleCompManager.php";
    require_once "models/ligne_compo/ligneCompoManager.php";

    class modeleController
    {
        private $modeleManager;
        private $programmeManager;
        private $auditManager;
        private $modeleCompManager;
        private $ligneCompManager;

        public function __construct()
        {
            $this->auditManager = new auditManager();

            $this->modeleManager = new ModeleManager();
            $this->modeleManager->loadModele();

            $this->programmeManager = new programmeManager();
            $this->programmeManager->loadProgramme();

            $this->modeleCompManager = new modeleCompManager();
            $this->modeleCompManager->loadModeleComp();

            $this->ligneCompManager = new ligneCompoManager();
            $this->ligneCompManager->loadLigneCompos();
        }

        public function displayModele()
        {
            $modeles = $this->modeleManager->getModeles();
            $modelesComp = $this->modeleCompManager->getModelesComp();
            $data_modeles = [];
            foreach ($modeles as $model){
                $item = array(
                    'id'=> $model->getIdModele(),
                    'nom'=> $model->getNomModele(),
                    'desc'=> $model->getDescModele(),
                    'prix'=> $model->getPrixModele(),
                    'cout'=> $model->getCoutModele(),
                    'recto'=> $model->getRectoModele(),
                    'verso'=> $model->getVersoModele(),
                    'comp'=> false,
                );
                array_push($data_modeles, $item);
            }

            foreach ($modelesComp as $model){
                $item = array(
                    'id'=> $model->getIdModComp(),
                    'nom'=> $model->getNomModComp(),
                    'desc'=> $model->getDescModComp(),
                    'prix'=> $model->getPrixModComp(),
                    'cout'=>'',
                    'recto'=> $model->getRectoModComp(),
                    'verso'=> $model->getVersoModComp(),
                    'comp'=> true,
                );
                array_push($data_modeles, $item);
            }
            require "views/modele/home.php";
        }

        public function addModele()
        {
            $modeles = $this->modeleManager->getModeles();
            require "views/modele/add.php";
        }

        public function addSaveModele()
        {
            //Add Image
            $repertoire = "public/image/modele/";

            if (!empty($_FILES['recto']['name'])) {
                $imageRecto = $_FILES['recto'];
                $nomImageAjouteRecto = $this->uploadImage($imageRecto, $repertoire);
            } else {
                $nomImageAjouteRecto = '';
            }

            if (!empty($_FILES['verso']['name'])) {
                $imageVerso = $_FILES['verso'];
                $nomImageAjouteVerso = $this->uploadImage($imageVerso, $repertoire);
            } else {
                $nomImageAjouteVerso = '';
            }
            if (!empty($_POST['modele'])) {
                $data = array(
                    'nom' => $this->fieldValidation($_POST['nom']),
                    'desc' => $this->fieldValidation($_POST['desc']),
                    'recto' => $nomImageAjouteRecto,
                    'verso' => $nomImageAjouteVerso,
                    'creat' => date("y-m-d"),
                    'mod' => date("y-m-d"),
                    'prix' => $this->fieldValidation($_POST['prix']),
                );
                $modeleCompId = $this->modeleCompManager->addModeleCompBd($data);

                foreach ($_POST['modele'] as $modele) {
                    $data_modele = array(
                        "modele" => $modele,
                        'modele_comp' => $modeleCompId,
                        'creat' => date("y-m-d"),
                        'mod' => date("y-m-d")
                    );
                    $this->ligneCompManager->addLigneCompoBd($data_modele);
                }

            } else {
                $data = array(
                    'nom' => $this->fieldValidation($_POST['nom']),
                    'desc' => $this->fieldValidation($_POST['desc']),
                    'recto' => $nomImageAjouteRecto,
                    'verso' => $nomImageAjouteVerso,
                    'creat' => date("y-m-d"),
                    'mod' => date("y-m-d"),
                    'prix' => $this->fieldValidation($_POST['prix']),
                    'cout' => $this->fieldValidation($_POST['cout']),
                    'cout_decoup' => $this->fieldValidation($_POST['coutd'])
                );
                $this->modeleManager->addModeleBd($data);
            }

            //Add audit
            $audit = array(
                'desc' => "Ajout d'un nouveau modèle: " . $data['nom'] . ' description ' . $data['desc'] . ' prix ' . $data['prix'],
                'action' => 'Ajout',
                'creat' => date("Y-m-d"),
                'user' => $_SESSION['id'],
            );
            $this->auditManager->addAuditBd($audit);
            header('location: ' . URL . 'modele');
        }

        public function updateModele($id)
        {
            $modele = $this->modeleManager->getModeleById($id);
            $modeleComposition = $this->modeleCompManager->getModeleCompById($id);
            if($modele){
                require "views/modele/update.php";
            }elseif($modeleComposition){
                //Get all modeles
                $modeles = $this->modeleManager->getModeles();
                //Get composition modele
                $lignecomposModele = $this->ligneCompManager->getLigneByModeleCompo($id);
                //Get all modeles
                $CompoundModeles = [];
                foreach ($lignecomposModele as $comp) {
                    $modeleUnique = $this->modeleManager->getModeleById($comp->getModele());
                    $item = array(
                        'id_modele'=>$modeleUnique->getIdModele(),
                        'id_comp'=>$comp->getIdModComp()
                    );
                    array_push($CompoundModeles, $item);
                }
                require "views/modele/updateComposition.php";
            }
        }

        public function updateSaveModele($id)
        {
            $modele = $this->modeleManager->getModeleById($id);
            $modeleComposition = $this->modeleCompManager->getModeleCompById($id);
            if($modele){

                $imageOldRecto = $modele->getRectoModele();
                $imageRecentRecto = $_FILES['recto'];

                $imageOldVerso = $modele->getVersoModele();
                $imageRecentVerso = $_FILES['verso'];

                if ($imageRecentRecto['size'] > 0) {
                    unlink("public/image/modele/" . $imageOldRecto);
                    $repertoire = "public/image/modele/";
                    $nomImageToAddRecto = $this->uploadImage($imageRecentRecto, $repertoire);
                } else {
                    $nomImageToAddRecto = $imageOldRecto;
                }

                if ($imageRecentVerso['size'] > 0) {
                    unlink("public/image/modele/" . $imageOldVerso);
                    $repertoire = "public/image/modele/";
                    $nomImageToAddVerso = $this->uploadImage($imageRecentVerso, $repertoire);
                } else {
                    $nomImageToAddVerso = $imageOldVerso;
                }

                $data = array(
                    'nom' => $this->fieldValidation($_POST['nom']),
                    'desc' => $this->fieldValidation($_POST['desc']),
                    'prix' => $this->fieldValidation($_POST['prix']),
                    'cout' => $this->fieldValidation($_POST['cout']),
                    'cout_decoup' => $this->fieldValidation($_POST['coutd']),
                    'mod' => date("Y-m-d"),
                    'recto' => $nomImageToAddRecto ,
                    'verso' => $nomImageToAddVerso,
                    'id' => $this->fieldValidation($_POST['modele'])
                );
                $this->modeleManager->updateModeleBD($data);
            }
            elseif($modeleComposition){

                if (isset($_POST['lignes'][0]) &&
                    !empty($_POST['lignes'][0]) &&
                    isset($_POST['modeles'][0]) &&
                    !empty($_POST['modeles'][0]))
                {
                    //Update ligne modele composition
                    for ($i = 0; $i < count($_POST['lignes']); $i++) {
                        $item = array(
                            'mod' => date("Y-m-d"),
                            'modele' =>(int) $_POST['modeles'][$i],
                            'id' => (int) $_POST['lignes'][$i],
                        );
                        $this->ligneCompManager->updateLigneCompoBD($item);
                    }

                   //Delete ligne modeles composition
                    $lignesFormToDelete = [];
                    $selectModeleCompo = $this->ligneCompManager->getLigneByModeleCompo($modeleComposition->getIdModComp());
                    if(count($selectModeleCompo) != count($_POST['lignes'])){
                        foreach ($selectModeleCompo as $item){
                            foreach ($_POST['lignes'] as $ligne){
                                if ((int) $ligne != (int) $item->getIdModComp()){
                                    array_push($lignesFormToDelete, $item->getIdModComp());
                                }
                            }
                        }
                        if (!empty($lignesFormToDelete)){
                            foreach ($lignesFormToDelete as $item){
                            $this->ligneCompManager->deleteLigneCompoBD($item);
                            }
                        }
                    }
                }

                //Add ligne modele composition
                if (isset($_POST['modeles_add'][0]) &&
                    !empty($_POST['modeles_add'][0])){

                    foreach ($_POST['modeles_add'] as $modele) {
                        $data_modele = array(
                            "modele" => $modele,
                            'modele_comp' => $modeleComposition->getIdModComp(),
                            'creat' => date("y-m-d"),
                            'mod' => date("y-m-d")
                        );
                        $this->ligneCompManager->addLigneCompoBd($data_modele);
                    }
                }

                //Update data modele composition
                $imageOldRecto = $modeleComposition->getRectoModComp();
                $imageRecentRecto = $_FILES['recto'];

                $imageOldVerso = $modeleComposition->getVersoModComp();
                $imageRecentVerso = $_FILES['verso'];

                if ($imageRecentRecto['size'] > 0) {
                    unlink("public/image/modele/" . $imageOldRecto);
                    $repertoire = "public/image/modele/";
                    $nomImageToAddRecto = $this->uploadImage($imageRecentRecto, $repertoire);
                } else {
                    $nomImageToAddRecto = $imageOldRecto;
                }

                if ($imageRecentVerso['size'] > 0) {
                    unlink("public/image/modele/" . $imageOldVerso);
                    $repertoire = "public/image/modele/";
                    $nomImageToAddVerso = $this->uploadImage($imageRecentVerso, $repertoire);
                } else {
                    $nomImageToAddVerso = $imageOldVerso;
                }

                $data = array(
                    'nom' => $this->fieldValidation($_POST['nom']),
                    'desc' => $this->fieldValidation($_POST['desc']),
                    'prix' => $this->fieldValidation($_POST['prix']),
                    'recto' => $nomImageToAddRecto ,
                    'verso' => $nomImageToAddVerso,
                    'mod' => date("Y-m-d"),
                    'id' => $modeleComposition->getIdModComp()
                );
                $this->modeleCompManager->updateModeleCompBD($data);
            }

            $audit = array(
                'desc' => "Modification du  modèle: " . $data['nom'] . ' description ' . $data['desc'] . ' prix ' . $data['prix'],
                'action' => 'Modification',
                'creat' => date("Y-m-d"),
                'user' => $_SESSION['id'],
            );
            $this->auditManager->addAuditBd($audit);
            header('location: ' . URL . 'modele');
        }

        public function detailModele($id)
        {
            $data = [];
            $modele = $this->modeleManager->getModeleById($id);
            $modeleComposition = $this->modeleCompManager->getModeleCompById($id);
            if ($modele){
                $item = array(
                    'id'=>$modele->getIdModele(),
                    'nom'=>$modele->getNomModele(),
                    'desc'=>$modele->getDescModele(),
                    'recto'=>$modele->getRectoModele(),
                    'verso'=>$modele->getVersoModele(),
                    'prix'=>$modele->getPrixModele(),
                    'montage'=>$modele->getCoutModele(),
                    'decoupage'=>$modele->getCoutDecoupModele(),
                );
                $data['modele'] = $item;
            }
            elseif($modeleComposition){
                $item = array(
                    'id'=>$modeleComposition->getIdModComp(),
                    'nom'=>$modeleComposition->getNomModComp(),
                    'desc'=>$modeleComposition->getDescModComp(),
                    'recto'=>$modeleComposition->getRectoModComp(),
                    'verso'=>$modeleComposition->getVersoModComp(),
                    'prix'=>$modeleComposition->getPrixModComp(),
                );
                $data['modele'] = $item;
                //Get composition modele
                $lignecomposModele = $this->ligneCompManager->getLigneByModeleCompo($id);
                //Get all modeles
                $data_modeles = [];
                foreach ($lignecomposModele as $comp) {
                    $modeleUnique = $this->modeleManager->getModeleById($comp->getModele());
                    array_push($data_modeles, $modeleUnique);
                }
                $data['composition'] = $data_modeles;
            }

            require "views/modele/detail.php";
        }

        public function displayPrixModele($id)
        {
            $modele = $this->modeleManager->getModeleById($id);
            $response = (!empty($modele)) ? $modele->getPrixModele() : 0;
            echo $response;
        }


        public function deleteSaveModele($id)
        {
            $modele = $this->modeleManager->getModeleById($id);
            $modeleComposition = $this->modeleCompManager->getModeleCompById($id);
            if($modele){
                $programmes = $this->programmeManager->getProgrammesModele($modele);
                if (!empty($programmes)) {
                    foreach ($programmes as $programme) {
                        $this->programmeManager->deleteProgrammeBD($programme->getIdCmt());
                    }
                }
                $audit = array(
                    'desc' => "Suppression du modèle: " . $modele->getNomModele() . ' description ' . $modele->getDescModele() . ' prix ' . $modele->getPrixModele(),
                    'action' => 'Suppression',
                    'creat' => date("Y-m-d"),
                    'user' => $_SESSION['id'],
                );
                $this->modeleManager->deleteModeleBD($id);

            }elseif($modeleComposition){
                $lignes = $this->ligneCompManager->getLigneByModeleCompo($id);
                foreach ($lignes as $ligne){
                    $this->ligneCompManager->deleteLigneCompoBD($ligne->getIdModComp());
                }

                $audit = array(
                    'desc' => "Suppression du modèle: " . $modeleComposition->getNomModComp() . ' description ' . $modeleComposition->getDescModComp() . ' prix ' . $modeleComposition->getPrixModComp(),
                    'action' => 'Suppression',
                    'creat' => date("Y-m-d"),
                    'user' => $_SESSION['id'],
                );
                $this->modeleCompManager->deleteModeleCompBD($id);
            }

            $this->auditManager->addAuditBd($audit);
            header('location: ' . URL . 'modele');
        }

        public function fieldValidation($param)
        {
            return htmlspecialchars(strip_tags($param));
        }

        private function uploadImage($file, $dir)
        {
            if (!isset($file['name']) || empty($file['name']))
                throw new Exception("Vous devez indiquer une image");

            if (!file_exists($dir)) mkdir($dir, 0777);

            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $random = rand(0, 99999);
            $target_file = $dir . $random . "_" . $file['name'];

            if (!getimagesize($file["tmp_name"]))
                throw new Exception("Le fichier n'est pas une image");
            if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
                throw new Exception("L'extension du fichier n'est pas reconnu");
            if (file_exists($target_file))
                throw new Exception("Le fichier existe déjà");
            if ($file['size'] > 500000)
                throw new Exception("Le fichier est trop gros");
            if (!move_uploaded_file($file['tmp_name'], $target_file))
                throw new Exception("l'ajout de l'image n'a pas fonctionné");
            else return ($random . "_" . $file['name']);
        }
    }