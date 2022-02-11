<?php
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
$unknown = ' - ';
?>
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Suivi de <?php echo($_POST['libelle_entreprise']);?></h2>
    </div>
    <div class="w-100 d-flex flew-row justify-content-between">
<!----------------------------------------BACK RETURN BUTTON-------------------------------------->
<?php
            if ($_POST['prospect_ou_client'] === "0") {
                if ($rights === 1) {
?>
                    <form class="w-25 d-flex align-items-center justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
<?php
                } elseif ($rights === 2) {
?>
                    <form class="w-25 d-flex align-items-center justify-content-center" action="/outils/Controllers/Controller_responsable.php" method="post">
<?php
                } elseif ($rights === 3) {
?>
                    <form class="w-25 d-flex align-items-center justify-content-center" action="/outils/Controllers/Controller_cdp.php" method="post">
<?php
                }
?>
                        <input type="hidden" name="action" value="prospectsListing">
                        <div class="d-flex justify-content-center">
                            <button title="Retour à la liste des prospects" type="submit" class="backToProListingIcon">
                                <i class="fas fa-chevron-circle-left"></i>
                            </button>
                        </div>
                    </form>
<?php
            } else {
                if ($rights === 1) {
?>
                    <form class="w-25 d-flex align-items-center justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
<?php
                } elseif ($rights === 2) {
?>
                    <form class="w-25 d-flex align-items-center justify-content-center" action="/outils/Controllers/Controller_responsable.php" method="post">
<?php
                } elseif ($rights === 3) {
?>
                    <form class="w-25 d-flex align-items-center justify-content-center" action="/outils/Controllers/Controller_cdp.php" method="post">
                        
<?php
                }
?>
                        <input type="hidden" name="action" value="clientsListing">
                        <div class="d-flex justify-content-center">
                            <button title="Retour à la liste des clients" type="submit" class="backToProListingIcon">
                                <i class="fas fa-chevron-circle-left"></i>
                            </button>
                        </div>
                    </form>
<?php
            }
?>
<?php
/*      
        Un chargé de projet ne peut ajouter une prise de contact sur un 
        prospect / client que s'il est en charge du suivi de ce dernier.
*/
        $userInChargeOfThisPro = Pro_Mgr::checkWhichUserIsInChargeOfThisPro((int) $_POST['ID_professionnel']);
        $idUserInChargeOfThisPro = (int) $userInChargeOfThisPro[0]['ID_utilisateur'];
//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°

//  Si l'utilisateur n'est pas un administrateur

//°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    if ($rights != 1) {
        if ($idUserInChargeOfThisPro === (int) $_POST['ID_utilisateur']) {
            if ($userConnected === (int) $_POST['ID_utilisateur']) {
//          Si l'utilisateur est un responsable ou un chargé de projet, affiche =>
                if ($rights === 2) {
                    echo
                    '<form class="w-50 d-flex justify-content-center align-items-center" action="/outils/Controllers/Controller_responsable.php" method="post">';
                } else {
                    echo
                    '<form class="w-50 d-flex justify-content-center align-items-center" action="/outils/Controllers/Controller_cdp.php" method="post">';
                }
                echo
                        '<input type="hidden" name="ID_professionnel" value="'.$_POST['ID_professionnel'].'">
                        <input type="hidden" name="libelle_entreprise" value="'.$_POST['libelle_entreprise'].'">
                        <input type="hidden" name="ID_utilisateur" value="'.$userConnected.'">
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
            '<form class="w-50 d-flex justify-content-center align-items-center" action="/outils/Controllers/Controller_admin.php" method="post">
                <input type="hidden" name="ID_professionnel" value="'.$_POST['ID_professionnel'].'">
                <input type="hidden" name="libelle_entreprise" value="'.$_POST['libelle_entreprise'].'">
                <input type="hidden" name="ID_utilisateur" value="'.$userConnected.'">
                <input type="hidden" name="action" value="addNewContactForm">
                <button type="submit" title="Enregistrer une nouvelle prise de contact" class="addNewContactIcon d-flex">
                    <i class="far fa-comment-dots"></i>
                </button>
            </form>';
    }
?>
<!----------------------------------------HIDDEN BUTTON-------------------------------------->
        <div class="w-25 d-flex align-items-center justify-content-center invisible">
            <div class="d-flex justify-content-center">
                <button title="Retour à la liste des prospects" type="submit" class="backToProListingIcon">
                    <i class="fas fa-chevron-circle-left"></i>
                </button>
            </div>
        </div>
<!------------------------------------------------------------------------------------------->
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-sortable="true" class="text-center">Contact du :</th>
                    <th data-sortable="true">entre</th>
                    <th>et</th>
                    <th>nom</th>
                    <th>par</th>
                    <th>au / à</th>
                    <th data-sortable="true">s'est conclu par</th>
                    <th data-sortable="true">Rendez-vous</th>
                    <th data-sortable="true">Relance prévue</th>
                    <th></th>
                </tr>
            </thead>
<?php
//      Récupère la liste des prospects de l'utilisateur connecté.
        $proId = (int) $_POST['ID_professionnel'];
        $tProActivities = Contacting_Mgr::getProActivity($proId);
// var_dump($tProActivities);
        foreach($tProActivities as $tProActivity) {
            echo
            '<tr>
                <td>';
            if ($rights === 1) {
                echo'<form action="/outils/Controllers/Controller_admin.php" method="post">';
            } elseif ($rights === 2) {
                echo'<form action="/outils/Controllers/Controller_responsable.php" method="post">';
            } else {
                echo'<form action="/outils/Controllers/Controller_cdp.php" method="post">';
            }
                echo    '<input type="hidden" name="ID_professionnel" value="'.$tProActivity['ID_professionnel'].'">
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
                if ($tProActivity['nom_decideur'] != '') {
                    echo'<td>'.$tProActivity['nom_decideur'].'</td>';
                } else {
                    echo'<td class="text-center">'.$unknown.'</td>';
                }
            } else {
                if ($tProActivity['nom_interlocuteur'] === NULL) {
                    echo'<td class="text-center">'.$unknown.'</td>';
                } else {
                    echo'<td>'.$tProActivity['nom_interlocuteur'].'</td>';
                }
            }
            if ($tProActivity['ID_nature'] === '1') {
                echo'<td>'.$tProActivity['libelle_nature'].'</td>';
            } elseif ($tProActivity['ID_nature'] === '2') {
                echo'<td>'.$tProActivity['libelle_nature'].'</td>';
            } elseif ($tProActivity['ID_nature'] === '3') {
                echo'<td>Téléphone</td>';
            } elseif ($tProActivity['ID_nature'] === '4') {
                echo'<td>Mail</td>';
            } else {
                echo'<td>Autre</td>';
            }
            if ($tProActivity['contact_interlocuteur'] === NULL) {
                echo'<td class="text-center">'.$unknown.'</td>';
            } else {
                echo'<td>'.$tProActivity['contact_interlocuteur'].'</td>';
            }
            echo    '<td title="'.$tProActivity['commentaire'].'">'.$tProActivity['libelle_conclusion'].'</td>';
            if ($tProActivity['date_rdv'] != NULL) {
                echo'<td class="text-center">'.$meetingDate = Dates_Mgr::dateFormatDayMonthYearHourMinutesSeconds($tProActivity['date_rdv']).'</td>';
            } else {
                echo'<td class="text-center">'.$unknown.'</td>';
            }
            if ($tProActivity['date_relance'] != NULL) {
                echo'<td class="text-center">'.$recallDate = Dates_Mgr::dateFormatDayMonthYear($tProActivity['date_relance']).'</td>';
            } else {
                echo'<td class="text-center">'.$unknown.'</td>';
            }
            echo'<td class="text-center">';
/*
            Un utilisateur doit pouvoir décaler un rendez-vous ou une date de relance programmée.
            Il a donc été défini que seule la dernière prise de contact avec un professionnel était modifiable.
            On va donc récupérer la dernière prise de contact effectuée pour un professionnel où la conclusion 
            est différente de "Création client".
*/
            $getUpdatableContact = Contacting_Mgr::getUpdatableContactByIdPro($proId);
            $updatableContact = $getUpdatableContact[0]['last_pdc'];
            if ($idUserInChargeOfThisPro === (int) $_POST['ID_utilisateur']) {
                if ($userConnected === (int) $_POST['ID_utilisateur']) {
/*
                    On compare donc la date de la dernière prise de contact avec le résultat de la requête. 
                    Si les résultats sont identiques, alors le formulaire apparaît.
*/
                    if ($tProActivity['date_derniere_pdc'] === $updatableContact) {
                        if ($rights === 1) {
                            echo'<form action="/outils/Controllers/Controller_admin.php" method="post">';
                        } elseif ($rights === 2) {
                            echo'<form action="/outils/Controllers/Controller_responsable.php" method="post">';
                        } else {
                            echo'<form action="/outils/Controllers/Controller_cdp.php" method="post">';
                        }
                            echo    '<input type="hidden" name="action" value="updateContact">
                                    <input type="hidden" name="date_rdv" value="'.$tProActivity['date_rdv'].'">
                                    <input type="hidden" name="prospect_ou_client" value="'.$tProActivity['prospect_ou_client'].'">
                                    <input type="hidden" name="date_relance" value="'.$tProActivity['date_relance'].'">
                                    <input type="hidden" name="ID_professionnel" value="'.$_POST['ID_professionnel'].'">
                                    <input type="hidden" name="libelle_entreprise" value="'.$_POST['libelle_entreprise'].'">
                                    <input type="hidden" name="ID_utilisateur" value="'.$_POST['ID_utilisateur'].'">
                                    <input type="hidden" name="ID_suivre" value="'.$tProActivity['ID_suivre'].'">
                                    <input type="hidden" name="commentaire" value="'.$tProActivity['commentaire'].'">
                                    <button class="updIcon" type="submit" title="Modifier date de relance / date de rendez-vous">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </form>';
                    } else {
                        echo($unknown);
                    }
                }
            }
            echo    '</td>
            </tr>'; 
        }
?>
        </table>
    </div>
</div>
