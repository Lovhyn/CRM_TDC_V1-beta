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
        <h2>Relances prévues</h2>
    </div>
<?php
//  Récupère toutes les relances dans la base de données pour l'utilisateur donné en paramètre.
    $tPlannedRecalls = Contacting_Mgr::getAllPlannedRecalls($userConnected);
            
?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-dark w-auto"
            data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true">Nom</th>
                    <th>Décideur</th>
                    <th class="text-center" data-sortable="true">Date</th>
                    <th>Mail</th>
                    <th></th>
                </tr>
            </thead>
<?php 
$today = Dates_Mgr::dateFormatDayMonthYear(Dates_Mgr::nowToUnixString());
foreach ($tPlannedRecalls as $tPlannedRecall) {
/*
    On cherche à afficher les relances du jour ou à venir, 
    On va donc comparer chaque date de rendez-vous enregistré en bdd en vérifiant qu'elle 
    est supérieure ou égale à celle du jour.
*/                
    if  (Dates_Mgr::dateFormatDayMonthYear($tPlannedRecall['date_relance']) >= $today) {
        $recallDate = Dates_Mgr::dateFormatDayMonthYear($tPlannedRecall['date_relance']);
        echo
            '<tr>
                <td title="'.$tPlannedRecall['commentaire'].'">'.$tPlannedRecall['libelle_entreprise'].'</td>
                <td title="'.$tPlannedRecall['commentaire'].'">'.$tPlannedRecall['nom_decideur'].'</td>
                <td title="'.$tPlannedRecall['commentaire'].'">'.$recallDate.'</td>';
        if ($tPlannedRecall['mail'] != '') {
            echo'<td title="'.$tPlannedRecall['commentaire'].'">'.$tPlannedRecall['mail'].'</td>';
        } else echo($unknown);
        if ($tPlannedRecall['tel'] != '') {
            echo
                '<td>
                    <div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tPlannedRecall['tel'].'" href="tel:'.$tPlannedRecall['tel'].'">
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