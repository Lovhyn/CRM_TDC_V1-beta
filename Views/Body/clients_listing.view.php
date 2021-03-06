<?php
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
$unknown = ' - ';
$oldestContactDate = Contacting_Mgr::getOldestContactingDate()[0]['oldestContact'];
$lastContactDate = Contacting_Mgr::getLastContactingDate()[0]['lastContact'];
//INITIALISATION DES VARIABLES DE SESSION (FILTRES).
if (isset($_POST['selectedUser'])) {
    $_SESSION['filterByUser'] = $_POST['selectedUser'];
} 
if (isset($_POST['startFilterDate'])) {
    $_SESSION['filterByStartDate'] = $_POST['startFilterDate'];
}
if (isset($_POST['endFilterDate'])) {
    $_SESSION['filterByEndDate'] = $_POST['endFilterDate'];
}
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2>Clients</h2>
    </div>
<?php 
if ($rights != 1 ) {
    if($rights === 2) {
        echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_responsable.php" method="post">';
    } else {
        echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_cdp.php" method="post">';
    }
} else {
    echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php" method="post">';
}
    echo
            '<input type="hidden" name="action" value="addNewClientForm">
            <button type="submit" class="addNewClientIcon" title="Enregistrer un nouveau client">
                <i class="fas fa-user-tie"></i>
            </button>
        </form>';
?>
    <div class="table-responsive">
        <div class="mt-4 filters w-100 d-flex justify-content-center">
<?php
        $tUsers = User_Mgr::getUndetailledUsersList();
?>
            <div class="w-100 d-md-flex flex-md-row justify-content-md-between
                            d-xs-flex flex-xs-column justify-content-xs-start">
                <div id="filterByUser">
<?php
                    if ($rights === 1) {
                        echo
                            '<form action="/outils/Controllers/Controller_admin.php" method="post">';
                    } elseif ($rights === 2) {
                        echo
                            '<form action="/outils/Controllers/Controller_responsable.php" method="post">';
                    } else {
                        echo
                            '<form action="/outils/Controllers/Controller_cdp.php" method="post">';
                    }
?>
                        <input type="hidden" name="action" value="clientsListing">
                        <label for="USERFILTER">Suivi par :</label>
                        <select class="form-select" name="selectedUser" id="USERFILTER" onchange="this.form.submit()">
                            <option selected value="0">Aucun filtre</option>
<?php 
//                  Permet le maintien en "selected" du filtrage par nom s??l??ctionn?? par l'utilisateur.
//                  Puis g??n??re la liste des utilisateurs dans la select-box.
                    foreach($tUsers as $tUser) {
                        echo '<option ';
                        if (($_SESSION['filterByUser']) AND ($_SESSION['filterByUser'] != '0')) {
                            if ((int) $tUser['ID_utilisateur'] === (int) $_SESSION['filterByUser']) {
                                echo ' selected';
                            } 
                        }
                        echo ' value="'.$tUser['ID_utilisateur'].'">'.$tUser['nom'].' '.$tUser['prenom'].'</option>';
                    }
?>
                        </select>
                    </form>
                </div>
<!-- (filtre) CALENDRIER DATE DE DEPART-->
                <div id="filterStartDate">
<?php
                if ($rights === 1) {
                    echo
                    '<form action="/outils/Controllers/Controller_admin.php" method="post">';
                } elseif ($rights === 2) {
                    echo
                    '<form action="/outils/Controllers/Controller_responsable.php" method="post">';
                } else {
                    echo
                    '<form action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
?>
                        <label for="STARTDATE">Entre : </label>
                        <input type="hidden" name="action" value="clientsListing">
<?php
//                  D??termine la date pr??-remplie en fonction de si le filtre (variable de session a ??t?? initialis??).
                    if ($_SESSION['filterByStartDate']) {
                        echo
                        '<input class="form-select" type="date" name="startFilterDate" value="'.$_SESSION['filterByStartDate'].'" id="STARTDATE" onchange="this.form.submit()">';
                    } else {
                        echo 
                        '<input class="form-select" type="date" name="startFilterDate" id="STARTDATE" onchange="this.form.submit()">';
                    }
?>
                    </form>
                </div>
<!-- (filtre) CALENDRIER DATE DE FIN-->
                <div id="filterEndDate">
<?php
                if ($rights === 1) {
                    echo
                    '<form action="/outils/Controllers/Controller_admin.php" method="post">';
                } elseif ($rights === 2) {
                    echo
                    '<form action="/outils/Controllers/Controller_responsable.php" method="post">';
                } else {
                    echo
                    '<form action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
?>
                        <label for="ENDDATE">Et :</label>
                        <input type="hidden" name="action" value="clientsListing">
<?php
//                  D??termine la date pr??-remplie en fonction de si le filtre (variable de session a ??t?? initialis??).
                    if ($_SESSION['filterByEndDate']) {
                        echo
                        '<input class="form-select" type="date" name="endFilterDate" value="'.$_SESSION['filterByEndDate'].'" id="ENDDATE" onchange="this.form.submit()">';
                    } else {
                        echo
                        '<input class="form-select" type="date" name="endFilterDate" id="ENDDATE" onchange="this.form.submit()">';
                    }
?>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-hover table-striped table-dark w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true">Nom</th>
                    <th>D??cideur</th>
                    <th data-sortable="true">Suivi par</th>
                    <th data-sortable="true">Dernier contact</th>
                    <th class="text-center" data-sortable="true">Date</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
<?php
//  Si au moins l'une des trois variables existe :
    if (($_SESSION['filterByUser']) OR ($_SESSION['filterByStartDate']) OR ($_SESSION['filterByEndDate'])) {
        if ((is_null($_SESSION['filterByUser'])) OR ($_SESSION['filterByUser'] === "0")) {
            $userFilter = '0';
        } else {
            $userFilter = $_SESSION['filterByUser'];
        }
        if ((is_null($_SESSION['filterByStartDate'])) OR ($_SESSION['filterByStartDate'] === '')) {
/*
            Si la date de d??part n'est pas param??tr??e ou qu'elle a ??t?? r??initialis??e sur le calendrier :
            On d??finit comme date de d??part la date de la plus ancienne prise de contact effectu??e.
*/         
            $startDateFilter = (string) $oldestContactDate;
        } else {
//          Sinon, on d??finit la date de d??part ?? la date s??lectionn??e par l'utilisateur connect??.
            $startDateFilter = Dates_Mgr::paramToUnixString($_SESSION['filterByStartDate']);
        }
        if ((is_null($_SESSION['filterByEndDate'])) OR ($_SESSION['filterByEndDate'] === '')) {
/*
            Si la date de fin n'est pas param??tr??e ou qu'elle a ??t?? r??initialis??e sur le calendrier :
            On d??finit comme date d'arriv??e la date de la derni??re prise de contact effectu??e.
*/
            $endDateFilter = (string) $lastContactDate;
        } else {
//          Sinon, on d??finit la date d'arriv??e ?? la date s??lectionn??e par l'utilisateur connect??.
            $endDateFilter = Dates_Mgr::paramToUnixString($_SESSION['filterByEndDate']);
        }
//      R??cup??re la liste des prospects selon le(s) param??tre(s) de filtrage actuellement(s) d??fini(s).
        $tCustomers = Pro_Mgr::getFilteredCustomersList($userFilter, 
                                                        $startDateFilter, 
                                                        $endDateFilter);
    } else {
//          Sinon, charge la liste compl??te sans aucun filtre.
            $tCustomers = Pro_Mgr::getFullCustomersList();
    }
    foreach($tCustomers as $tCustomer) {
        $tInfosLastContact = Contacting_Mgr::getInfosContactWhereDateIs($tCustomer['date_derniere_pdc']);

//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????

//          Si l'utilisateur n'est pas un administrateur

//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
        if ($rights != 1) {
            echo
            '<tr>
                <td>';
//              Si l'utilisateur est un responsable ou un charg?? de projet, affiche =>
                if ($rights === 2) {
                    echo
                    '<form action="/outils/Controllers/Controller_responsable.php" method="post">';
                } else {
                    echo
                    '<form action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
                        echo
                        '<input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tCustomer['date_derniere_pdc'].'">
                        <input type="hidden" name="action" value="fullInfosPro">
                        <input class="fullInfosBtn" type="submit" title="Voir fiche d??taill??e du client" value="'.$tCustomer['libelle_entreprise'].'">
                    </form>
                    </td>';
                if ($tCustomer['nom_decideur'] != '') {
                    echo'<td>'.$tCustomer['nom_decideur'].'</td>';
                } else {
                    echo'<td class="text-center">'.($unknown).'</td>';
                }
                echo
                '<td>'.$tCustomer['suivi'].'</td>
                <td title="'.$tInfosLastContact[0]['commentaire'].'">'.$tInfosLastContact[0]['libelle_conclusion'].'</td>
                <td>'.$lastContactDate = Dates_Mgr::dateFormatDayMonthYear($tCustomer['date_derniere_pdc']).'</td>
                <td>';
/*                  
                Un charg?? de projet ou un responsable peut consulter tous les prospects / clients de la base de donn??es
                Mais ne peut modifier que ceux dont il est en charge du suivi.
*/
                if ($userConnected === (int) $tCustomer['ID_utilisateur']) {
                    if ($rights === 2) {
                        echo
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_responsable.php" method="post">';
                    } else {
                        echo 
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_cdp.php" method="post">';
                    }
                    echo
                        '<input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="updatePro">
                        <button class="updIcon" type="submit" title="Modifier / Ajouter des informations sur le client">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>';
                } else {
                    echo'
                        <div title="Vous n\'??tes pas en charge de ce suivi" class="d-flex justify-content-center">
                            <div class="updIconNoRights">
                                <i class="far fa-edit"></i>
                            </div>
                        </div>';
                }
                echo
                '</td>
                <td>';
                if ($rights === 2) {
                    echo 
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_responsable.php" method="post">';
                        
                } else {
                    echo
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
                    echo 
                        '<input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="proActivity">
                        <button class="followIcon" type="submit" title="Voir le suivi">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
                <td>';
                if ($tCustomer['tel'] != '') {
                    echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tCustomer['tel'].'" href="tel:'.$tCustomer['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>';
                } else {
                    echo
                    '<div title="N?? de t??l??phone non renseign??" class="d-flex justify-content-center">
                        <div class="phoneIconNoRights">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>';
                }
                '</td>
            </tr>';
//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????

//          Sinon, l'utilisateur connect?? est "forc??ment" un administrateur.

//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
        } else {
            echo
            '<tr>
                <td>
                    <form action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tCustomer['date_derniere_pdc'].'">
                        <input type="hidden" name="action" value="fullInfosPro">
                        <input class="fullInfosBtn" type="submit" title="Voir fiche d??taill??e du client" value="'.$tCustomer['libelle_entreprise'].'">
                    </form> 
                </td>';
                if ($tCustomer['nom_decideur'] != '') {
                    echo'<td>'.$tCustomer['nom_decideur'].'</td>';
                } else {
                    echo'<td class="text-center">'.($unknown).'</td>';
                }
                echo
                '<td>'.$tCustomer['suivi'].'</td>
                <td title="'.$tInfosLastContact[0]['commentaire'].'">'.$tInfosLastContact[0]['libelle_conclusion'].'</td>
                <td>'.$lastContactDate = Dates_Mgr::dateFormatDayMonthYear($tCustomer['date_derniere_pdc']).'</td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tCustomer['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tCustomer['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tCustomer['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tCustomer['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tCustomer['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tCustomer['cp'].'">
                        <input type="hidden" name="ville" value="'.$tCustomer['ville'].'">
                        <input type="hidden" name="mail" value="'.$tCustomer['mail'].'">
                        <input type="hidden" name="tel" value="'.$tCustomer['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tCustomer['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tCustomer['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tCustomer['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tCustomer['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="updatePro">
                        <button class="updIcon" type="submit" title="Modifier / Ajouter des informations sur le client">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tCustomer['ID_professionnel'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tCustomer['ID_utilisateur'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tCustomer['libelle_entreprise'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tCustomer['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="proActivity">
                        <button class="followIcon" type="submit" title="Voir le suivi">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
                <td>';
                if ($tCustomer['tel'] != '') {
                echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tCustomer['tel'].'" href="tel:'.$tCustomer['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>';
                } else {
                    echo
                    '<div title="N?? de t??l??phone non renseign??" class="d-flex justify-content-center">
                        <div class="phoneIconNoRights">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>';
                }
                '</td>
            </tr>';
            }
        }
?>
        </table>
    </div>
</div>