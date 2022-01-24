<?php
    session_start();
    if ($_SESSION['rights'] === '1') {
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
//      -------------------------------------------------------------------------------------------
//      --------------------------------------Switch $action---------------------------------------
//      -------------------------------------------------------------------------------------------
        switch ($action) {
            case 'home' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/home_admin.view.php");
                require("../Views/Footer/footer.view.php");
                break;
//          ********************************** Management PRO *************************************
            case 'addNewProspectForm' : 
                require("../Views/Header/header_admin.view.php");
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
                            require("../Views/Header/header_admin.view.php");  
                            echo($msg);
                            require("../Views/Body/prospects_listing.view.php");
                            require("../Views/Footer/footer.view.php"); 
                            break;
                        }   
                    } catch (Exception $e) {
                        $msg = '<div class="text-center" style="color: #E84E0E">Erreur : Echec de l\'enregistrement.</div>';
                        require("../Views/Header/header_admin.view.php");
                        echo($msg);
                        require("../Views/Body/add_new_prospect.view.php");
                        require("../Views/Footer/footer.view.php");
                        break;
                    }
                } else {
                    goto prospectListing;
                }
                break;
            case 'prospectsListing' :
                prospectListing:
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/prospects_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'fullInfosPro' : 
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/full_infos_pro.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'updatePro' :
                require("../Views/Header/header_admin.view.php");
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
                $newFollowedBy = (int) $_POST['majProFollowedBy'];
                Pro_Mgr::updateProspect($newProName, $newDecisionMakerName, $newMainPhone, 
                                        $newSecondaryPhone, $newMail, $newMainAdress, 
                                        $newSecondaryAdress, $newCp, $newCity, $newObservation,
                                        $proToUpdate, $newFollowedBy);
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/prospects_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'clientsListing' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/clients_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'prospectActivity' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/prospect_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'fullInfosContact' : 
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/full_infos_contact.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'clientActivity' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/client_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
//          ********************************** Management USER ************************************
            case 'userManagement' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/user_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'addUser' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/add_user.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'addedUser' :
//              Vérifie que les mots de passe saisis sont identiques.
                if ((isset($_POST['newUserPassword²'])) AND ($_POST['newUserPassword²'] === $_POST['newUserPassword'])) {
                    $newUserName = $_POST['newUserName'];
                    $newUserSurname = $_POST['newUserSurname'];
                    $newUserPhone = $_POST['newUserPhone'];
                    $newUserMail = $_POST['newUserMail'];
                    $newUserPassword = $_POST['newUserPassword'];
                    $newUserRights = $_POST['newUserRights'];
                    if ($_POST['newUserRights'] === 'admin') {
                        $newUserRights = 1;
                    } elseif ($_POST['newUserRights'] === 'responsable') {
                        $newUserRights = 2;                   
                    } else {
                        $newUserRights = 3;                   
                    }
                    User_Mgr::createUser($newUserName, $newUserSurname, $newUserPassword,
                                        $newUserMail, $newUserPhone, $newUserRights);
                    require("../Views/Header/header_admin.view.php");
                    echo('<div class="text-center" style="color: #46ec4e">Nouvel utilisateur enregistré.</div>');
                    require("../Views/Body/user_management.view.php");
                    require("../Views/Footer/footer.view.php");
                    break;
                } else {
                    require("../Views/Header/header_admin.view.php");
                    echo('<div class="text-center" style="color: #E84E0E">Erreur : l\'utilisateur n\'a pas pu être enregistré.</div>');
                    require("../Views/Body/add_user.view.php");
                    require("../Views/Footer/footer.view.php");
                    break;
                }
            case 'updateUser' : 
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/update_user.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'updatedUser' : 
                $nameUserToUpdate = $_POST['majUserName'];
                $surnameUserToUpdate = $_POST['majUserSurname'];
                $phoneUserToUpdate = $_POST['majUserPhone'];
                $mailUserToUpdate = $_POST['majUserMail'];
                $rightsUserToUpdate = $_POST['majUserRights'];
                $idUserToUpdate = (int) $_POST['userId'];
                $oldPasswordUser = $_POST['oldUserPassword'];
                $newUserPassword = $_POST['newUserPassword'];
                $newUserPasswordConfirmation = $_POST['confirmNewUserPassword'];
                if ($_POST['majUserRights'] === 'admin') {
                    $rightsUserToUpdate = 1;
                } elseif ($_POST['majUserRights'] === 'responsable') {
                    $rightsUserToUpdate = 2;                   
                } else {
                    $rightsUserToUpdate = 3;                   
                }
                if (($newUserPassword != '') OR ($newUserPasswordConfirmation != '')) {
                    if ($newUserPassword === $newUserPasswordConfirmation) {
                        User_Mgr::updateUserPassword($idUserToUpdate, $newUserPassword);
                    } else {
                        require("../Views/Header/header_admin.view.php");
                        echo('<div class="text-center" style="color: #E84E0E">Erreur : le mot de passe n\'a pas pu être modifié.</div>');
                        require("../Views/Body/user_management.view.php");
                        require("../Views/Footer/footer.view.php");
                        break;
                    }
                }
                User_Mgr::updateUser($nameUserToUpdate, $surnameUserToUpdate, $mailUserToUpdate, 
                                    $phoneUserToUpdate, $rightsUserToUpdate, $idUserToUpdate);
                    require("../Views/Header/header_admin.view.php");
                    echo('<div class="text-center" style="color: #46ec4e">L\'utilisateur a bien été mis à jour.</div>');
                    require("../Views/Body/user_management.view.php");
                    require("../Views/Footer/footer.view.php");
                    break;
            case 'deleteUser' : 
                $userID = (int) $_POST['idUser'];
                User_Mgr::deleteUser($userID);
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/user_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
//          *********************************** Management ACTIVITYAREA ***************************
            case 'activityAreaManagement' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/activity_area_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'addAreaActivity' :
                $newActivityArea = $_POST['newActivityArea'];
                if (($newActivityArea != '') and (ActivityArea_Mgr::checkIfExists($newActivityArea) < 1)) {
                    ActivityArea_Mgr::createActivityArea($newActivityArea);
                    $msg = '<div class="text-center" style="color: #46ec4e">'.'"'.$newActivityArea.'" a bien été ajouté à la liste.'.'</div>';
                } elseif ($newActivityArea == '') {
                    $msg = '<div class="text-center" style="color: #E84E0E">Erreur : veuillez saisir un secteur.</div>';
                } else {
                    $msg = '<div class="text-center" style="color: #E84E0E">Erreur : ce secteur existe déjà</div>';
                }
                require("../Views/Header/header_admin.view.php");
                echo($msg);
                require("../Views/Body/activity_area_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'updateActivityArea' :
                $idActivityAreaToUpdate = $_POST['idActivityArea'];
                $newActivityAreaLabel = $_POST['updActivityArea'];
                ActivityArea_Mgr::updateActivityAreaById($idActivityAreaToUpdate, $newActivityAreaLabel);
                $msg = '<div class="text-center" style="color: #46ec4e">La modification a bien été effectuée.</div>';
                require("../Views/Header/header_admin.view.php");
                echo($msg);
                require("../Views/Body/activity_area_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'deleteActivityArea' :
                $idActivityAreaToDelete = (int) $_POST['idActivityArea'];
                $libActivityAreaToDelete = ActivityArea_Mgr::getActivityAreaLibById($idActivityAreaToDelete);
                $libActivityAreaToDelete = $libActivityAreaToDelete[0]['libelle_secteur'];
                $msg = '<div class="text-center" style="color: #46ec4e">'.'"'.$libActivityAreaToDelete.'" a bien été supprimé de la liste.'.'</div>';
                ActivityArea_Mgr::deleteActivityAreaById($idActivityAreaToDelete);
                require("../Views/Header/header_admin.view.php");
                echo($msg);
                require("../Views/Body/activity_area_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
//          *********************************** Management CONCLUSIONS ****************************
            case 'conclusionsManagement' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/conclusions_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'updateConclusion' :
                $idConclusionToUpdate = $_POST['idConclusion'];
                $newConclusionLabel = $_POST['updConclusion'];
                Conclusions_Mgr::updateConclusionById($idConclusionToUpdate, $newConclusionLabel);
                $msg = '<div class="text-center" style="color: #46ec4e">La modification a bien été effectuée.</div>';
                require("../Views/Header/header_admin.view.php");
                echo($msg);
                require("../Views/Body/conclusions_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'addConclusion' :
                $newConclusion = $_POST['newConclusion'];
                if (($newConclusion != '') and (Conclusions_Mgr::checkIfExists($newConclusion) < 1)) {
                    Conclusions_Mgr::createConclusion($newConclusion);
                    $msg = '<div class="text-center" style="color: #46ec4e">'.'"'.$newConclusion.'" a bien été ajouté à la liste.'.'</div>';
                } elseif ($newConclusion == '') {
                    $msg = '<div class="text-center" style="color: #E84E0E">Erreur : veuillez saisir un scénario</div>';
                } else {
                    $msg = '<div class="text-center" style="color: #E84E0E">Erreur : ce scénario existe déjà</div>';
                }
                require("../Views/Header/header_admin.view.php");
                echo($msg);
                require("../Views/Body/conclusions_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'deleteConclusion' :
                $idConclusionToDelete = (int) $_POST['idConclusion'];
                $libConclusionToDelete = Conclusions_Mgr::getConclusionLibById($idConclusionToDelete);
                $libConclusionToDelete = $libConclusionToDelete[0]['libelle_conclusion'];
                $msg = '<div class="text-center" style="color: #46ec4e">'.'"'.$libConclusionToDelete.'" a bien été supprimé de la liste.'.'</div>';
                Conclusions_Mgr::deleteConclusionById($idConclusionToDelete);
                require("../Views/Header/header_admin.view.php");
                echo($msg);
                require("../Views/Body/conclusions_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
        }
    } else header('Location: ../index.php');
?>