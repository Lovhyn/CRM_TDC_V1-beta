<?php
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
// var_dump($_SESSION);
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2>Rendez-vous</h2>
    </div>
<?php
//  Récupère tous les rendez-vous du jour dans la base de données pour l'utilisateur donné en paramètre.
    $tPlannedMeetings = Contacting_Mgr::getAllPlannedMeetings($userConnected);
            
?>
    <div class="table-responsive">
        <div class="mt-4 filters w-100 d-flex justify-content-center">
            <table class="table table-hover table-striped table-dark w-auto"
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
                <thead>
                    <tr>
                        <th data-sortable="true">Nom</th>
                        <th>Décideur</th>
                        <th class="text-center" data-sortable="true">Date / Heure</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
<?php 
        $today = Dates_Mgr::dateFormatDayMonthYear(Dates_Mgr::nowToUnixString());
        foreach ($tPlannedMeetings as $tPlannedMeeting) {
/*
            On cherche à n'afficher que les rendez-vous du jour ou à venir, 
            On va donc comparer chaque date de rendez-vous enregistré en bdd en vérifiant qu'elle 
            est supérieure ou égale à celle du jour. (Valeurs UNIX).
*/                
            if  (Dates_Mgr::dateFormatDayMonthYear($tPlannedMeeting['date_rdv']) >= $today) {
                $meetingHour = Dates_Mgr::dateFormatDayMonthYearHourMinutesSeconds($tPlannedMeeting['date_rdv']);
                echo
                    '<tr>
                        <td title="'.$tPlannedMeeting['commentaire'].'">'.$tPlannedMeeting['libelle_entreprise'].'</td>
                        <td title="'.$tPlannedMeeting['commentaire'].'">'.$tPlannedMeeting['nom_decideur'].'</td>
                        <td title="'.$tPlannedMeeting['commentaire'].'">'.$meetingHour.'</td>
                        <td>';
                        if ($tPlannedMeeting['adresse'] != '') {
                            echo
                            '<div class="d-flex justify-content-center">
                                <button class="mapIcon">
                                    <a target="_blank" title="Voir itinéraire : '.$tPlannedMeeting['adresse'].', '.$tPlannedMeeting['cp'].', '.$tPlannedMeeting['ville'].'" 
                                        href="http://maps.google.com/maps?daddr='.$tPlannedMeeting['adresse'].' '.$tPlannedMeeting['cp'].' '.$tPlannedMeeting['ville'].'">
                                        <i class="fa-solid fa-car"></i>
                                    </a>
                                </button>
                            </div>';
                        } 
                        echo
                        '</td>
                        <td>';
                        if ($tPlannedMeeting['cp']) {
                            echo
                            '<div class="d-flex justify-content-center">';
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
                                    <input type="hidden" name="commentaire" value="'.$tPlannedMeeting['cp'].'">
                                    <button class="showProsIcon" type="submit" title="Modifier date de relance / date de rendez-vous">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </button>
                                </form>
                            </div>';
                        }
                        echo
                        '</td>
                        <td>';
                        if ($tPlannedMeeting['tel'] != '') {
                            echo
                            '<div class="d-flex justify-content-center">
                                <button class="phoneIcon">
                                    <a title="Appeler : '.$tPlannedMeeting['tel'].'" href="tel:'.$tPlannedMeeting['tel'].'">
                                        <i id="iconPhone" class="fas fa-phone"></i>
                                    </a>
                                </button>
                            </div>';
                        }   
                        echo
                        '</td>
                    </tr>';
            }
        }
?>
            </table>
        </div>
    </div>
</div>