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
                if (isset($_POST['newProspectName'])) { 
                    if (Pro_Mgr::checkIfExists($_POST['newProspectName']) > 0) {
                        $_POST = array();
                        require("../Views/Header/header_cdp.view.php");
                        echo('<div class="text-center" style="color: #E84E0E">Erreur : un professionnel du même nom existe déjà.</div>');
                        require("../Views/Body/add_new_prospect.view.php");
                        require("../Views/Footer/footer.view.php");
                        break;  
                    } 
                } else {
                    require("../Views/Header/header_cdp.view.php");
                    require("../Views/Body/add_new_prospect.view.php");
                    require("../Views/Footer/footer.view.php");
                    break;
                }
            case 'myProspectsListing' : 
                if (isset($_POST['newProspectName']) AND ($_POST['newProspectName'] != NULL)) {
                    if (Pro_Mgr::checkIfExists($_POST['newProspectName']) != 0) { 
                        $_POST = array();
                        require("../Views/Header/header_cdp.view.php");
                        echo('<div class="text-center" style="color: #E84E0E">Erreur : un professionnel du même nom existe déjà.</div>');
                        require("../Views/Body/add_new_prospect.view.php");
                        require("../Views/Footer/footer.view.php");
                        break; 
                    } else {
                        echo('hello');
                        $followedBy = (int) $_SESSION['idUser'];       
                        $newProspectName = $_POST['newProspectName'];
                        $newProspectDecisionMakerName = $_POST['newDecisionMakerName'];
                        $newProspectActivityArea = $_POST['newActivityArea'];
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
                        $calendar = $_POST['calendar'];
                        $newContactComment = $_POST['newContactComment'];
                        Pro_Mgr::createNewPro($followedBy, $newProspectActivityArea, $newProspectName, 
                                            $newProspectDecisionMakerName, $newProspectMainPhone, 
                                            $newProspectSecondaryPhone, $newProspectMail, 
                                            $newProspectMainAdress, $newProspectSecondaryAdress, 
                                            $newProspectCP, $newProspectCity, $newProspectObservation);
                        $_POST = array();
                        var_dump($_POST['newProspectName']);
//                      On récupère la valeur du statut de l'auto-increment dans la table.
                        // $lastProRegistered = (Pro_Mgr::getLastAutoIncrementValue());
                        // echo($lastProRegistered) . '<br/>'; 
                        // echo(gettype($lastProRegistered)) . '<br/><br/>'; 
                        // Contacting_Mgr::createNewContact($followedBy,)
                        require("../Views/Header/header_cdp.view.php");
                        require("../Views/Body/my_prospects_listing.view.php");
                        require("../Views/Footer/footer.view.php");
                        break;
                    }
                } elseif (is_null($_POST['newProspectName'])) {
                    echo('bonjour');
                    require("../Views/Header/header_cdp.view.php");
                    require("../Views/Body/my_prospects_listing.view.php");
                    require("../Views/Footer/footer.view.php");
                    break; 
                }
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