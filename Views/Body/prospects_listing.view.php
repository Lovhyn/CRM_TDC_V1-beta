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
        <h2>Prospects</h2>
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
            '<input type="hidden" name="action" value="addNewProspectForm">
            <button type="submit" class="addNewProspectIcon" title="Enregistrer un nouveau prospect">
                <i class="fas fa-user-secret"></i>
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
                        <input type="hidden" name="action" value="prospectsListing">
                        <label for="USERFILTER">Suivi par :</label>
                        <select class="form-select" name="selectedUser" id="USERFILTER" onchange="this.form.submit()">
                            <option selected value="0">Aucun filtre</option>
<?php 
//                  Permet le maintien en "selected" du filtrage par nom séléctionné par l'utilisateur.
//                  Puis génère la liste des utilisateurs dans la select-box.
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
                        <input type="hidden" name="action" value="prospectsListing">
<?php
//                  Détermine la date pré-remplie en fonction de si le filtre (variable de session a été initialisé).
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
                        <input type="hidden" name="action" value="prospectsListing">
<?php
//                  Détermine la date pré-remplie en fonction de si le filtre (variable de session a été initialisé).
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
                    <th>Décideur</th>
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
            Si la date de départ n'est pas paramétrée ou qu'elle a été réinitialisée sur le calendrier :
            On définit comme date de départ la date de la plus ancienne prise de contact effectuée.
*/         
            $startDateFilter = (string) $oldestContactDate;
        } else {
//          Sinon, on définit la date de départ à la date sélectionnée par l'utilisateur connecté.
            $startDateFilter = Dates_Mgr::paramToUnixString($_SESSION['filterByStartDate']);
        }
        if ((is_null($_SESSION['filterByEndDate'])) OR ($_SESSION['filterByEndDate'] === '')) {
/*
            Si la date de fin n'est pas paramétrée ou qu'elle a été réinitialisée sur le calendrier :
            On définit comme date d'arrivée la date de la dernière prise de contact effectuée.
*/
            $endDateFilter = (string) $lastContactDate;
        } else {
//          Sinon, on définit la date d'arrivée à la date sélectionnée par l'utilisateur connecté.
            $endDateFilter = Dates_Mgr::paramToUnixString($_SESSION['filterByEndDate']);
        }
//      Récupère la liste des prospects selon le(s) paramètre(s) de filtrage actuellement(s) défini(s).
        $tProspects = Pro_Mgr::getFilteredProspectsList($userFilter, 
                                                        $startDateFilter, 
                                                        $endDateFilter);
    } else {
//          Sinon, charge la liste complète sans aucun filtre.
            $tProspects = Pro_Mgr::getFullProspectsList();
    }
    foreach($tProspects as $tProspect) {
        $tInfosLastContact = Contacting_Mgr::getInfosContactWhereDateIs($tProspect['date_derniere_pdc']);

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°

//          Si l'utilisateur n'est pas un administrateur

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
        if ($rights != 1) {
            echo
            '<tr>
                <td>';
//              Si l'utilisateur est un responsable ou un chargé de projet, affiche =>
                if ($rights === 2) {
                    echo
                    '<form action="/outils/Controllers/Controller_responsable.php" method="post">';
                } else {
                    echo
                    '<form action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
                        echo
                        '<input type="hidden" name="ID_professionnel" value="'.$tProspect['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProspect['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProspect['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tProspect['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tProspect['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tProspect['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tProspect['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tProspect['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tProspect['cp'].'">
                        <input type="hidden" name="ville" value="'.$tProspect['ville'].'">
                        <input type="hidden" name="mail" value="'.$tProspect['mail'].'">
                        <input type="hidden" name="tel" value="'.$tProspect['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tProspect['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tProspect['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tProspect['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tProspect['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProspect['prospect_ou_client'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tProspect['date_derniere_pdc'].'">
                        <input type="hidden" name="action" value="fullInfosPro">
                        <input class="fullInfosBtn" type="submit" title="Voir fiche détaillée du prospect" value="'.$tProspect['libelle_entreprise'].'">
                    </form>
                </td>';
                if ($tProspect['nom_decideur'] != '') {
                    echo'<td>'.$tProspect['nom_decideur'].'</td>';
                } else {
                    echo'<td class="text-center">'.($unknown).'</td>';
                }
                echo
                '<td>'.$tProspect['suivi'].'</td>
                <td title="'.$tInfosLastContact[0]['commentaire'].'">'.$tInfosLastContact[0]['libelle_conclusion'].'</td>
                <td>'.$lastContactDate = Dates_Mgr::dateFormatDayMonthYear($tProspect['date_derniere_pdc']).'</td>
                <td>';
/*                  
                Un chargé de projet ou un responsable peut consulter tous les prospects / clients de la base de données
                Mais ne peut modifier que ceux dont il est en charge du suivi.
*/
                if ($userConnected == $tProspect['ID_utilisateur']) {
                    if ($rights === 2) {
                        echo
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_responsable.php" method="post">';
                    } else {
                        echo 
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_cdp.php" method="post">';
                    }
                    echo
                        '<input type="hidden" name="ID_professionnel" value="'.$tProspect['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProspect['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProspect['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tProspect['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tProspect['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tProspect['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tProspect['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tProspect['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tProspect['cp'].'">
                        <input type="hidden" name="ville" value="'.$tProspect['ville'].'">
                        <input type="hidden" name="mail" value="'.$tProspect['mail'].'">
                        <input type="hidden" name="tel" value="'.$tProspect['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tProspect['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tProspect['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tProspect['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tProspect['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProspect['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="updatePro">
                        <button class="updIcon" type="submit" title="Modifier / Ajouter des informations sur le prospect">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>';
                } else {
                    echo'
                        <div title="Vous n\'êtes pas en charge de ce suivi" class="d-flex justify-content-center">
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
                        '<input type="hidden" name="ID_professionnel" value="'.$tProspect['ID_professionnel'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProspect['ID_utilisateur'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProspect['libelle_entreprise'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProspect['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="proActivity">
                        <button class="followIcon" type="submit" title="Voir le suivi">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
                <td>';
                if ($tProspect['tel'] != '') {
                    echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tProspect['tel'].'" href="tel:'.$tProspect['tel'].'">
                                <i class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>';
                } else {
                    echo
                    '<div class="d-flex justify-content-center">
                        <div class="phoneIconNoRights">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>';
                }
                '</td>
            </tr>';
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°

//          Sinon, l'utilisateur connecté est "forcément" un administrateur.

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
        } else {
            echo
            '<tr>
                <td>
                    <form action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tProspect['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProspect['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProspect['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tProspect['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tProspect['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tProspect['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tProspect['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tProspect['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tProspect['cp'].'">
                        <input type="hidden" name="ville" value="'.$tProspect['ville'].'">
                        <input type="hidden" name="mail" value="'.$tProspect['mail'].'">
                        <input type="hidden" name="tel" value="'.$tProspect['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tProspect['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tProspect['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tProspect['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tProspect['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProspect['prospect_ou_client'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tProspect['date_derniere_pdc'].'">
                        <input type="hidden" name="action" value="fullInfosPro">
                        <input class="fullInfosBtn" type="submit" title="Voir fiche détaillée du prospect" value="'.$tProspect['libelle_entreprise'].'">
                    </form>
                </td>';
                if ($tProspect['nom_decideur'] != '') {
                    echo'<td>'.$tProspect['nom_decideur'].'</td>';
                } else {
                    echo'<td class="text-center">'.($unknown).'</td>';
                }
                echo
                '<td>'.$tProspect['suivi'].'</td>
                <td title="'.$tInfosLastContact[0]['commentaire'].'">'.$tInfosLastContact[0]['libelle_conclusion'].'</td>
                <td>'.$lastContactDate = Dates_Mgr::dateFormatDayMonthYear($tProspect['date_derniere_pdc']).'</td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tProspect['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProspect['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProspect['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tProspect['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tProspect['prenom'].'">
                        <input type="hidden" name="ID_secteur" value="'.$tProspect['ID_secteur'].'">
                        <input type="hidden" name="libelle_secteur" value="'.$tProspect['libelle_secteur'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tProspect['nom_decideur'].'">
                        <input type="hidden" name="cp" value="'.$tProspect['cp'].'">
                        <input type="hidden" name="ville" value="'.$tProspect['ville'].'">
                        <input type="hidden" name="mail" value="'.$tProspect['mail'].'">
                        <input type="hidden" name="tel" value="'.$tProspect['tel'].'">
                        <input type="hidden" name="tel_2" value="'.$tProspect['tel_2'].'">
                        <input type="hidden" name="adresse" value="'.$tProspect['adresse'].'">
                        <input type="hidden" name="adresse_2" value="'.$tProspect['adresse_2'].'">
                        <input type="hidden" name="observation" value="'.$tProspect['observation'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProspect['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="updatePro">
                        <button class="updIcon" type="submit" title="Modifier / Ajouter des informations sur le prospect">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="ID_professionnel" value="'.$tProspect['ID_professionnel'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProspect['ID_utilisateur'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProspect['libelle_entreprise'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProspect['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="proActivity">
                        <button class="followIcon" type="submit" title="Voir le suivi">
                            <i class="fas fa-glasses"></i>
                        </button>
                    </form>
                </td>
                <td>';
                if ($tProspect['tel'] != '') {
                echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tProspect['tel'].'" href="tel:'.$tProspect['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
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