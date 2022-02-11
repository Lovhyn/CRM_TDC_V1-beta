<?php
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
$unknown = '<td class="d-flex justify-content-center"> - </td>';
$noPhone = '<td>
                <div title="N° de téléphone non renseigné" class="d-flex justify-content-center">
                    <div class="phoneIconNoRights">
                        <i class="fas fa-phone"></i>
                    </div>
                </div>
            </td>';
$noCp = '<td>
            <div title="Code postal non renseigné" class="d-flex justify-content-center">
                <div class="showProsIconNoRights">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
            </div>
        </td>';
$noAdress = '<td>
                <div title="Adresse non renseignée" class="d-flex justify-content-center">
                    <div class="carIconNoRights">
                        <i class="fa-solid fa-car"></i>
                    </div>
                </div>
            </td>';
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2>Rendez-vous à venir</h2>
    </div>
<?php
//  Récupère tous les rendez-vous dans la base de données pour l'utilisateur donné en paramètre.
    $tPlannedMeetings = Contacting_Mgr::getAllPlannedMeetings($userConnected);
            
?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-dark w-auto"
            data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true">Nom</th>
                    <th>Décideur</th>
                    <th class="text-center" data-sortable="true">Date</th>
                    <th class="text-center" data-sortable="true">Heure</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
<?php 
$today = Dates_Mgr::dateFormatDayMonthYear(Dates_Mgr::nowToUnixString());
foreach ($tPlannedMeetings as $tPlannedMeeting) {
/*
    On cherche à afficher les rendez-vous du jour ou à venir, 
    On va donc comparer chaque date de rendez-vous enregistré en bdd en vérifiant qu'elle 
    est supérieure ou égale à celle du jour.
*/                
    if  (Dates_Mgr::dateFormatDayMonthYear($tPlannedMeeting['date_rdv']) >= $today) {
        $meetingDate = explode(" à ", Dates_Mgr::dateFormatDayMonthYearHourMinutesSeconds($tPlannedMeeting['date_rdv']));
        $meetingHour = explode(" à ", Dates_Mgr::dateFormatDayMonthYearHourMinutesSeconds($tPlannedMeeting['date_rdv']));
        echo
            '<tr>
                <td title="'.$tPlannedMeeting['commentaire'].'">'.$tPlannedMeeting['libelle_entreprise'].'</td>
                <td title="'.$tPlannedMeeting['commentaire'].'">'.$tPlannedMeeting['nom_decideur'].'</td>
                <td title="'.$tPlannedMeeting['commentaire'].'">'.$meetingDate[0].'</td>
                <td title="'.$tPlannedMeeting['commentaire'].'">'.$meetingHour[1].'</td>';
        if ($tPlannedMeeting['adresse'] != '') {
            echo
                '<td>
                    <div class="d-flex justify-content-center">
                        <button class="carIcon">
                            <a target="_blank" title="Voir itinéraire : '.$tPlannedMeeting['adresse'].', '.$tPlannedMeeting['cp'].', '.$tPlannedMeeting['ville'].'" 
                                href="http://maps.google.com/maps?daddr='.$tPlannedMeeting['adresse'].' '.$tPlannedMeeting['cp'].' '.$tPlannedMeeting['ville'].'">
                                <i class="fa-solid fa-car"></i>
                            </a>
                        </button>
                    </div>
                </td>';
        } else echo($noAdress); 
        if ($tPlannedMeeting['cp']) {
            echo
                '<td>
                    <div class="d-flex justify-content-center">';
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
                echo    
                            '<input type="hidden" name="action" value="allProsByCp">
                            <input type="hidden" name="cp" value="'.$tPlannedMeeting['cp'].'">
                            <button class="showProsIcon" type="submit" title="Voir tous les professionnels dont le code postal est '.$tPlannedMeeting['cp'].'">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </button>
                        </form>
                    </div>
                </td>';
        } else echo($noCp);
        if ($tPlannedMeeting['tel'] != '') {
            echo
                '<td>
                    <div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tPlannedMeeting['tel'].'" href="tel:'.$tPlannedMeeting['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>
                </td>';
        } else echo($noPhone);
        echo
            '</tr>';
    }
}
?>
        </table>
    </div>
</div>