<!--$_POST = OK-->
<?php
// var_dump($_POST);
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
$unknown = 'Non renseigné';
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Suivi de <?php echo($_POST['libelle_entreprise']);?></h2>
    </div>
<?php
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°

//  Si l'utilisateur n'est pas un administrateur

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    if ($rights != 1) {
/*      
        Un chargé de projet ne peut ajouter une prise de contact sur un 
        prospect / client que s'il est en charge du suivi de ce dernier.
*/
        $userInChargeOfThisPro = Pro_Mgr::checkWhichUserIsInChargeOfThisPro((int) $_POST['ID_professionnel']);
        $idUserInChargeOfThisPro = (int) $userInChargeOfThisPro[0]['ID_utilisateur'];
        if ($idUserInChargeOfThisPro === (int) $_POST['ID_utilisateur']) {
            if ($userConnected === (int) $_POST['ID_utilisateur']) {
//          Si l'utilisateur est un responsable ou un chargé de projet, affiche =>
                if ($rights === 2) {
                    echo
                    '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_responsable.php" method="post">';
                } else {
                    echo
                    '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
                echo
                        '<input type="hidden" name="ID_professionnel" value="'.$_POST['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$_POST['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$idUserInChargeOfThisPro.'">
                        <input type="hidden" name="action" value="addNewContactForm">
                        <button type="submit" title="Enregistrer une nouvelle prise de contact" class="addNewContactIcon">
                            <i class="far fa-comment-dots"></i>
                        </button>
                    </form>';
            }
        }
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°

//  Sinon, l'utilisateur connecté est "forcément" un administrateur.

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    } else {
        echo
            '<form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php" method="post">
                <input type="hidden" name="ID_professionnel" value="'.$_POST['ID_professionnel'].'">
                <input type="hidden" name="libelle_entreprise" value="'.$_POST['libelle_entreprise'].'">
                <input type="hidden" name="ID_utilisateur" value="'.$idUserInChargeOfThisPro.'">
                <input type="hidden" name="action" value="addNewContactForm">
                <button type="submit" title="Enregistrer une nouvelle prise de contact" class="addNewContactIcon">
                    <i class="far fa-comment-dots"></i>
                </button>
            </form>';
    }
?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true">Contact du :</th>
                    <th class="text-center" data-sortable="true">entre</th>
                    <th class="text-center">et</th>
                    <th class="text-center">nom</th>
                    <th class="text-center">par</th>
                    <th class="text-center">au / à</th>
                    <th class="text-center" data-sortable="true">s'est conclu par</th>
                    <th class="text-center" data-sortable="true">Rendez-vous</th>
                    <th class="text-center" data-sortable="true">Relance prévue</th>
                </tr>
            </thead>
<?php
//      Récupère la liste des prospects de l'utilisateur connecté.
        $proId = (int) $_POST['ID_professionnel'];
        $tProActivities = Contacting_Mgr::getProActivity($proId);
        // var_dump($tProspectActivities);
        foreach($tProActivities as $tProActivity) {
            echo
            '<tr>
                <td>';
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
                        '<input type="hidden" name="ID_professionnel" value="'.$tProActivity['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProActivity['libelle_entreprise'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tProActivity['nom_decideur'].'">
                        <input type="hidden" name="tel" value="'.$tProActivity['tel'].'">
                        <input type="hidden" name="mail" value="'.$tProActivity['mail'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProActivity['ID_utilisateur'].'">
                        <input type="hidden" name="currentUserInChargeOfThisPro" value="'.$idUserInChargeOfThisPro.'">
                        <input type="hidden" name="nom" value="'.$tProActivity['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tProActivity['prenom'].'">
                        <input type="hidden" name="ID_interlocuteur" value="'.$tProActivity['ID_interlocuteur'].'">
                        <input type="hidden" name="libelle_interlocuteur" value="'.$tProActivity['libelle_interlocuteur'].'">
                        <input type="hidden" name="nom_interlocuteur" value="'.$tProActivity['nom_interlocuteur'].'">
                        <input type="hidden" name="contact_interlocuteur" value="'.$tProActivity['contact_interlocuteur'].'">
                        <input type="hidden" name="ID_nature" value="'.$tProActivity['ID_nature'].'">
                        <input type="hidden" name="libelle_nature" value="'.$tProActivity['libelle_nature'].'">
                        <input type="hidden" name="libelle_conclusion" value="'.$tProActivity['libelle_conclusion'].'">
                        <input type="hidden" name="commentaire" value="'.$tProActivity['commentaire'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tProActivity['date_derniere_pdc'].'">
                        <input type="hidden" name="date_rdv" value="'.$tProActivity['date_rdv'].'">
                        <input type="hidden" name="date_relance" value="'.$tProActivity['date_relance'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProActivity['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="fullInfosContact">
                        <input class="fullInfosBtn" type="submit" title="Voir détail de la prise de contact" value="'.$contactDate = Dates_Mgr::dateFormatDayMonthYear($tProActivity['date_derniere_pdc']).'"></input>
                    </form>
                </td> 
                <td>'.$tProActivity['suivi'].'</td>
                <td>'.$tProActivity['libelle_interlocuteur'].'</td>';
/*
                Si l'utilisateur a eu un contact avec le décideur, on affiche directement le nom du décideur.
                Si le nom du décideur n'a pas été renseigné dans la BDD, on affiche "non renseigné".
*/
                if ($tProActivity['ID_interlocuteur'] === '1') {
                    if ($tProActivity['nom_decideur'] === '') {
                        echo 
                        '<td>'.$unknown.'</td>';
                    } else {
                        echo 
                        '<td>'.$tProActivity['nom_decideur'].'</td>';
                    }
                } else {
                    if ($tProActivity['nom_interlocuteur'] === '') {
                        echo
                        '<td>'.$unknown.'</td>';
                    } else {
                        echo
                        '<td>'.$tProActivity['nom_interlocuteur'].'</td>';
                    }
                }
                echo
                '<td>'.$tProActivity['libelle_nature'].'</td>';
                if ($tProActivity['contact_interlocuteur'] === '') {
                    echo 
                    '<td>'.$unknown.'</td>';
                } else {
                    echo
                    '<td>'.$tProActivity['contact_interlocuteur'].'</td>';
                }
                echo
                '<td title="'.$tProActivity['commentaire'].'">'.$tProActivity['libelle_conclusion'].'</td>
                <td class="text-center">'.$meetingDate = Dates_Mgr::dateFormatDayMonthYear($tProActivity['date_rdv']).'</td>
                <td class="text-center">'.$recallDate = Dates_Mgr::dateFormatDayMonthYear($tProActivity['date_relance']).'</td>
            </tr>';
        }
?>
        </table>
    </div>
</div>
