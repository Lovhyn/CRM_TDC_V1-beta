<?php
    session_start();
    if ($_SESSION['rights'] === '2') {
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

        switch ($action) {
            case 'home':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/home_responsable.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myProspectsActivity':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/my_prospects_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myClientsActivity':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/my_clients_activity.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myContactRecalls':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/my_contact_recalls.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'myMeetingRecalls':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/my_meeting_recalls.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'prospectsListing':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/prospects_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'clientsListing':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/clients_listing.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'activityAreaManagement':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/activity_area_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
            case 'conclusionsManagement':
                require("../Views/Header/header_responsable.view.php");
                require("../Views/Body/conclusions_management.view.php");
                require("../Views/Footer/footer.view.php");
                break;
        }
    } else header('Location: ../index.php');
?>