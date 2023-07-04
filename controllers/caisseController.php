<?php

require_once 'models/caisse/caisseManager.php';
require_once 'models/caisse/caisseManager.php';
require_once 'models/audit/auditManager.php';
require_once 'models/config/config.php';

class caisseController
{
    private $caisseManager;
    private $auditManager;
    private $config;

    public function __construct()
    {
        $this->caisseManager = new caisseManager();
        $this->caisseManager->loadCaisse();

        $this->auditManager = new auditManager();

        $this->config = new configData();
    }

    public function displayCaisse()
    {
        $caisses = $this->caisseManager->getCaisses();
        if (!empty($caisses)) {
            $somme_entre = $this->config->inactif;
            $somme_sorti = $this->config->inactif;
            $data_entre = [];
            $data_sortie = [];
            $date_debut = DateTime::createFromFormat('Y-m-d', date("Y") . '-01-01')->format('Y-m-d');
            $date_fin = DateTime::createFromFormat('Y-m-d', date("Y") . '-12-31')->format('Y-m-d');
            foreach ($caisses as $caisse) {
                if (($caisse->getCreatCaisse() >= $date_debut) && ($caisse->getCreatCaisse() <= $date_fin)) {
                    if ($caisse->getTypeCaisse() == 'entre') {
                        $somme_entre += $caisse->getSommeCaisse();
                        array_push($data_entre, $caisse);
                    } else {
                        $somme_sorti += $caisse->getSommeCaisse();
                        array_push($data_sortie, $caisse);
                    }
                }
            }
        }
        require 'views/caisse/home.php';
    }

    public function addSaveCaisse()
    {
        $data = array(
            'somme' => $this->fieldValidation($_POST['somme']),
            'desc' => $this->fieldValidation($_POST['desc']),
            'type' => $this->fieldValidation($_POST['type']),
            'creat' => date("Y-m-d"),
            'mod' => date("Y-m-d"),
            'user' => $_SESSION['id'],
            'agence' => $_SESSION['agence'],
            'paiement' => $this->config->inactif,
            'personnel' => $this->config->inactif,
            'tissu' => $this->config->inactif,
            'charge' => $this->config->inactif,
        );
        $audit = array(
            'desc' => $data['desc'] . " dont le montant est " . $data['somme'],
            'action' => 'Ajout',
            'creat' => date("Y-m-d"),
            'user' => $_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->caisseManager->addCaisseBd($data);
    }

    public function updateCaisse($id_caisse)
    {
        $caisse = $this->caisseManager->getCaisseById($id_caisse);
        require "views/caisse/update.php";
    }

    public function updateSaveCaisse()
    {
        $data = array(
            'date' => $this->fieldValidation($_POST['date_caisse']),
            'somme' => $this->fieldValidation($_POST['somme']),
            'desc' => $this->fieldValidation($_POST['desc']),
            'type' => $this->fieldValidation($_POST['type']),
            'mod' => date("Y-m-d"),
            'id' => $this->fieldValidation($_POST['id']),
        );

        $this->caisseManager->updateCaisseBD($data);
        $audit = array(
            'desc' => $data['desc'] . " dont le montant est " . $data['somme'],
            'action' => 'Modification',
            'creat' => date("Y-m-d"),
            'user' => $_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function deleteSaveCaisse($id)
    {
        $caisse = $this->caisseManager->getCaisseById($id);
        $audit = array(
            'desc' => "Suppression de la ligne de caisse " . $caisse->getDescCaisse() . " dont le montant est " . $caisse->getSommeCaisse(),
            'action' => 'Suppression',
            'creat' => date("Y-m-d"),
            'user' => $_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->caisseManager->deleteCaisseBD($id);
        header('location: ' . URL . 'caisse');
    }

    public function periodeCaisse()
    {
        require "views/caisse/home_periode.php";
    }

    public function displayPeriodeCaisse()
    {
        $somme_entre = $this->config->inactif;
        $somme_sorti = $this->config->inactif;
        $debut = $this->fieldValidation($_POST['dt_debut']);
        $fin = $this->fieldValidation($_POST['dt_fin']);
        $caisses = $this->caisseManager->getCaissePeriode($debut, $fin);

        $entres = [];
        $sorties = [];
        if (!empty($caisses)) {
            foreach ($caisses as $caisse) {
                if ($caisse['type_caisse'] == 'entre') {
                    $somme_entre += $caisse['somme_caisse'];
                    array_push($entres, $caisse);
                }
                if ($caisse['type_caisse'] == 'sortie') {
                    $somme_sorti += $caisse['somme_caisse'];
                    array_push($sorties, $caisse);
                }
            }
        }

        require 'views/caisse/home_periode.php';
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

}