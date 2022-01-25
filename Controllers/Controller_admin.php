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
//      Routes : 
        $header = "../Views/Header/header_admin.view.php";
        $footer = "../Views/Footer/footer.view.php";
        $home = "../Views/Body/home_admin.view.php";
        $prospectListing = "../Views/Body/prospects_listing.view.php";
        $addNewProspectForm = "../Views/Body/add_new_prospect.view.php";
        $fullInfosPro = "../Views/Body/full_infos_pro.php";
        $updateProForm = "../Views/Body/update_pro.php";
        $proActivity = "../Views/Body/pro_activity.view.php";
        $fullInfosContact = "../Views/Body/full_infos_contact.view.php";
        $addNewContactForm = "../Views/Body/add_new_contact.view.php";
        $clientsListing = "../Views/Body/clients_listing.view.php";
        $addNewClientForm = "../Views/Body/add_new_client.view.php";
        $userManagement = "../Views/Body/user_management.view.php";
        $addUserForm = "../Views/Body/add_user.view.php";
        $updateUserForm = "../Views/Body/update_user.view.php";
        $activityAreaManagement = "../Views/Body/activity_area_management.view.php";
        $conclusionsManagement = "../Views/Body/conclusions_management.view.php";
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
            case 'proActivity' :
                require($header);
                require($proActivity);
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
//          CREATE => [FORM]
            case 'addNewClientForm' : 
                require($header);
                require($addNewClientForm);
                require($footer);
                break;
//          CREATE => [ON SUBMIT]
            case 'addedNewClient' :
                require($header);
                require($proActivity);
                require($footer);
                break;
//          UPDATE => [FORM]
            case 'updatePro' :
                require($header);
                require($updateProForm);
                require($footer);
                break;
//          UPDATE => [ON SUBMIT]
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
                require($proActivity);
                require($footer); 
                break;
//          ********************************** MANAGEMENT USER ************************************
//          READ
            case 'userManagement' :
                require($header);
                require($userManagement);
                require($footer);
                break;
//          CREATE => [FORM]
            case 'addUser' :
                require($header);
                require($addUserForm);
                require($footer);
                break;
//          CREATE => [ON SUBMIT]
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
                    require($header);
                    echo('<div class="text-center" style="color: #46ec4e">Nouvel utilisateur enregistré.</div>');
                    require($userManagement);
                    require($footer);
                    break;
                } else {
                    require($header);
                    echo('<div class="text-center" style="color: #E84E0E">Erreur : l\'utilisateur n\'a pas pu être enregistré.</div>');
                    require($addUserForm);
                    require($footer);
                    break;
                }
//          UPDATE => [FORM]
            case 'updateUser' : 
                require($header);
                require($updateUserForm);
                require($footer);
                break;
//          UPDATE => [ON SUBMIT]
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
                        require($header);
                        echo('<div class="text-center" style="color: #E84E0E">Erreur : le mot de passe n\'a pas pu être modifié.</div>');
                        require($userManagement);
                        require($footer);
                        break;
                    }
                }
                User_Mgr::updateUser($nameUserToUpdate, $surnameUserToUpdate, $mailUserToUpdate, 
                                    $phoneUserToUpdate, $rightsUserToUpdate, $idUserToUpdate);
                    require($header);
                    echo('<div class="text-center" style="color: #46ec4e">L\'utilisateur a bien été mis à jour.</div>');
                    require($userManagement);
                    require($footer);
                    break;
//          DELETE
            case 'deleteUser' : 
                $userID = (int) $_POST['idUser'];
                User_Mgr::deleteUser($userID);
                require($header);
                require($userManagement);
                require($footer);
                break;
//          *********************************** MANAGEMENT ACTIVITYAREA ***************************
//          READ
            case 'activityAreaManagement' :
                require($header);
                require($activityAreaManagement);
                require($footer);
                break;
//          CREATE
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
                require($header);
                echo($msg);
                require($activityAreaManagement);
                require($footer);
                break;
//          UPDATE
            case 'updateActivityArea' :
                $idActivityAreaToUpdate = $_POST['idActivityArea'];
                $newActivityAreaLabel = $_POST['updActivityArea'];
                ActivityArea_Mgr::updateActivityAreaById($idActivityAreaToUpdate, $newActivityAreaLabel);
                $msg = '<div class="text-center" style="color: #46ec4e">La modification a bien été effectuée.</div>';
                require($header);
                echo($msg);
                require($activityAreaManagement);
                require($footer);
                break;
//          DELETE
            case 'deleteActivityArea' :
                $idActivityAreaToDelete = (int) $_POST['idActivityArea'];
                $libActivityAreaToDelete = ActivityArea_Mgr::getActivityAreaLibById($idActivityAreaToDelete);
                $libActivityAreaToDelete = $libActivityAreaToDelete[0]['libelle_secteur'];
                $msg = '<div class="text-center" style="color: #46ec4e">'.'"'.$libActivityAreaToDelete.'" a bien été supprimé de la liste.'.'</div>';
                ActivityArea_Mgr::deleteActivityAreaById($idActivityAreaToDelete);
                require($header);
                echo($msg);
                require($activityAreaManagement);
                require($footer);
                break;
//          *********************************** MANAGEMENT CONCLUSIONS ****************************
//          READ
            case 'conclusionsManagement' :
                require($header);
                require($conclusionsManagement);
                require($footer);
                break;
//          CREATE
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
                require($header);
                echo($msg);
                require($conclusionsManagement);
                require($footer);
                break;
//          UPDATE
            case 'updateConclusion' :
                $idConclusionToUpdate = $_POST['idConclusion'];
                $newConclusionLabel = $_POST['updConclusion'];
                Conclusions_Mgr::updateConclusionById($idConclusionToUpdate, $newConclusionLabel);
                $msg = '<div class="text-center" style="color: #46ec4e">La modification a bien été effectuée.</div>';
                require($header);
                echo($msg);
                require($conclusionsManagement);
                require($footer);
                break;
//          DELETE
            case 'deleteConclusion' :
                $idConclusionToDelete = (int) $_POST['idConclusion'];
                $libConclusionToDelete = Conclusions_Mgr::getConclusionLibById($idConclusionToDelete);
                $libConclusionToDelete = $libConclusionToDelete[0]['libelle_conclusion'];
                $msg = '<div class="text-center" style="color: #46ec4e">'.'"'.$libConclusionToDelete.'" a bien été supprimé de la liste.'.'</div>';
                Conclusions_Mgr::deleteConclusionById($idConclusionToDelete);
                require($header);
                echo($msg);
                require($conclusionsManagement);
                require($footer);
                break;
        }
    } else header('Location: ../index.php');
?>