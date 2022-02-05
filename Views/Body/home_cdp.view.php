<?php
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mb-2">
        <h2>Bonjour <?php echo($_SESSION['surnameUserConnected']);?></h2>
    </div>
    <div class="d-flex justify-content-center mb-4">
        <h4>Voici votre activité du jour :</h4>
    </div>
    <div class="w-100 d-md-flex flex-md-row justify-content-md-around
                    d-xs-flex flex-xs-column justify-content-xs-center">
        <div class="w-md-50 w-xs-100">
            <div class="d-flex justify-content-center">
                <h5>Rendez-vous :</h5>
            </div>
<?php 
//          Récupère tous les rendez-vous planifiés dans la base de données pour l'utilisateur donné en paramètre.
            $tPlannedMeetings = Contacting_Mgr::getAllPlannedMeetings($userConnected);
// var_dump($tPlannedMeetings);
?>
            <table class="table table-hover table-striped table-dark w-auto">
                <thead>
                    <tr>
                        <th>Avec</th>
                        <th>Quand ?</th>
                        <th class="text-center">Où ?</th>
                        <th class="text-center">Tel</th>
                    </tr>
                </thead>
<?php 
                foreach ($tPlannedMeetings as $tPlannedMeeting) {  
/*
                    On cherche à n'afficher que les rendez-vous du jour, 
                    On va donc comparer chaque date de rendez-vous enregistré en bdd avec la date du jour.

*/                
                    $meetingDate = Dates_Mgr::dateFormatDayMonthYear($tPlannedMeeting['date_rdv']);
                    $today = Dates_Mgr::dateFormatDayMonthYear(Dates_Mgr::nowToUnixString()); 
                    if  (Dates_Mgr::dateFormatDayMonthYear($tPlannedMeeting['date_rdv']) === $today) {
//                      La méthode "explode" permet de segmenter la chaîne passée en second paramètre au niveau du séparateur donné en premier paramètre.
                        $meetingHour = explode("à ", Dates_Mgr::dateFormatDayMonthYearHourMinutesSeconds($tPlannedMeeting['date_rdv']));
                        echo
                            '<tr>
                                <td>'.$tPlannedMeeting['libelle_entreprise'].'</td>
                                <td> à '.$meetingHour[1].'</td>
                                <td>';
                        if ($tPlannedMeeting['tel'] != '') {
                            echo
                                    '<div class="d-flex justify-content-center">
                                        <button class="mapIcon">
                                            <a title="Itinéraire" href="'.'">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </a>
                                        </button>
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
                        }   echo
                                '</td>
                            </tr>';
                    }
                }
?>
            </table>
        </div>
        <div class="w-md-50 w-xs-100">
            <div class="d-flex justify-content-center">
                <h5>À relancer :</h5>
            </div>
            <table class="table table-hover table-striped table-dark w-auto">
                <thead>
                    <tr>
                        <th>Avec</th>
                        <th>Tel</th>
                        <th>Mail</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

