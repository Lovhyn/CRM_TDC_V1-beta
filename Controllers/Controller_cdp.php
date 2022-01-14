<?php
    session_start();
    if ($_SESSION['rights'] === '3') {
/*
        Charge automatiquement toutes les classes du dossier Models.
*/
        spl_autoload_register(function ($classe) {
            include "../Models/" . $classe . ".class.php";
        });
/*
        Enregistre dans une variable la valeur passée en "GET" de l'action      
        appelée par l'utilisateur.
*/ 
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
//  ----------------------------Switch $action---------------------------------
        switch ($action) {
            case 'home' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/home_cdp.view.php");
                require("../Views/Footer/footer.view.php");
                break;
//          *********************************** Management PRO ************************************
            case 'addNewProspectForm' : 
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/add_new_prospect.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'addedNewProspect' :
                // var_dump($_POST);
                $followedBy = (int) $_SESSION['idUser'];       
                $newProspectName = $_POST['newProspectName'];
                $newProspectDecisionMakerName = $_POST['newDecisionMakerName'];
                if ($_POST['newActivityArea'] === '0') {
                    $newProspectActivityArea = '';
                } else {
                    $newProspectActivityArea = $_POST['newActivityArea'];
                }
                $newProspectMail = $_POST['newProspectMail'];
                $newProspectMainPhone = $_POST['newProspectMainPhone'];
                $newProspectSecondaryPhone = $_POST['newProspectSecondaryPhone'];
                $newProspectMainAdress = $_POST['newProspectMainAdress'];
                $newProspectSecondaryAdress = $_POST['newProspectSecondaryAdress'];
                $newProspectCP = $_POST['newProspectCP'];
                $newProspectCity = $_POST['newProspectCity'];
                $newProspectObservation = $_POST['newProspectObservation'];
                $newContactInterlocutor = $_POST['newContactInterlocutor'];
                $newContactType = $_POST['newContactType'];
                $newContactConclusion = $_POST['newContactConclusion'];
                $newContactComment = $_POST['newContactComment'];
                $msg = '';
//              Avant l'ajout, on contrôle qu'aucun professionnel n'a un un nom semblable.
                if (Pro_Mgr::checkIfExists($newProspectName) === 0) {
//                  Récupère la prochaine valeur de l'auto-increment avant l'insert.
                    $resultBefore = Pro_Mgr::getLastAutoIncrementValue();
//                  Convertit le résultat en entier.
                    $lastValueBefore = (int) $resultBefore[0]["AUTO_INCREMENT"];
                    Pro_Mgr::createNewPro($followedBy, $newProspectActivityArea, $newProspectName, 
                                        $newProspectDecisionMakerName, $newProspectMainPhone, 
                                        $newProspectSecondaryPhone, $newProspectMail, 
                                        $newProspectMainAdress, $newProspectSecondaryAdress, 
                                        $newProspectCP, $newProspectCity, $newProspectObservation);
//                  Récupère la prochaine valeur de l'auto-increment après l'insert.
                    $resultAfter = Pro_Mgr::getLastAutoIncrementValue();
//                  Convertit le résultat en entier.
                    $lastValueAfter = (int) $resultAfter[0]["AUTO_INCREMENT"];
/*
                    Contrôle que l'insert du professionnel a correctement été effectué
                    avant d'insérer un suivi dans la base de données.
*/               
                    if ($lastValueAfter === ($lastValueBefore + 1)) {
                        $firstContactDate = Dates_Mgr::nowToUnixString();
//                      A la création d'un nouveau suivi, les date de début de suivi et de dernier contact sont identiques.
                        $lastContactDate = $firstContactDate;
//                      Si l'utilisateur a validé une date depuis le calendrier rdv, on enregistre une date de rdv. 
                        if ((isset($_POST['meetingCalendar'])) AND ($newContactConclusion === '5')) {
                            $meetingDate = Dates_Mgr::paramToUnixString($_POST['meetingCalendar']);
                            Contacting_Mgr::createNewContactMeeting($followedBy, $lastValueBefore, $newContactInterlocutor,
                                                                $newContactType, $newContactConclusion, $newContactComment,
                                                                $firstContactDate, $lastContactDate, $meetingDate);
                        } else {
                            if ((isset($_POST['recallCalendar'])) AND ($newContactConclusion === '7')) {
                                $meetingDate = Dates_Mgr::paramToUnixString($_POST['recallCalendar']);
//                          Sinon, on automatise l'enregistrement d'une date de relance suivant la conclusion sélectionnée. 
                            } elseif (($newContactConclusion === '1') OR ($newContactConclusion === '4') OR ($newContactConclusion === '8')) {
                                $recallDate = (string) strtotime('+3 days', time());
                            } elseif ($newContactConclusion === '2') {
                                $recallDate = (string) strtotime('+5 months', time());
                            } elseif ($newContactConclusion === '3') {
                                $recallDate = (string) strtotime('+5 days', time());
                            } elseif ($newContactConclusion === '6') {
                                $recallDate = (string) strtotime('+8 days', time());
                            } 
                            Contacting_Mgr::createNewContactRecall($followedBy, $lastValueBefore, $newContactInterlocutor,
                                                                $newContactType, $newContactConclusion, $newContactComment,
                                                                $firstContactDate, $lastContactDate, $recallDate);
                        }  
                    }
                    $msg = '<div class="text-center" style="color: #46ec4e">Nouveau suivi enregistré.</div>';
                    require("../Views/Header/header_cdp.view.php");  
                    echo($msg);
                    require("../Views/Body/my_prospects_listing.view.php");
                    require("../Views/Footer/footer.view.php"); 
                } else {
                    $msg = '<div class="text-center" style="color: #E84E0E">Erreur : un professionnel portant le même nom a déjà été enregistré.</div>';
                    require("../Views/Header/header_cdp.view.php");
                    echo($msg);
                    require("../Views/Body/my_prospects_listing.view.php");
                    require("../Views/Footer/footer.view.php");
                }
                break;
            case 'myProspectsListing' : 
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/my_prospects_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break; 
            case 'fullInfosPro' : 
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/full_infos_pro.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'updatePro' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/update_pro.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'updatedPro' :
                $proToUpdate = (int) $_POST['currentProId'];
                $newProName = $_POST['majProName'];
                $newDecisionMakerName = $_POST['majDecisionMakerName'];
                $newMainPhone = $_POST['majProPhone'];
                $newSecondaryPhone = $_POST['majProPhone2'];
                $newMail = $_POST['majProMail'];
                $newMainAdress = $_POST['majProAdress'];
                $newSecondaryAdress = $_POST['majProAdress2'];
                $newCp = $_POST['majProCp'];
                $newCity = $_POST['majProCity'];
                $newObservation = $_POST['majProObservation'];
/*              
                ATTENTION  : 
                Un chargé de projet ne pouvant modifier l'utilisateur en charge d'un professionnel, 
                nous passerons par défaut l'identifiant de l'utilisateur connecté en argument à la fonction. 
*/
                $followedBy = (int) $_SESSION['idUser'];
                Pro_Mgr::updateProspect($newProName, $newDecisionMakerName, $newMainPhone, 
                                        $newSecondaryPhone, $newMail, $newMainAdress, 
                                        $newSecondaryAdress, $newCp, $newCity, $newObservation,
                                        $proToUpdate, $followedBy);
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/my_prospects_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myProspectActivity':
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/my_prospect_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myClientsListing' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/my_clients_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myClientActivity' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/my_client_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myContactRecalls' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/my_contact_recalls.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myMeetingRecalls' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/my_meeting_recalls.view.php");
                require("../Views/Footer/footer.view.php");
                break;
        }
    } else header('Location: ../index.php');
?>