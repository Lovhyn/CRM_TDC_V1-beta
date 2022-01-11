<?php
//  Charge automatiquement toutes les classes du dossier Models.
    spl_autoload_register(function ($classe) {
        include "../Models/" . $classe . ".class.php";
    });
    if ((isset($_POST['userMail'])) && isset($_POST['userPassword'])) {
        $userMail = $_POST['userMail'];
        $userPassword = $_POST['userPassword'];
    } 

//  Initialisation des variables.
    $userExists = false;
    $userId = '';
    $userName = '';
    $userSurname = '';
    $userRights = '';
    $userRole = '';
    $userInfo = [$userName, $userSurname, $userRights, $userRole, $userMail, $userPassword];
    $users = User_Mgr::getUsersList();

//  On parcourt le tableau d'utilisateurs récupéré par la méthode getUsersList.
    foreach($users as $user) {
        if ($userMail == $user['mail']) {
//          La méthode md5() permet de comparer les deux mots de passe après hashage.
            if (md5($userPassword) == $user['mot_de_passe']) {
/*
                Récupère et stocke dans des variables les informations 
                de chaque utilisateur afin de les afficher dynamiquement 
                par la suite côté HTML.
*/   
                $userId = $user['ID_utilisateur'];
                $userName = $user['nom'];
                $userSurname = $user['prenom'];
                $userRights = $user['ID_droit'];
                $userRole = $user['libelle_droit'];
                $userExists = true;
                break;
            }  
        }
    } 
    if ($userExists === false) {
        header('Location: ../errorAuth.php');
    }

    switch ($userRights) {
//      Cas "Administrateur"
        case '1':
            session_start();
            $_SESSION['idUser'] = $userId;
            $_SESSION['nameUserConnected'] = $userName;
            $_SESSION['surnameUserConnected'] = $userSurname;
            $_SESSION['rights'] = $userRights;
            $_SESSION['role'] = $userRole;
            require("../Views/Header/header_admin.view.php");
            require("../Views/Body/home_admin.view.php");
            require("../Views/Footer/footer.view.php");
            break;
//      Cas "Responsable"
        case '2':        
            session_start();
            $_SESSION['idUser'] = $userId;
            $_SESSION['nameUserConnected'] = $userName;
            $_SESSION['surnameUserConnected'] = $userSurname;
            $_SESSION['rights'] = $userRights;
            $_SESSION['role'] = $userRole;
            require("../Views/Header/header_responsable.view.php");
            require("../Views/Body/home_responsable.view.php");
            require("../Views/Footer/footer.view.php");
            break;
//      Cas "Chargé(e) de projet"
        case '3':
            session_start();
            $_SESSION['idUser'] = $userId;
            $_SESSION['nameUserConnected'] = $userName;
            $_SESSION['surnameUserConnected'] = $userSurname;
            $_SESSION['rights'] = $userRights;
            $_SESSION['role'] = $userRole;
            require("../Views/Header/header_cdp.view.php");
            require("../Views/Body/home_cdp.view.php");
            require("../Views/Footer/footer.view.php");
            break;
    }
?>

