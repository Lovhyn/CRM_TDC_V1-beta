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
//  Récupère la liste de tous les professionnels ayant le même code postal que celui passé en paramètre.
    $tProListByCp = Pro_Mgr::getProListByCp($_POST['cp']);
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2>Prospects</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-dark w-auto" 
                    data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true">Nom</th>
                    <th>Décideur</th>
                    <th>Adresse</th>
                    <th>Code postal</th>
                    <th>Ville</th>
                    <th>Observation</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
<?php 
        foreach($tProListByCp as $tProByCp) {
            echo
                '<tr>
                    <td>'.$tProByCp['libelle_entreprise'].'</td>';
            if ($tProByCp['nom_decideur'] != '') {
                echo
                    '<td>'.$tProByCp['nom_decideur'].'</td>';
            } else echo($unknown);
            if ($tProByCp['adresse'] != '') {
                echo
                    '<td>'.$tProByCp['adresse'].'</td>';
            } else echo($noAdress);
            if ($tProByCp['cp'] != '') {
                echo
                    '<td>'.$tProByCp['cp'].'</td>';
            } else echo($unknown);
            if ($tProByCp['ville'] != '') {
                echo
                    '<td>'.$tProByCp['ville'].'</td>';
            } else echo($unknown);
            if ($tProByCp['observation'] != '') {
                echo
                    '<td>'.$tProByCp['observation'].'</td>';
            } else echo($unknown);
            if ($tProByCp['prospect_ou_client'] === "1") {
                echo
                    '<td>(Client)</td>';
            } else echo('<td>(Prospect)</td>'); 
            if ($tProByCp['tel'] != '') {
                echo 
                '<td>
                    <div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="Appeler : '.$tProByCp['tel'].'" href="tel:'.$tProByCp['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>
                </td>';
            }
            echo
            '</tr>';
        }
?>
            </thead>
        </table>
    </div>
</div>