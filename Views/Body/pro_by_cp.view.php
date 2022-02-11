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
        <h2>Tous les professionnels du secteur</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-dark w-auto" 
                    data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true">Nom</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
<?php 
        foreach($tProListByCp as $tProByCp) {
            echo
                '<tr>';
            if ($tProByCp['prospect_ou_client'] === "1") {
                echo
                    '<td title="(Client) | '.$tProByCp['observation'].'">'.$tProByCp['libelle_entreprise'].'</td>';
            } else {
                echo
                    '<td title="(Prospect) | '.$tProByCp['observation'].'">'.$tProByCp['libelle_entreprise'].'</td>';
            }
            if ($tProByCp['adresse'] != '') {
                echo
                    '<td>
                        <div class="d-flex justify-content-center">
                            <button class="carIcon">
                                <a target="_blank" title="Voir itinéraire : '.$tProByCp['adresse'].', '.$tProByCp['cp'].', '.$tProByCp['ville'].'" 
                                    href="http://maps.google.com/maps?daddr='.$tProByCp['adresse'].' '.$tProByCp['cp'].' '.$tProByCp['ville'].'">
                                    <i class="fa-solid fa-car"></i>
                                </a>
                            </button>
                        </div>
                    </td>';
            } else echo($noAdress);
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
            } else echo($noPhone);
            echo
            '</tr>';
        }
?>
            </thead>
        </table>
    </div>
</div>