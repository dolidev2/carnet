<?php
date_default_timezone_set("Africa/Ouagadougou");
session_start();
define("URL",str_replace("index.php","",
    (isset($_SERVER['HTTPS'])? "https": "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
require_once "controllers/clientController.php";
require_once "controllers/commandeController.php";
require_once "controllers/paiementController.php";
require_once "controllers/mesureController.php";
require_once "controllers/tissuController.php";
require_once "controllers/statistiqueController.php";
require_once "controllers/modeleController.php";
require_once "controllers/agenceController.php";
require_once "controllers/ressourceController.php";
require_once "controllers/personnelController.php";
require_once "controllers/programmeController.php";
require_once "controllers/chargeController.php";
require_once "controllers/caisseController.php";
require_once "controllers/userController.php";
require_once "controllers/stockController.php";
require_once "controllers/printController.php";
require_once "models/audit/auditManager.php";


$clientController = new clientController();
$commandeController = new commandeController();
$paieController = new paiementController();
$mesureController = new mesureController();
$tissuController = new tissuController();
$statController = new statistiqueController();
$modeleController = new modeleController();
$agenceController = new agenceController();
$ressourceController = new ressourceController();
$personnelController = new personnelController();
$pogrammeController = new programmeController();
$chargeController = new chargeController();
$caisseController = new caisseController();
$userController = new userController();
$stockController = new stockController();
$printController = new printController();

try {
        if (empty($_GET['page'])){
            require "views/user/login.php";
        }
        else{
                $url = explode("/",filter_var($_GET['page']),FILTER_SANITIZE_URL);
                try {
                    switch ($url[0]){
                        case 'accueil' : $statController->displayHome();
                            break;
                        case 'time' : require "views/partials/timeline.php";
                            break;

                        case 'chart' : $clientController->chart();
                            break;
                            
                        case 'unlogin' : $userController->unloginUser();
                        break;

                        case 'client' :
                            if (empty($url[1])){
                                $clientController->displayClient();
                            }else{
                                switch ($url[1]){
                                    case 'ajouter':  $clientController->addClient();
                                        break;
                                    case 'av':  $clientController->addSaveClient();
                                    break;
                                    case 'modifier':  $clientController->updateClient($url[2]);
                                        break;
                                    case 'mv':  $clientController->updateSaveClient();
                                        break;
                                    case 'sv':  $clientController->deleteClient($url[2]);
                                        break;
                                    //les routes de info client
                                    case 'info':
                                        if(empty($url[3])){
                                            $clientController->detailClient($url[2]);
                                        }else{
                                            switch ($url[3]){
                                                //Mesure Client
                                                case 'mesure_ajouter': $mesureController->addMesure($url[2]);
                                                    break;
                                                case 'mesure': $mesureController->displayMesure($url[4]);
                                                    break;
                                                case 'mesure_av': $mesureController->addSaveMesure();
                                                    break;
                                                case 'mesure_modifier': $mesureController->updateMesure($url[4]);
                                                    break;
                                                case 'mesure_mv': $mesureController->updateSaveMesure($url[4]);
                                                    break;
                                                case 'mesure_sv': $mesureController->deleteMesure($url[4]);
                                                    break;
                                                case 'mesure_pdf': $mesureController->mesurePdf($url[4]);
                                                    break;
                                                //End Mesure Client
                                                //Tissu Client
                                                case 'tissu_ajouter': $tissuController->addTissu($url[2]);
                                                    break;
                                                case 'tissu': $tissuController->displayTissu($url[4]);
                                                    break;
                                                case 'tissu_av': $tissuController->addSaveTissu();
                                                    break;
                                                case 'tissu_modifier': $tissuController->updateTissu($url[4]);
                                                    break;
                                                case 'tissu_mv': $tissuController->updateSaveTissu($url[4]);
                                                    break;
                                                case 'tissu_sv': $tissuController->deleteTissu($url[4]);
                                                    break;

                                                //End Tissu Client
                                                //Commande Client
                                                case 'commande_ajouter': $commandeController->addCommande($url[2]);
                                                    break;
                                                case 'commande_affecter': $commandeController->affectCommande($url[4]);
                                                    break;
                                                case 'commande': $commandeController->displayCommande($url[4]);
                                                    break;
                                                case 'commande_av': $commandeController->addSaveCommande();
                                                    break;
                                                case 'commande_avc': $commandeController->addSaveProgramme($url[2]);
                                                    break;
                                                case 'commande_avca': $commandeController->addSaveProgramme($url[2]);
                                                    break;
                                                case 'commande_modifier': $commandeController->updateCommande($url[4]);
                                                    break;
                                                case 'commande_mv': $commandeController->updateSaveCommande($url[4]);
                                                    break;
                                                case 'commande_mvc': $commandeController->updateSaveProgramme($url[4]);
                                                    break;
                                                case 'commande_sv': $commandeController->deleteCommande($url[4]);
                                                    break;
                                                case 'commande_svd': $commandeController->deleteProgramme($url[2],$url[4],$url[5]);
                                                    break;
                                                case 'facture' : $commandeController->pdf($url[4]);
                                                    break;

                                                case 'facture_article' : $commandeController->facture_article($url[4]);
                                                    break;

                                                case 'commande_composition' : $commandeController->commande_compo_pdf($url[4]);
                                                    break;

                                                case 'commande_report' : $commandeController->commande_report_pdf($url[4]);
                                                    break;

                                                    case 'commande_satisfaction' : $commandeController->commande_satisfaction_pdf($url[4]);
                                                    break;
                                                //End Commande Client
                                                //Paiement Client
                                                case 'paiement_ajouter': $paieController->addPaie($url[4]);
                                                    break;
                                                case 'paiement': $paieController->displayPaiesCommande($url[4]);
                                                    break;
                                                case 'paiement_av': $paieController->addSavePaie();
                                                    break;
                                                case 'paiement_modifier': $paieController->updatePaie($url[4]);
                                                    break;
                                                case 'paiement_mv': $paieController->updateSavePaie($url[4]);
                                                    break;
                                                case 'paiement_sv': $paieController->deletePaie($url[4]);
                                                    break;
                                                case 'recu' : $paieController->recuPaie($url[4]);
                                                    break;
                                                //End Paiement Client

                                                //Statistique Client
                                                case 'statistique':  $statController->statistiqueClient($url[2],$url[4]);
                                                    break;

                                                case 'statistique_frequence':  $statController->frequenceCouture($url[2]);
                                                    break;

                                                case 'statistique_frequence_annee':  $statController->frequenceCoutureAnnee($url[2]);
                                                    break;

                                                case 'statistique_recette':  $statController->profitCouture($url[2]);
                                                    break;

                                                case 'statistique_recette_annee':  $statController->profitCoutureAnne($url[2]);
                                                    break;

                                                case 'statistique_modele':  $statController->modele($url[2]);
                                                    break;

                                                case 'statistique_modele_annee':  $statController->modeleAnnee($url[2]);
                                                    break;

                                                //Statistique Client frequenceCoutureAnnee

                                                //Recommandation
                                                case 'recommandation':  $clientController->recommandation($url[2]);
                                                    break;

                                                //End recommandation
                                            }
                                        }
                                        break;

                                    case 'mesure':  $clientController->addClient();
                                        break;

                                    case 'commande':  $clientController->ajouterCommandeClient();
                                        break;

                                    case 'detail':  $commandeController->programCommande();
                                        break;
                                }
                            }
                            break;
                        case 'modele' :
                            if (empty($url[1])){
                                $modeleController->displayModele();
                            }else{
                                switch ($url[1]){
                                    case 'ajouter' : $modeleController->addModele();
                                        break;

                                    case 'av' : $modeleController->addSaveModele();
                                        break;

                                    case 'modifier' : $modeleController->updateModele($url[2]);
                                        break;

                                    case 'mv' : $modeleController->updateSaveModele($url[2]);
                                        break;

                                    case 'detail' : $modeleController->detailModele($url[2]);
                                        break;

                                    case 'sv' : $modeleController->deleteSaveModele($url[2]);
                                        break;

                                    case 'sid' : $modeleController->displayPrixModele($url[2]);
                                        break;
                                }
                            }
                            break;
                        case 'agence' :
                            if (empty($url[1])){
                                $agenceController->displayAgence();
                            }else{
                                switch ($url[1]){
                                    case 'ajouter' : $agenceController->addAgence();
                                        break;

                                    case 'av' : $agenceController->addSaveAgence();
                                        break;

                                    case 'modifier' : $agenceController->updateAgence($url[2]);
                                        break;

                                    case 'mv' : $agenceController->updateSaveAgence();
                                        break;

                                    case 'agence_session' : $agenceController->updateAgenceSession();
                                        break;

                                    case 'sv' : $agenceController->deleteSaveAgence($url[2]);
                                        break;
                                }
                            }
                            break;
                        case 'ressource' :
                            if (empty($url[1])){
                                $ressourceController->displayRessource();
                            }else{
                                switch ($url[1]){
                                    case 'ajouter' : $ressourceController->addRessource();
                                        break;

                                    case 'av' : $ressourceController->addSaveRessource();
                                        break;

                                    case 'modifier' : $ressourceController->updateRessource($url[2]);
                                        break;

                                    case 'mv' : $ressourceController->updateSaveRessource($url[2]);
                                        break;

                                    case 'detail' : $ressourceController->detailRessource($url[2]);
                                        break;

                                    case 'sv' : $ressourceController->deleteSaveRessource($url[2]);
                                        break;

                                    case 'af' : $ressourceController->affectRessource();
                                        break;
                                    case 'mf' : $ressourceController->updateAffectRessource($url[2]);
                                        break;
                                    case 'sf' : $ressourceController->deleteAffectRessource($url[2]);
                                        break;
                                }
                            }
                            break;

                        case 'personnel' :
                            if (empty($url[1])){
                                $personnelController->displayPersonnel();
                            }else{
                                switch ($url[1]){
                                    case 'ajouter' : $personnelController->addPersonnel();
                                        break;

                                    case 'av' : $personnelController->addSavePersonnel();
                                        break;

                                    case 'periode' : $personnelController->periodePersonnel($url[2]);
                                        break;

                                    case 'modifier' : $personnelController->updatePersonnel($url[2]);
                                        break;

                                    case 'mv' : $personnelController->updateSavePersonnel($url[2]);
                                        break;

                                    case 'statistique' : $personnelController->StatPersonnel($url[2]);
                                        break;

                                    case 'statistque_annee' : $personnelController->StatPersonnelAnnee($url[2]);
                                        break;

                                    case 'pdf' : $personnelController->paiementPdf($url[2],$url[3],$url[4],$url[5]);
                                        break;

                                    case 'detail' : $personnelController->detailPersonnel($url[2]);
                                        break;

                                    case 'charge' : $chargeController->addCharge($url[2]);
                                        break;

                                    case 'sv' : $personnelController->deleteSavePersonnel($url[2]);
                                        break;

                                    //Affecter Ressource
                                    case 'af' : $personnelController->affectPersonnel();
                                        break;
                                    case 'mf' : $personnelController->updateAffectPersonnel($url[2]);
                                        break;
                                    case 'sf' : $personnelController->deleteAffectPersonnel($url[2]);
                                        break;
                                    case 'programme' : $personnelController->programmePersonnelPdf($url[2]);
                                        break;
                                    //End Affecter Ressource

                                    //Paiement

                                    case 'paiement' : $personnelController->displayPaiement($url[2]);
                                        break;

                                    case 'pav' : $personnelController->addPaiementPers($url[2]);
                                        break;
                                    case 'psv' : $personnelController->deleteSavePersonnelPaiement($url[2]);
                                        break;
                                    //End Paiement

                                    //Capacite de production
                                    case 'production' : $personnelController->displayModelePersonnel($url[2]);
                                        break;

                                    case 'ajouter_production' : $personnelController->addModelePersonnel($url[2]);
                                        break;

                                    case 'modifier_production' : $personnelController->updateSaveProduction($url[2]);
                                        break;

                                    case 'supprimer_production' : $personnelController->deleteSaveProduction($url[2]);
                                        break;

                                    case 'avam' : $personnelController->addSaveModelePersonnel($url[2]);
                                        break;

                                    case 'mavm' : $personnelController->updateSaveModelePersonnel($url[2]);
                                        break;

                                    case 'svm' : $personnelController->deleteSaveModelePersonnel($url[2]);
                                        break;

                                    case 'imprimer' : $personnelController->printModelePersonnel($url[2]);
                                        break;
                                    //End Capacite de production
                                    //Avance
                                    case 'avance' : $personnelController->displayAvancePersonnel($url[2]);
                                        break;

                                    case 'ava' : $personnelController->addAvanceSavePersonnel($url[2]);
                                        break;

                                    case 'sava' : $personnelController->deleteAvanceSavePersonnel($url[2]);
                                        break;
                                    //Avance
                                }
                            }
                            break;
                        case 'commande' :
                            if (empty($url[1])){
                                $pogrammeController->displayProgramme();
                            }else{
                                switch ($url[1]){
                                    case 'cloturer' : $pogrammeController->closeArticle($url[2]);
                                        break;

                                    case 'av' : $pogrammeController->addSaveProgramme();
                                        break;

                                    case 'ava' : $pogrammeController->addSaveProgrammeOne();
                                        break;

                                    case 'mv' : $pogrammeController->updateProgramme();
                                        break;

                                    case 'sv' : $pogrammeController->deleteProgramme($url[2]);
                                        break;

                                    case 'reporter' : $pogrammeController->addSaveReportProgramme($url[2]);
                                        break;

                                    case 'periode' : $pogrammeController->displayPeriodeProgramme();
                                        break;
                                }
                            }
                            break;
                        case 'charge' :
                            if (empty($url[1])){
                                $personnelController->displayPersonnel();
                            }else{
                                switch ($url[1]){

                                    case 'av' : $chargeController->addSaveCharge($url[2]);
                                        break;

                                    case 'modifier' : $chargeController->updateCharge($url[2]);
                                        break;

                                    case 'mv' : $chargeController->updateSaveCharge($url[2]);
                                        break;

                                    case 'sv' : $chargeController->deleteSaveCharge($url[2]);
                                        break;
                                }
                            }
                            break;
                        case 'caisse' :
                            if (empty($url[1])){
                                $caisseController->displayCaisse();
                            }else{
                                switch ($url[1]){

                                    case 'av' : $caisseController->addSaveCaisse();
                                        break;

                                    case 'update' : $caisseController->updateCaisse($url[2]);
                                        break;

                                    case 'mv' : $caisseController->updateSaveCaisse();
                                        break;

                                    case 'sv' : $caisseController->deleteSaveCaisse($url[2]);
                                        break;

                                    case 'periode' : $caisseController->periodeCaisse();
                                        break;

                                    case 'periode_av' : $caisseController->displayPeriodeCaisse();
                                        break;
                                }
                            }
                            break;
                        case 'utilisateur' :
                            if (empty($url[1])){
                                $userController->displayUser();
                            }else{
                                switch ($url[1]){

                                    case 'ajouter' : $userController->addUser();
                                        break;

                                    case 'login' : $userController->loginUser();
                                        break;

                                    case 'av' : $userController->addSaveUser();
                                        break;

                                    case 'unlogin' : $userController->unloginUser();
                                        break;

                                    case 'modifier' : $userController->updateUser($url[2]);
                                        break;

                                    case 'mv' : $userController->updateSaveUser();
                                        break;

                                    case 'sv' : $userController->deleteSaveUser($url[2]);
                                        break;

                                    case 'detail' : $userController->displayDetailUser($url[2]);
                                        break;

                                    case 'info' : $userController->displayDetail($url[2]);
                                        break;

                                    case 'unloged' : $userController->unloged();
                                        break;
                                }
                            }
                            break;

                        case 'stock' :
                            if (empty($url[1])){
                                $stockController->displayStock();
                            }else{
                                switch ($url[1]){

                                    case 'av' : $stockController->addSaveStock();
                                        break;

                                    case 'mv' : $stockController->updateSaveStock();
                                        break;

                                    case 'sv' : $stockController->deleteSaveStock($url[2]);
                                        break;

                                    case 'periode' : $stockController->periodeStock();
                                        break;

                                    case 'periode_av' : $stockController->periodeAvStock();
                                        break;

                                    case 'ressource' : $stockController->ressourcePeriodeStock();
                                        break;
                                }
                            }
                            break;
                        case 'modele' :
                            if (empty($url[1])){
                                $modeleController->displayModele();
                            }else{
                                  switch ($url[1]){

                                    case 'ajouter' : $modeleController->addModele();
                                        break;

                                    case 'av' : $modeleController->addSaveModele();
                                        break;

                                    case 'modifier' : $modeleController->updateModele($url[2]);
                                        break;

                                    case 'mv' : $modeleController->updateSaveModele($url[2]);
                                        break;

                                    case 'sv' : $modeleController->deleteSaveModele($url[2]);
                                        break;

                                    case 'detail' : $modeleController->detailModele($url[2]);
                                        break;
                                }
                            }
                            break;
                        case 'impression':
                            if (empty($url[1])){
                                $printController->displayHome();
                            }else{
                                switch ($url[1]){

                                    case 'chiffreAffairePeriode' : $printController->printChiffreAffairePeriode();
                                        break;

                                    case 'chiffreAffairePeriodeClient' : $printController->chiffreAffaireClient();
                                        break;

                                    case 'classementPeriodeClient' : $printController->classementPeriodClient();
                                        break;

                                    case 'classementPeriodModele' : $printController->classementModeleByAgencePeriod();
                                        break;

                                    case 'classementPeriodPersonnel' : $printController->classementPeriodPersonnel();
                                        break;

                                    case 'classementPeriodClient' : $printController->classementPeriodClient();
                                        break;

                                    case 'classementPeriodClientTissu' : $printController->classementPeriodClientTissu();
                                        break;

                                    case 'caissePeriod' : $printController->caissePeriod();
                                        break;

                                    case 'rdvPeriod' : $printController->rdvPeriod();
                                        break;

                                    case 'rdvReportePeriod' : $printController->rdvReportePeriod();
                                        break;
                                    case 'listStockRessource' : $printController->listStockRessource();
                                        break;

                                    case 'commandeClientPeriod' : $printController->commandeClientPeriod();
                                        break;

                                    case 'listClientPeriodAgence' : $printController->listClientPeriodAgence();
                                        break;

                                    case 'detail' : $modeleController->detailModele($url[2]);
                                        break;
                                }
                            }
                            break;
                    }
                } catch (Exception $e){
                    echo  $e->getMessage();
                }
    }

} catch (Exception $e){
    echo $e->getMessage();
}

?>