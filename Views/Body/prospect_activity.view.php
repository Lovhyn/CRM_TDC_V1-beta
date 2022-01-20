<?php
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
// echo($rights);
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Suivi de <?php echo($_POST['pro_name']);?></h2>
    </div>
<?php
//  Si l'utilisateur est un chargé de projet, affiche =>
    if ($rights != 1) {
/*      
        Un chargé de projet ne peut ajouter une prise de contact sur un 
        prospect / client que s'il est en charge du suivi de ce dernier.
*/
        if ($userConnected === (int) $_POST['user_ID']) {
            echo
            '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_cdp.php?action=addNewContactForm" method="post">
                <input type="hidden" name="pro_ID" value="' . $_POST['pro_ID']. '">
                <input type="hidden" name="pro_name" value="' . $_POST['pro_name']. '">
                <button type="submit" title="Enregistrer une nouvelle prise de contact" name="action" value="addNewContactForm" class="addNewContactIcon">
                    <i class="far fa-comments"></i>
                </button>
            </form>';
        }
//  Sinon, l'utilisateur connecté est forcément un administrateur.
    } else {
        echo
        '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php?action=addNewContactForm" method="post">
            <input type="hidden" name="pro_ID" value="' . $_POST['pro_ID']. '">
            <input type="hidden" name="pro_name" value="' . $_POST['pro_name']. '">
            <button type="submit" title="Enregistrer une nouvelle prise de contact" name="action" value="addNewContactForm" class="addNewContactIcon">
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
                    <th>Le</th>
                    <th>entre</th>
                    <th>et</th>
                    <th>nom</th>
                    <th>par</th>
                    <th>au / à</th>
                    <th>s'est conclue par</th>
                    <th>Date rendez-vous</th>
                    <th>Relance prévue</th>
                </tr>
            </thead>
<?php
//      Récupère la liste des prospects de l'utilisateur connecté.
        $proId = (int) $_POST['pro_ID'];
        $tProspectActivities = Contacting_Mgr::getProspectActivity($proId);
        foreach($tProspectActivities as $tProspectActivity) {
            echo
            '<tr>
                <td>';
            if ($rights != 1) {
                echo
                    '<form action="/outils/Controllers/Controller_cdp.php?action=fullInfosContact" method="post">';
            } else {
                echo
                    '<form action="/outils/Controllers/Controller_admin.php?action=fullInfosContact" method="post">';
            } 
                echo
                    '<input type="hidden" name="action" value="fullInfosContact">
                        <input class="fullInfosBtn" type="submit" title="Voir détail de la prise de contact" name="last_contact_date" value="' . $contactDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_derniere_pdc']) . '"></input>
                    </form>
                </td> 
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
                <td class="text-center">' . $meetingDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_rdv']) . '</td>
                <td class="text-center">' . $recallDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_relance']) . '</td>
            </tr>';
        }
?>
        </table>
    </div>
</div>
