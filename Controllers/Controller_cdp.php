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
        Enregistre dans une variable la valeur passée en "GET" ou en "POST" 
        de l'action appelée par l'utilisateur.
*/ 
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
        } elseif (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
//      Routes :
        $header = "../Views/Header/header_cdp.view.php";
        $footer = "../Views/Footer/footer.view.php";
        $home = "../Views/Body/home_cdp.view.php";
        $prospectListing = "../Views/Body/prospects_listing.view.php";
        $addNewProspectForm = "../Views/Body/add_new_prospect.view.php";
        $fullInfosPro = "../Views/Body/full_infos_pro.php";
        $updateProForm = "../Views/Body/update_pro.php";
        $prospectActivity = "../Views/Body/prospect_activity.view.php";
        $fullInfosContact = "../Views/Body/full_infos_contact.view.php";
        $addNewContactForm = "../Views/Body/add_new_contact.view.php";
        $clientsListing = "../Views/Body/clients_listing.view.php";
        $clientActivity = "../Views/Body/client_activity.view.php";
//      -------------------------------------------------------------------------------------------
//      --------------------------------------Switch $action---------------------------------------
//      -------------------------------------------------------------------------------------------
        switch ($action) {
//          ************************************** HOME *******************************************
            case 'home' :
                require($header);
                require($home);
                require($footer);
                break;
//          ****************************** MANAGEMENT PROSPECTS & CLIENTS *************************
//          READ
            case 'prospectsListing' : 
                prospectListing:
                require($header);
                require($prospectListing);
                require($footer);
                break; 
            case 'clientsListing' :
                require($header);
                require($clientsListing);
                require($footer);
                break;
            case 'fullInfosPro' : 
                require($header);
                require($fullInfosPro);
                require($footer);
                break;
            case 'fullInfosContact' : 
                require($header);
                require($fullInfosContact);
                require($footer);
                break;
            case 'prospectActivity':
                require($header);
                require($prospectActivity);
                require($footer);
                break;
            case 'clientActivity' :
                require($header);
                require($clientActivity);
                require($footer);
                break;
//          CREATE => [FORM]
            case 'addNewProspectForm' : 
                require($header);
                require($addNewProspectForm);
                require($footer);
                break;
//          CREATE => [ON SUBMIT]
            case 'addedNewProspect' :
/*
                L'opération d'ajout d'un nouveau prospect implique tacitement mais impérativement
                la création d'un suivi (et donc l'enregistrement d'informations concernant l'interlocuteur).
                Il faut donc à la validation du formulaire réaliser 3 inserts :
                - Etape 1 : On insert un nouveau professionnel
                - Etape 2 : On insert les infos sur l'interlocuteur
                - Etape 3 : On insert un suivi en récupèrant les identifiants du pro et de l'interlocuteur.
*/                 
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
/*              
                Définit automatiquement que si le type d'interlocuteur est une messagerie,
                le type de contact sera obligatoirement par téléphone.
*/    
                if ($newContactInterlocutor === 3) {
                    $newContactType = 3;
                } else {
                    $newContactType = (int) $_POST['newContactType'];
                }
                $newContactConclusion = (int) $_POST['newContactConclusion'];
                $newContactComment = $_POST['newContactComment'];
/*
                Attention au typage : 
                Les données concernant l'interlocuteur ne sont pas requises, par conséquent, des
                valeurs NULL peuvent être envoyées en BDD. Nous contrôlons ici si les variables sont
                vides ou non. Si elles le sont, nous envoyons des chaînes vides à la fonction 'createInterlocutorInfos'
                qui elle, se chargera d'envoyer NULL si elle reçoit des chaînes vides en paramètre.
*/
                if ($_POST['newContactInterlocutorName'] === '') {
                    $newInfosInterlocutorName = '';
                } else {
                    $newInfosInterlocutorName = $_POST['newContactInterlocutorName'];
                }
                if ($_POST['newContactInterlocutorInfoTel'] === '') {
                    if ($_POST['newContactInterlocutorInfoMail'] === '') {
                        $newInfosInterlocutorContact = '';
                    } else {
                        $newInfosInterlocutorContact = $_POST['newContactInterlocutorInfoMail'];
                    }
                } else {
                    $newInfosInterlocutorContact = $_POST['newContactInterlocutorInfoTel'];
                }         
                $msg = '';
//          Etape 1 :
//              Avant l'ajout, on contrôle qu'aucun professionnel n'a un nom semblable.
                if (Pro_Mgr::checkIfExists($newProspectName) === 0) {
                    try {
//                      Récupère la prochaine valeur de l'auto-increment avant l'insert.
                        $resultBefore = Pro_Mgr::getLastAutoIncrementValue();
//                      Convertit le résultat en entier.
                        $lastValueBefore = (int) $resultBefore[0]["AUTO_INCREMENT"];
                        Pro_Mgr::createNewProspect($followedBy, $newProspectActivityArea, $newProspectName, 
                                            $newProspectDecisionMakerName, $newProspectMainPhone, 
                                            $newProspectSecondaryPhone, $newProspectMail, 
                                            $newProspectMainAdress, $newProspectSecondaryAdress, 
                                            $newProspectCP, $newProspectCity, $newProspectObservation);
//                      Récupère la prochaine valeur de l'auto-increment après l'insert.
                        $resultAfter = Pro_Mgr::getLastAutoIncrementValue();
//                      Convertit le résultat en entier.
                        $lastValueAfter = (int) $resultAfter[0]["AUTO_INCREMENT"];
//          Etape 2 :              
                        if ($lastValueAfter === ($lastValueBefore + 1)) {
                            InfosInterlocutor_Mgr::createInterlocutorInfos($newInfosInterlocutorName, $newInfosInterlocutorContact);
//                          Récupère la prochaine valeur de l'auto-increment après l'insert.
                            $lastIdInfosAfter = InfosInterlocutor_Mgr::getLastAutoIncrementValue();
//                          Convertit le résultat en entier.
                            $infosInterlocutorIdValue = (int) $lastIdInfosAfter[0]["AUTO_INCREMENT"];
//                          Récupère l'identifiant du dernier insert de la table 'infos_interlocuteur'.
                            $infoInterlocutorId = $infosInterlocutorIdValue - 1;
//                          Récupère la date du jour et là retourne au format Unix sous forme de String.
//          Etape 3 :
                            $lastContactDate = Dates_Mgr::nowToUnixString();
//                          Si l'utilisateur a validé une date depuis le calendrier rdv, on enregistre une date de rdv. 
                            if ((isset($_POST['meetingCalendar'])) AND ($newContactConclusion === 5)) {
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
                            require($header);  
                            echo($msg);
                            require($prospectListing);
                            require($footer); 
                            break;
                        }   
                    } catch (Exception $e) {
                        $msg = '<div class="text-center" style="color: #E84E0E">Erreur : Echec de l\'enregistrement.</div>';
                        require($header);
                        echo($msg);
                        require($addNewProspectForm);
                        require($footer);
                        break;
                    }
                } else {
                goto prospectListing;
                }
                break;
//          UPDATE => [FORM]
            case 'updatePro' :
                require($header);
                require($updateProForm);
                require($footer);
                break;
//          UPDATE => [ONSUBMIT]
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
                Un chargé de projet ne peut modifier que les prospects / clients dont il est en charge du suivi.
                Un chargé de projet ne peut pas modifier l'utilisateur en charge du suivi d'un prospect / client. 
                => Nous passons donc par défaut l'identifiant de l'utilisateur connecté à la fonction updateProspect.
*/
                $followedBy = (int) $_SESSION['idUser'];
                Pro_Mgr::updateProspect($newProName, $newDecisionMakerName, $newMainPhone, 
                                        $newSecondaryPhone, $newMail, $newMainAdress, 
                                        $newSecondaryAdress, $newCp, $newCity, $newObservation,
                                        $proToUpdate, $followedBy);
                require($header);
                require($prospectListing);
                require($footer);
                break;
//          CREATE => [FORM]
            case 'addNewContactForm' : 
                require($header);
                require($addNewContactForm);
                require($footer);
                break;
//          CREATE => [ON SUBMIT]
            case 'addedNewContact' : 
                $idPro = (int) $_POST['ID_professionnel'];
                $idUser = (int) $_SESSION['idUser'];
                $idInterlocutorType = (int) $_POST['idInterlocutorType'];
                $idContactType = (int) $_POST['idContactType'];
                $contactConclusion = (int) $_POST['contactConclusion'];
                $meetingCalendar = $_POST['meetingCalendar'];
                $recallCalendar = $_POST['recallCalendar'];
                $contactComment = $_POST['contactComment'];
/*
                Attention au typage : 
                Les données concernant l'interlocuteur ne sont pas requises, par conséquent, des
                valeurs NULL peuvent être envoyées en BDD. Nous contrôlons ici si les variables sont
                vides ou non. Si elles le sont, nous envoyons des chaînes vides à la fonction 'createInterlocutorInfos'
                qui elle, se chargera d'envoyer NULL si elle reçoit des chaînes vides en paramètre.
*/
                if ($_POST['contactInterlocutorName'] === '') {
                    $contactInterlocutorName = '';
                } else {
                    $contactInterlocutorName = $_POST['contactInterlocutorName'];
                }
                if ($_POST['contactInterlocutorInfoTel'] === '') {
                    if ($_POST['contactInterlocutorInfoMail'] === '') {
                        $contactInterlocutorInfo = '';
                    } else {
                        $contactInterlocutorInfo = $_POST['contactInterlocutorInfoMail'];
                    }
                } else {
                    $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                }
                InfosInterlocutor_Mgr::createInterlocutorInfos($contactInterlocutorName, $contactInterlocutorInfo);
//              Récupère la prochaine valeur de l'auto-increment après l'insert.
                $lastIdInfosAfter = InfosInterlocutor_Mgr::getLastAutoIncrementValue();
//              Convertit le résultat en entier.
                $infosInterlocutorIdValue = (int) $lastIdInfosAfter[0]["AUTO_INCREMENT"];
//              Récupère l'identifiant du dernier insert de la table 'infos_interlocuteur'.
                $infoInterlocutorId = $infosInterlocutorIdValue - 1;
//              Récupère la date du jour et là retourne au format Unix sous forme de String.
                $lastContactDate = Dates_Mgr::nowToUnixString();;
//              Si l'utilisateur a validé une date depuis le calendrier rdv, on enregistre une date de rdv. 
                if ((isset($_POST['meetingCalendar'])) AND ($contactConclusion === 5)) {
                    $meetingDate = Dates_Mgr::paramToUnixString($meetingCalendar);
                    Contacting_Mgr::createNewContactMeeting($idUser, $idPro, $idInterlocutorType, 
                                                        $infoInterlocutorId, $idContactType, $contactConclusion, 
                                                        $contactComment, $lastContactDate, $meetingDate);
//              Sinon, l'utilisateur saisit obligatoirement une date de relance.
                } elseif (isset($_POST['recallCalendar'])) {   
                    $recallDate = Dates_Mgr::paramToUnixString($recallCalendar);
                    Contacting_Mgr::createNewContactRecall($idUser, $idPro, $idInterlocutorType, 
                                                        $infoInterlocutorId, $idContactType, $contactConclusion, 
                                                        $contactComment, $lastContactDate, $recallDate);
                }  
                $msg = '<div class="text-center" style="color: #46ec4e">Nouvelle prise de contact enregistrée !</div>';
                require($header);  
                echo($msg);
                require($prospectActivity);
                require($footer); 
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