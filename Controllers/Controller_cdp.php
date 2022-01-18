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
                $followedBy = (int) $_SESSION['idUser'];       
                $newProspectName = $_POST['newProspectName'];
                $newProspectDecisionMakerName = $_POST['newDecisionMakerName'];
                $newProspectActivityArea = (int) $_POST['newActivityArea'];
                $newProspectMail = $_POST['newProspectMail'];
                $newProspectMainPhone = $_POST['newProspectMainPhone'];
                $newProspectSecondaryPhone = $_POST['newProspectSecondaryPhone'];
                $newProspectMainAdress = $_POST['newProspectMainAdress'];
                $newProspectSecondaryAdress = $_POST['newProspectSecondaryAdress'];
                $newProspectCP = $_POST['newProspectCP'];
                $newProspectCity = $_POST['newProspectCity'];
                $newProspectObservation = $_POST['newProspectObservation'];
                $newContactInterlocutor = (int) $_POST['newContactInterlocutor'];
                if ($newContactInterlocutor === 3) {
                    $newContactType = 3;
                } else {
                    $newContactType = (int) $_POST['newContactType'];
                }
                $newContactConclusion = (int) $_POST['newContactConclusion'];
                $newContactComment = $_POST['newContactComment'];
                if (isset($_POST['newContactInterlocutorName'])) {
                    $newContactInterlocutorName = $_POST['newContactInterlocutorName'];
                } else {
                    $newContactInterlocutorName = '';
                }
                if (isset($_POST['newContactInterlocutorInfoTel'])) {
                    $newContactInterlocutorContact = $_POST['newContactInterlocutorInfoTel'];
                } elseif (isset($_POST['newContactInterlocutorInfoMail'])) {
                    $newContactInterlocutorContact = $_POST['newContactInterlocutorInfoMail'];
                } else {
                    $newContactInterlocutorContact = '';
                }
                $msg = '';
//              Avant l'ajout, on contrôle qu'aucun professionnel n'a un nom semblable.
                if (Pro_Mgr::checkIfExists($newProspectName) === 0) {
                    try {
//                      Récupère la prochaine valeur de l'auto-increment avant l'insert.
                        $resultBefore = Pro_Mgr::getLastAutoIncrementValue();
//                      Convertit le résultat en entier.
                        $lastValueBefore = (int) $resultBefore[0]["AUTO_INCREMENT"];
                        Pro_Mgr::createNewPro($followedBy, $newProspectActivityArea, $newProspectName, 
                                            $newProspectDecisionMakerName, $newProspectMainPhone, 
                                            $newProspectSecondaryPhone, $newProspectMail, 
                                            $newProspectMainAdress, $newProspectSecondaryAdress, 
                                            $newProspectCP, $newProspectCity, $newProspectObservation);
//                      Récupère la prochaine valeur de l'auto-increment après l'insert.
                        $resultAfter = Pro_Mgr::getLastAutoIncrementValue();
//                      Convertit le résultat en entier.
                        $lastValueAfter = (int) $resultAfter[0]["AUTO_INCREMENT"];
/*
                        Contrôle que l'insert du professionnel a correctement été effectué
                        avant d'insérer un suivi dans la base de données.
*/               
                        if ($lastValueAfter === ($lastValueBefore + 1)) {
                            InfosInterlocutor_Mgr::createInterlocutorInfos($newContactInterlocutorName, $newContactInterlocutorContact);
//                          Récupère la prochaine valeur de l'auto-increment après l'insert.
                            $lastIdInfosAfter = InfosInterlocutor_Mgr::getLastAutoIncrementValue();
//                          Convertit le résultat en entier.
                            $infosInterlocutorIdValue = (int) $lastIdInfosAfter[0]["AUTO_INCREMENT"];
                            $infoInterlocutorId = $infosInterlocutorIdValue - 1;
/*
                            Contrôle que l'insert des infos sur l'interlocuteur a correctement été effectué
                            avant d'insérer un nouveau suivi dans la base de données.
*/ 
                            $lastContactDate = Dates_Mgr::nowToUnixString();;
//                          Si l'utilisateur a validé une date depuis le calendrier rdv, on enregistre une date de rdv. 
                            if ((isset($_POST['meetingCalendar'])) AND ($newContactConclusion === '5')) {
                                $meetingDate = Dates_Mgr::paramToUnixString($_POST['meetingCalendar']);
                                Contacting_Mgr::createNewContactMeeting($followedBy, $lastValueBefore, $newContactInterlocutor, 
                                                                    $infoInterlocutorId, $newContactType, $newContactConclusion, 
                                                                    $newContactComment, $lastContactDate, $meetingDate);
//                          Sinon, l'utilisateur saisit obligatoirement une date de relance.
                            } elseif (isset($_POST['recallCalendar'])) {   
                                $recallDate = Dates_Mgr::paramToUnixString($_POST['recallCalendar']);
                                Contacting_Mgr::createNewContactRecall($followedBy, $lastValueBefore, $newContactInterlocutor,
                                                                    $infoInterlocutorId, $newContactType, $newContactConclusion, 
                                                                    $newContactComment, $lastContactDate, $recallDate);
                            }  
                            $msg = '<div class="text-center" style="color: #46ec4e">Nouveau suivi enregistré.</div>';
                            require("../Views/Header/header_cdp.view.php");  
                            echo($msg);
                            require("../Views/Body/prospects_listing.view.php");
                            require("../Views/Footer/footer.view.php"); 
                            break;
                        }   
                    } catch (Exception $e) {
                        $msg = '<div class="text-center" style="color: #E84E0E">Erreur : Echec de l\'enregistrement.</div>';
                        require("../Views/Header/header_cdp.view.php");
                        echo($msg);
                        require("../Views/Body/add_new_prospect.view.php");
                        require("../Views/Footer/footer.view.php");
                        break;
                    }
                } else {
                    $msg = '<div class="text-center" style="color: #E84E0E">Erreur : un professionnel portant le même nom a déjà été enregistré.</div>';
                    require("../Views/Header/header_cdp.view.php");
                    echo($msg);
                    require("../Views/Body/prospects_listing.view.php");
                    require("../Views/Footer/footer.view.php");
                }
                break;
            case 'prospectsListing' : 
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/prospects_listing.view.php");
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
                Un chargé de projet ne pouvant modifier l'utilisateur en charge du suivi d'un professionnel, 
                nous passerons par défaut l'identifiant de l'utilisateur connecté en argument à la fonction. 
*/
                $followedBy = (int) $_SESSION['idUser'];
                Pro_Mgr::updateProspect($newProName, $newDecisionMakerName, $newMainPhone, 
                                        $newSecondaryPhone, $newMail, $newMainAdress, 
                                        $newSecondaryAdress, $newCp, $newCity, $newObservation,
                                        $proToUpdate, $followedBy);
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/prospects_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'prospectActivity':
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/prospect_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'addNewContactForm' : 
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/prospect_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'addedNewContact' : 
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/add_new_contact.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'clientsListing' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/clients_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'clientActivity' :
                require("../Views/Header/header_cdp.view.php");
                require("../Views/Body/client_activity.view.php");
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