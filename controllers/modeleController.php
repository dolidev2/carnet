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
            $modeleComp = $this->modeleCompManager->getModeleCompById($id);

            $data_modele_comp = [];
            if (!empty($modeleComp)) {
                $modeleCompDetails = $this->ligneCompManager->getLigneByModeleCompo($modeleComp);
                foreach ($modeleCompDetails as $comp) {
                    $modeleId = $this->modeleManager->getModeleById($comp->getModele());
                    array_push($data_modele_comp, $modeleId);
                }
                $modeles = $this->modeleManager->getModeles();
                require "views/modele/update.php";
            }

            require "views/modele/update.php";
        }

        public function updateSaveModele($id)
        {
            if (isset($_POST['modeles'][0]) && !empty($_POST['modeles'][0])) {
                //Get compo modele
                $modeleCompId = $this->modeleCompManager->getModeleComp($id);

                //update modele
                for ($i = 0; $i < count($_POST['modeles']); $i++) {
                    $item = array(
                        'creat' => date("Y-m-d"),
                        'modele' => $this->fieldValidation($_POST['modeles'][$i]),
                        'id' => $modeleCompId[$i]['id_mod_comp'],
                    );
                    $this->modeleCompManager->updateModeleCompBD($item);
                }
            }
            $modele = $this->modeleManager->getModeleById($id);
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
                'recto' => $nomImageToAddRecto,
                'verso' => $nomImageToAddVerso,
                'mod' => date("Y-m-d"),
                'prix' => $this->fieldValidation($_POST['prix']),
                'cout' => $this->fieldValidation($_POST['cout']),
                'cout_decoup' => $this->fieldValidation($_POST['coutd']),
                'id' => $id
            );
            $this->modeleManager->updateModeleBD($data);
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
            $modele = $this->modeleManager->getModeleById($id);
            //Get compo modele
            $modeleCompId = $this->modeleCompManager->getModeleComp($id);
            $data_modele_comp = [];
            if (!empty($modeleCompId)) {
                foreach ($modeleCompId as $comp) {
                    $modeleId = $this->modeleManager->getModeleById($comp['modele_comp']);
                    array_push($data_modele_comp, $modeleId);
                }
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
            $this->auditManager->addAuditBd($audit);
            $this->modeleManager->deleteModeleBD($id);
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