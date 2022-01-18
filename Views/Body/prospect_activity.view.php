<?php
$userConnected = (int) $_SESSION['idUser'];
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Suivi de <?php echo($_POST['pro_name']);?></h2>
    </div>
<?php
    if ($userConnected === (int) $_POST['user_ID']) {
        echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_cdp.php?action=addNewContactForm" method="post">
            <input type="hidden" name="pro_ID" value="' . $_POST['pro_ID']. '">
            <input type="hidden" name="pro_name" value="' . $_POST['pro_name']. '">
            <button type="submit" name="action" value="addNewContactForm" class="addNewContactIcon">
                <i class="far fa-comments"></i>
            </button>
        </form>';
    }
?>
    <div class="d-flex justify-content-center">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th>Quand ?</th>
                    <th>Qui ?</th>
                    <th>Avec</th>
                    <th>Nom</th>
                    <th>Comment</th>
                    <th>Tel / Mail</th>
                    <th>Conclusion</th>
                    <th>Compte-rendu</th>
                    <th>Date rendez-vous</th>
                    <th>Relance prévue</th>
                </tr>
            </thead>
<?php
//      Récupère la liste des prospects de l'utilisateur connecté.
        $proId = (int) $_POST['pro_ID'];
        $tProspectActivities = Contacting_Mgr::getCdpProspectActivity($proId);
        foreach($tProspectActivities as $tProspectActivity) {
            
            echo
            '<tr>
                <td class="text-center">' . $contactDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_derniere_pdc']) . '</td>
                <td>' . $tProspectActivity['suivi'] . '</td>
                <td>' . $tProspectActivity['libelle_interlocuteur'] . '</td>';
                if ($tProspectActivity['libelle_interlocuteur'] === 'Décideur') {
                    echo 
                    '<td>' . $tProspectActivity['nom_decideur'] . '</td>';
                } else {
                    echo
                    '<td>' . $tProspectActivity['nom_interlocuteur'] . '</td>';
                }
                echo
                '<td>' . $tProspectActivity['libelle_nature'] . '</td>
                <td>' . $tProspectActivity['contact_interlocuteur'] . '</td>
                <td>' . $tProspectActivity['libelle_conclusion'] . '</td>
                <td>' . $tProspectActivity['commentaire'] . '</td>
                <td class="text-center">' . $meetingDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_rdv']) . '</td>
                <td class="text-center">' . $recallDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_relance']) . '</td>
            </tr>';
        }
?>
        </table>
    </div>
</div>
