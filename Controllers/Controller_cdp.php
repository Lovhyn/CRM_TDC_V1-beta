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
                var_dump($_POST);
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
                $newContactComment = $_POST['newContactComment'];
                $msg = '';
/*
                Manipule les dates de façon à entrer les dates de rendez-vous
                ou de relances sous forme de TimeStamp dans la base de données.
                
                Dans les deux cas où l'on récupère les dates depuis le calendrier 
                du formulaire au format String, il nous suffit de convertir le 
                résultat obtenu (Y-m-d) en TimeStamp avec la méthode strtotime.
*/
                if ((isset($_POST['meetingCalendar'])) AND ($newContactConclusion === '5')) {
                    $meetingDate = $_POST['meetingCalendar'];
                    $meetingTimeStampedDate = strtotime($meetingDate);
                    $recallTimeStampedDate = NULL;
                } elseif ((isset($_POST['recallCalendar'])) AND ($newContactConclusion === '7')) {
                    $recallDate = $_POST['recallCalendar'];
                    $recallTimeStampedDate = strtotime($recallDate);
                    $meetingTimeStampedDate = NULL;
                } else {
                    $meetingTimeStampedDate = NULL;
/*
                    Détermine les différentes automatisations de relances en fonction
                    de la conclusion sélectionnée par l'utilisateur.
*/                   
                    if ($newContactConclusion === '1') {
//                      On crée un nouvel objet date.
                        $currentDate = new DateTime();
//                      On crée un nouvel objet interval avec l'intervalle désiré en paramètre.
                        $interval  = new DateInterval('P3D');
//                      On enregistre dans une variable la valeur de l'intervalle ajouté à l'objet.
                        $recallDate = $currentDate->add($interval);
//                      On convertit la variable implémentée au format String.
                        $recallDateToString = $recallDate->format('Y-m-d');
//                      On convertit enfin la date de relance en TimeStamp
                        $recallTimeStampedDate = strtotime($recallDateToString);
                    }
                }                
                if (Pro_Mgr::checkIfExists($newProspectName) === 0) {
//                  Récupère la dernière valeur de l'auto-increment avant l'insert.
                    $resultBefore = Pro_Mgr::getLastAutoIncrementValue();
                    $lastValueBefore = (int) $resultBefore[0]["AUTO_INCREMENT"];
                    Pro_Mgr::createNewPro($followedBy, $newProspectActivityArea, $newProspectName, 
                                        $newProspectDecisionMakerName, $newProspectMainPhone, 
                                        $newProspectSecondaryPhone, $newProspectMail, 
                                        $newProspectMainAdress, $newProspectSecondaryAdress, 
                                        $newProspectCP, $newProspectCity, $newProspectObservation);
//                  Récupère la dernière valeur de l'auto-increment après l'insert.
                    $resultAfter = Pro_Mgr::getLastAutoIncrementValue();
                    $lastValueAfter = (int) $resultAfter[0]["AUTO_INCREMENT"];
/*
                    Contrôle que l'insert du professionnel a correctement été effectué
                    avant d'insérer un suivi dans la base de données.
*/                 
                    // if ($lastValueAfter === ($lastValueBefore + 1)) {
                    //     Contacting_Mgr::createNewContact($followedBy, $lastValueAfter, $newContactInterlocutor,
                    //                                     $newContactType, $newContactConclusion, $newContactComment, 
                    //                                     $meetingTimeStampedDate, $recallTimeStampedDate);
                    //                                     echo('youpi');
                    // }
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