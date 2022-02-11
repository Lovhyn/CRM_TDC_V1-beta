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
        <h4>Voici ton activité du jour</h4>
    </div>
    <div class="w-100 d-md-flex flex-md-row justify-content-md-around
                    d-xs-flex flex-xs-column justify-content-xs-center">
        <div class="w-md-50 w-xs-100">
            <div class="d-flex justify-content-center">
                <h5>Déplacements</h5>
            </div>
<?php 
//          Récupère tous les rendez-vous du jour dans la base de données pour l'utilisateur donné en paramètre.
            $tPlannedMeetings = Contacting_Mgr::getAllPlannedMeetings($userConnected);
?>
            <table class="table table-hover table-striped table-dark w-auto">
                <div class="d-flex justify-content-center">
                    <form action="/outils/Controllers/Controller_cdp.php" method="post">
                        <input type="hidden" name="action" value="myMeetings">
                        <input class="myMeetingsLink" type="submit" title="Voir tout tes déplacements" value="(Voir tout)">
                    </form>
                </div>
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
<?php 
        $today = Dates_Mgr::dateFormatDayMonthYear(Dates_Mgr::nowToUnixString()); 
        for ($i = 0 ; $i < 5 ; $i++) {  
/*
            On cherche à n'afficher que les rendez-vous du jour, 
            On va donc comparer chaque date de rendez-vous enregistré en bdd avec la date du jour.
*/                
            if  (Dates_Mgr::dateFormatDayMonthYear($tPlannedMeetings[$i]['date_rdv']) === $today) {
//              La méthode "explode" permet de segmenter la chaîne passée en second paramètre au niveau du séparateur donné en premier paramètre.
                $meetingHour = explode("à ", Dates_Mgr::dateFormatDayMonthYearHourMinutesSeconds($tPlannedMeetings[$i]['date_rdv']));
                echo
                    '<tr title="'.$tPlannedMeetings[$i]['commentaire'].'">
                        <td>'.$tPlannedMeetings[$i]['libelle_entreprise'].'</td>
                        <td> à '.$meetingHour[1].'</td>
                        <td>';
                if ($tPlannedMeetings[$i]['adresse'] != '') {
                    echo
                            '<div class="d-flex justify-content-center">
                                <button class="mapIcon">
                                    <a target="_blank" title="Voir itinéraire : '.$tPlannedMeetings[$i]['adresse'].', '.$tPlannedMeetings[$i]['cp'].', '.$tPlannedMeetings[$i]['ville'].'" 
                                        href="http://maps.google.com/maps?daddr='.$tPlannedMeetings[$i]['adresse'].' '.$tPlannedMeetings[$i]['cp'].' '.$tPlannedMeetings[$i]['ville'].'">
                                        <i class="fa-solid fa-car"></i>
                                    </a>
                                </button>
                            </div>';
                        
                }
                    echo
                        '</td>
                        <td>';
                if ($tPlannedMeetings[$i]['cp'] != '') {
                    echo
                            '<div class="d-flex justify-content-center">
                                <form action="/outils/Controllers/Controller_cdp.php" method="post">
                                    <input type="hidden" name="action" value="allProsByCp">
                                    <input type="hidden" name="commentaire" value="'.$tPlannedMeetings[$i]['cp'].'">
                                    <button class="showProsIcon" type="submit" title="Voir tous les professionnels dont le code postal est '.$tPlannedMeetings[$i]['cp'].'">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </button>
                                </form>
                            </div>';
                }
                    echo
                        '</td>
                        <td>';
                if ($tPlannedMeetings[$i]['tel'] != '') {
                    echo
                            '<div class="d-flex justify-content-center">
                                <button class="phoneIcon">
                                    <a title="Appeler : '.$tPlannedMeetings[$i]['tel'].'" href="tel:'.$tPlannedMeetings[$i]['tel'].'">
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
                <h5>Relances</h5>
            </div>
<?php 
//          Récupère toutes les relances du jour dans la base de données pour l'utilisateur donné en paramètre.
            $tPlannedRecalls = Contacting_Mgr::getAllPlannedRecalls($userConnected);
            // var_dump($tPlannedRecalls);
?>
            <table class="table table-hover table-striped table-dark w-auto">
                <div class="d-flex justify-content-center">
                    <a class="fullListLink" href="">(Voir tout)</a>
                </div>
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                </thead> 
<?php
        foreach($tPlannedRecalls as $tPlannedRecall) {
/*
            On cherche à n'afficher que les relances du jour, 
            On va donc comparer chaque date de relance enregistrée en bdd avec la date du jour.
*/    
            $recallDate = Dates_Mgr::dateFormatDayMonthYear($tPlannedRecall['date_relance']);
            $today = Dates_Mgr::dateFormatDayMonthYear(Dates_Mgr::nowToUnixString()); 
            if  (Dates_Mgr::dateFormatDayMonthYear($tPlannedRecall['date_relance']) === $today) {
                echo
                    '<tr title="'.$tPlannedRecall['commentaire'].'">
                        <td>'.$tPlannedRecall['libelle_entreprise'].'</td>
                        <td>'.$tPlannedRecall['libelle_conclusion'].'</td>
                        <td>';
                if ($tPlannedRecall['tel'] != '') {
                    echo
                            '<div class="d-flex justify-content-center">
                                <button class="phoneIcon">
                                    <a title="Appeler : '.$tPlannedRecall['tel'].'" href="tel:'.$tPlannedRecall['tel'].'">
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
    </div>
</div>

