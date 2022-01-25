<!--$_POST = OK-->
<?php

$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
$unknown = 'Non renseigné';
// echo($rights).'<br/>';
// echo($userConnected);
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
        if ((int) $userInChargeOfThisPro[0]['ID_utilisateur'] === (int) $_POST['ID_utilisateur']) {
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
                        <input type="hidden" name="ID_utilisateur" value="'.$_POST['ID_utilisateur'].'">
                        <input type="hidden" name="action" value="addNewContactForm">
                        <button type="submit" title="Enregistrer une nouvelle prise de contact" class="addNewContactIcon">
                            <i class="far fa-comments"></i>
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
                <input type="hidden" name="action" value="addNewContactForm">
                <button type="submit" title="Enregistrer une nouvelle prise de contact" class="addNewContactIcon">
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
                    <th>Contact du :</th>
                    <th class="text-center">entre</th>
                    <th class="text-center">et</th>
                    <th class="text-center">nom</th>
                    <th class="text-center">par</th>
                    <th class="text-center">au / à</th>
                    <th class="text-center">s'est conclue par</th>
                    <th class="text-center">Rendez-vous</th>
                    <th class="text-center">Relance prévue</th>
                </tr>
            </thead>
<?php
//      Récupère la liste des prospects de l'utilisateur connecté.
        $proId = (int) $_POST['ID_professionnel'];
        $tProspectActivities = Contacting_Mgr::getProspectActivity($proId);
        // var_dump($tProspectActivities);
        foreach($tProspectActivities as $tProspectActivity) {
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
                        '<input type="hidden" name="ID_professionnel" value="'.$tProspectActivity['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$tProspectActivity['libelle_entreprise'].'">
                        <input type="hidden" name="nom_decideur" value="'.$tProspectActivity['nom_decideur'].'">
                        <input type="hidden" name="tel" value="'.$tProspectActivity['tel'].'">
                        <input type="hidden" name="mail" value="'.$tProspectActivity['mail'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$tProspectActivity['ID_utilisateur'].'">
                        <input type="hidden" name="nom" value="'.$tProspectActivity['nom'].'">
                        <input type="hidden" name="prenom" value="'.$tProspectActivity['prenom'].'">
                        <input type="hidden" name="ID_interlocuteur" value="'.$tProspectActivity['ID_interlocuteur'].'">
                        <input type="hidden" name="libelle_interlocuteur" value="'.$tProspectActivity['libelle_interlocuteur'].'">
                        <input type="hidden" name="nom_interlocuteur" value="'.$tProspectActivity['nom_interlocuteur'].'">
                        <input type="hidden" name="contact_interlocuteur" value="'.$tProspectActivity['contact_interlocuteur'].'">
                        <input type="hidden" name="ID_nature" value="'.$tProspectActivity['ID_nature'].'">
                        <input type="hidden" name="libelle_nature" value="'.$tProspectActivity['libelle_nature'].'">
                        <input type="hidden" name="libelle_conclusion" value="'.$tProspectActivity['libelle_conclusion'].'">
                        <input type="hidden" name="commentaire" value="'.$tProspectActivity['commentaire'].'">
                        <input type="hidden" name="date_derniere_pdc" value="'.$tProspectActivity['date_derniere_pdc'].'">
                        <input type="hidden" name="date_rdv" value="'.$tProspectActivity['date_rdv'].'">
                        <input type="hidden" name="date_relance" value="'.$tProspectActivity['date_relance'].'">
                        <input type="hidden" name="prospect_ou_client" value="'.$tProspectActivity['prospect_ou_client'].'">
                        <input type="hidden" name="action" value="fullInfosContact">
                        <input class="fullInfosBtn" type="submit" title="Voir détail de la prise de contact" value="'.$contactDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_derniere_pdc']).'"></input>
                    </form>
                </td> 
                <td>'.$tProspectActivity['suivi'].'</td>
                <td>'.$tProspectActivity['libelle_interlocuteur'].'</td>';
/*
                Si l'utilisateur a eu un contact avec le décideur, on affiche directement le nom du décideur.
                Si le nom du décideur n'a pas été renseigné dans la BDD, on affiche "non renseigné".
*/
                if ($tProspectActivity['ID_interlocuteur'] === '1') {
                    if ($tProspectActivity['nom_decideur'] === '') {
                        echo 
                        '<td>'.$unknown.'</td>';
                    } else {
                        echo 
                        '<td>'.$tProspectActivity['nom_decideur'].'</td>';
                    }
                } else {
                    if ($tProspectActivity['nom_interlocuteur'] === '') {
                        echo
                        '<td>'.$unknown.'</td>';
                    } else {
                        echo
                        '<td>'.$tProspectActivity['nom_interlocuteur'].'</td>';
                    }
                }
                echo
                '<td>'.$tProspectActivity['libelle_nature'].'</td>';
                if ($tProspectActivity['contact_interlocuteur'] === '') {
                    echo 'Non renseigné';
                } else {
                    echo
                    '<td>'.$tProspectActivity['contact_interlocuteur'].'</td>';
                }
                echo
                '<td title="'.$tProspectActivity['commentaire'].'">'.$tProspectActivity['libelle_conclusion'].'</td>
                <td class="text-center">'.$meetingDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_rdv']).'</td>
                <td class="text-center">'.$recallDate = Dates_Mgr::dateFormatDayMonthYear($tProspectActivity['date_relance']).'</td>
            </tr>';
        }
?>
        </table>
    </div>
</div>
