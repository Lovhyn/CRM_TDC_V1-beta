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
        Enregistre dans une variable la valeur passée en "GET" de l'action      
        appelée par l'utilisateur.
*/ 
        if (isset($_GET['action'])) {
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
            case 'prospectsListing' :
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
                $idUserToUpdate = $_POST['userId'];
                if ($_POST['majUserRights'] === 'admin') {
                    $rightsUserToUpdate = 1;
                } elseif ($_POST['majUserRights'] === 'responsable') {
                    $rightsUserToUpdate = 2;                   
                } else {
                    $rightsUserToUpdate = 3;                   
                }
                if ((isset($_POST['majUserPassword'])) AND (isset($_POST['majUserPassword²']))) {
                    $passwordUserToUpdate = $_POST['majUserPassword'];
                    $passwordUserToUpdateConfirmation = $_POST['majUserPassword²'];
                    if ($passwordUserToUpdate === $passwordUserToUpdateConfirmation) {
                        User_Mgr::updateUser($nameUserToUpdate, $surnameUserToUpdate, $passwordUserToUpdate, 
                                    $mailUserToUpdate, $phoneUserToUpdate, $rightsUserToUpdate, $idUserToUpdate);
                        require("../Views/Header/header_admin.view.php");
                        echo('<div class="text-center" style="color: #46ec4e">L\'utilisateur a bien été mis à jour.</div>');
                        require("../Views/Body/user_management.view.php");
                        require("../Views/Footer/footer.view.php");
                    break;
                    } else {
                        require("../Views/Header/header_admin.view.php");
                        echo('<div class="text-center" style="color: #E84E0E">Erreur : l\'utilisateur n\'a pas pu être mis à jour.</div>');
                        require("../Views/Body/user_management.view.php");
                        require("../Views/Footer/footer.view.php");
                        break;
                    }
                } else {
                    $oldPasswordUser = $_POST['oldUserPassword'];
                    User_Mgr::updateUser($nameUserToUpdate, $surnameUserToUpdate, $oldPasswordUser, 
                                    $mailUserToUpdate, $phoneUserToUpdate, $rightsUserToUpdate, $idUserToUpdate);
                    require("../Views/Header/header_admin.view.php");
                    echo('<div class="text-center" style="color: #46ec4e">L\'utilisateur a bien été mis à jour.</div>');
                    require("../Views/Body/user_management.view.php");
                    require("../Views/Footer/footer.view.php");
                    break;
                }
/*
            case 'deleteUser' : 
                $userID = (int) $_POST['idUser'];
                User_Mgr::deleteUser($userID);
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/user_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
*/
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
                    require("../Views/Header/header_admin.view.php");
                    require("../Views/Body/activity_area_management.view.php");
                    require("../Views/Footer/footer.view.php");
                } elseif ($newActivityArea == '') {
                    require("../Views/Header/header_admin.view.php");
                    echo('<div class="text-center" style="color: #E84E0E">Erreur : veuillez saisir un secteur</div>');
                    require("../Views/Body/activity_area_management.view.php");
                    require("../Views/Footer/footer.view.php");
                } else {
                    require("../Views/Header/header_admin.view.php");
                    echo('<div class="text-center" style="color: #E84E0E">Erreur : ce secteur existe déjà</div>');
                    require("../Views/Body/activity_area_management.view.php");
                    require("../Views/Footer/footer.view.php");
                }
                break;
            case 'updateActivityArea' :
                $idActivityAreaToUpdate = $_POST['idActivityArea'];
                $newActivityAreaLabel = $_POST['updActivityArea'];
                ActivityArea_Mgr::updateActivityAreaById($idActivityAreaToUpdate, $newActivityAreaLabel);
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/activity_area_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'deleteActivityArea' :
                $idActivityAreaToDelete = $_POST['idActivityArea'];
                ActivityArea_Mgr::deleteActivityAreaById($idActivityAreaToDelete);
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/activity_area_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
//          *********************************** Management CONCLUSIONS ****************************
            case 'conclusionsManagement' :
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/conclusions_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            // case 'addConclusion' :
            //     $newConclusion = $_POST['newConclusion'];
            //     if (($newConclusion != '') and (Conclusions_Mgr::checkIfExists($newConclusion) < 1)) {
            //         Conclusions_Mgr::createConclusion($newConclusion);
            //         require("../Views/Header/header_admin.view.php");
            //         require("../Views/Body/conclusions_management.view.php");
            //         require("../Views/Footer/footer.view.php");
            //     } elseif ($newConclusion == '') {
            //         require("../Views/Header/header_admin.view.php");
            //         echo('<div class="text-center" style="color: #E84E0E">Erreur : veuillez saisir un scénario</div>');
            //         require("../Views/Body/conclusions_management.view.php");
            //         require("../Views/Footer/footer.view.php");
            //     } else {
            //         require("../Views/Header/header_admin.view.php");
            //         echo('<div class="text-center" style="color: #E84E0E">Erreur : ce scénario existe déjà</div>');
            //         require("../Views/Body/conclusions_management.view.php");
            //         require("../Views/Footer/footer.view.php");
            //     }
            //     break;
            case 'updateConclusion' :
                $idConclusionToUpdate = $_POST['idConclusion'];
                $newConclusionLabel = $_POST['updConclusion'];
                Conclusions_Mgr::updateConclusionById($idConclusionToUpdate, $newConclusionLabel);
                require("../Views/Header/header_admin.view.php");
                require("../Views/Body/conclusions_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            // case 'deleteConclusion' :
            //     $idConclusionToDelete = $_POST['idConclusion'];
            //     Conclusions_Mgr::deleteConclusionById($idConclusionToDelete);
            //     require("../Views/Header/header_admin.view.php");
            //     require("../Views/Body/conclusions_management.view.php");
            //     require("../Views/Footer/footer.view.php");
            //     break;
        }
    } else header('Location: ../index.php');
?>