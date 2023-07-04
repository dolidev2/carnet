<?php

require_once 'models/agence/agenceManager.php';
require_once 'models/audit/auditManager.php';

class agenceController
{
    private $agenceManager;
    private $auditManager;

    public function __construct()
    {
        $this->agenceManager = new agenceManager();
        $this->agenceManager->loadAgence();

        $this->auditManager = new auditManager();
    }

    public function addAgence()
    {
        require 'views/agence/add.php';
    }
    public function addSaveAgence()
    {
        $data = array(
            'nom'=> $this->fieldValidation($_POST['nom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'adresse'=> $this->fieldValidation($_POST['adresse']),
            'email'=> $this->fieldValidation($_POST['email']),
            'bp'=> $this->fieldValidation($_POST['bp']),
            'df'=> $this->fieldValidation($_POST['df']),
            'ri'=> $this->fieldValidation($_POST['ri']),
            'ifu'=> $this->fieldValidation($_POST['ifu']),
            'rccm'=> $this->fieldValidation($_POST['rccm']),
            'statut'=> $this->fieldValidation($_POST['statut']),
            'creat'=>date("Y-m-d"),
            'mod'=>date("Y-m-d")
        );
        $this->agenceManager->addAgenceBd($data);

        $audit = array(
            'desc'=>"Ajout de l'agence ".$data['nom']." adresse ".$data['adresse']." contact ".$data['contact'],
            'action'=>'Ajout',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function displayAgence()
    {
        $agences = $this->agenceManager->getAgences();
        require 'views/agence/home.php';
    }

    public function updateAgenceSession()
    {
        $agenceId = $this->fieldValidation($_POST['agence']);
        $agence = $this->agenceManager->getAgenceById($agenceId);
        //Agence
        $_SESSION['agence'] = $agence->getIdAgence();
        $_SESSION['agence_role'] = $agence->getStatutAgence();
        $_SESSION['agence_nom'] = $agence->getNomAgence();
        $_SESSION['agence_contact'] = $agence->getContactAgence();
        $_SESSION['agence_adresse'] = $agence->getAdresseAgence();
        $_SESSION['agence_email'] = $agence->getEmailAgence();
        $_SESSION['agence_ifu'] = $agence->getIfuAgence();
        $_SESSION['agence_rccm'] = $agence->getRccmAgence();
        $_SESSION['agence_bp'] = $agence->getBoitePostaleAgence();
        $_SESSION['agence_ri'] = $agence->getRegimeImpositionAgence();
        $_SESSION['agence_df'] = $agence->getDivisionFiscaleAgence();
        $_SESSION['agence_df'] = $agence->getDivisionFiscaleAgence();
        echo $_SESSION['agence_nom'];

    }
    public function updateAgence($id)
    {
        $agence = $this->agenceManager->getAgenceById($id);
        require 'views/agence/update.php';
    }

    public function updateSaveAgence()
    {
        $data = array(
            'nom'=> $this->fieldValidation($_POST['nom']),
            'contact'=> $this->fieldValidation($_POST['contact']),
            'adresse'=> $this->fieldValidation($_POST['adresse']),
            'email'=> $this->fieldValidation($_POST['email']),
            'bp'=> $this->fieldValidation($_POST['bp']),
            'df'=> $this->fieldValidation($_POST['df']),
            'ri'=> $this->fieldValidation($_POST['ri']),
            'ifu'=> $this->fieldValidation($_POST['ifu']),
            'rccm'=> $this->fieldValidation($_POST['rccm']),
            'statut'=> $this->fieldValidation($_POST['statut']),
            'id'=>$this->fieldValidation($_POST['id']),
            'mod'=>date("Y-m-d")
        );

        $audit = array(
            'desc'=>"Modification de l'agence ".$data['nom']." adresse ".$data['adresse']." contact ".$data['contact'],
            'action'=>'Modification',
            'creat'=>date("Y-m-d"),
            'user'=>$_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->agenceManager->updateAgenceBD($data);
    }

    public function deleteSaveAgence($id)
    {
        $agence =  $this->agenceManager->getAgenceById($id);
        $audit = array(
        'desc'=>"ajout de l'agence ".$agence->getNomAgence()." adresse ".$agence->getAdresseAgence()." contact ".$agence->getContactAgence(),
        'action'=>'Suppression',
        'creat'=>date("Y-m-d"),
        'user'=>$_SESSION['id'],
    );
        $this->auditManager->addAuditBd($audit);
        $this->agenceManager->deleteAgenceBD($id);

        header('location: '.URL.'agence');

    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

}