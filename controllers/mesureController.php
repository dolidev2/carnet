<?php

require_once "models/client/clientManager.php";
require_once "models/client/mesure/mesureClientManager.php";
require_once "models/client/mesure/mesureClientOldManager.php";
require_once "models/audit/auditManager.php";
require_once "models/user/userManager.php";
require_once "models/agence/agenceManager.php";

class mesureController
{
    private $clientManager;
    private $mesureManager;
    private $auditManager;
    private $userManager;
    private $agenceManager;
    private $mesOldManager;

    public function __construct()
    {
        $this->mesOldManager = new mesureClientOldManager();
        $this->mesOldManager->loadMesure();

        $this->clientManager = new clientManager();
        $this->clientManager->loadClient();

        $this->mesureManager = new mesureClientManager();
        $this->mesureManager->loadMesure();

        $this->userManager = new userManager();
        $this->userManager->loadUser();

        $this->agenceManager = new agenceManager();
        $this->agenceManager->loadAgence();

        $this->auditManager = new auditManager();
    }

    public function addMesure($id)
    {

        $client = $this->clientManager->getClientById($id);
        require "views/client/mesure/add.php";
    }

    public function addSaveMesure()
    {
        $client = $this->clientManager->getClientById($_POST['client']);
        $data = array(
            'epaule' => $this->fieldValidation($_POST['epaule']),
            'l_epaule' => $this->fieldValidation($_POST['l_epaule']),
            'carrure' => $this->fieldValidation($_POST['carrure']),
            'poitrine' => $this->fieldValidation($_POST['poitrine']),
            'dos' => $this->fieldValidation($_POST['dos']),
            't_taille' => $this->fieldValidation($_POST['t_taille']),
            'ceinture' => $this->fieldValidation($_POST['ceinture']),
            'bassin' => $this->fieldValidation($_POST['bassin']),
            'cuisse' => $this->fieldValidation($_POST['cuisse']),
            't_genou' => $this->fieldValidation($_POST['t_genou']),
            'bas' => $this->fieldValidation($_POST['bas']),

            'cole' => $this->fieldValidation($_POST['cole']),
            't_manche' => $this->fieldValidation($_POST['t_manche']),
            'poignet' => $this->fieldValidation($_POST['poignet']),
            'l_manche' => $this->fieldValidation($_POST['l_manche']),
            'l_taille' => $this->fieldValidation($_POST['l_taille']),
            'l_chemise' => $this->fieldValidation($_POST['l_chemise']),
            'l_chemise_a' => $this->fieldValidation($_POST['l_chemise_a']),
            'l_gilet' => $this->fieldValidation($_POST['l_gilet']),
            'l_veste' => $this->fieldValidation($_POST['l_veste']),
            'l_genou' => $this->fieldValidation($_POST['l_genou']),

            'e_p_poitrine' => $this->fieldValidation($_POST['e_p_poitrine']),
            'l_jupe' => $this->fieldValidation($_POST['l_jupe']),
            'l_robe' => $this->fieldValidation($_POST['l_robe']),
            'l_poitrine' => $this->fieldValidation($_POST['l_poitrine']),
            'l_haut' => $this->fieldValidation($_POST['l_haut']),

            'l_pantalon' => $this->fieldValidation($_POST['l_pantalon']),
            'pantacourt' => $this->fieldValidation($_POST['pantacourt']),
            'frappe' => $this->fieldValidation($_POST['frappe']),
            'e_jambe' => $this->fieldValidation($_POST['e_jambe']),
            'creat' => date("Y-m-d"),
            'mod' => date("Y-m-d"),
            'sexe' => $this->fieldValidation($_POST['sexe']),
            't_tete' => $this->fieldValidation($_POST['t_tete']),
            'client' => $client->getIdClient()
        );
        $this->mesureManager->addMesureBD($data);
        $audit = array(
            'desc' => "Ajout des mesures du client: " . $client->getNomClient() . ' ' . $client->getPrenomClient() . ' ' . $client->getContactClient(),
            'action' => 'Ajout',
            'creat' => date("Y-m-d"),
            'user' => $_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function updateMesure($id)
    {
        $mesure = $this->mesureManager->getMesureById($id);
        $client = $this->clientManager->getClientById($mesure->getClient());
        require "views/client/mesure/update.php";
    }

    public function updateSaveMesure($id)
    {
        $mesure = $this->mesureManager->getMesureById($id);
        $client = $this->clientManager->getClientById($mesure->getClient());
        $data = array(
            'epaule' => $mesure->getEpauleMesure(),
            'l_epaule' => $mesure->getLEpauleMesure(),
            'carrure' => $mesure->getCarrureMesure(),
            'poitrine' => $mesure->getPoitrineMesure(),
            'dos' => $mesure->getDosMesure(),
            't_taille' => $mesure->getLTailleMesure(),
            'ceinture' => $mesure->getCeintureMesure(),
            'bassin' => $mesure->getBassinMesure(),
            'cuisse' => $mesure->getCuisseMesure(),
            't_genou' => $mesure->getTGenouMesure(),
            'bas' => $mesure->getBasMesure(),

            'cole' => $mesure->getColeMesure(),
            't_manche' => $mesure->getTMancheMesure(),
            'poignet' => $mesure->getPoignetMesure(),
            'l_manche' => $mesure->getLMancheMesure(),
            'l_taille' => $mesure->getLTailleMesure(),
            'l_chemise' => $mesure->getLChemiseMesure(),
            'l_chemise_a' => $mesure->getLChemiseAMesure(),
            'l_gilet' => $mesure->getLGiletMesure(),
            'l_veste' => $mesure->getLVesteMesure(),
            'l_genou' => $mesure->getLGenouMesure(),

            'e_p_poitrine' => $mesure->getEPPoitrineMesure(),
            'l_jupe' => $mesure->getLJupeMesure(),
            'l_robe' => $mesure->getLRobeMesure(),
            'l_poitrine' => $mesure->getLPoitrineMesure(),
            'l_haut' => $mesure->getLHautMesure(),

            'l_pantalon' => $mesure->getLPantalonMesure(),
            'pantacourt' => $mesure->getPantacourtMesure(),
            'frappe' => $mesure->getFrappeMesure(),
            'e_jambe' => $mesure->getEJambeMesure(),
            'creat' => date("Y-m-d"),
            'mod' => date("Y-m-d"),
            'sexe' => $mesure->getSexeMesure(),
            't_tete' => $mesure->getTTeteMesure(),
            'mesure' => $mesure->getIdMesure(),
        );
        $this->mesOldManager->addMesureBD($data);

        $data = array(
            'id' => $id,
            'epaule' => $this->fieldValidation($_POST['epaule']),
            'l_epaule' => $this->fieldValidation($_POST['l_epaule']),
            'carrure' => $this->fieldValidation($_POST['carrure']),
            'poitrine' => $this->fieldValidation($_POST['poitrine']),
            'dos' => $this->fieldValidation($_POST['dos']),
            't_taille' => $this->fieldValidation($_POST['t_taille']),
            'ceinture' => $this->fieldValidation($_POST['ceinture']),
            'bassin' => $this->fieldValidation($_POST['bassin']),
            'cuisse' => $this->fieldValidation($_POST['cuisse']),
            't_genou' => $this->fieldValidation($_POST['t_genou']),
            'bas' => $this->fieldValidation($_POST['bas']),

            'cole' => $this->fieldValidation($_POST['cole']),
            't_manche' => $this->fieldValidation($_POST['t_manche']),
            'poignet' => $this->fieldValidation($_POST['poignet']),
            'l_manche' => $this->fieldValidation($_POST['l_manche']),
            'l_taille' => $this->fieldValidation($_POST['l_taille']),
            'l_chemise' => $this->fieldValidation($_POST['l_chemise']),
            'l_chemise_a' => $this->fieldValidation($_POST['l_chemise_a']),
            'l_gilet' => $this->fieldValidation($_POST['l_gilet']),
            'l_veste' => $this->fieldValidation($_POST['l_veste']),
            'l_genou' => $this->fieldValidation($_POST['l_genou']),

            'e_p_poitrine' => $this->fieldValidation($_POST['e_p_poitrine']),
            'l_jupe' => $this->fieldValidation($_POST['l_jupe']),
            'l_robe' => $this->fieldValidation($_POST['l_robe']),
            'l_poitrine' => $this->fieldValidation($_POST['l_poitrine']),
            'l_haut' => $this->fieldValidation($_POST['l_haut']),

            'l_pantalon' => $this->fieldValidation($_POST['l_pantalon']),
            'pantacourt' => $this->fieldValidation($_POST['pantacourt']),
            'frappe' => $this->fieldValidation($_POST['frappe']),
            'e_jambe' => $this->fieldValidation($_POST['e_jambe']),
            'mod' => date("Y-m-d"),
            'sexe' => $this->fieldValidation($_POST['sexe']),
            't_tete' => $this->fieldValidation($_POST['t_tete']),
        );

        $this->mesureManager->updateMesureBd($data);

        $audit = array(
            'desc' => "Modification des mesures du client: " . $client->getNomClient() . ' ' . $client->getPrenomClient() . ' ' . $client->getContactClient(),
            'action' => 'Modification',
            'creat' => date("Y-m-d"),
            'user' => $_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
    }

    public function displayMesure($id)
    {
        $mesure = $this->mesureManager->getMesureById($id);
        $mesureolds = $this->mesOldManager->getMesuresMesure($mesure);
        $client = $this->clientManager->getClientById($mesure->getClient());
        require "views/client/mesure/detail.php";
    }

    public function mesurePdf($id)
    {
        $mesure = $this->mesureManager->getMesureById($id);
        $client = $this->clientManager->getClientById($mesure->getClient());

        $user = $this->userManager->getUserById($_SESSION['id']);
        $agence = $this->agenceManager->getAgenceById($_SESSION['agence']);

        require "views/client/mesure/mesure_pdf.php";
    }

    public function deleteMesure($id)
    {
        $mesure = $this->mesureManager->getMesureById($id);
        $client = $this->clientManager->getClientById($mesure->getClient());
        $audit = array(
            'desc' => "Modification des mesures du client: " . $client->getNomClient() . ' ' . $client->getPrenomClient() . ' ' . $client->getContactClient(),
            'action' => 'Modification',
            'creat' => date("Y-m-d"),
            'user' => $_SESSION['id'],
        );
        $this->auditManager->addAuditBd($audit);
        $this->mesureManager->deleteMesureBD($id);
        header('location: ' . URL . 'client/info/' . $mesure->getClient());
    }

    public function fieldValidation($param)
    {
        return htmlspecialchars(strip_tags($param));
    }

}