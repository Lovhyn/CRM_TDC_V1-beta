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
        $proActivity = "../Views/Body/pro_activity.view.php";
        $fullInfosContact = "../Views/Body/full_infos_contact.view.php";
        $addNewContactForm = "../Views/Body/add_new_contact.view.php";
        $clientsListing = "../Views/Body/clients_listing.view.php";
        $addNewClientForm = "../Views/Body/add_new_client.view.php";
        $updateContactForm = "../Views/Body/updateContactForm.view.php";
        $myMeetings = "../Views/Body/my_meetings.view.php";
        $myRecalls = "../Views/Body/my_recalls.view.php";
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
            case 'myMeetings' :
                require($header);
                require($myMeetings);
                require($footer);
                break;
            case 'myRecalls' :
                require($header);
                require($myRecalls);
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
                $idUser = (int) $_SESSION['idUser'];       
                $newProspectName = $_POST['prospectName'];
                $newProspectDecisionMakerName = $_POST['prospectDecisionMakerName'];
                $newProspectActivityArea = (int) $_POST['prospectActivityArea'];
                $newProspectMail = $_POST['prospectMail'];
                $newProspectMainPhone = $_POST['prospectMainPhone'];
                $newProspectSecondaryPhone = $_POST['prospectSecondaryPhone'];
                $newProspectMainAdress = $_POST['prospectMainAdress'];
                $newProspectSecondaryAdress = $_POST['prospectSecondaryAdress'];
                $newProspectCP = $_POST['prospectCp'];
                $newProspectCity = $_POST['prospectCity'];
                $newProspectObservation = $_POST['prospectObservation'];

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
                vides ou non. Si elles le sont, nous envoyons des chaînes vides à la fonction
                'createInterlocutorInfos' qui elle, se chargera d'envoyer NULL si elle reçoit des 
                chaînes vides en paramètre.
*/
                switch ($idInterlocutorType) {
                    case 1 :
                        $contactInterlocutorName = $newProspectDecisionMakerName;
                        if ($idContactType === 3) {
                            if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                            } else {
                                $contactInterlocutorInfo = '';
                            }
                        } elseif ($idContactType === 4) {
                            if ((isset($_POST['contactInterlocutorInfoMail'])) AND ($_POST['contactInterlocutorInfoMail'] != '')) {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoMail'];
                            } else {
                                $contactInterlocutorInfo = '';
                            } 
                        } else {
                            $contactInterlocutorInfo = '';
                        } 
                        break;
                    case 2 :
                        if (isset($_POST['contactInterlocutorName'])) {
                            $contactInterlocutorName = $_POST['contactInterlocutorName'];
                        }
                        if ($idContactType === 3) {
                            if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                            } else {
                                $contactInterlocutorInfo = '';
                            }
                        } elseif ($idContactType === 4) {
                            if ((isset($_POST['contactInterlocutorInfoMail'])) AND ($_POST['contactInterlocutorInfoMail'] != '')) {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoMail'];
                            } else {
                                $contactInterlocutorInfo = '';
                            } 
                        } else {
                            $contactInterlocutorInfo = '';
                        } 
                        break;
                    case 3 :
                        $idContactType = 3;
                        if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                            $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                        } else {
                            $contactInterlocutorInfo = '';
                        }
                        $contactInterlocutorName = '';
                        break;
                    case 4 :
                        if (isset($_POST['contactInterlocutorName'])) {
                            $contactInterlocutorName = $_POST['contactInterlocutorName'];
                        }
                        if ($idContactType === 3) {
                            if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                            } else {
                                $contactInterlocutorInfo = '';
                            }
                        } elseif ($idContactType === 4) {
                            if ((isset($_POST['contactInterlocutorInfoMail'])) AND ($_POST['contactInterlocutorInfoMail'] != '')) {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoMail'];
                            } else {
                                $contactInterlocutorInfo = '';
                            } 
                        } else {
                            $contactInterlocutorInfo = '';
                        } 
                        break;
                }
//          Etape 1 :
//              Avant l'ajout, on contrôle qu'aucun professionnel n'a un nom semblable.
                if (Pro_Mgr::checkIfExists($newProspectName) === 0) {
                    try {
//                      Récupère la prochaine valeur de l'auto-increment avant l'insert.
                        $resultBefore = Pro_Mgr::getLastAutoIncrementValue();
//                      Convertit le résultat en entier.
                        $lastValueBefore = (int) $resultBefore[0]["AUTO_INCREMENT"];
                        Pro_Mgr::createNewProspect($idUser, $newProspectActivityArea, $newProspectName, 
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
                            InfosInterlocutor_Mgr::createInterlocutorInfos($contactInterlocutorName, 
                                                                        $contactInterlocutorInfo);
//                          Récupère la prochaine valeur de l'auto-increment après l'insert.
                            $lastIdInfosAfter = InfosInterlocutor_Mgr::getLastAutoIncrementValue();
//                          Convertit le résultat en entier.
                            $infosInterlocutorIdValue = (int) $lastIdInfosAfter[0]["AUTO_INCREMENT"];
//                          Récupère l'identifiant du dernier insert de la table 'infos_interlocuteur'.
                            $infoInterlocutorId = $infosInterlocutorIdValue - 1;
//          Etape 3 :
//                          Récupère la date du jour et là retourne au format Unix sous forme de String.
                            $lastContactDate = Dates_Mgr::nowToUnixString();
//                          Si l'utilisateur a validé une date depuis le calendrier rdv, on enregistre une date de rdv. 
                            if ((isset($_POST['meetingCalendar'])) AND ($contactConclusion === 5)) {
                                $meetingDate = Dates_Mgr::paramToUnixString($meetingCalendar);
                                Contacting_Mgr::createNewContactMeeting($idUser, $lastValueBefore, $idInterlocutorType, 
                                                                    $infoInterlocutorId, $idContactType, $contactConclusion, 
                                                                    $contactComment, $lastContactDate, $meetingDate);
//                          Sinon, l'utilisateur saisit obligatoirement une date de relance.
                            } elseif (isset($_POST['recallCalendar'])) {
                                $recallDate = Dates_Mgr::paramToUnixString($recallCalendar);
                                Contacting_Mgr::createNewContactRecall($idUser, $lastValueBefore, $idInterlocutorType, 
                                                                    $infoInterlocutorId, $idContactType, $contactConclusion, 
                                                                    $contactComment, $lastContactDate, $recallDate);
                            }   
                            $msg = '<div class="text-center" style="color: #3bf6a2">Nouveau suivi enregistré.</div>';
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
                $userId = (int) $_SESSION['idUser'];
                $clientName = $_POST['clientName'];
                $clientDecisionMakerName = $_POST['clientDecisionMakerName'];
                $clientActivityArea = (int) $_POST['clientActivityArea'];
                $clientMail = $_POST['clientMail'];
                $clientMainPhone = $_POST['clientMainPhone'];
                $clientSecondaryPhone = $_POST['clientSecondaryPhone'];
                $clientMainAdress = $_POST['clientMainAdress'];
                $clientSecondaryAdress = $_POST['clientSecondaryAdress'];
                $clientCp = $_POST['clientCp'];
                $clientCity = $_POST['clientCity'];
                $clientObservation = $_POST['clientObservation'];
//          Etape 1 :
//              Avant l'ajout, on contrôle qu'aucun professionnel n'a un nom semblable.
                if (Pro_Mgr::checkIfExists($clientName) === 0) {
                    try {
//                      Récupère la prochaine valeur de l'auto-increment avant l'insert.
                        $resultBefore = Pro_Mgr::getLastAutoIncrementValue();
//                      Convertit le résultat en entier.
                        $lastValueBefore = (int) $resultBefore[0]["AUTO_INCREMENT"];
                        Pro_Mgr::createNewCustomer($userId, $clientActivityArea, $clientName, $clientDecisionMakerName, 
                                                $clientMainPhone, $clientSecondaryPhone, $clientMail, $clientMainAdress, 
                                                $clientSecondaryAdress, $clientCp, $clientCity, $clientObservation );
//                      Récupère la prochaine valeur de l'auto-increment après l'insert.
                        $resultAfter = Pro_Mgr::getLastAutoIncrementValue();
//                      Convertit le résultat en entier.
                        $lastValueAfter = (int) $resultAfter[0]["AUTO_INCREMENT"];
//          Etape 2 :
                        if ($lastValueAfter === ($lastValueBefore + 1)) {
                            $emptyName = '';
                            $emptyContact = '';
                            InfosInterlocutor_Mgr::createInterlocutorInfos($emptyName, $emptyContact);
//                          Récupère la prochaine valeur de l'auto-increment après l'insert.
                            $lastIdInfosAfter = InfosInterlocutor_Mgr::getLastAutoIncrementValue();
//                          Convertit le résultat en entier.
                            $infosInterlocutorIdValue = (int) $lastIdInfosAfter[0]["AUTO_INCREMENT"];
//                          Récupère l'identifiant du dernier insert de la table 'infos_interlocuteur'.
                            $infoInterlocutorId = $infosInterlocutorIdValue - 1;
//          Etape 3 :
//                          Récupère la date du jour et là retourne au format Unix sous forme de String.
                            $lastContactDate = Dates_Mgr::nowToUnixString();
//                          Récupère l'identifiant de l'interlocuteur "Autre" pour l'affecter au suivi.
                            $getInterlocutorId = Contacting_Mgr::getIdInterlocutorTypeWhereCaseIsOther();
                            $interlocutorId = (int) $getInterlocutorId[0]['ID_interlocuteur'];
//                          Récupère l'identifiant du type de contact "Autre" pour l'affecter au suivi.
                            $getContactTypeId = Contacting_Mgr::getIdContactTypeWhereCaseIsOther();
                            $contactTypeId = (int) $getContactTypeId[0]['ID_nature'];
//                          Récupère l'identifiant de la conclusion "Création client" pour l'affecter au suivi.
                            $getConclusionId = Conclusions_Mgr::getIdConclusionWhereCaseIsCreateCustomer();
                            $conclusionId = (int) $getConclusionId[0]['ID_conclusion'];
//                          Enregistre le message commentaire automatique pour la création d'un suivi lors de l'enregistrement d'un client.
                            $comment = 'Enregistrement du client dans la base de données.';
                            Contacting_Mgr::createNewContactWhenAddedCustomer($userId, $lastValueBefore, $interlocutorId, 
                                                                            $infoInterlocutorId, $contactTypeId, $conclusionId, 
                                                                            $comment, $lastContactDate);
                        }
                        $msg = '<div class="text-center" style="color: #3bf6a2">Nouveau client enregistré.</div>';
                    } catch (Exception $e) {
                        $msg = '<div class="text-center" style="color: #E84E0E">Erreur : Echec de l\'enregistrement.</div>';
                        require($header);
                        echo($msg);
                        require($addNewClientForm);
                        require($footer);
                        break; 
                    }
                }
                require($header);
                echo($msg);
                require($clientsListing);
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
                $msg = '<div class="text-center" style="color: #3bf6a2">Les informations ont bien été mises à jour !</div>';
                if ((int) $_POST['prospect_ou_client'] > 0) {
                    require($header);
                    echo($msg);
                    require($clientsListing);
                    require($footer);
                    break;
                } else {
                    require($header);
                    echo($msg);
                    require($prospectListing);
                    require($footer);
                    break;
                }
//          CREATE => [FORM]
            case 'addNewContactForm' : 
                require($header);
                require($addNewContactForm);
                require($footer);
                break;
//          CREATE => [ON SUBMIT]
            case 'addedNewContact' :
                $idPro = (int) $_POST['ID_professionnel'];
                $idUser = (int) $_POST['ID_utilisateur'];
                $idInterlocutorType = (int) $_POST['idInterlocutorType'];
                $idContactType = (int) $_POST['idContactType'];
                $contactConclusion = (int) $_POST['contactConclusion'];
                $meetingCalendar = $_POST['meetingCalendar'];
                $recallCalendar = $_POST['recallCalendar'];
                $contactComment = $_POST['contactComment'];
                $proMail = Pro_Mgr::getProMail($idPro);
                $proDecisionMakerName = Pro_Mgr::getDecisionMakerName($idPro);
                $proDecisionMakerName = $proDecisionMakerName[0]['nom_decideur'];
/*
                Attention au typage : 
                Les données concernant l'interlocuteur ne sont pas "requises", par conséquent, des
                valeurs NULL peuvent être envoyées en BDD. Nous contrôlons ici si les variables sont
                vides ou non en fonction des champs du formulaire dynamique. 
                Si elles le sont, nous envoyons des chaînes vides à la fonction 'createInterlocutorInfos'
                qui elle, se chargera d'envoyer NULL si elle reçoit des chaînes vides en paramètre.
*/              
                switch ($idInterlocutorType) {
                    case 1 :
                        if ($idContactType === 3) {
                            if ((isset($_POST['proTel'])) AND ($_POST['proTel'] === 'otherPhone')) {
                                if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                                    $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                                } else {
                                    $contactInterlocutorInfo = '';
                                }
                            } else {
                                $contactInterlocutorInfo = $_POST['proTel'];
                            }
                        } elseif ($idContactType === 4) {
                            if ((isset($_POST['contactInterlocutorInfoMail'])) AND ($_POST['contactInterlocutorInfoMail'] === $proMail)) {
                                $contactInterlocutorInfo = $proMail;
                            } elseif ($_POST['contactInterlocutorInfoMail'] === '') {
                                $contactInterlocutorInfo = '';
                            } else {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoMail'];
                            }
                        } else {
                            $contactInterlocutorInfo = '';
                        } 
                        $contactInterlocutorName = $proDecisionMakerName;
                        break;
                    case 2 :
                        if (isset($_POST['contactInterlocutorName'])) {
                            $contactInterlocutorName = $_POST['contactInterlocutorName'];
                        }
                        if ($idContactType === 3) {
                            if ((isset($_POST['proTel'])) AND ($_POST['proTel'] === 'otherPhone')) {
                                if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                                    $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                                } else {
                                    $contactInterlocutorInfo = '';
                                }
                            } else {
                                $contactInterlocutorInfo = $_POST['proTel'];
                            }
                        } elseif ($idContactType === 4) {
                            if ((isset($_POST['contactInterlocutorInfoMail'])) AND ($_POST['contactInterlocutorInfoMail'] === $proMail)) {
                                $contactInterlocutorInfo = $proMail;
                            } elseif ($_POST['contactInterlocutorInfoMail'] === '') {
                                $contactInterlocutorInfo = '';
                            } else {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoMail'];
                            }
                        } else {
                            $contactInterlocutorInfo = '';
                        } 
                        break;
                    case 3 :
                        $idContactType = 3;
                        if ((isset($_POST['proTel'])) AND ($_POST['proTel'] === 'otherPhone')) {
                            if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                            } else {
                                $contactInterlocutorInfo = '';
                            }
                        } else {
                            $contactInterlocutorInfo = $_POST['proTel'];
                        }
                        $contactInterlocutorName = '';
                        break;
                    case 4 :
                        if (isset($_POST['contactInterlocutorName'])) {
                            $contactInterlocutorName = $_POST['contactInterlocutorName'];
                        }
                        if ($idContactType === 3) {
                            if ((isset($_POST['proTel'])) AND ($_POST['proTel'] === 'otherPhone')) {
                                if ((isset($_POST['contactInterlocutorInfoTel'])) AND ($_POST['contactInterlocutorInfoTel'] != '')) {
                                    $contactInterlocutorInfo = $_POST['contactInterlocutorInfoTel'];
                                } else {
                                    $contactInterlocutorInfo = '';
                                }
                            } else {
                                $contactInterlocutorInfo = $_POST['proTel'];
                            }
                        } elseif ($idContactType === 4) {
                            if ((isset($_POST['contactInterlocutorInfoMail'])) AND ($_POST['contactInterlocutorInfoMail'] === $proMail)) {
                                $contactInterlocutorInfo = $proMail;
                            } elseif ($_POST['contactInterlocutorInfoMail'] === '') {
                                $contactInterlocutorInfo = '';
                            } else {
                                $contactInterlocutorInfo = $_POST['contactInterlocutorInfoMail'];
                            }
                        } else {
                            $contactInterlocutorInfo = '';
                        } 
                        break;
                }
                InfosInterlocutor_Mgr::createInterlocutorInfos($contactInterlocutorName, $contactInterlocutorInfo);
//              Récupère la prochaine valeur de l'auto-increment après l'insert.
                $lastIdInfosAfter = InfosInterlocutor_Mgr::getLastAutoIncrementValue();
//              Convertit le résultat en entier.
                $infosInterlocutorIdValue = (int) $lastIdInfosAfter[0]["AUTO_INCREMENT"];
//              Récupère l'identifiant du dernier insert de la table 'infos_interlocuteur'.
                $infoInterlocutorId = $infosInterlocutorIdValue - 1;
//              Récupère la date du jour et là retourne au format Unix sous forme de String.
                $lastContactDate = Dates_Mgr::nowToUnixString();
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
                if ($contactConclusion === 8) {
                    Pro_Mgr::prospectBecomeClient($idPro);
                }
                $msg = '<div class="text-center" style="color: #3bf6a2">Nouvelle prise de contact enregistrée !</div>';
                require($header);  
                echo($msg);
                require($proActivity);
                require($footer);
                break;
            case 'updateContact' :
                require($header);
                require($updateContactForm);
                require($footer);
                break;
            case 'updatedContact' :
                $idContact = (int) $_POST['ID_suivre'];
                $oldComment = $_POST['commentaire'];
                if (isset($_POST['majRecallCalendar'])) {
                    if (($_POST['majRecallCalendar'] != NULL) AND ($_POST['majRecallCalendar']!= '')) {
//                      On convertit la date saisie depuis le calendrier de mise à jour en UNIX.
                        $selectedDate = Dates_Mgr::paramToUnixString($_POST['majRecallCalendar']);
                        $newDate = Dates_Mgr::dateFormatDayMonthYear($selectedDate);
//                      On récupère la date du jour.
                        $today = Dates_Mgr::dateFormatDayMonthYear(Dates_Mgr::nowToUnixString());
/*
                        On détermine que la mise à jour ne sera faite que si et seulement si
                        le jour de relance choisi par l'utilisateur est ultérieur ou égal 
                        à la date du jour.  
*/                      
                        if ($newDate >= $today) {
                            Contacting_Mgr::updateRecallDate($selectedDate, $idContact);
                            $msg = '<div class="text-center" style="color: #3bf6a2">La date de relance a bien été modifiée !</div>';
                        } else {
                            $msg = '<div class="text-center" style="color: #E84E0E">Erreur : La date saisie ne doit pas être antérieure ou égale à celle d\'aujourd\'hui.</div>';
                        }
                    } 
                } elseif (isset($_POST['majMeetingCalendar'])) {
                    if (($_POST['majMeetingCalendar'] != NULL) AND ($_POST['majMeetingCalendar'] != '')) {
//                      On convertit la date saisie depuis le calendrier de mise à jour en UNIX.
                        $newDate = Dates_Mgr::paramToUnixString($_POST['majMeetingCalendar']);
//                      On récupère la valeur UNIX du moment présent.
                        $now = Dates_Mgr::nowToUnixString();
/*
                        On détermine que la mise à jour ne sera faite que si et seulement si
                        le jour de rdv choisi par l'utilisateur est ultérieur ou égal 
                        à la date du jour.  
*/    
                        if ($newDate > $now) {
                            if (isset($_POST['oldDate'])) {
                                $oldDateUnix = (String) $_POST['oldDate'];
                                $oldDate = Dates_Mgr::dateFormatDayMonthYear($oldDateUnix);
                            } else {
                                $oldDate = '';
                            }
                            $newComment = '(Rendez-vous du '.$oldDate.' décalé)'.' - '.$oldComment.'';
                            Contacting_Mgr::updateMeetingDate($newComment, $newDate, $idContact);
                            $msg = '<div class="text-center" style="color: #3bf6a2">La date de rendez-vous a bien été modifiée !</div>';
                        } else {
                            $msg = '<div class="text-center" style="color: #E84E0E">Erreur : La date saisie ne doit pas être antérieure ou égale à celle d\'aujourd\'hui.</div>';
                        }
                    }
                }
                require($header);
                echo($msg);
                require($proActivity);
                require($footer);
                break;
        }
    } else header('Location: ../index.php');
?>